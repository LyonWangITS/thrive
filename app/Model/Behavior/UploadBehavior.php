<?php

/**
*	Wraps up some useful validation rules for file uploads.
*/
class UploadBehavior extends ModelBehavior {

	public static $COMMON_DOC_EXTENSIONS = array( 'pdf' );
	public static $COMMON_IMAGE_EXTENSIONS = array( 'jpg', 'jpeg', 'png', 'gif' );

	public $settings = array();
	
	/**
	*	Called when behaviour initiated.
	*/
	public function setup( Model $model, $settings = array() ) {
	
		if ( !isset( $this->settings[$model->alias] ) ) {
		
			$this->settings[$model->alias] = array(
				'file_key' => 'file', // E.g. $data['file_key']
				'is_required' => false, // If true, a file must be uploaded. Otherwise can be left blank.
				'max_size_bytes' => 8 * ( 1024 * 1024 ), // Maximum allowed filesize in bytes. 0 for no limit.
				'allowed_types' => array(), // Allowed mime types. Leave empty to accept all types.
				'allowed_extensions' => array_merge( self::$COMMON_DOC_EXTENSIONS, self::$COMMON_IMAGE_EXTENSIONS ), // Allowed file extensions. Leave empty to allow all extensions (NOT recommended for security).
				'save_directory' => '', // Where to save the file, relative to WWW_ROOT. 
				'save_filename' => '', // The name to save the file as, EXCLUDING extension. If empty, the filename will become ID.ext. E.g. 123.jpg. The ID comes from the database.
				'save_field' => 'path', // The database column name the file path will be saved to.
			);
		}
		$this->settings[$model->alias] = array_merge(
			$this->settings[$model->alias], (array)$settings );
	}
	
	/**
	*	Validates the provided file in accordance with the settings, above.
	*/
	public function validate_upload( &$model = null, $data ) {
	
		$file_key = $this->settings[$model->alias]['file_key'];
	
		// Handle is_required
		if ( empty( $data[$file_key]['tmp_name'] ) ) {
		
			if ( !empty( $this->settings[$model->alias]['is_required'] ) ) {
			
				return 'Please select a file.';
			}
			else {

				// There's no file so we're done.
				return true;
			}
		}
		
		// Ensure file was actually uploaded. This is good security as it prevents
		// someone submitting a local file path.
		if ( $data[$file_key]['error'] != UPLOAD_ERR_OK || !is_uploaded_file( $data[$file_key]['tmp_name'] ) ) {
		
			return 'Error while uploading file. Please try again.';
		}
		
		// Check filesize
		if ( !empty( $this->settings[$model->alias]['max_size_bytes'] ) ) {
		
			if ( $data[$file_key]['size'] > $this->settings[$model->alias]['max_size_bytes'] ) {

				return 'Sorry, the uploaded file exceeds the maximum allowed file size of ' . format_bytes( $this->settings[$model->alias]['max_size_bytes'] ) . '.';
			}
		}

		// Check file types
		if ( !empty( $this->settings[$model->alias]['allowed_types'] ) ) {
		
			if ( !in_array( $data[$file_key]['type'], $this->settings[$model->alias]['allowed_types'] ) ) {

				return "Sorry, files of type '{$data[$file_key]['type']}' are not allowed.";
			}
		}

		// Check file extensions
		if ( !empty( $this->settings[$model->alias]['allowed_extensions'] ) ) {
		
			$extension = explode( '.', $data[$file_key]['name'] );
			$extension = array_pop( $extension );
			if ( !in_array( $extension, $this->settings[$model->alias]['allowed_extensions'] ) ) {

				return "Sorry, file extension '$extension' not allowed.";
			}
		}

		// Done!
		return true;
	}

	/**
	*	Called before associated model is saved. We use the ID of that entity as the filename.
	*/
	public function afterSave( Model $model, $created, $options = array() ) {

		$file_key = $this->settings[$model->alias]['file_key'];

		if ( empty( $model->data[$model->alias][$file_key]['tmp_name'] ) ) {

			// No file uploaded. Done.
			return;
		}

		// Try to move file.
		$filename = ( !empty( $this->settings[$model->alias]['save_filename'] ) ) ? $this->settings[$model->alias]['save_filename'] : $model->data[$model->alias]['id'];
		$extension = explode( '.', $model->data[$model->alias][$file_key]['name'] );
		$extension = array_pop( $extension );
		$new_path = rtrim( $this->settings[$model->alias]['save_directory'], '/\\' );
		$new_path .= "/{$filename}.{$extension}";

		if ( !move_uploaded_file( $model->data[$model->alias][$file_key]['tmp_name'], WWW_ROOT . $new_path ) ) {

			// Should only really happen due to file permission error, etc. I.e. it's a server problem
			throw new InternalErrorException( 'Unable to save file to filesystem.' );
		}

		// Update record
		$model->id = $model->data[$model->alias]['id'];
		$model->saveField( $this->settings[$model->alias]['save_field'], $new_path );
	}
}
