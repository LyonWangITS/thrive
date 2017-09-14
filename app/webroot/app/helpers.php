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

function get_weekdays() {
	return array(
		'sun' => 'Sunday',
		'mon' => 'Monday',
		'tue' => 'Tuesday',
		'wed' => 'Wednesday',
		'thu' => 'Thursday',
		'fri' => 'Friday',
		'sat' => 'Saturday',
	);
}


function get_stages() {
	return array(
		array('name' => 'hi', 'title' => ''),
		array('name' => 's-one', 'number_in_letters' => 'one', 'title' => 'All about you'),
		array('name' => 's-two', 'number_in_letters' => 'two', 'icon_class' => 's2', 'title' => 'Past and Present Drinking'),
		array('name' => 's-three', 'number_in_letters' => 'three', 'icon_class' => 's3', 'title' => 'In the last four weeks'),
		array('name' => 's-four', 'number_in_letters' => 'four', 'icon_class' => 's4', 'title' => 'Effects of Drinking'),
		array('name' => 's-five', 'number_in_letters' => 'five', 'icon-class' => 's5', 'title' => ''),
	);
}


function get_stage_vars($stage, $global_vars) {
	if ($stage == 1) {
		return array(
			'legend' => 'Please fill in these details about yourself.',
			'intro' => array(
				'title' => 'All about you',
				'description' => array(
					'Thanks, ' . h(ifne($global_vars, 'participant_name')) . '. First of all we\'d like to know a little bit more about you...',
				),
			),
		);
	}

	if ($stage == 2) {
		return array(
			'legend' => 'Please answer the following questions about your consumption of alcohol.',
			'intro' => array(
				'title' => 'Past and present drinking',
				'description' => array(
					'Now we\'d like to ask some questions about your past alcohol use.',
					'Please tick the box that relates best to your answer using<br />the definitions of Standard Drinks below as a guide.',
				),
			),
		);
	}

	if ($stage == 3) {
		$tabular_rows = array();
		foreach (get_weekdays() as $day => $label) {
			$tabular_rows['past_4wk_drinks_' . $day] = $label;
		}

		return array(
			'include_drinks_guide' => true,
			'legend' => 'Please fill in the details about your drinking habits below.',
			'intro' => array(
				'title' => 'In the last four weeks',
				'description' => array(
					'Now we\'d like to ask you about your drinking in the last four weeks only.<br>We understand that this might be difficult to remember exactly so<br>for these questions please give your best estimate.',
					'Please use the definitions of Standard Drinks below as a guide.',
				),
			),
			'tabular' => array(
				'section_number' => '02',
				'image_name' => 'vessels',
				'image_desc' => 'Drinking Vessel',
				'intro' => array(
					'Indicate below how many times you drank any alcohol on each day of the week <strong>during the past 4 weeks</strong>.',
					'For example, if you never drank on any Tuesday, you would select "None" for Tuesdays. If you drank on every Thursday in the past 4 weeks, you would select "4" for Thursday.',
				),
				'columns' => array_combine(range(0, 4), array('None', '1', '2', '3', '4')),
				'rows' => $tabular_rows,
			),
		);
	}

	if ($stage == 4) {
		return array(
			'include_drinks_guide' => true,
			'legend' => 'Please fill in the details of your alcohol usage below.',
			'intro' => array(
				'title' => 'Effects of Drinking',
				'description' => array(
					'These questions relate to your experiences when drinking.',
					'Remember your responses are anonymous.',
				),
			),
			'tabular' => array(
				'section_number' => '01',
				'image_name' => 'vessels',
				'image_desc' => 'Drinking Vessel',
				'intro' => array(
					'Please rate the following items according to how often each has occurred in your drinking experiences <strong>during the past 30 days</strong>.',
					'It is important that you answer according to what has actually happened to you and not according to your beliefs about your drinking.'
				),
				'columns' => array(
					'never' => 'Never',
					'rarely' => 'Rarely',
					'sometimes' => 'Sometimes',
					'often' => 'Often',
					'always' => 'Always',
					'skip' => 'I choose not to answer',
				),
				'rows' => array(
					'embarassing-things' => 'While drinking, I have said or done embarrassing things.',
					'hangover' => 'I have had a hangover (headache, sick stomach) the morning after I had been drinking.',
					'sick' => 'I have felt very sick to my stomach or thrown up after drinking.',
					'end-up-drinking-without-planning' => 'I often have ended up drinking on nights when I had planned not to drink.',
					'take-foolish-risks' => 'I have taken foolish risks when I have been drinking.',
					'pass-out' => 'I have passed out from drinking.',
					'need-larger-amounts-to-feel-effect' => 'I have found that I needed larger amounts of alcohol to feel any effect, or that I could no longer get high or drunk on the amount that used to get me high or drunk.',
					'impulsive-things' => 'When drinking, I have done impulsive things that I regretted later.',
					'memory-loss' => 'I’ve not been able to remember large stretches of time while drinking heavily.',
					'drive-unsafely' => 'I have driven a car when I knew I had too much to drink to drive safely.',
					'miss-work-or-class' => 'I have not gone to work or missed classes at school because of drinking, a hangover, or illness caused by drinking.',
					'regretted-sexual-situations' => 'My drinking has gotten me into sexual situations I later regretted.',
					'difficult-to-limit' => 'I have often found it difficult to limit how much I drink.',
					'become-rude' => 'I have become very rude, obnoxious or insulting after drinking.',
					'wake-up-unexpected-place' => 'I have woken up in an unexpected place after heavy drinking.',
					'feel-bad' => 'I have felt badly about myself because of my drinking.',
					'lack-of-energy' => 'I have had less energy or felt tired because of my drinking.',
					'suffered-work-quality' => 'The quality of my work or schoolwork has suffered because of my drinking.',
					'spend-too-much-time-drinking' => 'I have spent too much time drinking.',
					'neglect-obligations' => 'I have neglected my obligations to family, work, or school because of drinking.',
					'relationship-problems' => 'My drinking has created problems between myself and my boyfriend/girlfriend/spouse, parents, or other near relatives.',
					'overweight' => 'I have been overweight because of drinking.',
					'harmed-physical-appearance' => 'My physical appearance has been harmed by my drinking.',
					'need-drink-before-breakfast' => 'I have felt like I needed a drink after I’d gotten up (that is, before breakfast).',
				),
			),
		);
	}

	if ($stage == 5) {
		return array(
			'include_drinks_guide' => true,
			'tabular' => array(
				'columns' => array(
					'yes' => 'Yes',
					'no' => 'No',
					'skip' => 'I choose not to answer',
				),
				'rows' => array(
					'difficult-to-limit' => 'I have found it difficult to limit the amount I drank',
					'start-drinking-after-deciding-not-to' => 'I have started drinking even after deciding not to',
					'end-up-drinking-more' => 'Even when I intended to have only one or two drinks, I ended up having many more',
					'cut-down-drinking' => 'I have been able to cut down my drinking (i.e., drink less) when I want to',
					'drink-when-causing-problems' => 'I have started drinking at times when I knew it would cause me problems (e.g., problems with school, with family/friends)',
					'stop-drinking-after-two-drinks' => 'I have been able to stop drinking easily after one or two drinks',
					'stop-drinking-after-drunk' => 'I have been able to stop drinking before becoming completely drunk',
					'irresistible-urge-continue-drinking' => 'I have had an irresistible urge to continue drinking once I started',
					'difficult-to-resist-drinking' => 'I have found it difficult to resist drinking, even for a single day',
					'able-to-slow-drinking' => 'I have been able to slow my drinking when I wanted to',
				),
			 ),
		);
	}

	return array();
}
