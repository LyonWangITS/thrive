<?php

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
		array('group' => 'zero', 'step' => 'zero', 'title' => ''),
		array('group' => 'one', 'step' => 'one', 'title' => 'All about you'),
		array('group' => 'two', 'step' => 'two', 'title' => 'Past and Present Drinking'),
		array('group' => 'three', 'step' => 'three', 'title' => 'In the last four weeks'),
		array('group' => 'three', 'step' => 'four', 'title' => 'Effects of Drinking (1/2)'),
		array('group' => 'three', 'step' => 'five', 'title' => 'Effects of Drinking (2/2)'),
		array('group' => 'three', 'step' => 'six', 'title' => 'Precautions on Drinking'),
		array('group' => 'four', 'step' => 'seven', 'title' => 'What would you like to do?'),
		array('group' => 'four', 'step' => 'eight', 'title' => 'Current Smoking'),
		array('group' => 'five', 'step' => 'nine', 'title' => 'Results'),
	);
}


function get_stage_vars($stage, $global_vars = array()) {
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
			'legend' => 'Please fill in the details of your alcohol usage below.',
			'intro' => array(
				'title' => 'Effects of Drinking',
				'description' => array(
					'These questions relate to your experiences when drinking.',
					'Remember your responses are anonymous.',
				),
			),
			'include_tabular' => true,
			'tabular' => array(
				'section_number' => '01',
				'image_name' => 'vessels',
				'image_desc' => 'Drinking Vessel',
				'intro' => array(
					'Please rate the following items according to how often each has occurred in your drinking experiences <strong>during the past 30 days</strong>.',
					'It is important that you answer according to what has actually happened to you and not according to your beliefs about your drinking.'
				),
				'columns' => array(
					'yes' => 'Yes',
					'no' => 'No',
					'skip' => 'I choose not to answer',
				),
				'rows' => array(
					'difficult_to_limit' => 'I have found it difficult to limit the amount I drank',
					'start_drinking_after_deciding_not_to' => 'I have started drinking even after deciding not to',
					'end_up_drinking_more' => 'Even when I intended to have only one or two drinks, I ended up having many more',
					'cut_down_drinking' => 'I have been able to cut down my drinking (i.e., drink less) when I want to',
					'drink_when_causing_problems' => 'I have started drinking at times when I knew it would cause me problems (e.g., problems with school, with family/friends)',
					'stop_drinking_after_two_drinks' => 'I have been able to stop drinking easily after one or two drinks',
					'stop_drinking_after_drunk' => 'I have been able to stop drinking before becoming completely drunk',
					'irresistible_urge_continue_drinking' => 'I have had an irresistible urge to continue drinking once I started',
					'difficult_to_resist_drinking' => 'I have found it difficult to resist drinking, even for a single day',
					'able_to_slow_drinking' => 'I have been able to slow my drinking when I wanted to',
				),
			 ),
		);
	}

	if ($stage == 5) {
		return array(
			'legend' => 'Please fill in the details of your alcohol usage below.',
			'intro' => array(
				'title' => 'Effects of Drinking',
				'description' => array(
					'These questions relate to your experiences when drinking.',
					'Remember your responses are anonymous.',
				),
			),
			'include_tabular' => true,
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
					'embarassing_things' => 'While drinking, I have said or done embarrassing things.',
					'hangover' => 'I have had a hangover (headache, sick stomach) the morning after I had been drinking.',
					'sick' => 'I have felt very sick to my stomach or thrown up after drinking.',
					'end_up_drinking_without_planning' => 'I often have ended up drinking on nights when I had planned not to drink.',
					'take_foolish_risks' => 'I have taken foolish risks when I have been drinking.',
					'pass_out' => 'I have passed out from drinking.',
					'need_larger_amounts_to_feel_effect' => 'I have found that I needed larger amounts of alcohol to feel any effect, or that I could no longer get high or drunk on the amount that used to get me high or drunk.',
					'impulsive_things' => 'When drinking, I have done impulsive things that I regretted later.',
					'memory_loss' => 'I’ve not been able to remember large stretches of time while drinking heavily.',
					'drive_unsafely' => 'I have driven a car when I knew I had too much to drink to drive safely.',
					'miss_work_or_class' => 'I have not gone to work or missed classes at school because of drinking, a hangover, or illness caused by drinking.',
					'regretted_sexual_situations' => 'My drinking has gotten me into sexual situations I later regretted.',
					'difficult_to_limit' => 'I have often found it difficult to limit how much I drink.',
					'become_rude' => 'I have become very rude, obnoxious or insulting after drinking.',
					'wake_up_unexpected_place' => 'I have woken up in an unexpected place after heavy drinking.',
					'feel_bad' => 'I have felt badly about myself because of my drinking.',
					'lack_of_energy' => 'I have had less energy or felt tired because of my drinking.',
					'suffered_work_quality' => 'The quality of my work or schoolwork has suffered because of my drinking.',
					'spend_too_much_time_drinking' => 'I have spent too much time drinking.',
					'neglect_obligations' => 'I have neglected my obligations to family, work, or school because of drinking.',
					'relationship_problems' => 'My drinking has created problems between myself and my boyfriend/girlfriend/spouse, parents, or other near relatives.',
					'overweight' => 'I have been overweight because of drinking.',
					'harmed_physical_appearance' => 'My physical appearance has been harmed by my drinking.',
					'need_drink_before_breakfast' => 'I have felt like I needed a drink after I’d gotten up (that is, before breakfast).',
				),
			),
		);
	}

	if ($stage == 6) {
		return array(
			'legend' => 'Please fill in the details of your alcohol usage below.',
			'intro' => array(
				'title' => 'Precautions on Drinking',
				'description' => array(
					'The following items are designed to assess the extent to which students endorse common things they do before they drink alcohol or while they are drinking.',
				),
			),
			'include_tabular' => true,
			'tabular' => array(
				'section_number' => '01',
				'image_name' => 'vessels',
				'image_desc' => 'Drinking Vessel',
				'intro' => array(
					'Answer each of the following by clicking on the appropriate box.',
					'When I am drinking, I...',
				),
				'columns' => array(
					'never' => 'Never',
					'almost-never' => 'Almost never',
					'sort-time' => 'Sort of the time',
					'half-time' => 'Half of the time',
					'most-time' => 'Most of the time',
					'almost-always' => 'Almost always',
					'always' => 'Always',
					'skip' => 'I choose not to answer',
				),
				'rows' => array(
					'count_drinks' => 'Count the number of drinks I have over the course of the night.',
					'set_number_drinks' => 'Have a set number of drinks I will have for the social occasion.',
					'eat_before' => 'Eat before I go out.',
					'space_drinks_out' => 'Space my drinks out over time.',
					'alternate_drinks' => 'Alternate alcoholic drinks with nonalcoholic beverages.',
					'drink_for_quality' => 'Drink for quality not quantity.',
					'avoid_drinking_games' => 'Avoid drinking games.',
					'have_a_reliable_driver' => 'Have a reliable designated driver.',
					'preplan_transportation' => 'Preplan transportation to get home.',
					'dst_protection' => 'Use protection for STDs with a sexual partner (condoms, dental dams, etc.).',
					'watch_out_for_each_other' => 'Have a plan with a friend to watch out for each other.',
				),
			),
		);
	}

	if ($stage == 7) {
		return array(
			'legend' => 'Please fill the fields below.',
			'intro' => array(
				'title' => 'What would you like to do?',
			),
			'include_tabular' => true,
			'tabular' => array(
				'section_number' => '01',
				'image_name' => 'vessels',
				'image_desc' => 'Drinking Vessel',
				'intro' => array(
					'On a 7-point scale with <strong>1</strong> indicating <strong>not at all</strong> and <strong>7</strong> indicating <strong>definitely</strong>, please rate the following',
				),
				'columns' => array(
					'1' => 'Not at all<br><br>1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
					'7' => 'Definitely<br><br>7',
				),
				'rows' => array(
					'cut_down_drinking' => 'I would like to cut down on drinking.',
					'stop_drinking' => 'I would like to stop drinking entirely.',
				),
			),
		);
	}

	if ($stage == 8) {
		return array(
			'legend' => 'Please fill the fields below.',
			'intro' => array('title' => 'Current smoking'),
			'submit' => array('title' => 'See results'),
		);
	}

	if ($stage == 9) {
		return array(
			'legend' => 'Please fill the fields below.',
			'intro' => array(
				'title' => 'Thanks for completing the survey, ' . h(ifne($global_vars, 'participant_name')),
				'description' => array(
					'Here you will find some feedback based on the answers you have<br />provided as well as some other information on staying safe whilst drinking <br />which you may find useful.',
					'<a href="download-feedback.php?t=' . h( $global_vars['token'] ) . '&x=.pdf" target="_blank" class="btn pdf"><i class="icn pdf"></i>Download as PDF</a>'
				),
			),
			'classes' => 'results',
			'last_step' => true,
		);
	}

	return array();
}
