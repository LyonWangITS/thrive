<?
/*
	Callback form
*/
	require_once 'app/helpers.php';
	require_once 'app/config.php';
	require_once 'app/db.php';
	require_once 'app/Partner.class.php';
	require_once 'app/Survey.class.php';

	if ( empty( $_POST ) ){
		do_survey_redirect('', $version);
		exit;
	}

	include_once( 'app/library/humaan-basic-form-handler/HumaanBasicFormHandler.php' );
	
	if ( isset( $_POST['submit'] ) && ( $_POST['submit'] == 'callback' ) ){
		
		/*
			Prep work
		*/
		$the_survey = new Survey();
		$param_token = ifne( $_REQUEST, 't' );
		$existing_token = '';

		//===============================================================
		
		if ( $param_token != '' ){
			if ( Survey::tokenExists( $param_token ) ){
				$existing_token = $param_token;
				$the_survey->loadFrom( 'token', $existing_token );
			} else {
				do_survey_redirect('', $version);
				//exit
			}
		} else {
			do_survey_redirect('', $version);
		}
		
		$status = 'nok';
		$error = false;
		$post = $_POST;
		$gender_names = array(
			'female' => 'Female',
			'male' => 'Male',
			'transgender-ftm' => 'Transgender or transexual FtM',
			'transgender-mtf' => 'Transgender or transexual MtF',
			'genderqueer' => 'Genderqueer',
			'androgynous' => 'Androgynous',
			'intersex' => 'Intersex'
		);
		$post[ 'callback-age' ] = ifne( $the_survey->data, '01_age' );
		$post[ 'callback-gender' ] = $gender_names[ ifne( $the_survey->data, '01_gender' ) ];
		
		
		$handler = new HumaanBasicFormHandler(array(
			'fields' => array(
				'callback-firstname' => 'notempty',
				'callback-phone' => 'notempty',
				'callback-age' => null,
				'callback-gender' => null,
				'callback-message-ok' => null,
				'callback-weekdays' => null,
				'callback-weekends' => null
			),
			'post_data' => $post,
			'send_as_html' => true,
			'template_path' => 'callback',
			'timezone' => '+0800'
		));
		
		//Email address comes from partner. Default is set in app/config.php
		$email_from = $email_to = CALLBACK_FORM_EMAIL_ADDRESS;
		$error = $handler->sendIfValidates( stripslashes( ifne( $post, 'callback-firstname' ) ), $email_from, $email_to, 'THRIVE Callback Request Form' );
		
		if ( $error == '' ){
			
			$the_survey->save(array(
				'callback_requested' => 1
			));
			
			//Submitter is anonymous so we can't send receipt
			$status = 'ok';
			
		} else {
			
			echo $error;
			
		}
		
		echo $status;
		exit;
		
		
	} else {
		do_survey_redirect('', $version);
		exit;
	}


?>
