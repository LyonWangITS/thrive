<?php

/**
*	A user account entity.
*/
class Account extends AppModel {

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'allowEmpty' => false,
			'required' => 'create',
			'message' => 'Please enter your name.',
		),
		'role_id' => array(
			'rule' => 'notEmpty',
			'allowEmpty' => false,
			'required' => 'create',
			'message' => 'Please select your role.',
		),
		'email' => array(
			'email' => array(
				'rule' => 'email',
				'message' => 'Please enter your email address.',
				'required' => 'create',
			),
			'isUnique' => array(
				'rule' => array( 'isUnique' ),
				'required' => 'create',
				'message' => 'Your email address is already in use by another account.',
			)
		),
		'new_email' => array(
			'email' => array(
				'rule' => 'email',
				'message' => 'Please enter a valid new email address or leave blank.',
				'allowEmpty' => true,
			),
			'isUnique' => array(
				'rule' => array( 'validate_new_email_is_unique' ),
				'message' => 'Your new email address is already used by another account.',
			)
		),
		'retype_email' => array(
			'rule' => array( 'validate_emails_match' ),
			'allowEmpty' => true,
			'message' => 'Your new email and re-typed email did not match.',
		),
		'password' => array(
			'rule' => array( 'minLength', 6 ),
			'required' => 'create',
			'message' => 'Your password must be at least 6 characters long.',
		),
		'new_password' => array(
			'rule' => array( 'minLength', 6 ),
			'allowEmpty' => true,
			'message' => 'Your new password must be at least 6 characters long.',
		),
		'retype_password' => array(
			'rule' => array( 'validate_passwords_match' ),
			'required' => 'create',
			'message' => 'Your password and re-typed password did not match.',
		),
	);

	public $virtualFields = array(
	);
	
	public $belongsTo = array(
		'Partner',
	);
	
	/**
	*	Custom validation rules
	*/

	/**
	*	Checks the new_email is unique. Cannot use isUnique here because new_email isn't actually in the database.
	*/
	function validate_new_email_is_unique() {
		
		$count = $this->find( 'count', array( 'conditions' => array( 
			'Account.id !=' => $this->data[$this->name]['id'],
			'Account.email' => $this->data[$this->name]['new_email'],
		) ) );
		return ( $count == 0 );
	}

	/**
	 * Custom validation method that ensures email and re-typed email are the same.
	 *
	 * @param array $data
	 * @return boolean whether the emails match
	 */
	public function validate_emails_match( $data ) {
	
		return ( 
			!empty( $this->data[$this->alias]['new_email'] ) &&
			$this->data[$this->alias]['new_email'] == $data['retype_email']
		);
	}
	
	/**
	 * Custom validation method that ensures password and re-typed password are the same.
	 * Can match the retype_password against password or new_password.
	 *
	 * @param array $data
	 * @return boolean whether the passwords match
	 */
	public function validate_passwords_match( $data ) {
	
		if ( isset( $this->data[$this->alias]['new_password'] ) ) {

			return ( 
				empty( $this->data[$this->alias]['new_password'] ) ||
				$this->data[$this->alias]['new_password'] == $data['retype_password']
			);
		}
		else {
		
			return ( 
				!empty( $this->data[$this->alias]['password'] ) &&
				$this->data[$this->alias]['password'] == $data['retype_password']
			);
		}
	}
		
	/**
	*	Callbacks
	*/

	/**
	*	Always called before model or field is saved.
	*/
	public function beforeSave( $options = array() ) {
	
		//
		// If updating email, copy new_email to the actual email field.
		if ( isset( $this->data[$this->name]['new_email'] ) && !empty( $this->data[$this->name]['new_email'] ) ) {
			 
			$this->data[$this->name]['email'] = $this->data[$this->name]['new_email'];
		}

		//
		// If updating password, copy new_password to the actual email field.
		if ( isset( $this->data[$this->name]['new_password'] ) && !empty( $this->data[$this->name]['new_password'] ) ) {
			 
			$this->data[$this->name]['password'] = $this->data[$this->name]['new_password'];
		}
	
		//
		// Change password functionality
		if ( isset( $this->data[$this->name]['password'] ) && !empty( $this->data[$this->name]['password'] ) ) {
			 
			$hashed_password = AuthComponent::password( $this->data[$this->name]['password'] );
			$this->data[$this->name]['password'] = $hashed_password;
		}
		
		return true;
	}
}
