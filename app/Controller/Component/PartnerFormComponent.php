<?php

App::uses( 'Component', 'Controller' );

/**
*	Wraps up the logic for processing the partner form seeing it appears in a few 
*	places and contexts.
*/
class PartnerFormComponent extends Component {

	private $controller = null;
	
	/**
	*	Constructor
	*/
	public function __construct( ComponentCollection $collection, $settings = array() ) {
	
		parent::__construct( $collection, $settings );
	}

	/**
	*	This is called automatically prior to any actions being called.
	*/
	public function initialize( Controller $controller ) {
		
		$this->controller = $controller;

		// Give ourselves access to any models we need
		$this->Partner = ClassRegistry::init( 'Partner' );
		$this->PendingChange = ClassRegistry::init( 'PendingChange' );
		$this->Role = ClassRegistry::init( 'Role' );
		$this->Service = ClassRegistry::init( 'Service' );
	}

	/**
	*	Handles the full lifecycle for the partner form. Can be accessed in several 
	*	ways, including:
	*	- registration (no user not logged in): creates new unapproved partner, emails admin
	*	- user editing their own profile: creates pending changes, emails admin
	*	- admin adding new partner: created approved partner
	*	- admin editing partner: displays any pending changes, updates partner
	*	@partner_id Should pass in the appropriate ID if this is an edit page.
	*/
	public function handle_form( $partner_id = null ) {

		//
		// Populate form

		$current_user = $this->controller->current_user;

		$role_options = $this->Role->find( 'list', array( 
			'order' => 'order ASC', 
			'fields' => array( 'id', 'name' ) 
		) );
		$this->controller->set( 'role_options', $role_options );

		$status_options = array(
			LU_PARTNER_STATE_UNAPPROVED => 'Unapproved',
			LU_PARTNER_STATE_APPROVED => 'Approved',
		);
		$this->controller->set( 'status_options', $status_options );

		// Try fetch existing partner from database
		$partner = $this->Partner->find( 'first', array(
			'conditions' => array(
				'Partner.id' => $partner_id,
				'Partner.lu_partner_state_id !=' => LU_PARTNER_STATE_DELETED,
			),
		) );
		$this->controller->set( 'partner', $partner );
		if ( !empty( $partner_id ) && empty( $partner ) ) {

			throw new NotFoundException( 'Partner not found.' );
		}

		// If there's a partner and user isn't admin, validate access
		if ( !empty( $partner ) && empty( $current_user['Account']['is_admin'] ) ) {

			if ( $partner['Partner']['id'] != $current_user['Account']['partner_id'] ) {

				throw new ForbiddenException( 'Sorry, you do not have permission to edit this partner.' );
			}
		}

		// Set some defaults
		$this->controller->set( 'is_pending', false );
		$this->controller->set( 'has_pending', false );

		//
		// Handle postbacks
		if ( empty( $this->controller->data ) ) {

			// Populate initial form with values from database.
			if ( !empty( $partner ) ) {
				
				// Check if there are pending changes. 
				if ( !empty( $partner['PendingChange']['data'] ) && empty( $_GET['skip_pending'] ) ) {
				
					// Show pending changes.
					$this->controller->request->data = unserialize( $partner['PendingChange']['data'] );
					$this->controller->set( 'is_pending', true );
					$this->controller->set( 'has_pending', true );
					// Show the pending logo. If keeping same logo, pendingchange won't have a logo file or no_logo ticked
					if ( !empty( $partner['PendingChange']['no_logo'] ) || !empty( $partner['PendingChange']['logo_path'] ) ) {

						$partner['Partner']['logo_path'] = $partner['PendingChange']['logo_path'];
					}
					$this->controller->set( 'partner', $partner );
				}
				else {

					// Show last approved.
					$this->controller->request->data = $partner;
					$this->controller->set( 'is_pending', false );
					$this->controller->set( 'has_pending', ( !empty( $partner['PendingChange']['data'] ) ) );
				}
			}
			return;
		}

		//
		// Validate and save pipeline

		// Set derived values

		// Ensure account is linked
		if ( !empty( $partner ) ) {

			$this->controller->request->data['Partner']['id'] = $partner['Partner']['id'];
			$this->controller->request->data['Account']['partner_id'] = $partner['Partner']['id'];
			$this->controller->request->data['Account']['id'] = $partner['Account']['id'];
		}

		// If ticked 'no logo', clear the field
		if ( !empty( $this->controller->data['Partner']['no_logo'] ) ) {

			$this->controller->request->data['Partner']['logo_path'] = '';
		}

		// This behaves quite differently if it's a user editing their own profile.
		if ( !empty( $current_user ) && empty( $current_user['Account']['is_admin'] ) ) {

			// As a user editing their own profile, we validate the form and if successful, 
			// save a pending change to the database and email admin.

			// Set the slug as partners aren't allowed to edit this
			if ( !empty( $partner ) ) {

				$this->controller->request->data['Partner']['slug'] = $partner['Partner']['slug'];
			}

			// Validate form
			if ( !$this->Partner->saveAll( $this->controller->request->data, array( 'validate' => 'only' ) ) ) {

				$this->controller->Session->setFlash( 'Please correct the error(s) below. ', 'failure' );
				return;
			}

			// Delete any cached versions of the pending logo as it could have changed
			if ( !empty( $partner['PendingChange']['logo_path'] ) ) {

				$logo_path = $partner['PendingChange']['logo_path'];
				$logo_path = substr( $logo_path, 0, strrpos( $logo_path, '.' ) );
				foreach( glob( WWW_ROOT . "{$logo_path}_*" ) as $file_name ) {
					
					@unlink( $file_name );
				}
			}

			// Save (or update) pending data (including logo, if any), to pending table
			$this->PendingChange->create();
			$this->controller->request->data['Partner']['lu_partner_state_id'] = $partner['Partner']['lu_partner_state_id'];
			$data = array( 
				'partner_id' => $partner['Partner']['id'],
				'data' => serialize( $this->controller->request->data ),
				'file' => $this->controller->request->data['Partner']['file'],
			);
			if ( !empty( $partner ) && !empty( $partner['PendingChange']['id'] ) ) {

				$data['id'] = $partner['PendingChange']['id'];
			}
			$this->PendingChange->save( $data );

			// Email admin
			App::uses( 'CakeEmail', 'Network/Email' );
			$email = new CakeEmail( 'default' );
			$email->template( 'admin_partner_changed' )
				->to( EMAIL_ADMIN )
				->from( array( EMAIL_GENERAL => EMAIL_FROM_NAME ) )
				->subject( "Partner update requires approval: {$partner['Partner']['name']}" );
			$email->viewVars( array( 'partner' => $partner ) );
			$result = $email->send();

			// Display confirmation and done
			$this->controller->Session->setFlash( 'Thank you for updating your details. The will be applied as soon as we review them.', 'success' );
			$this->controller->redirect( '/admin' );
			die;
		}

		// If new account, set up new partner state
		if ( empty( $current_user ) ) {

			$this->controller->request->data['Partner']['lu_partner_state_id'] = LU_PARTNER_STATE_UNAPPROVED;
		}

		/*
		// Ensure at least two services were submitted
		if ( count( $this->controller->data['Service'] ) < 2 ) {

			$this->controller->Session->setFlash( 'Please provide at least two local support services. ', 'failure' );
			return;
		}
		*/

		// Ensure T&C was approved for new accounts
		if ( empty( $current_user ) && empty( $this->controller->data['Account']['read_terms'] ) ) {

			$this->controller->Session->setFlash( 'Sorry, you must agree to the Terms of Use to continue.', 'failure' );
			return;
		}

		// Validate and save
		if ( !$this->Partner->saveAll( $this->controller->data ) ) {

			$this->controller->Session->setFlash( 'Please correct the error(s) below. ', 'failure' );
			return;
		}

		//
		// Post-save logic

		// Delete any services that weren't updated. Do this BEFORE refetching saved partner.
		if ( !empty( $partner ) ) {

			foreach ( $partner['Service'] as $service ) {

				$is_saved = false;
				foreach ( $this->controller->data['Service'] as $new_service ) {

					if ( $new_service['id'] == $service['id'] ) {

						$is_saved = true;
						break;
					}
				}
				if ( !$is_saved ) {

					$this->Service->delete( $service['id'] );
				}
			}
		}

		// Refetch partner
		$partner = $this->Partner->findById( $this->Partner->id );

		// Delete any cached versions of the logo as it could have changed.
		if ( !empty( $partner['Partner']['logo_path'] ) ) {

			$logo_path = $partner['Partner']['logo_path'];
			$logo_path = substr( $logo_path, 0, strrpos( $logo_path, '.' ) );
			foreach( glob( WWW_ROOT . "{$logo_path}_*" ) as $file_name ) {
				
				@unlink( $file_name );
			}
		}

		// If there was logo uploaded with the pending change, may need to copy logo over.
		if ( !empty( $partner['PendingChange']['id'] ) ) {

			$copy_pending_logo = (
				!empty( $partner['PendingChange']['logo_path'] ) && 
				empty( $this->controller->request->data['Partner']['file']['tmp_name'] ) &&
				empty( $this->controller->request->data['Partner']['keep_old_logo'] )
			);

			// Handle the common step for 2 and 3
			if ( $copy_pending_logo ) {

				// Delete the current logo
				if ( !empty( $partner['Partner']['logo_path'] ) ) {

					@unlink( WWW_ROOT . $partner['Partner']['logo_path'] );
				}

				// Move the new logo from the pending directory.
				$extension = explode( '.', $partner['PendingChange']['logo_path'] );
				$extension = array_pop( $extension );
				$new_path = "/images/partners/{$partner['Partner']['id']}.{$extension}";
				rename( WWW_ROOT . $partner['PendingChange']['logo_path'], WWW_ROOT . $new_path );

				// Update database
				$this->Partner->id = $partner['Partner']['id'];
				$this->Partner->saveField( 'logo_path', $new_path );
			}
		}

		// If there was a pending change, delete the change as it has now been applied.
		if ( !empty( $partner['PendingChange']['id'] ) ) {

			// If a logo was uploaded, tidy up the files.
			if ( !empty( $partner['PendingChange']['logo_path'] ) ) {

				// Ensure the pending logo is deleted.
				@unlink( WWW_ROOT . $partner['PendingChange']['logo_path'] );

				// Delete any cached versions of the pending logo.
				$logo_path = $partner['PendingChange']['logo_path'];
				$logo_path = substr( $logo_path, 0, strrpos( $logo_path, '.' ) );
				foreach( glob( WWW_ROOT . "{$logo_path}_*" ) as $file_name ) {
					
					@unlink( $file_name );
				}
			}

			// Delete from db.
			$this->PendingChange->delete( $partner['PendingChange']['id'] );
		}

		// If new account, email admin and display thank you
		if ( empty( $current_user ) ) {

			// Email admin
			App::uses( 'CakeEmail', 'Network/Email' );
			$email = new CakeEmail( 'default' );
			$email->template( 'admin_new_partner' )
				->to( EMAIL_ADMIN )
				->from( array( EMAIL_GENERAL => EMAIL_FROM_NAME ) )
				->subject( "New partner registration: {$partner['Partner']['name']}" );
			$email->viewVars( array( 'partner' => $partner ) );
			$result = $email->send();

			// Email user
			$email = new CakeEmail( 'default' );
			$email->template( 'new_partner' )
				->to( $partner['Account']['email'] )
				->from( array( EMAIL_GENERAL => EMAIL_FROM_NAME ) )
				->subject( 'Your THRIVE partner registration' );
			// To display their password need to get it from post data. Cannot use version from database (it's hashed).
			$email->viewVars( array( 'partner' => $partner, 'new_password' => $this->controller->data['Account']['password'] ) );
			$result = $email->send();

			$this->controller->Session->setFlash( "An email with account details has been sent to <strong>{$partner['Account']['email']}</strong>.", 'success' );
			$this->controller->redirect( '/admin/thank_you' );
		}

		// If admin, always go to partners page
		if ( !empty( $current_user['Account']['is_admin'] ) ) {
			
			$this->controller->Session->setFlash( 'Partner saved. ', 'success' );
			$this->controller->redirect( '/partners/view' );
		}
	}
}

?>