<?php
/**
 * Receives AJAX requests to save a participant's time spent in each section of the final page of the survey
 * Adapted from save-feedback.php
 */

require_once( 'app/config.php' );
require_once( 'app/db.php' );
require_once( 'app/helpers.php' );
require_once( 'app/Survey.class.php' );

$survey = new Survey();
$param_token = ifne($_POST, 't' );
$data = json_encode($_POST['data']);


if ( $param_token != '' && Survey::tokenExists( $param_token ) ) {

    $survey->loadFrom( 'token', $param_token );
}

// If survey not found, stop
if ( empty( $survey->id ) ) {
    die( 'Invalid survey' );
}

// Update survey
$survey->save( array(
    'final_page_section_timestamps' => $data
) );


// Done
die( 'OK' );

?>
