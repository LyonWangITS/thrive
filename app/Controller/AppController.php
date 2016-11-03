<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $uses = array(
		'Account',
	);
	
	public $components = array(
		'Auth' => array(
			'loginAction' => '/admin/login',
			'logoutRedirect' => '/admin/logout',
			'authenticate' => array(
				'Form' => array(
					'fields' => array( 'username' => 'email' ),
					'userModel' => 'Account',
				),
			),
		),
		'Session',
	);
	
	public $current_user = null;
	
	/**
	*	Helper methods
	*/

	// Ensures the current page is being accessed via HTTPS otherwise reloads.
	// Only happens on live. 
	protected function ensure_ssl() {
	
		if ( !ENFORCE_SSL ) {

			return;
		} 
		
		if ( !isset( $_SERVER['HTTPS'] ) || empty( $_SERVER['HTTPS'] ) ) {

			$redirect = "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
			$this->redirect( $redirect );
		}
	}
	
	/**
	*	Ensures the current user is logged in, otherwise redirects to login page.
	*	This is partly to capture when an admin accesses a page intended for users.
	*/
	protected function restrict_to_user() {

		if ( empty( $this->current_user ) || !empty( $this->current_user['Account']['is_admin'] ) ) {
		
			$this->redirect( $this->Auth->loginAction );
			return;
		}
	}

	/**
	*	Ensures the current user is logged in as an admin, otherwise redirects to login page.
	*/
	protected function restrict_to_admin() {

		if ( empty( $this->current_user ) || empty( $this->current_user['Account']['is_admin'] ) ) {
		
			$this->redirect( $this->Auth->loginAction );
			return;
		}
	}

	/**
	*	Callbacks
	*/

	/**
	*	Called before each action.
	*/
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		//
		// By default, everything is public. Each controller needs to lock down its own actions.
		$this->Auth->allow();

		//
		// Populate current user if they are not admin. Admin is still a user, but shouldn't 
		// appear as one to the public site.
		$current_user = $this->Account->find( 'first', array(
			'conditions' => array(
				'Account.id' => $this->Auth->user( 'id' ),
			),
		) );
		
		$this->current_user = $current_user;
		$this->set( 'current_user', $current_user );
		
		//
		// Set the return_url
		$return_url = '?return=' . urlencode( $this->here );
		$this->return_url = $return_url;
		$this->set( 'return_url', $return_url );
		
		//
		// This is a useful but crazy long parameter to have available in forms.
		// Pass this to a field using the error key to have error message HTML not escaped.
		// E.g. $this->Form->input( 'field_name', array( 'error' => $no_escape_html );
		$no_html_escape = array( 'attributes' => array( 'escape' => false ) );
		$this->set( 'no_html_escape', $no_html_escape );
	}
}
