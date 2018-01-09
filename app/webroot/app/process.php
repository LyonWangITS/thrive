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
				'participant_name' => validateField( ifne( $_POST, 'participant_name' ), 'notempty', 'Name cannot be empty' ),
				'participant_id' => validateField( ifne( $_POST, 'participant_id' ), 'notempty', 'ID cannot be empty' )
			);

			if ( formIsValid( $form_errors ) ){

				//Create it
				$partner = Partner::getCurrentPartner();
				$is_test = ( !empty( $_POST['is_test'] ) );
				$new_token = Survey::create( $partner->data['id'], $_POST[ 'participant_name' ], $_POST[ 'participant_id' ], $is_test );

				do_survey_redirect($new_token, $version);
				//exit
			}

		}

		if ( $survey_stage == 1 ){

			$form_errors = array(
				'gender' => validateField( ifne( $_POST, 'gender' ), 'in-set', 'Gender is unrecognized', array('female','male','transgender-ftm','transgender-mtf','genderqueer','androgynous','intersex') ),
				'age' => validateField( ifne( $_POST, 'age' ), 'in-set', 'Please select a value', array( 18,19,20,21,22,23,24 ) ),
				'race' => validateField( ifne( $_POST, 'race' ), 'in-set', 'Please select a value', array( 'native-american','asian','hawaiian','black','white','mixed-race','other','skip' ) ),
				'ethnicity' => validateField( ifne( $_POST, 'ethnicity' ), 'in-set', 'Please select a value', array( 'hispanic-latino','not-hispanic-latino','skip' ) ),
				'where' => validateField( ifne( $_POST, 'where' ), 'in-set', 'Please select a value', array( 'dorm','with-parents','with-roommates' ) ),
			);

			foreach (array('first_pet', 'first_concert', 'mother_letters', 'phone_digits') as $field) {
				$form_errors[$field] = validateField( ifne( $_POST, $field ), 'notempty', 'Field cannot be empty' );
			}

			$fields = array_keys($form_errors);

			if ( formIsValid( $form_errors ) ) {
				$data = array();
				foreach ($fields as $field) {
					$data['01_' . $field] = $_POST[$field];
				}

				$the_survey->save( $data );

				do_survey_redirect($existing_token, $version);
			}

		} else if ( $survey_stage == 3 ){

			$form_errors = array(
				'how_often_drink_alcohol' => validateField( ifne( $_POST, 'how_often_drink_alcohol' ), 'in-set', 'Please select a value', array( 'never','lt-1pm','1pm','1p2w','1pw','2-3pw','4pw' ) ),
				'how_many_on_typical_day' => validateField( ifne( $_POST, 'how_many_on_typical_day' ), 'in-set', 'Please enter a value', array_merge(range(1, 24), array('25+')) ),
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
					'03_how_often_drink_alcohol' => $_POST[ 'how_often_drink_alcohol' ],
					'03_how_many_on_typical_day' => $_POST[ 'how_many_on_typical_day' ],
					'03_how_often_six_or_more' => $_POST[ 'how_often_six_or_more' ],
					'03_past_year_how_often_unable_to_stop' => $_POST[ 'past_year_how_often_unable_to_stop' ],
					'03_past_year_how_often_failed_expectations' => $_POST[ 'past_year_how_often_failed_expectations' ],
					'03_past_year_needed_morning_drink' => $_POST[ 'past_year_needed_morning_drink' ],
					'03_past_year_how_often_remorseful' => $_POST[ 'past_year_how_often_remorseful' ],
					'03_past_year_how_often_unable_to_remember' => $_POST[ 'past_year_how_often_unable_to_remember' ],
					'03_been_injured_or_injured_someone' => $_POST[ 'been_injured_or_injured_someone' ],
					'03_others_concerned_about_my_drinking' => $_POST[ 'others_concerned_about_my_drinking' ]
				));

				do_survey_redirect($existing_token, $version);
				//exit
			} else {
				//echo print_r($form_errors);
			}

		} else if ( $survey_stage == 4 ){
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
				'past_4wk_largest_number_single_occasion' => validateField( ifne( $_POST, 'past_4wk_largest_number_single_occasion' ), 'in-set', 'Please enter a value', array_merge(range(1, 24), array('25+'))),
				'past_4wk_hours_amount_drank' => validateField( ifne( $_POST, 'past_4wk_hours_amount_drank' ), 'in-set', 'Please enter a value', array_merge(range(1, 23), array('24+'))),
				'body_height_cm' => $body_height_message,
				'body_weight_kg' => validateField( ifne( $_POST, 'body_weight-number' ), 'notempty', 'Please enter your weight' )
			);

			$weekdays = get_weekdays();
			$weekdays = array_keys($weekdays);

			foreach ($weekdays as $day) {
				$form_errors['past_4wk_drinks_' . $day] = validateField(ifne($_POST, 'past_4wk_drinks_' . $day), 'in-set', 'Please select a value', array_keys($stage_vars['tabular']['columns']));
				$form_errors['past_4wk_std_drinks_' . $day] = validateField(ifne($_POST, 'past_4wk_std_drinks_' . $day ), 'in-set', 'Please enter a value', array_merge(range(0, 24), array('25+')));
			}

			if ( formIsValid( $form_errors ) ) {
				$values = array(
					'04_past_4wk_largest_number_single_occasion' => $_POST[ 'past_4wk_largest_number_single_occasion' ],
					'04_past_4wk_hours_amount_drank' => $_POST[ 'past_4wk_hours_amount_drank' ],
					'04_body_height_cm' => $body_height_cm,
					'04_body_weight_kg' => $_POST[ 'body_weight-number'] * ( ifne( $_POST, 'body_weight-unit', 'kg' ) == 'lbs' ? 0.453592 : 1 )
				);

				foreach ($weekdays as $day) {
					$fields = array(
						'past_4wk_drinks_' . $day,
						'past_4wk_std_drinks_' . $day,
					);

					foreach ($fields as $field) {
						$values['04_' . $field] = $_POST[$field];
					}
				}


				$the_survey->save($values);
				do_survey_redirect($existing_token, $version);
			}


		} else if ( in_array($survey_stage, array(2, 5, 6, 7, 8)) ) {

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

		else if ( $survey_stage == 9 ) {
			$form_errors = array();
			if ( formIsValid( $form_errors ) ) {
				$the_survey->save(array(
					'09_tobacco_use' => ifne( $_POST, 'tobacco_use', null ),
					'09_tobacco_frequency' => ifne( $_POST, 'tobacco_frequency', null ),
					'09_tobacco_init' => ifne( $_POST, 'tobacco_init', null ),
				));

				do_survey_redirect($existing_token, $version);
			}
		}



	} // endif isset $POST

} //end do_process()
