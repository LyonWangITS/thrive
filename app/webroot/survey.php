<?php
/*
	Survey Page Switchboard
*/

	require_once 'app/config.php';
	require_once 'app/helpers.php';
	require_once 'app/stages_config.php';
	require_once 'app/db.php';
	require_once 'app/Partner.class.php';
	require_once 'app/Survey.class.php';
	require_once 'app/process.php';
	require_once 'app/renderer.php';
	require_once 'app/library/WebImageHelper.php';

	/*
		Ensure this is a valid partner, otherwise 404.
	*/
	$partner = Partner::getCurrentPartner();
	if ( empty( $partner->id ) ) {

		header( 'HTTP/1.1 404 Not Found' );
		require_once( '404.php' );
		die;
	}

	/*
		Prep work
	*/

	$the_survey = new Survey();
	$target_stage = 0;

	$param_token = ifne( $_REQUEST, 't' );
	$existing_token = '';
	$version = empty($_GET['v']) ? '1' : $_GET['v'];

	$_REQUEST = batch_decode( $_REQUEST );
	$_POST = batch_trim( $_POST );

	//===============================================================

	if ( $param_token != '' ){
		if ( Survey::tokenExists( $param_token ) ){
			$existing_token = $param_token;
			$the_survey->loadFrom( 'token', $existing_token );
		} else {
			do_survey_redirect('', $version);
			//exit
		}
	}

	/*
		Do we need to process some posted data?
	*/
	doProcess( $the_survey, $existing_token, $version);

	/*
		Figure out Resume position
		- bear in mind that unless the survey is completed they can still go back to any of the previous stages but 0
	*/

	if ( $existing_token == '' ){

		$target_stage = 0;

	} else {

		$last_stage = $the_survey->lastCompletedStage();

		if ( in_array( $last_stage, array( 0, 1, 2, 3, 4, 5, 6, 7, 8 ) ) ) {

			$target_stage = $last_stage + 1;

		} else {

			$target_stage = 0;

		}

	}

	/*
		Render screen
	*/
	$page_vars = array(
		'title' => 'THRIVE',
		'description' => '',
		'keywords' => '',
		'participant_name' => ifne( $the_survey->data, '00_participant_name' ),
		'target_stage' => $target_stage,
		'token' => $existing_token,
		'version' => $version,
	);

	if ( $target_stage == 9 ) {

		$audit_score = $the_survey->calculateAuditScore();
		$the_survey->save( array(
			'audit_score' => $audit_score,
		) );
		$page_vars[ 'audit_score' ] = $audit_score;
		$page_vars[ 'expenses' ] = $the_survey->calculateExpenses();
		$page_vars[ 'consumption' ] = $the_survey->calculateConsumption();

		if ( ifne( $the_survey->data, '03_past_4wk_consumed_alcohol' ) == 1 ){
			$page_vars[ 'bac' ] = $the_survey->calculateBAC();
		}

		$page_vars[ 'rating_important_reduce_drinking' ] = $the_survey->data[ 'rating_important_reduce_drinking' ];
		$page_vars[ 'rating_confident_reduce_drinking' ] = $the_survey->data[ 'rating_confident_reduce_drinking' ];
		$page_vars[ 'rating_important_talk_professional' ] = $the_survey->data[ 'rating_important_talk_professional' ];
		$page_vars[ 'rating_ready_talk_professional' ] = $the_survey->data[ 'rating_ready_talk_professional' ];

		$avg = $the_survey->calculateAverageConsumption();
		$page_vars[ 'average_per_occasion' ] = $avg['occasion'];
		$page_vars[ 'average_per_week' ] = $avg['week'];
	}

	$page_vars += get_stage_vars($target_stage, $page_vars);

	renderStage( $target_stage, $page_vars );

	//--The End--
