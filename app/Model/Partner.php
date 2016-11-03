<?php

/**
*	A partner is an institution offering the THRIVE survey.
*/
class Partner extends AppModel {

	public $actsAs = array(
		'Upload' => array(
			'is_required' => false,
			'save_directory' => '/images/partners/',
			'save_field' => 'logo_path',
			'allowed_extensions' => array( 'jpg', 'jpeg', 'png', 'gif' ),
		),
	);

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => 'create',
			'message' => 'Please enter the organisation name.',
		),
		'file' => array(
			'rule' => array( 'validate_upload' ),
			'allowEmpty' => true,
			'message' => '', // Will come from function.
		),
		'slug' => array(
			'rule' => array( 'isUnique' ),
			'required' => false,
			'message' => 'Please provide a unique slug.',
		)
	);

	public $belongsTo = array(
		'LuPartnerState',
	);

	public $hasMany = array(
		'Service',
	);

	public $hasOne = array(
		'Account',
		'PendingChange',
	);
	
	/**
	*	Callbacks
	*/

	/**
	*	Always called before model or field is validated.
	*/
	public function beforeValidate( $options = array() ) {
	
		//
		// Ensure slug is slug format
		if ( !empty( $this->data[$this->name]['slug'] ) ) {

			$this->data[$this->name]['slug'] = to_slug( $this->data[$this->name]['slug'] );
		}
		// Always provide a default slug
		else if ( !empty( $this->data[$this->name]['name'] ) ) {

			$this->data[$this->name]['slug'] = to_slug( $this->data[$this->name]['name'] );
		}
		
		return true;
	}

	/**
	*	Always called before model or field is saved.
	*/
	public function beforeSave( $options = array() ) {
	
		//
		// Ensure website starts with HTTP
		if ( !empty( $this->data[$this->name]['website'] ) ) {

			$url = $this->data[$this->name]['website'];
			if ( strpos( $url, 'http' ) !== 0 ) {
			
				$url = 'http://' . $url;
			}
			$this->data[$this->name]['website'] = $url;
		}
		
		return true;
	}
}
