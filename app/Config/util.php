<?php

/**
*	A short-hand for echo, but also escapes any HTML, making it safe to use this 
*	anywhere there's a risk of HTML-injection attacks by site users.
*/
function p( $str ) {

	echo htmlentities( $str );
}
 
/**
*	Utility method for getting a random string.
*	Removed any characters that are easily mistaken for others.
*/
function random_string( $length ) {
	
	$base = 'abcdefghkmnpqrstwxyz23456789';
	$max = strlen($base) - 1;
	$string = '';
	mt_srand( (double)microtime() * 1000000 );
	while ( strlen( $string ) < ( $length ) ) {
		$string .= $base { mt_rand( 0, $max ) };
	}
	
	return $string;	
}

/**
*	Given a string, returns a slug version.
*/
function to_slug( $name ) {

	$slug = strtolower( $name );
	$slug = preg_replace( '/\W/', '-', $slug );
	while ( strpos( $slug, '--' ) !== false ) {

		$slug = str_replace( '--', '-', $slug );
	}
	return $slug;
}

/**
*	Given an integer or decimal, displays as a nicely formatting price. Does not add 
*	the currency symbol.
*	$include_cents If not empty, will include cents. If 'if_set', then cents are only
*	included when they're not 0.
*/
function format_price( $price, $include_cents = '' ) {

	$decimals = ( !empty( $include_cents ) ) ? 2 : 0;
	$price = number_format( $price, $decimals, '.', ',' );
	if ( $include_cents === 'if_set' ) {
	
		$price = str_replace( '.00', '', $price );
	}
	return $price;
}

/**
*	Given bytes, converts to the most succinct summary. 
*/
function format_bytes( $bytes, $precision = 2 ) { 

	$units = array( 'B', 'KB', 'MB', 'GB', 'TB' ); 

	$bytes = max( $bytes, 0 ); 
	$pow = floor( ( $bytes ? log( $bytes ) :  0) / log( 1024 ) ); 
	$pow = min( $pow, count( $units ) - 1 ); 

	$bytes /= pow( 1024, $pow );
	
	return round( $bytes, $precision ) . ' ' . $units[$pow]; 
} 
