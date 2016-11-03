<?php
class PartnerRoute extends CakeRoute {

	/**
	*	Checks if the current URL, stripped of slahes, is a partner slug. 
	*	If so, redirects to the survey script. E.g. curtin -> /curtin/survey.php
	*/
	public function parse( $url ) {
	
		$partner_slug = trim( $url, '/' );
		
		App::import( 'model', 'Partner' );
		$partner_model = new Partner();
		$count = $partner_model->find( 'count', array(
			'conditions' => array( 'Partner.slug' => $partner_slug ),
			'recursive' => -1,
		) );
		if ( $count > 0 ) {

			header( "Location: /{$partner_slug}/survey.php" );
			die;
		}

		return false;
	}

}
