<?php
/*
	Process any incoming data

	GLOBALS:
	$the_survey
	$existing_token
*/
function doProcess( $the_survey, $existing_token, $version ){

	$form_errors = array();

	if ( !empty( $_POST ) ){

		$survey_stage = ifne( $_POST, 'survey-stage', 0 );
		$stage_vars = get_stage_vars($survey_stage);

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

				do_survey_redirect($new_token, $version);
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
				'alcohol_last_12mths' => validateField( ifne( $_POST, 'alcohol_last_12mths' ), 'in-set', 'Please select a value', array( 'yes', 'no') ),
				'gender' => validateField( $gender, 'in-set', 'Gender is unrecognized', array('female','male','transgender-ftm','transgender-mtf','genderqueer','androgynous','intersex') ),
				'age' => validateField( ifne( $_POST, 'age' ), 'in-set', 'Please select a value', array( 18,19,20,21,22,23,24 ) ),
				'race' => validateField( ifne( $_POST, 'race' ), 'in-set', 'Please select a value', array( 'native-american','asian','hawaiian','black','white','mixed-race','other','skip' ) ),
				'ethnicity' => validateField( ifne( $_POST, 'ethnicity' ), 'in-set', 'Please select a value', array( 'hispanic-latino','not-hispanic-latino','skip' ) ),
				'where' => validateField( ifne( $_POST, 'where' ), 'in-set', 'Please select a value', array( 'dorm','with-parents','with-roommates' ) ),
			);

			if ( formIsValid( $form_errors ) ) {

				$data = array(
					'01_gender' => $gender,
					'01_age' => $_POST[ 'age' ],
					'01_alcohol_last_12mths' => ( $_POST[ 'alcohol_last_12mths' ] == 'yes' ? 1 : 0 ),
					'01_race' => $_POST[ 'race' ],
					'01_ethnicity' => $_POST[ 'ethnicity' ],
					'01_where' => $_POST[ 'where' ],
				);

				if ( $data[ '01_alcohol_last_12mths' ] == 0 ){
					$data[ 'completed' ] = get_gmt();
				}

				$the_survey->save( $data );

				do_survey_redirect($existing_token, $version);
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
				'others_concerned_about_my_drinking' => validateField( ifne( $_POST, 'others_concerned_about_my_drinking' ), 'in-set', 'Please select a value', array( 'no','yes-nly','yes-ly' ) ),
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

				do_survey_redirect($existing_token, $version);
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

					$weekdays = get_weekdays();
					$weekdays = array_keys($weekdays);

					foreach ($weekdays as $day) {
						$form_errors['past_4wk_drinks_' . $day] = validateField(ifne($_POST, 'past_4wk_drinks_' . $day), 'in-set', 'Please select a value', array_keys($stage_vars['tabular']['columns']));
						$form_errors['past_4wk_std_drinks_' . $day] = validateField(ifne($_POST, 'past_4wk_std_drinks_' . $day ), 'notempty', 'Please enter a value');
					}

					if ( formIsValid( $form_errors ) ) {
						$values = array(
							'03_past_4wk_consumed_alcohol' => ( $_POST[ 'past_4wk_consumed_alcohol' ] == 'yes' ? 1 : 0 ),
							'03_past_4wk_largest_number_single_occasion' => $_POST[ 'past_4wk_largest_number_single_occasion' ],
							'03_past_4wk_hours_amount_drank' => $_POST[ 'past_4wk_hours_amount_drank' ],
							'03_body_height_cm' => $body_height_cm,
							'03_body_weight_kg' => $_POST[ 'body_weight-number'] * ( ifne( $_POST, 'body_weight-unit', 'kg' ) == 'lbs' ? 0.453592 : 1 )
						);

						foreach ($weekdays as $day) {
							$fields = array(
								'past_4wk_drinks_' . $day,
								'past_4wk_std_drinks_' . $day,
							);

							foreach ($fields as $field) {
								$values['03_' . $field] = $_POST[$field];
							}
						}


						$the_survey->save($values);
						do_survey_redirect($existing_token, $version);
						//exit

					} else {

						//echo print_r( $form_errors );

					}


				} else {

					//Nothing else to validate
					$the_survey->save(array(
						'03_past_4wk_consumed_alcohol' => ( $_POST[ 'past_4wk_consumed_alcohol' ] == 'yes' ? 1 : 0 )
					));

					do_survey_redirect($existing_token, $version);
					//exit

				}

			} else {

				//echo print_r($form_errors);

			}


		} else if ( in_array($survey_stage, range(4, 7)) ) {

			$values = array();
			$form_errors = array();

			foreach (array_keys($stage_vars['tabular']['rows']) as $field) {
				$form_errors[$field] = validateField(ifne($_POST, $field ), 'notempty', 'Please enter a value');
				$values['0' . $survey_stage . '_' . $field] = ifne( $_POST, $field, null );
			}

			if ( formIsValid( $form_errors ) ) {
				$values['completed'] = get_gmt();
				$the_survey->save($values);

				do_survey_redirect($existing_token, $version);
			}

		}

		else if ( $survey_stage == 8 ) {
			$form_errors = array();
			if ( formIsValid( $form_errors ) ) {
				$the_survey->save(array(
					'08_tobacco_use' => ifne( $_POST, 'tobacco_use', null ),
					'08_tobacco_frequency' => ifne( $_POST, 'tobacco_frequency', null ),
					'08_tobacco_init' => ifne( $_POST, 'tobacco_init', null ),
				));

				do_survey_redirect($existing_token, $version);
			}
		}



	} // endif isset $POST

} //end do_process()
