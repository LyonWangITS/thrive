<?php
/*
	Survey Model Interface
*/

	class Survey {

		/*
			Properties
		*/
		public $token = null;
		public $id = null;
		public $data = null;


		function __construct(){

		}

		/*
			Survey Lifecycle
		*/


		/*
			Load survey from token or id
			- loads up the fetched data into this->data
		*/
		public function loadFrom( $from = 'id', $value ){

			$from_field = ( $from == 'token' ? 'token' : 'id' );

			$sql = "SELECT *
					FROM entries as e
					WHERE e.$from_field = ?";

			try{

				$db = getConnection();
				$stmt = $db->prepare( $sql );
				$stmt->execute( array( $value ) );

				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				$db = null;

				if ( $result ){

					$this->data = $result;
					$this->id = $result['id'];
					$this->token = ifne( $result, 'token' );

					return $result;

				}

			} catch( PDOException $e ){

				echo $e->getMessage();

			}

		}



		/*
			Save survey data
		*/
		public function save( $data ){

			if ( $this->id ){

				$columns = array_keys( $data );
				$placeholders = array();
				foreach( $columns as $column ){
					$placeholders[] = $column . '= :' . $column;
				}

				$sql = "UPDATE entries
						SET " . implode( ', ', $placeholders ). "
						WHERE id = :id";

				try {

					$db = getConnection();
					$stmt = $db->prepare( $sql );

					foreach ( $data as $key => $value ){
						$stmt->bindValue( ':' . $key, $value );
					}
					$stmt->bindValue( 'id', $this->id );

					$stmt->execute();
					$db = null;

				} catch( PDOException $e ){

					echo $e->getMessage();

				}

			}

		}



		/*
			Create new survey record
			- return last inserted id
		*/
		public static function create( $partner_id, $participant_name, $participant_id, $is_test = false ){

			$token = Survey::newToken();

			//Add it
			$inserted_id = 0;
			$result = null;
			$is_test = !empty( $is_test ) ? '1' : '0';

			if ( $token != '' ){

				$sql = "INSERT INTO entries (
							partner_id,
							token,
							started,
							is_test,
							00_participant_name,
							00_participant_id
						) VALUES (
							:partner_id,
							:token,
							:started,
							:is_test,
							:participant_name,
							:participant_id
						)";

				try{

					$db = getConnection();
					$stmt = $db->prepare( $sql );
					$stmt->bindValue( 'partner_id', $partner_id );
					$stmt->bindValue( 'token', $token );
					$stmt->bindValue( 'started', get_gmt() );
					$stmt->bindValue( 'is_test', $is_test );
					$stmt->bindValue( 'participant_name', $participant_name );
					$stmt->bindValue( 'participant_id', $participant_id );

					$stmt->execute();
					$inserted_id = $db->lastInsertId();
					$db = null;

				} catch( PDOException $e ){

					echo $e->getMessage();

				}

			}

			return ( $inserted_id ? $token : null );

		}

		/*
			Find last completed stage
			- available stages are:
			 	- 0 : Welcome, name entry,
				- 1 : All about you
				- 2 : Past & present drinking
				- 3 : In the last four weeks
				- 4 : Alcohol related problems
				- 5 : Results

			- ie. returns 0 if 1 is incomplete
		*/
		public function lastCompletedStage(){

			$last_stage = 0;

			if ( $this->data ){

				// 0 : Welcome
				if ( ifne( $this->data, '00_participant_name', null ) !== null ) {
					$last_stage = 0;
				}

				// 1 : All about you
				$stage_1_keys = array(
					'01_gender',
					'01_age',
					'01_race',
					'01_ethnicity',
					'01_where',
					'01_first_pet',
					'01_first_concert',
					'01_mother_letters',
					'01_phone_digits',
				);
				$stage_1_passed = true;
				foreach( $stage_1_keys as $key ){
					if ( ifne( $this->data, $key, null ) === null ){
						$stage_1_passed = false;
						break;
					}
				}

				$stage_2_passed = true;
				$page_vars = get_stage_vars(2);
				foreach (array_keys($page_vars['tabular']['rows']) as $field) {
					if ( ifne( $this->data, '02_' . $field, null ) === null ) {
						$stage_2_passed = false;
						break;
					}
				}

				// 3 : Past & Present Drinking
				$stage_3_keys = array(
					'03_how_often_drink_alcohol',
					'03_how_many_on_typical_day',
					'03_how_often_six_or_more',
					'03_past_year_how_often_unable_to_stop',
					'03_past_year_how_often_failed_expectations',
					'03_past_year_needed_morning_drink',
					'03_past_year_how_often_remorseful',
					'03_past_year_how_often_unable_to_remember',
					'03_been_injured_or_injured_someone',
					'03_others_concerned_about_my_drinking'
				);
				$stage_3_passed = true;
				foreach( $stage_3_keys as $key ){
					if ( ifne( $this->data, $key, null ) === null ){
						$stage_3_passed = false;
						break;
					}
				}

				$stage_4_passed = true;
				$stage_5_passed = true;
				$stage_6_passed = true;

				$stage_4_keys = array(
					'04_past_4wk_largest_number_single_occasion',
					'04_past_4wk_hours_amount_drank',
					'04_body_height_cm',
					'04_body_weight_kg'
				);

				$page_vars = get_stage_vars(5);
				foreach (array_keys($page_vars['tabular']['rows']) as $field) {
					if ( ifne( $this->data, '05_' . $field, null ) === null ) {
						$stage_5_passed = false;
						break;
					}
				}

				$page_vars = get_stage_vars(6);
				foreach (array_keys($page_vars['tabular']['rows']) as $field) {
					if ( ifne( $this->data, '06_' . $field, null ) === null ) {
						$stage_6_passed = false;
						break;
					}
				}

				foreach( $stage_4_keys as $key ){
					if ( ifne( $this->data, $key, null ) === null ) {
						$stage_4_passed = false;
						break;
					}
				}

				$stage_7_passed = true;
				$page_vars = get_stage_vars(7);
				foreach (array_keys($page_vars['tabular']['rows']) as $field) {
					if ( ifne( $this->data, '07_' . $field, null ) === null ) {
						$stage_7_passed = false;
						break;
					}
				}

				$stage_8_passed = true;
				$page_vars = get_stage_vars(8);
				foreach (array_keys($page_vars['tabular']['rows']) as $field) {
					if ( ifne( $this->data, '08_' . $field, null ) === null ) {
						$stage_8_passed = false;
						break;
					}
				}

				$stage_9_keys = array(
					'09_tobacco_use',
					'09_tobacco_frequency',
					'09_tobacco_init',
				);

				$stage_9_passed = true;
				foreach( $stage_9_keys as $key ){
					if ( ifne( $this->data, $key, null ) === null ) {
						$stage_9_passed = false;
						break;
					}
				}

				//Calculate
				if ( $stage_1_passed ) {
					if ( $stage_2_passed ) {
						if ( $stage_3_passed ) {
							if ( $stage_4_passed ) {
								if ( $stage_5_passed ) {
									if ( $stage_6_passed ) {
										if ( $stage_7_passed ) {
											if ( $stage_8_passed ) {
												if ( $stage_9_passed ) {
													$last_stage = 9;
												} else {
													$last_stage = 8;
												}
											} else {
												$last_stage = 7;
											}
										} else {
											$last_stage = 6;
										}
									} else {
										$last_stage = 5;
									}
								} else {
									$last_stage = 4;
								}
							} else {
								$last_stage = 3;
							}
						} else {
							$last_stage = 2;
						}
					} else {
						$last_stage = 1;
					}
				} else {
					$last_stage = 0;
				}
			}

			return $last_stage;

		}


		/*
			================================================================================
				AUDIT calculations
			================================================================================>

		*/
		public function calculateAuditScore(){
			/*
				03_how_often_drink_alcohol
				- 'never' = 0, 'lt-1pm' = 1, '1pm' = 1, '1p2w' = 2,'1pw' = 2,'2-3pw' = 3,'4pw' = 4

				03_how_many_on_typical_day (numeric)
				- 1-2 = 0, 3-4 = 1, 5-6 = 2, 7-9 = 3, 10+ = 4

				03_how_often_six_or_more
				- 'never' = 0, '1-2py' = 1,'lt-1pm' = 1, '1pm' = 2, '1pw' = 3, '1pd' = 4

				03_past_year_how_often_unable_to_stop
				- 'never' = 0, 'lt-1pm' = 1, '1pm' = 2, '1pw' = 3, '1pd' = 4

				03_past_year_how_often_failed_expectations
				- 'never' = 0, 'lt-1pm' = 1, '1pm' = 2, '1pw' = 3, '1pd' = 4

				03_past_year_needed_morning_drink
				- 'never' = 0, 'lt-1pm' = 1, '1pm' = 2, '1pw' = 3, '1pd' = 4

				03_past_year_how_often_remorseful
				- 'never' = 0, 'lt-1pm' = 1, '1pm' = 2, '1pw' = 3, '1pd' = 4

				03_past_year_how_often_unable_to_remember
				- 'never' = 0, 'lt-1pm' = 1, '1pm' = 2, '1pw' = 3, '1pd' = 4

				03_been_injured_or_injured_someone
				- 'no' = 0, 'yes-nly' = 2, 'yes-ly' = 4

				03_others_concerned_about_my_drinking
				- 'no' = 0, 'yes-nly' = 2, 'yes-ly' = 4

			*/

			$enum_values = array(
				'03_how_often_drink_alcohol' => array(
					'never' => 0,
					'lt-1pm' => 1,
					'1pm' => 1,
					'1p2w' => 2,
					'1pw' => 2,
					'2-3pw' => 3,
					'4pw' => 4
				),
				'03_how_often_six_or_more' => array(
					'never' => 0,
					'1-2py' => 1,
					'lt-1pm' => 1,
					'1pm' => 2,
					'1pw' => 3,
					'1pd' => 4
				),
				'03_past_year_how_often_unable_to_stop' => array(
					'never' => 0,
					'lt-1pm' => 1,
					'1pm' => 2,
					'1pw' => 3,
					'1pd' => 4
				),
				'03_past_year_how_often_failed_expectations' => array(
					'never' => 0,
					'lt-1pm' => 1,
					'1pm' => 2,
					'1pw' => 3,
					'1pd' => 4
				),
				'03_past_year_needed_morning_drink' => array(
					'never' => 0,
					'lt-1pm' => 1,
					'1pm' => 2,
					'1pw' => 3,
					'1pd' => 4
				),
				'03_past_year_how_often_remorseful' => array(
					'never' => 0,
					'lt-1pm' => 1,
					'1pm' => 2,
					'1pw' => 3,
					'1pd' => 4
				),
				'03_past_year_how_often_unable_to_remember' => array(
					'never' => 0,
					'lt-1pm' => 1,
					'1pm' => 2,
					'1pw' => 3,
					'1pd' => 4
				),
				'03_been_injured_or_injured_someone' => array(
					'no' => 0,
					'yes-nly' => 2,
					'yes-ly' => 4
				),
				'03_others_concerned_about_my_drinking' => array(
					'no' => 0,
					'yes-nly' => 2,
					'yes-ly' => 4
				)

			);




			$audit_score = 0;

			$audit_score += ifne ( $enum_values[ '03_how_often_drink_alcohol' ], ifne( $this->data, '03_how_often_drink_alcohol' ) );

			$typical_day_count = ifne( $this->data, '03_how_many_on_typical_day' );
			$typical_day_score = 0;
			if ( $typical_day_count > 0 ){
				if ( ( $typical_day_count >= 3 ) && ( $typical_day_count <= 4 ) ){
					//3-4 = 1
					$typical_day_score = 1;
				} elseif ( ( $typical_day_count >= 5 ) && ( $typical_day_count <= 6 ) ){
					//5-6 = 2
					$typical_day_score = 2;
				} elseif ( ( $typical_day_count >= 7 ) && ( $typical_day_count <= 9 ) ){
					//7-9 = 3
					$typical_day_score = 3;
				} else if ( $typical_day_count >= 10 ) {
					//10+
					$typical_day_score = 4;
				}
			}
			$audit_score += $typical_day_score;

			$audit_score += ifne ( $enum_values[ '03_how_often_six_or_more' ], ifne( $this->data, '03_how_often_six_or_more' ) );
			$audit_score += ifne ( $enum_values[ '03_past_year_how_often_unable_to_stop' ], ifne( $this->data, '03_past_year_how_often_unable_to_stop' ) );
			$audit_score += ifne ( $enum_values[ '03_past_year_how_often_failed_expectations' ], ifne( $this->data, '03_past_year_how_often_failed_expectations' ) );
			$audit_score += ifne ( $enum_values[ '03_past_year_needed_morning_drink' ], ifne( $this->data, '03_past_year_needed_morning_drink' ) );
			$audit_score += ifne ( $enum_values[ '03_past_year_how_often_remorseful' ], ifne( $this->data, '03_past_year_how_often_remorseful' ) );
			$audit_score += ifne ( $enum_values[ '03_past_year_how_often_unable_to_remember' ], ifne( $this->data, '03_past_year_how_often_unable_to_remember' ) );
			$audit_score += ifne ( $enum_values[ '03_been_injured_or_injured_someone' ], ifne( $this->data, '03_been_injured_or_injured_someone' ) );
			$audit_score += ifne ( $enum_values[ '03_others_concerned_about_my_drinking' ], ifne( $this->data, '03_others_concerned_about_my_drinking' ) );

			return $audit_score;

		}




		public function calculateBAC(){

			$audit_score = $this->calculateAuditScore();

			$standard_drinks = ifne( $this->data, '04_past_4wk_largest_number_single_occasion' );
			$weight = ifne( $this->data, '04_body_weight_kg' );

			//Body water constant
			/*
				0.58 for Males, 0.49 for Females
			*/
			$gender = ifne( $this->data, '01_gender' );
			$gender_constants = array(
				'female' => 0.49,
				'male' => 0.58,
				'transgender-ftm' => 0.49,
				'transgender-mtf' => 0.49,
				'genderqueer' => 0.49,
				'androgynous' => 0.49,
				'intersex' => 0.49
			);
			$body_water_constant = ifne( $gender_constants, $gender, 0.53 );

			//Metabolism rate
			if ( ( $audit_score >= 0 ) && ( $audit_score <= 7 ) ){
				$metabolism_rate = 0.017;
			} else {
				$metabolism_rate = 0.02;
			}

			$drinking_period = ifne( $this->data, '04_past_4wk_hours_amount_drank' );

			$bac = ( ( 0.806 * $standard_drinks ) / ( $body_water_constant * $weight ) ) - ( $metabolism_rate * $drinking_period );


			/*
			echo 'standard drinks :' . $standard_drinks . "\n";
			echo 'bwc : ' . $body_water_constant . "\n";
			echo 'weight : ' . $weight . "\n";
			echo 'metabolism rate : ' . $metabolism_rate . "\n";
			echo 'drinking period : ' . $drinking_period . "\n";
			echo 'bac ====== ' . $bac;

			(1) 0.806 * 2 = 1.612

			(2) 0.58 * 78 = 45.24

			(1)/(2) = 0.03563218391

			(3) = .02 * 1 = .02
			*/

			if ($bac < 0) {
				return 0;
			}

			return $bac;
		}





		public function calculateExpenses(){

			$frequency_multipliers = array(
				'never' => 0,
				'lt-1pm' => 6,
				'1pm' => 12,
				'1p2w' => 26,
				'1pw' => 52,
				'2-3pw' => 130,
				'4pw' => 208
			);

			$past_year_spending = ifne( $this->data, '03_how_many_on_typical_day' ) * $frequency_multipliers[ ifne( $this->data, '03_how_often_drink_alcohol' ) ];

			return array(
				'from' => round( $past_year_spending * 1.50 ),
				'to' => round( $past_year_spending * 6 )
			);
		}



		public function calculateConsumption(){

			//Standard drinks consumed per occasion
			//You reported having approximately {XX} drinks on a typical occasion. The graph on the right shows how this compares to other people your age.
			$consumption_typical_day = ifne( $this->data, '03_how_many_on_typical_day' );

			$frequency_multipliers = array(
				'never' => 0,
				'lt-1pm' => 0.125,
				'1pm' => 0.25,
				'1p2w' => 0.5,
				'1pw' => 1,
				'2-3pw' => 2.5,
				'4pw' => 4
			);
			$consumption_per_week = $consumption_typical_day * $frequency_multipliers[ ifne( $this->data, '03_how_often_drink_alcohol' ) ];

			return array(
				'typical_day' => $consumption_typical_day,
				'per_week' => $consumption_per_week,
				'per_month' => $consumption_per_week * 4
			);


		}


		public function calculateAverageConsumption() {
			$avg = array();

			if ($this->data['01_gender'] == 'male') {
				if ($this->data['01_age'] >= 18 && $this->data['01_age'] <= 20) {
					$avg['occasion'] = 3.9;
					$avg['week'] = 7.19;
				}
				elseif ($this->data['01_age'] > 20 && $this->data['01_age'] <= 25) {
					$avg['occasion'] = 3.09;
					$avg['week'] = 8.46;
				}
				else {
					$avg['occasion'] = 4.26;
					$avg['week'] = 13.24;
				}
			}
			else {
				if ($this->data['01_age'] <= 20) {
					$avg['occasion'] = 2.95;
					$avg['week'] = 3.62;
				}
				elseif ($this->data['01_age'] > 20 && $this->data['01_age'] <= 24) {
					$avg['occasion'] = 2.93;
					$avg['week'] = 4.42;
				}
				else {
					$avg['occasion'] = 0;
					$avg['week'] = 0;
				}
			}

			return $avg;
		}



		/*
			================================================================================
				Token Handling Static Functions (Class Methods)
			================================================================================
		*/

		/*
			Create new unique token
		*/
		public static function newToken(){

			$token = random_token( SURVEY_TOKEN_LENGTH );

			while( Survey::tokenExists( $token ) ){
				$token = random_token( SURVEY_TOKEN_LENGTH );
			}

			return $token;

		}

		/*
			Load survey based on token
		*/
		public static function tokenExists( $token ){

			$result = null;

			if ( $token != '' ){

				$sql = "SELECT
							e.id,
							e.started,
							e.completed,
							e.token
						FROM entries as e
						WHERE e.token = ?";

				try{

					$db = getConnection();
					$stmt = $db->prepare( $sql );
					$stmt->execute( array( $token ) );

					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					$db = null;

				} catch( PDOException $e ){

					echo $e->getMessage();

				}

			}

			$exists = ( $result ? true : false );

			return $exists;

		}



	}

