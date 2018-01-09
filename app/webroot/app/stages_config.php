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
		array('group' => 'one', 'step' => 'two', 'title' => 'All about you'),
		array('group' => 'two', 'step' => 'three', 'title' => 'Past and Present Drinking'),
		array('group' => 'three', 'step' => 'four', 'title' => 'In the last four weeks'),
		array('group' => 'three', 'step' => 'five', 'title' => 'Effects of Drinking (1/2)'),
		array('group' => 'three', 'step' => 'six', 'title' => 'Effects of Drinking (2/2)'),
		array('group' => 'three', 'step' => 'seven', 'title' => 'Before and During Drinking'),
		array('group' => 'four', 'step' => 'eight', 'title' => 'What would you like to do?'),
		array('group' => 'four', 'step' => 'nine', 'title' => 'Current Smoking'),
		array('group' => 'five', 'step' => 'ten', 'title' => 'Results'),
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
			'legend' => 'Please fill in these details about yourself.',
			'intro' => array(
				'title' => 'All about you',
				'description' => array(
					'Thanks, ' . h(ifne($global_vars, 'participant_name')) . '. First of all we\'d like to know a little bit more about you...',
				),
			),
			'include_tabular' => true,
			'tabular' => array(
				'section_number' => '01',
				'intro' => array(
					'Below are a number of statements that describe ways in which people act and think. For each statement, please indicate how much you agree or disagree with the statement.',
					'Be sure to indicate your agreement or disagreement for every statement below.',
				),
				'columns' => array(
					'agree-strongly' => 'Agree Strongly',
					'agree-somewhat' => 'Agree Somewhat',
					'disagree-somewhat' => 'Disagree Somewhat',
					'disagree-strongly' => 'Disagree Strongly',
				),
				'rows' => array(
					'see_things_through_to_the_end' => 'I generally like to see things through to the end.',
					'thinking_careful_purposeful' => 'My thinking is usually careful and purposeful.',
					'great_mood_leading_to_problematic_situations' => 'When I am in a great mood, I tend to get into situations that could cause me problems.',
					'unfinished_tasks_bother_me' => 'Unfinished tasks really bother me.',
					'think_things_over_before_doing' => 'I like to stop and think things over before I do them.',
					'feeling_bad_leading_to_regretful_actions' => 'When I feel bad, I will often do things I later regret in order to make myself feel better now.',
					'hate_to_stop_doing_things' => 'Once I get going on something, I hate to stop.',
					'feeling_bad_difficult_to_stop' => 'Sometimes when I feel bad, I can’t seem to stop what I am doing even though it is making me feel worse.',
					'enjoy_taking_risks' => 'I quite enjoy taking risks.',
					'good_mood_lose_control' => 'I tend to lose control when I am in a great mood.',
					'finish_when_start' => 'I finish when I start.',
					'rational_sensible_approach' => 'I tend to value and follow a rational, “sensible” approach to things.',
					'upset_act_without_thinking' => 'When I am upset, I often act without thinking.',
					'welcome_new_exciting_experiences' => 'I welcome new and exciting experiences and sensations, even if they are a little frightening and unconventional.',
					'rejection_leading_to_say_regretful_things' => 'When I feel rejected, I will often say things I later regret.',
					'learn_fly_airplane' => 'I would like to learn to fly an airplane.',
					'others_shocked_about_my_excitement' => 'Others are shocked or worried about the things I do when I am feeling very excited.',
					'skiing_very_fast' => 'I would enjoy the sensation of skiing very fast down a high mountain slope.',
					'think_carefully_before_doing_anything' => 'I usually think carefully before doing anything.',
					'act_withoug_thinking_when_excited' => 'I tend to act without thinking when I am really excited.',
				),
			),
		);
	}

	if ($stage == 3) {
		return array(
			'include_drinks_guide' => true,
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

	if ($stage == 4) {
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
					'Now we\'d like to ask you about your drinking in the <strong>last four weeks only</strong>.<br>We understand that this might be difficult to remember exactly so<br>for these questions please give your best estimate.',
					'Please use the definitions of Standard Drinks below as a guide.',
				),
			),
			'tabular' => array(
				'section_number' => '01',
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

	if ($stage == 5) {
		return array(
			'legend' => 'Please fill in the details of your alcohol usage below.',
			'intro' => array(
				'title' => 'Effects of Drinking',
				'description' => array(
					'These questions relate to your experiences when drinking.',
				),
			),
			'include_tabular' => true,
			'tabular' => array(
				'section_number' => '01',
				'image_name' => 'vessels',
				'image_desc' => 'Drinking Vessel',
				'intro' => array(
					'Please rate the following items according to how often each has occurred in your drinking experiences <strong>in the past month</strong>.',
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

	if ($stage == 6) {
		return array(
			'legend' => 'Please fill in the details of your alcohol usage below.',
			'intro' => array(
				'title' => 'Effects of Drinking',
				'description' => array(
					'These questions relate to your experiences when drinking.',
				),
			),
			'include_tabular' => true,
			'tabular' => array(
				'section_number' => '01',
				'image_name' => 'vessels',
				'image_desc' => 'Drinking Vessel',
				'intro' => array(
					'Below is a list of things that sometimes happen to people either during, or after they have been drinking alcohol.',
					'Next to each item below, please click YES or NO to indicate whether that item describes something that has happened to you <strong>in the past month</strong>.',
				),
				'columns' => array(
					'yes' => 'Yes',
					'no' => 'No',
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

	if ($stage == 7) {
		return array(
			'legend' => 'Please fill in the details of your alcohol usage below.',
			'intro' => array(
				'title' => 'Before and During Drinking',
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
					'Answer each of the following by clicking on the appropriate circle.',
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

	if ($stage == 8) {
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

	if ($stage == 9) {
		return array(
			'legend' => 'Please fill the fields below.',
			'intro' => array('title' => 'Current smoking'),
			'submit' => array('title' => 'See results'),
		);
	}

	if ($stage == 10) {
		return array(
			'legend' => 'Please fill the fields below.',
			'intro' => array(
				'title' => 'Thanks for completing the survey, ' . h(ifne($global_vars, 'participant_name')),
				'description' => array(
					'In a moment, you will have a chance to review some personalized feedback based on your responses to the questions in this survey. Please take a look at this feedback and the information in the Tips, Facts and Support screens.',
					'<a href="download-feedback.php?t=' . h( $global_vars['token'] ) . '&x=.pdf" target="_blank" class="btn pdf"><i class="icn pdf"></i>Download as PDF</a>'
				),
			),
			'classes' => 'results',
			'last_step' => true,
		);
	}

	return array();
}
