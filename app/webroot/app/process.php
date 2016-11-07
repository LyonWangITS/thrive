<?php
/*
	Process any incoming data

	GLOBALS:
	$the_survey
	$existing_token
*/
function doProcess( $the_survey, $existing_token ){

	$form_errors = array();

	if ( !empty( $_POST ) ){

		$survey_stage = ifne( $_POST, 'survey-stage', 0 );

		//Validation rules
		// 0 : name - notempty
		if ( $survey_stage == 0 ){
			$form_errors = array(
				'participant_name' => validateField( ifne( $_POST, 'participant_name' ), 'notempty', 'Name cannot be empty' )
			);

			if ( formIsValid( $form_errors ) ){

				//Create it
				$partner = Partner::getCurrentPartner();
				$is_test = ( !empty( $_POST['is_test'] ) );
				$new_token = Survey::create( $partner->data['id'], $_POST[ 'participant_name' ], $is_test );

				do_redirect( 'survey.php?t=' . urlencode( $new_token ) );
				//exit
			}

		}


		/*

			'01_gender',
			'01_age',
			'01_type_of_study',
			'01_hours_per_week',
			'01_alcohol_last_12mths'

		*/
		if ( $survey_stage == 1 ){

			$gender = ifne( $_POST, 'gender-mf', ifne( $_POST, 'gender-more' ) );

			/*
			$form_errors = array(
				'gender' => validateField( $gender, 'in-set', 'Gender is unrecognized', array('female','male','transgender-ftm','transgender-mtf','genderqueer','androgynous','intersex') ),
				'age' => validateField( ifne( $_POST, 'age' ), ( $_POST[ 'age' ] > 17 ), 'You must be over 17 to take part in this survey' ),
				'type_of_study' => validateField( ifne( $_POST, 'type_of_study' ), 'in-set', 'Please select a value', array( 'vet-trade','vet-non-trade','higher-ed','unsure' ) ),
				'hours_per_week' => validateField( ifne( $_POST, 'hours_per_week' ), 'in-set', 'Please select a value', array( 'gt-10', 'lt-10' ) ),
				'alcohol_last_12mths' => validateField( ifne( $_POST, 'alcohol_last_12mths' ), 'in-set', 'Please select a value', array( 'yes', 'no') )
			);
			*/

			$form_errors = array(
				'gender' => validateField( $gender, 'in-set', 'Gender is unrecognized', array('female','male','transgender-ftm','transgender-mtf','genderqueer','androgynous','intersex') ),
				'age' => validateField( ifne( $_POST, 'age' ), ( $_POST[ 'age' ] > 17 ), 'You must be over 17 to take part in this survey' ),
				'staff_student' => validateField( ifne( $_POST, 'staff_student' ), 'in-set', 'Please select a value', array( 'staff', 'student' ) ),
				'alcohol_last_12mths' => validateField( ifne( $_POST, 'alcohol_last_12mths' ), 'in-set', 'Please select a value', array( 'yes', 'no') ),
			);

			if ( $_POST['staff_student']  == 'student' ){

				$form_errors[] = validateField( ifne( $_POST, 'hours_per_week' ), 'in-set', 'Please select a value', array( 'gt-10', 'lt-10' ) );
			}

			// Optional demographic questions
			// These only apply for students
			if ( $_POST['staff_student']  == 'student' ) {

				$partner = Partner::getCurrentPartner();
				if (!empty($partner->data['is_year_level_question_enabled'])) {

					$form_errors[] = validateField(ifne($_POST, 'year_level'), 'in-set', 'Please select a value', array('1st-year', '2nd-year', '3rd-year', '4th-year', 'postgraduate', 'not-applicable'));
				}
				if (!empty($partner->data['is_on_campus_question_enabled'])) {

					$form_errors[] = validateField(ifne($_POST, 'on_campus'), 'in-set', 'Please select a value', array('yes', 'no'));
				}
				if (!empty($partner->data['is_from_question_enabled'])) {

					$form_errors[] = validateField(ifne($_POST, 'where_from'), 'in-set', 'Please select a value', array('perth-metro', 'regional-wa', 'other-state', 'international'));
				}
			}

			if ( formIsValid( $form_errors ) ) {

				$data = array(
					'01_gender' => $gender,
					'01_age' => $_POST[ 'age' ],
					'01_staff_student' => $_POST[ 'staff_student' ],
					'01_hours_per_week' => ( isset( $_POST[ 'hours_per_week' ] ) ) ? $_POST[ 'hours_per_week' ] : null,
					'01_year_level' => ( isset( $_POST[ 'year_level' ] ) ) ? $_POST[ 'year_level' ] : null,
					'01_on_campus' => ( isset( $_POST[ 'on_campus' ] ) ) ? ( $_POST[ 'on_campus' ] == 'yes' ? 1 : 0 ) : null,
					'01_where_from' => ( isset( $_POST[ 'where_from' ] ) ) ? $_POST[ 'where_from' ] : null,
					'01_alcohol_last_12mths' => ( $_POST[ 'alcohol_last_12mths' ] == 'yes' ? 1 : 0 ),
				);

				if ( $data[ '01_alcohol_last_12mths' ] == 0 ){
					$data[ 'completed' ] = get_gmt();
				}

				$the_survey->save( $data );

				do_redirect( 'survey.php?t=' . urlencode( $existing_token ) );
				//exit
			} else {
				//echo print_r($form_errors);
			}

		} else if ( $survey_stage == 2 ){

			$form_errors = array(
				'how_often_drink_alcohol' => validateField( ifne( $_POST, 'how_often_drink_alcohol' ), 'in-set', 'Please select a value', array( 'never','lt-1pm','1pm','1p2w','1pw','2-3pw','4pw' ) ),
				'how_many_on_typical_day' => validateField( ifne( $_POST, 'how_many_on_typical_day' ), 'notempty', 'Please enter a value' ),
				'how_often_six_or_more' => validateField( ifne( $_POST, 'how_often_six_or_more' ), 'in-set', 'Please select a value', array( 'never','1-2py','lt-1pm','1pm','1pw','1pd' ) ),
				'past_year_how_often_unable_to_stop' => validateField( ifne( $_POST, 'past_year_how_often_unable_to_stop' ), 'in-set', 'Please select a value', array( 'never','lt-1pm','1pm','1pw','1pd' ) ),
				'past_year_how_often_failed_expectations' => validateField( ifne( $_POST, 'past_year_how_often_failed_expectations' ), 'in-set', 'Please select a value', array( 'never','lt-1pm','1pm','1pw','1pd' ) ),
				'past_year_needed_morning_drink' => validateField( ifne( $_POST, 'past_year_needed_morning_drink' ), 'in-set', 'Please select a value', array( 'never','lt-1pm','1pm','1pw','1pd' ) ),
				'past_year_how_often_remorseful' => validateField( ifne( $_POST, 'past_year_how_often_remorseful' ), 'in-set', 'Please select a value', array( 'never','lt-1pm','1pm','1pw','1pd' ) ),
				'past_year_how_often_unable_to_remember' => validateField( ifne( $_POST, 'past_year_how_often_unable_to_remember' ), 'in-set', 'Please select a value', array( 'never','lt-1pm','1pm','1pw','1pd' ) ),
				'been_injured_or_injured_someone' => validateField( ifne( $_POST, 'been_injured_or_injured_someone' ), 'in-set', 'Please select a value', array( 'no','yes-nly','yes-ly' ) ),
				'others_concerned_about_my_drinking' => validateField( ifne( $_POST, 'others_concerned_about_my_drinking' ), 'in-set', 'Please select a value', array( 'no','yes-nly','yes-ly' ) )
			);

			if ( formIsValid( $form_errors ) ) {

				$the_survey->save(array(
					'02_how_often_drink_alcohol' => $_POST[ 'how_often_drink_alcohol' ],
					'02_how_many_on_typical_day' => $_POST[ 'how_many_on_typical_day' ],
					'02_how_often_six_or_more' => $_POST[ 'how_often_six_or_more' ],
					'02_past_year_how_often_unable_to_stop' => $_POST[ 'past_year_how_often_unable_to_stop' ],
					'02_past_year_how_often_failed_expectations' => $_POST[ 'past_year_how_often_failed_expectations' ],
					'02_past_year_needed_morning_drink' => $_POST[ 'past_year_needed_morning_drink' ],
					'02_past_year_how_often_remorseful' => $_POST[ 'past_year_how_often_remorseful' ],
					'02_past_year_how_often_unable_to_remember' => $_POST[ 'past_year_how_often_unable_to_remember' ],
					'02_been_injured_or_injured_someone' => $_POST[ 'been_injured_or_injured_someone' ],
					'02_others_concerned_about_my_drinking' => $_POST[ 'others_concerned_about_my_drinking' ]
				));

				do_redirect( 'survey.php?t=' . urlencode( $existing_token ) );
				//exit
			} else {
				//echo print_r($form_errors);
			}

		} else if ( $survey_stage == 3 ){

			$consumed_alcohol_message = validateField( ifne( $_POST, 'past_4wk_consumed_alcohol' ), 'in-set', 'Please select a value', array( 'yes', 'no') );
			if ( $consumed_alcohol_message == '' ){

				if ( $_POST[ 'past_4wk_consumed_alcohol' ] == 'yes' ){

					//Manual validation of height/weight fields
					$body_height_cm = ifne( $_POST, 'body_height-cm' );

					$body_height_feet = ifne( $_POST, 'body_height-feet' );
					$body_height_inches = ifne( $_POST, 'body_height-inches', '' );
					$body_height_inches = ( $body_height_inches == '' ? 0 : $body_height_inches );

					$body_height_message = '';
					$body_weight_message = '';

					if ( $body_height_cm == '' ){
						if ( ( $body_height_feet == '' ) ){
							$body_height_message = 'Please enter a weight in cm or feet/inches';
						} else {
							//Calculate height in cm
							$body_height_cm = ( $body_height_feet * 30.48 ) + ( $body_height_inches * 2.54 );
						}
					}

					//Validate everything
					$form_errors = array(
						'past_4wk_consumed_alcohol' => $consumed_alcohol_message,
						'past_4wk_largest_number_single_occasion' => validateField( ifne( $_POST, 'past_4wk_largest_number_single_occasion' ), 'notempty', 'Please enter a value' ),
						'past_4wk_hours_amount_drank' => validateField( ifne( $_POST, 'past_4wk_hours_amount_drank' ), 'notempty', 'Please enter a value' ),
						'body_height_cm' => $body_height_message,
						'body_weight_kg' => validateField( ifne( $_POST, 'body_weight-number' ), 'notempty', 'Please enter your weight' )
					);

					if ( formIsValid( $form_errors ) ) {

						$the_survey->save(array(
							'03_past_4wk_consumed_alcohol' => ( $_POST[ 'past_4wk_consumed_alcohol' ] == 'yes' ? 1 : 0 ),
							'03_past_4wk_largest_number_single_occasion' => $_POST[ 'past_4wk_largest_number_single_occasion' ],
							'03_past_4wk_hours_amount_drank' => $_POST[ 'past_4wk_hours_amount_drank' ],
							'03_body_height_cm' => $body_height_cm,
							'03_body_weight_kg' => $_POST[ 'body_weight-number'] * ( ifne( $_POST, 'body_weight-unit', 'kg' ) == 'lbs' ? 0.453592 : 1 )
						));

						do_redirect( 'survey.php?t=' . urlencode( $existing_token ) );
						//exit

					} else {

						//echo print_r( $form_errors );

					}


				} else {

					//Nothing else to validate
					$the_survey->save(array(
						'03_past_4wk_consumed_alcohol' => ( $_POST[ 'past_4wk_consumed_alcohol' ] == 'yes' ? 1 : 0 )
					));

					do_redirect( 'survey.php?t=' . urlencode( $existing_token ) );
					//exit

				}

			} else {

				//echo print_r($form_errors);

			}


		} else if ( $survey_stage == 4 ) {

			/*
			$form_errors = array(
				'been_insulted_humiliated' => validateField( ifne( $_POST, 'been_insulted_humiliated' ), 'in-set', 'Please select a value', array( 'no','yes','skip' ) ),
				'serious_argument_quarrel' => validateField( ifne( $_POST, 'serious_argument_quarrel' ), 'in-set', 'Please select a value', array( 'no','yes','skip' ) ),
				'assaulted' => validateField( ifne( $_POST, 'assaulted' ), 'in-set', 'Please select a value', array( 'no','yes','skip' ) ),
				'property_damaged' => validateField( ifne( $_POST, 'property_damaged' ), 'in-set', 'Please select a value', array( 'no','yes','skip' ) ),
				'babysit_another_student' => validateField( ifne( $_POST, 'babysit_another_student' ), 'in-set', 'Please select a value', array( 'no','yes','skip' ) ),
				'found_vomit' => validateField( ifne( $_POST, 'found_vomit' ), 'in-set', 'Please select a value', array( 'no','yes','skip' ) ),
				'study_sleep_interrupted' => validateField( ifne( $_POST, 'study_sleep_interrupted' ), 'in-set', 'Please select a value', array( 'no','yes','skip' ) ),
				'unwanted_sexual_advance' => validateField( ifne( $_POST, 'unwanted_sexual_advance' ), 'in-set', 'Please select a value', array( 'no','yes','skip' ) ),
				'victim_of_sexual_assault' => validateField( ifne( $_POST, 'victim_of_sexual_assault' ), 'in-set', 'Please select a value', array( 'no','yes','skip' ) ),
				'victim_of_another_crime_on_campus' => validateField( ifne( $_POST, 'victim_of_another_crime_on_campus' ), 'in-set', 'Please select a value', array( 'no','yes','skip' ) ),
				'victim_of_another_crime_off_campus' => validateField( ifne( $_POST, 'victim_of_another_crime_off_campus' ), 'in-set', 'Please select a value', array( 'no','yes','skip' ) )
			);

			if ( formIsValid( $form_errors ) ){

				$the_survey->save(array(
					'04_been_insulted_humiliated' => $_POST[ 'been_insulted_humiliated' ],
					'04_serious_argument_quarrel' => $_POST[ 'serious_argument_quarrel' ],
					'04_assaulted' => $_POST[ 'assaulted' ],
					'04_property_damaged' => $_POST[ 'property_damaged' ],
					'04_babysit_another_student' => $_POST[ 'babysit_another_student' ],
					'04_found_vomit' => $_POST[ 'found_vomit' ],
					'04_study_sleep_interrupted' => $_POST[ 'study_sleep_interrupted' ],
					'04_unwanted_sexual_advance' => $_POST[ 'unwanted_sexual_advance' ],
					'04_victim_of_sexual_assault' => $_POST[ 'victim_of_sexual_assault' ],
					'04_victim_of_another_crime_on_campus' => $_POST[ 'victim_of_another_crime_on_campus' ],
					'04_victim_of_another_crime_off_campus' => $_POST[ 'victim_of_another_crime_off_campus' ],
					'completed' => date('Y-m-d H:i:s')
				));

				do_redirect( 'survey.php?t=' . urlencode( $existing_token ) );
				//exit

			} else {

				echo print_r( $form_errors );

			}*/

			//All fields optional
			$the_survey->save(array(
				'04_hangover' => ifne( $_POST, 'hangover', null ),
				'04_emotional_outburst' => ifne( $_POST, 'emotional_outburst', null ),
				'04_vomiting' => ifne( $_POST, 'vomiting', null ),
				'04_heated_argument' => ifne( $_POST, 'heated_argument', null ),
				'04_physically_aggressive' => ifne( $_POST, 'physically_aggressive', null ),
				'04_blackouts' => ifne( $_POST, 'blackouts', null ),
				'04_inability_to_pay_bills' => ifne( $_POST, 'inability_to_pay_bills', null ),
				'04_unprotected_sex' => ifne( $_POST, 'unprotected_sex', null ),
				'04_sexual_situation_not_happy_about' => ifne( $_POST, 'sexual_situation_not_happy_about', null ),
				'04_sexual_encounter_later_regretted' => ifne( $_POST, 'sexual_encounter_later_regretted', null ),
				'04_injury_requiring_medical_attention' => ifne( $_POST, 'injury_requiring_medical_attention', null ),
				'04_drove_car_unsafely' => ifne( $_POST, 'drove_car_unsafely', null ),
				'04_passenger_of_unsafe_driver' => ifne( $_POST, 'passenger_of_unsafe_driver', null ),
				'04_stole_property' => ifne( $_POST, 'stole_property', null ),
				'04_committed_vandalism' => ifne( $_POST, 'committed_vandalism', null ),
				'04_removed_or_banned_from_pub_club' => ifne( $_POST, 'removed_or_banned_from_pub_club', null ),
				'04_arrested' => ifne( $_POST, 'arrested', null ),
				'completed' => get_gmt()
			));

			do_redirect( 'survey.php?t=' . urlencode( $existing_token ) );
			//exit

		}



	} // endif isset $POST

} //end do_process()




