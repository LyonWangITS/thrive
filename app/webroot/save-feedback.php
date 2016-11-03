<?php
/**
 * Receives AJAX requests to save a participant's feedback rating. Uses token to identify user.
 */

require_once( 'app/config.php' );
require_once( 'app/db.php' );
require_once( 'app/helpers.php' );
require_once( 'app/Survey.class.php' );

//
// Validate request

// Field must be from the given set
$field = ifne( $_REQUEST, 'id' );
$allowed_fields = array(
	'rating_important_reduce_drinking',
	'rating_confident_reduce_drinking',
	'rating_important_talk_professional',
	'rating_ready_talk_professional'
);
if ( !in_array( $field, $allowed_fields ) ) {

	die( 'Invalid field' );
}

// Score must be between 0 and 10, inclusive
$score = ifne( $_REQUEST, 'score' );
$score = intval( $score );
if ( $score < 0 || $score > 10 ) {

	die( 'Invalid score' );
}

//
// Fetch appropriate survey
$survey = new Survey();
$param_token = ifne( $_REQUEST, 't' );

if ( $param_token != '' && Survey::tokenExists( $param_token ) ) {

	$survey->loadFrom( 'token', $param_token );
}

// If survey not found, stop
if ( empty( $survey->id ) ) {

	die( 'Invalid survey' );
}

//
// Update survey
$survey->save( array(

	$field => $score
) );

//
// Done
die( 'OK' );
