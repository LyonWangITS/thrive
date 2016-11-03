<?php

/**
*	This drives logging in/out, password reset. etc, and dashboard.
*/
class AdminController extends AppController {

	public $components = array(
		'PartnerForm',
	);

	public $uses = array(
		'Account',
		'Partner',
		'PendingChange',
	);

	/**
	*	This is a page for users to edit their own account details (account, 
	*	partner and services).
	*/
	public function details() {

		//
		// No admins, just users.
		$this->restrict_to_user();

		//
		// The form is handled using same code as /partners/edit.
		$this->PartnerForm->handle_form( $this->current_user['Partner']['id'] );
	}

	/**
	*	Allows changing password. 
	*/
	public function change_password() {
		
		// 
		// Handle postback
		if ( empty( $this->data ) ) {
		
			// Populate initial form with current details.
			$this->request->data = $this->current_user;
			return;
		}

		// Set derived values
		$this->request->data['Account']['id'] = $this->current_user['Account']['id'];
		
		// Validate and save
		if ( !$this->Account->save( $this->data ) ) {

			$this->Session->setFlash( 'Please correct the error(s) below. ', 'failure' );
			return;
		}
		
		// Because email could have been updated, log user back in with new details.
		$account = $this->Account->findById( $this->current_user['Account']['id'] );
		$this->Auth->login( $account['Account'] );
		
		$this->Session->setFlash( 'Account details updated!', 'success' );
		$this->redirect( "/admin" );
		return;
	}

	/**
	*	Allows a user to initiate a password reset. An email with a 
	*	verification link is sent. Only if that's clicked is their password reset.
	*/
	public function forgot_password() {
		
		//
		// Handle postbacks
		if ( empty( $this->data ) ) {
			return;
		}
		
		$account = $this->Account->find( 'first', array(
			'conditions' => array(
				'Account.email' => $this->data['Account']['email'],
			),
		) );
		if ( empty( $account ) ) {
		
			$this->Session->setFlash( "Sorry, no account found with email address <strong>" . htmlentities( $this->data['Account']['email'] ) . "</strong>. Please try again.", 'failure' );
			$this->redirect( '/admin/forgot_password' );
			return;
		}
		
		//
		// Set new reset code for account
		$this->Account->id = $account['Account']['id'];
		$reset_code = random_string( 6 );
		$this->Account->saveField( 'reset_code', $reset_code );
		
		// Send email
		App::uses( 'CakeEmail', 'Network/Email' );
		$email = new CakeEmail( 'default' );
			$email->template( 'forgot_password' )
			->to( $account['Account']['email'] )
			->from( array( EMAIL_GENERAL => EMAIL_FROM_NAME ) )
			->subject( 'Instructions to reset your THRIVE password' );
		$email->viewVars( array( 'account' => $account, 'reset_code' => $reset_code ) );
		$email->send();

		// Done
		$this->Session->setFlash( "We have emailed instructions to reset your password to <strong>{$account['Account']['email']}</strong>.", 'success' );
		unset( $this->request->data );
		return;
	}

	/**
	*	Dashboard. 
	*/
	public function index() {
	
		//
		// Populate content

		// Admin stats
		if ( !empty( $this->current_user['Account']['is_admin'] ) ) {

			$unapproved_count = $this->Partner->find( 'count', array(
				'conditions' => array(
					'Partner.lu_partner_state_id' => LU_PARTNER_STATE_UNAPPROVED,
				),
			) );
			$this->set( 'unapproved_count', $unapproved_count );

			$approved_count = $this->Partner->find( 'count', array(
				'conditions' => array(
					'Partner.lu_partner_state_id' => LU_PARTNER_STATE_APPROVED,
				),
			) );
			$this->set( 'approved_count', $approved_count );

			$change_count = $this->PendingChange->find( 'count', array(
				'conditions' => array(
					'Partner.lu_partner_state_id !=' => LU_PARTNER_STATE_DELETED,
				),
			) );
			$this->set( 'change_count', $change_count );
		}
	}
	
	/**
	*	Login page.
	*/
	public function login() {
		
		//
		// If already logged in, redirect to dash
		if ( !empty( $this->current_user ) ) {
		
			$this->redirect( '/admin' );
		}
		
		//
		// Handle postback
		if ( empty( $this->data ) ) {
			return;
		}
	
		// Handle login
		if ( $this->Auth->login() ) {
		
			// If user is not an admin, must be attached to a partner.
			$account = $this->Auth->user();
			$is_valid = (
				!empty( $account['is_admin'] ) ||
				$account['Partner']['lu_partner_state_id'] != LU_PARTNER_STATE_DELETED
			);
			if ( !$is_valid ) {

				$this->Session->setFlash( 'Unable to log in. Your institution is pending approval.', 'failure' );
				$this->Auth->logout();
				$this->redirect( $this->Auth->loginAction );
			}

			$this->redirect( '/admin' );
			return;
		} 
		else {
		
			$this->Session->setFlash( 'Email or password is incorrect.', 'failure' );
		}
	}
	
	/**
	*	Logout page.
	*/
	public function logout() {
		
		$this->Auth->logout();
		$this->current_user = null;
		$this->set( 'current_user', null );
	}

	/**
	*	Registration page.
	*/
	public function register() {

		//
		// If already logged in, redirect to dash
		if ( !empty( $this->current_user ) ) {
		
			$this->redirect( '/admin' );
		}

		//
		// The form is handled using same code as /partners/add.
		$this->PartnerForm->handle_form();
	}

	/**
	*	Users come here from an email to reset their password.
	*	Not a viewable page, redirects away.
	*/
	public function reset_password( $account_id = '', $reset_code = '' ) {
	
		// Validate account
		$account = $this->Account->find( 'first', array(
			'conditions' => array(
				'Account.id' => $account_id,
				'Account.reset_code' => $reset_code 
			),
		) );
		if ( empty( $account ) ) { 
			
			$this->Session->setFlash( 'Sorry, unable to reset password. Please try the forgot password feature again.', 'failure' );
			$this->redirect( '/admin/forgot_password' );
			die;
		}
	
		// Update password
		$new_password = random_string( 7 );
		$this->Account->id = $account_id;
		$this->Account->saveField( 'password', $new_password );
		
		// Clear the reset code so the reset email will no longer work.
		$this->Account->saveField( 'reset_code', null );
	
		// Send email
		App::uses( 'CakeEmail', 'Network/Email' );
		$email = new CakeEmail( 'default' );
		$email->template( 'reset_password' )
			->to( $account['Account']['email'] )
			->from( array( EMAIL_GENERAL => EMAIL_FROM_NAME ) )
			->subject( 'Your new THRIVE password' );
		$email->viewVars( array( 'account' => $account, 'new_password' => $new_password ) );
		$result = $email->send();

		// Log them in
		$this->Auth->login( $account['Account'] );
		
		// Done
		$this->Session->setFlash( "Password reset to <strong>{$new_password}</strong>. We have logged you in and emailed your new password to <strong>{$account['Account']['email']}</strong>. You can change your password by going to My Account.", 'success' );
		$this->redirect( '/admin' );
	}

	/**
	*	Registration thank-you page.
	*/
	public function thank_you() {
	}
	
	/**
	*	Helper methods
	*/
	
	/**
	*	Callbacks
	*/
	
	/**
	*	Called before each action.
	*/
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		// Nothing is public except login stuff.
		$this->Auth->deny();
		$this->Auth->allow( 
			'login',
			'logout',
			'forgot_password',
			'register',
			'reset_password',
			'thank_you'
		);
	}
}

?>