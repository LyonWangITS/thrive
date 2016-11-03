<?php
/*
	Helper functions
*/

function h($str) {
	return htmlspecialchars($str);
}

function ifne($var, $index, $default = '') {
	
	if ( is_array($var) ){
		
		//return (!empty($var[$index]) ? $var[$index] : $default );
		return ( array_key_exists( $index, $var ) ? $var[ $index ] : $default );
		
	} else {
		
		return $default;
		
	}
	
	
}


function random_token( $length = 5 ){
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$count = mb_strlen($chars);

	for ($i = 0, $result = ''; $i < $length; $i++) {
	    $index = rand(0, $count - 1);
	    $result .= mb_substr($chars, $index, 1);
	}

	return $result;
}


function batch_decode( $vars ){
	
	if ( is_array( $vars ) ){
		foreach ( $vars as $key => $value ){
			$vars[$key] = urldecode( $value );
		}
	}
	
	return $vars;
}


function batch_trim( $vars ){
	
	if ( is_array( $vars ) ){
		foreach ( $vars as $key => $value ){
			$vars[$key] = trim( $value );
		}
	}
	
	return $vars;
	
}

function get_gmt( $format = 'Y-m-d H:i:s' ){
		
	$server_time = time();
	
	$gm_time = $server_time - date('Z', $server_time);
	
	return date($format, $gm_time);
	
}


function validateField( $value, $rule, $message = 'Invalid', $options = array() ){
	
	$error = false;
	
	if ( ( $rule === true ) || ( $rule === false ) ) {
		
		if ( $rule === false ){
			$error = true;
		}
		
		
	} elseif ( $rule == 'notempty' ){
		
		$error = ( $value == '' );
		
	} elseif ( $rule == 'email' ){
		
		$error = (!filter_var( $value, FILTER_VALIDATE_EMAIL ));
		
	} elseif ( $rule == 'in-set' ){
		
		$error = !in_array( strtolower( $value ), $options );
		
	}
	
	return ( $error ? $message : '' );
}


// Checks the form_errors object for any invalidities
function formIsValid( $form_errors ){
	
	$valid = true;
	
	foreach( $form_errors as $key => $value ){
		if ( $value != '' ){
			$valid = false;
			break;
		}
	}
	
	return $valid;
	
}




function do_redirect( $url ){
	
	header( 'Location: ' . $url );
	exit();
	
}







