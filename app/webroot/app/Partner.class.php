<?php
/**
*	A partner.
*/
class Partner {

	private static $current_partner = null; // Saves refetching from the database

	/*
		Properties
	*/
	public $id = null;
	public $data = null;
	
	function __construct(){
	}

	/*
		CRUD methods
	*/

	/*
		Load partner by key/value (or returns first partner if no key provided). Partner must be active.
		- loads up the fetched data into this->data
	*/
	public function loadFrom( $from = 'id', $value = '' ) {
	
		if ( empty( $from ) ) {

			$sql = "SELECT *
					FROM partners as p
					WHERE p.lu_partner_state_id = " . LU_PARTNER_STATE_APPROVED . "
					ORDER BY p.id ASC
					LIMIT 1";
		}
		else {

			$sql = "SELECT *
					FROM partners as p
					WHERE p.$from = ?
					AND p.lu_partner_state_id = " . LU_PARTNER_STATE_APPROVED;
		}
		
		try{
			
			$db = getConnection();
			$stmt = $db->prepare( $sql );
			$stmt->execute( array( $value ) );
			
			$result = $stmt->fetch( PDO::FETCH_ASSOC );
			$db = null;
			
			if ( $result ) {
				
				$this->data = $result;
				$this->id = $result['id'];
				
				return $result;
				
			}
			
		} catch( PDOException $e ){
			
			echo $e->getMessage();
		}
	}

	/*
		Returns an array of services belonging to the given partner.
	*/
	public static function loadServices( $partner_id ) {

		$sql = "SELECT *
				FROM services as s
				WHERE s.partner_id = ?";
		
		try {
			$db = getConnection();
			$stmt = $db->prepare( $sql );
			$stmt->execute( array( $partner_id ) );
			
			$services = array();
			while ( $result = $stmt->fetch( PDO::FETCH_ASSOC ) ) {

				$services[] = $result;
			}
			return $services;
			
		} catch( PDOException $e ){
			
			echo $e->getMessage();
		}
	}

	/*
		Static interface
	*/

	/**
	*	Parses the current request to return the appropriate partner from the database.
	*	@return Partner Matched partner or empty partner object (not null).
	*/
	public static function getCurrentPartner() {

		// Check cache
		if ( !empty( Partner::$current_partner ) ) {

			return Partner::$current_partner;
		}

		//
		// Get the partner slug (the first directory in the URL)
		$partner_slug = explode( '/', ltrim( $_SERVER['REQUEST_URI'], '/' ) );
		$partner_slug = array_shift( $partner_slug );

		//
		// Fetch partner
		$partner = new Partner();
		$partner->loadFrom( 'slug', $partner_slug );

		/*
		// If partner not found, load the default instead
		if ( empty( $partner->id ) ) {

			$partner->loadFrom( null );
		}
		*/

		Partner::$current_partner = $partner;

		return $partner;
	}

	/**
	 * Gets a partner by ID.
	 * @param $id int The ID of the partner to return.
	 * @return Partner The partner, or null if not found.
	 */
	public static function getPartnerById( $id ) {

		//
		// Fetch partner
		$partner = new Partner();
		$partner->loadFrom( 'id', $id );

		// If partner not found, return null
		if ( empty( $partner->id ) ) {

			return null;
		}

		return $partner;
	}

}
