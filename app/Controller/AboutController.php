<?php

/**
*	Drives the static pages for the site.
*/
class AboutController extends AppController {

	public $components = array(
	);
	
	public $helpers = array(
	);

	public $uses = array(
		'Partner',
	);

	public $layout = 'static';

	/**
	*	Homepage
	*/
	public function home() {
	
		// Populate partner list
		$partners = $this->Partner->find( 'all', array(
			'conditions' => array(
				'Partner.lu_partner_state_id' => LU_PARTNER_STATE_APPROVED,
			),
			'order' => array( 'Partner.name' => 'asc' ),
		) );
		$this->set( 'partners', $partners );
	}

	/**
	*	About page
	*/
	public function index() {
	}
	
	/**
	*	Terms and Conditions page
	*/
	public function terms() {
	
		$this->layout = 'default';
	}
	
	/**
	*	Callbacks
	*/
	
	/**
	*	Called before each action.
	*/
	public function beforeFilter() {
		
		parent::beforeFilter();
	}
}

?>