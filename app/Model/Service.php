<?php

/**
*	A support service offered by a partner.
*/
class Service extends AppModel {

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'allowEmpty' => false,
			'required' => 'create',
			'message' => 'Please enter the organisation name.',
		),
	);

	public $belongsTo = array(
		'LuPartnerState',
	);

	public $hasMany = array(
		'Service',
	);

	public $hasOne = array(
		'Account',
	);

	/**
	*	Callbacks
	*/

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
