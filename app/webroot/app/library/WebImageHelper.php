<?php

/**
 * Helper class for showing images that might need resizing or compressing
 * to be web-friendly.
 *
 *	Version 2
 */
class WebImageHelper {

	private $is_test_mode = false; // If true, always regenerates images.

	/**
	 * Given the path to an image, and optionally a required width and 
	 * height, returns the path to a compressed, resized copy of the image.
	 *
	 * @param string $relative_url
	 * @param int $required_width
	 * @param int $required_height
	 * @param string $mode
	 * @return string
	 */
	public function resize( 
		$relative_url, 
		$required_width = null, 
		$required_height = null,
		$mode = 'min',
		$image_quality = 90 )
	{
		// Get the URL for the friendly version.
		
		$relative_url_info = pathinfo( $relative_url );
		
		if ( empty( $relative_url_info[ 'extension' ] )) {
			
			// Invalid path, return.
			
			return $relative_url;
		}
		
		$friendly_url = str_replace( 
			$relative_url_info[ 'basename' ],
			$relative_url_info[ 'filename' ] . "_" . $required_width . "_" . $required_height . "_" . $mode . "." . $relative_url_info[ 'extension' ],
			$relative_url );

		// Check if the friendly version exists.
		if ( $this->is_test_mode || !file_exists( './' . $friendly_url ) )
		{
			// No, so create friendly version.
			
			$created = $this->_resize_image( 
				'./' . $relative_url, 
				'./' . $friendly_url, 
				$relative_url_info[ 'extension' ],
				$image_quality, 
				$required_width, 
				$required_height,
				$mode );
			
			if ( !$created )
			{
				// Failed to create image, so return original instead.
				return $relative_url;
			}
		}

		// Return friendly URL.
		return $friendly_url;
	}
	
	public function get_size($relative_url)
	{
		$original_image = $this->_load_image( './' . $relative_url );
		if ( $original_image === false ) {
			return false;
		}
		return array(imagesx($original_image), imagesy($original_image));
	}
	
	/**
	 * Private helper functions. Please don't call these externally.
	 */
	
	/**
	 * Resizes an image and creates a new copy.
	 *
	 * @param string $img_path
	 * @param string $save_path
	 * @param string $img_extension
	 * @param int $quality
	 * @param int $width
	 * @param int $height
	 * @param string $mode [max] Will maintain aspect ratio and make the image as large as possible without exceeding either dimension.
	 *					   [min] Will maintain aspect ratio and make the image as small as possible but so both width and height are at least the provided values. 
	 *					   [fit] resizes like min, but then center crops the image if any of it spills out of the desired width and height. 
	 * @return bool
	 */
	private function _resize_image(
		$img_path,
		$save_path,
		$img_extension,
		$quality,
		$width = null,
		$height = null,
		$mode = '' )
	{
		// Load the existing image.
		$original_image = $this->_load_image( $img_path );

		if ( $original_image == null )
		{
			return false;
		}
		
		// Calculate the new width and height. If either isn't set, maintain
		// aspect ratio.
		
		$new_width = $width;
		$new_height = $height;
		
		if ( $width == null && 
			 $height == null )
		{
			$new_width 	= imagesx( $original_image );
			$new_height = imagesy( $original_image );
		}
		elseif ( $width == null )
		{
			$new_width = round(( $height / imagesy( $original_image )) * imagesx( $original_image ));
		}
		elseif ( $height == null )
		{
			$new_height = round(( $width / imagesx( $original_image )) * imagesy( $original_image ));
		}
		elseif ( empty( $mode ) || $mode === 'min' )
		{
			$width_scale = $width / imagesx( $original_image );
			$height_scale = $height / imagesy( $original_image );
			$scale = max( $width_scale, $height_scale );
			
			if ( imagesx( $original_image ) < $width ||
				 imagesy( $original_image ) < $height ) {
			
				// Don't scale up images that are smaller than required. You can use CSS for that...
				$new_width = imagesx( $original_image );
				$new_height = imagesy( $original_image );
			}
			else {
			
				$new_width = imagesx( $original_image ) * $scale;
				$new_height = imagesy( $original_image ) * $scale;
			}
		}
		elseif ( empty( $mode ) || $mode === 'fit' )
		{
			$width_scale = $width / imagesx( $original_image );
			$height_scale = $height / imagesy( $original_image );
			$scale = max( $width_scale, $height_scale );
			
			$new_width = imagesx( $original_image ) * $scale;
			$new_height = imagesy( $original_image ) * $scale;
		}
		elseif ( $mode === 'max' )
		{
			$new_width = $width;
			$new_height = round(( $width / imagesx( $original_image )) * imagesy( $original_image ));
			if ( $new_height > $height )
			{
				$new_height = $height;
				$new_width = round(( $height / imagesy( $original_image )) * imagesx( $original_image ));				
			}
		}

		// Create new image.
		$new_image = null;
		
		$actual_width = $new_width;
		$x_offset = 0;
		if ( $new_width < $width ) {
			
			$actual_width = $width;
			$x_offset = ( $width - $new_width ) / 2;
		}
		
		$actual_height = $new_height;
		$y_offset = 0;
		if ( $new_height < $height ) {
			
			$actual_height = $height;
			$y_offset = ( $height - $new_height ) / 2;
		}
		
		if ( $mode === 'fit' ) {
		
			if ( $new_width > $width ) {
			
				$actual_width = $width;
				$x_offset = -1 * ( $new_width - $width ) / 2;
			}
			if ( $new_height > $height ) {
			
				$actual_height = $height;
				$y_offset = -1 * ( $new_height - $height ) / 2;
			}
		}
		
		$new_image = imagecreatetruecolor( $actual_width, $actual_height );
		$white = imagecolorallocate( $new_image, 255, 255, 255 );
		imagefilledrectangle( $new_image, 0, 0, $actual_width, $actual_height, $white );		
		
		imagecopyresampled( 
			$new_image, 
			$original_image, 
			$x_offset, 
			$y_offset, 
			0, 
			0, 
			$new_width, 
			$new_height, 
			imageSX( $original_image ), 
			imageSY( $original_image )
		);
		
		// Save.
		
		$saved_flag = false;
		
		switch( strtoupper( $img_extension ))
		{
			case 'JPG':
			case 'JPEG':
				$saved_flag = imagejpeg( $new_image, $save_path, $quality );
				break;
				
			case 'PNG';
				$saved_flag = imagepng( $new_image, $save_path, 0 );
				break;
				
			case 'GIF':
				$saved_flag = imagegif( $new_image, $save_path );
				break;
				
			default:
				// Do nothing.
				break;
		}
		
		// Cleanup.
		
		imagedestroy( $original_image );
		imagedestroy( $new_image );

		return $saved_flag;
	}
	
	/**
	 * Loads an image as a resource and returns it.
	 *
	 * @param string $img_path
	 * @return resource
	 */
	private function _load_image( $img_path )
	{
		// Load the existing image.
		
		$img_path_info = pathinfo( $img_path );
		$img_extension = ( !empty( $img_path_info[ 'extension' ] )) ? $img_path_info[ 'extension' ] : '';

		$original_image = null;
		
		switch( strtoupper( $img_extension ))
		{
			case 'JPG':
			case 'JPEG':
				$original_image = @imagecreatefromjpeg( $img_path );
				break;
				
			case 'PNG';
				$original_image = @imagecreatefrompng( $img_path );
				break;
				
			case 'GIF':
				$original_image = @imagecreatefromgif ( $img_path );
				break;
				
			default:
				// Do nothing.
				break;
		}
		
		// Check image was created.
		return $original_image;
	}	
}

?>