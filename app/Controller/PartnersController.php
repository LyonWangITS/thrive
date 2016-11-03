<?php

/**
*	Admin partner CRUD.
*/
class PartnersController extends AppController {

	public $components = array(
		'PartnerForm',
	);

	public $uses = array(
		'Partner',
	);

	public $paginate = array(
		'Partner' => array(
			'conditions' => array(
				'Partner.lu_partner_state_id !=' => LU_PARTNER_STATE_DELETED,
			),
			'limit' => 20, 
			'order' => array(
				'Partner.name' => 'asc',
			),
		),
	);
	
	/**
	*	Default action just redirects to view.
	*/
	public function index() {

		$this->redirect( '/partners/view' );
	}

	/**
	*	List.
	*/
	public function view() {
	
		//
		// Populate page

		// Populate form options
		$this->_populate_form_options();
		
		//
		// Filter
		$conditions = array();
		
		if ( !empty( $this->request->query ) ) {
		
			// Allow GET
			$this->request->data = $this->request->query;
			$this->_apply_filters( $conditions );
		}
		
		$results = $this->paginate( 'Partner', $conditions );
		$this->set( 'results', $results );
	}
	
	/**
	*	Nice way to call edit() for a new entity.
	*/
	public function add() {
	
		$this->edit( null );
		$this->render( 'edit' );
	}
	
	/**
	*	The Add/Edit Details page.
	*	@id The ID of the entity being edited. Set to empty for new entities.
	*/
	public function edit( $id = null ) {
	
		$this->PartnerForm->handle_form( $id );
	}
	
	/**
	*	Preview and confirm deleting an entity.
	*	This is a soft delete only.
	*/
	public function delete( $id = '' ) {
	
		// Validate access
		$partner = $this->Partner->find( 'first', array(
			'conditions' => array( 
				'Partner.id' => $id,
				'Partner.lu_partner_state_id !=' => LU_PARTNER_STATE_DELETED,
			),
		) );
		$this->set( 'partner', $partner );
		if ( empty( $partner ) ) {
		
			throw new ForbiddenException( 'Sorry, you do not have permission to view this partner.' );
		}
		
		//
		// Handle postback
		if ( empty( $this->data ) ) {
		
			return;
		}
		
		//
		// Delete partner
		$this->Partner->id = $id;
		$this->Partner->saveField( 'lu_partner_state_id', LU_PARTNER_STATE_DELETED );
		
		$this->Session->setFlash( "Deleted '{$partner['Partner']['name']}'.", 'success' );
		$this->redirect( "/partners/view" );
		die;
	}
	
	/**
	*	Helper methods
	*/
	
	/**
	*	Filtering options for the list page.
	*/
	private function _apply_filters( &$conditions ) {
	
		// Document name
		if ( !empty( $this->data['name'] ) ) {
		
			$conditions['Partner.name LIKE'] = "%{$this->data['name']}%";
		}
	}
	
	/**
	*	Populate common form options used on add/edit and possibly filtering.
	*/
	private function _populate_form_options() {
	}
	
	/**
	*	Callbacks
	*/
	
	/**
	*	Called before each action.
	*/
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		// Admin only
		$this->restrict_to_admin();
	}
}
