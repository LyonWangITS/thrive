<?php
/*
*	Configuration. Note this file is imported into the CakePHP app as well as this original standalone part.
*/

//
// Database
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '123');
define('DBNAME', 'app_database');

//
// Email
define( 'EMAIL_ADMIN', 'pbc@ufl.edu' ); // Receives emails about new partners, etc
define( 'EMAIL_GENERAL', 'pbc@ufl.edu' ); // From address on automated emails to partners. E.g. password reset
define( 'EMAIL_FROM_NAME', 'THRIVE Health' );

/* The slug for Polytechnic West. Used to control the display of the $500 prize on the summary page. */
define('POLYTECHNIC_WEST_SLUG', 'polytechnicwest' );

/* Prefixed to the path of any assets (CSS, JS, images) embedded in pages. Only need to change it
	from / if the application isn't being installed in the www root. */
define('BASE_URL', '/web_app/');

/* Misc */
define( 'SURVEY_TOKEN_LENGTH', 32 );
define( 'LU_PARTNER_STATE_APPROVED', 2 );
define('CALLBACK_FORM_EMAIL_ADDRESS', 'pbc@ufl.edu'); // As this is for the ADIS form (only relevant for Western Australia), you can probably ignore it.
define('SUPPRESS_WARNINGS', false );
define( 'HOST', $_SERVER['HTTP_HOST'] );

/* =============================================================== */

if ( SUPPRESS_WARNINGS ) {
	error_reporting( 0 );
}
