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
	$participant_name = isset($global_vars['participant_name']) ? htmlspecialchars($global_vars['participant_name']) : '';

	if ($stage == 1) {
		return array(
			'legend' => 'Please fill in these details about yourself.',
			'intro' => array(
				'title' => 'All about you',
				'description' => array(
					'Thanks, ' . $participant_name . '. First of all we\'d like to know a little bit more about you...',
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
					'Thanks, ' . $participant_name . '. First of all we\'d like to know a little bit more about you...',
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
					'relationship_problems' => 'My drinking has created problems between myself and my romantic partner, parents, or other near relatives.',
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
					'some-time' => 'Some of the time',
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
					'1' => '<span class="hide-mobile">Not at all<br><br>1</span><span class="hide-desktop">1 - Not at all</span>',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
					'7' => '<span class="hide-mobile">Definitely<br><br>7</span><span class="hide-desktop">7 - Definitely</span>',
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
		$version = empty($_GET['v']) ? '1' : $_GET['v'];
		return array(
			'legend' => 'Please fill the fields below.',
			'intro' => array(
				'title' => 'Thanks for completing the survey, ' . $participant_name,
				'description' => array(
					'In a moment, you will have a chance to review some personalized feedback based on your responses to the questions in this survey. Please take a look at this feedback and the information in the Tips, Facts and Support screens.',
					'<a href="download-feedback.php?t=' . htmlspecialchars($global_vars['token']) . '&v=' . $version . '&x=.pdf" target="_blank" class="btn pdf"><i class="icn pdf"></i>Download as PDF</a>'
				),
			),
			'classes' => 'results',
			'last_step' => true,
		);
	}

	return array();
}

function get_feedback_sections() {
	$version = empty($_GET['v']) ? '1' : $_GET['v'];

	return array(
		'tips' => array(
			'label' => 'Tips',
			'intro' => array(
				'label' => 'Stuff other people do...',
			),
			'content' => get_feedback_tips($version),
		),
		'facts' => array(
			'label' => 'Facts',
			'intro' => array(
				'label' => 'Stuff about alcohol and you...',
				'content' => 'Safe drinking guidelines have been developed to help you protect your health - both physically and socially. Everyone is faced with some risk when consuming alcohol but thinking before you drink can lead to an enjoyable and safe experience.',
			),
			'content' => get_feedback_facts(),
		),
	);
}

function get_feedback_tips($version) {
	if ($version == 1) {
		return array(
			array(
				'label' => 'Flock together',
				'content' => 'There are more reasons to stick with your friends than just to laugh at them when they start stumbling. Looking out for them (and they for you) can ensure that the night ends on a good note and not with someone left on the side of the road or unconscious in a toilet stall.',
			),
			array(
				'label' => 'Cashed up?',
				'content' => 'Two-minute noodle dinners can get pretty boring after the second week - but then that might be the only option after a big night out! Carrying less money with you when you go out reduces the amount of alcohol you purchase which can be good for your body as well as your pocket. Make sure you leave some aside though if you need to catch a taxi - try putting it in your shoe so you\'re less likely to spend it.',
			),
			array(
				'label' => 'How many have you had?',
				'content' => 'Do you know what a standard drink is? It\'s a measurement of alcohol and it isn\'t always the same as a bottle/can/glass. Most drinks are more than a single \'standard drink\' so you could be consuming more than you think. Safe drinking guidelines are based on this measurement so it pays to know what they are. Set a limit at the start of the night and stick to it. Avoid partial drink refills so you can actually keep track.',
			),
			array(
				'label' => 'Slow down',
				'content' => 'Extend your night - space your drinks with water or soft drinks. It\'ll keep you hydrated and less likely to end up on the floor. Even start off your night with a non-alcoholic drink to quench your thirst before moving onto the booze. Grab a bite to eat beforehand and snack throughout the night.',
			),
			array(
				'label' => 'Be yourself',
				'content' => 'If you don\'t feel like another drink or want to drink at your own pace, real friends should respect that. If you\'re getting hassled, tell them you\'re driving, on antibiotics, or you\'re a sexual athlete who needs to perform later that night. And soft drinks look the same whether there\'s alcohol in them or not. Find something that works for you.',
			),
			array(
				'label' => 'Can I buy you a drink?',
				'content' => 'There might be some strangers you want to meet, but it\'s probably better to do it while you\'re conscious. Drink spiking happens - to girls and guys. To protect yourself, only accept drinks from people you don\'t know if they are unopened cans or bottles. Never leave your drink unattended and keep a thumb over the top of your bottle - it\'ll also help prevent you wasting your drink if your arms get a little too excited.',
			),
			array(
				'label' => 'Unwanted gifts',
				'content' => 'Getting lucky doesn\'t mean you have to get Chlamydia. If there\'s any possibility that you may end up in bed with someone - carry a condom with you - and make sure you know how to use it.',
			),
			array(
				'label' => 'Stay off the road',
				'content' => 'Plan how you\'re getting home before you go out. Grab a taxi - go in a group and you can share the bill. Put the taxi number in your phone. If you\'re organizing a designated driver, make sure they really are not drinking - the last thing you want is to have no money and no one able to drive when it is time to head home.',
			),
			array(
				'label' => 'Mixers',
				'content' => 'Diversity might be the spice of life but when it comes to drugs it can be fatal. Mixing alcohol with other drugs - even prescribed medication can have unanticipated effects. Stick to the alcohol and if you\'re sick take the night off.',
			),
		);
	}

	if ($version == 2) {
		return array(
			array(
				'label' => 'How many have you had?',
				'content' => 'Do you know what a standard drink is? It\'s a measurement of alcohol and it isn\'t always the same as a bottle/can/glass. Most drinks are more than a single \'standard drink\' so you could be consuming more than you think. Safe drinking guidelines are based on this measurement so it pays to know what they are. Avoid partial drink refills so you can actually keep track of the number of drinks you\'ve had in the course of a night.',
			),
			array(
				'label' => 'Stick to your guns',
				'content' => 'Set a drink limit at the start of the night and stick to it.',
			),
			array(
				'label' => 'Slow down',
				'content' => 'Extend your night. Space out your drinks.',
			),
			array(
				'label' => 'Take turns',
				'content' => 'Alternate between alcoholic drinks and either water, juice or soft drinks. It\'ll keep you hydrated and less likely to end up on the floor. Even start off your night with a non-alcoholic drink to quench your thirst before moving onto the booze.',
			),
		);
	}

	if ($version == 3) {
		return array(
			array(
				'label' => 'Flock together',
				'content' => 'There are more reasons to stick with your friends then just to laugh at them when they start stumbling. Looking out for them (and they for you) can ensure that the night ends on a good note and not with someone left on the side of the road or unconscious in a toilet stall.',
			),
			array(
				'label' => 'Unwanted gifts',
				'content' => 'Getting lucky doesn\'t mean you have to get Chlamydia. If there\'s any possibility that you may end up in bed with someone - carry a condom with you - and make sure you know how to use it.',
			),
			array(
				'label' => 'Stay off the road',
				'content' => 'Plan how you\'re getting home before you go out. Grab a taxi - go in a group and you can share the bill. Put the taxi number in your phone.',
			),
			array(
				'label' => 'How to designate a driver',
				'content' => 'If you\'re organizing a designated driver, make sure they really are not drinking - the last thing you want is to have no money and no one able to drive when it is time to head home.',
			),
		);
	}
}

function get_feedback_facts() {
	return array(
		array(
			'label' => 'Standard Drinks',
			'content' => 'Alcohol comes in all different types, colours and containers. Regardless of this, a standard drink is about 14 grams or 17.7mL of pure alcohol. Alcohol labels are displayed on the bottle to tell you how many standard drinks it contains. Remember one bottle/can/glass doesn\'t always equal one standard drink.',
			'list' => array(
				'Men shouldn\'t drink more than 4 standard drinks a day to avoid long-term harm, with at least two alcohol-free days a week.',
				'Women shouldn\'t drink more than 3 standard drinks a day to avoid long-term harm, with at least two alcohol-free days a week.',
			),
		),
		array(
			'label' => 'Everyone is Different',
			'content' => 'People come in all different shapes and sizes, so depending on your gender, age, weight and other factors; you may be affected by alcohol more than others. Get to know your body in relation to the standard drink guidelines, and try to keep one to two days a week free of alcohol.',
		),
		array(
			'label' => 'Staying Under the Limit',
			'content' => 'It doesn\'t take much to put you over the 0.08% blood alcohol concentration (BAC) limit (0.02% for those under the age of 21). To stay under this:',
			'list' => array(
				'Women of average size shouldn\'t drink more than one standard drink per hour; and',
				'Men of average size can drink up to two standard drinks in the first hour and no more than one standard drink per hour after that.',
			),
		),
		array(
			'label' => 'Alcohol and Your Body',
			'content' => array(
				'The immediate effects of alcohol can include slurred speech, blurred vision, changes in mood, loss of inhibitions, vomiting, loss of balance and clumsiness. These effects are greater with increasing amounts of alcohol consumed. More serious effects can be unconsciousness, alcohol poisoning, coma or death with excessive alcohol consumption. It\'s called a depressant for a reason.',
				'Longer-term effects of heavy drinking can leave you with serious health problems. These can include alcohol dependence, liver damage or disease, mood changes, cancer (mouth, throat, breast), sexual difficulties, memory loss or strokes.',
			),
		),
		array(
			'label' => 'Other Effects of Alcohol',
			'content' => 'Alcohol can affect more than just your body. There are physical and social risks that may happen when drinking too much. These can include injury, car crashes, getting into trouble with the police, arguments, fights, unwanted or unsafe sexual activity, offending others or doing things you regret later. Controlling your drinks enables you to control your behaviour.',
		),
		array(
			'label' => 'Alcohol and the Law',
			'content' => 'Alcohol impairs your judgement, which can lead to doing something you wouldn\'t when sober. Some alcohol-related laws to keep in mind are:',
			'list' => array(
				'Consuming alcohol in a public place or on private property could result in a $500 fine and may even lead to a jail term of up to 60 days;',
				'Argumentative, disorderly or violent behavior isn\'t acceptable, it can get you into trouble with the police;',
			),
		),
		array(
			'label' => 'Driving Under the Influence (DUI)',
			'content' => 'DUI is taken very seriously. Here are the BAC limits for drivers of different ages and the hefty punishments that may result if you decide to take the risk:',
			'list' => array(
				'Drivers under the age of 21 - Your BAC limit for driving is 0.02%',
				'Other drivers - Your BAC limit is 0.08%',
				'If you are found to have driven under the influence, for a first offense you could get a fine between $500-$2000, plus administrative and potentially lawyer\'s fees. Even the first offense could lead to a sentence of 6-9 months in jail or an alcohol/drug treatment program plus probation, 50 hours or more of mandatory community service and leave you without a license for 6 months-1 year. Subsequent offenses and DUIs where bodily harm is involved increase the amount of fines and increase the likelihood of actual jail time rather than community service only.'
			),
			'secondary_content' => 'Drinking alcohol can be part of an enjoyable night out, but drinking safely will ensure you have good memories and that you keep your license.',
		),
	);
}
