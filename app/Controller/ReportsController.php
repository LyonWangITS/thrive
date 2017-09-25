<?php

require_once '../webroot/app/stages_config.php';

/**
*	Reporting section.
*/
class ReportsController extends AppController {

	public $components = array(
	);

	public $uses = array(
		'Entry',
		'Partner',
	);

	//
	// Build list of reports available
	public $reports = array(
		'demographics' => array(
			'_name' => 'Demographics',
			'gender' => array(
				'title' => 'Sample proportions by gender',
				'xaxis' => 'Gender options',
				'yaxis' => 'Frequency',
			),
			'age' => array(
				'title' => 'Sample proportions by age',
				'xaxis' => 'Age groupings',
				'yaxis' => 'Frequency',
			),
			'staff_student' => array(
				'title' => 'Sample proportions by staff/student',
				'xaxis' => 'Staff/student',
				'yaxis' => 'Frequency',
			),
			'year_level' => array(
				'title' => 'Sample proportions by level/class standing',
				'xaxis' => 'Level/class standing',
				'yaxis' => 'Frequency',
			),
			'on_campus' => array(
				'title' => 'Sample proportions by if accommodation on-campus',
				'xaxis' => 'On-campus accommodation',
				'yaxis' => 'Frequency',
			),
			'where_from' => array(
				'title' => 'Sample proportions by where from',
				'xaxis' => 'Where from',
				'yaxis' => 'Frequency',
			),
		),
		'consumption' => array(
			'_name' => 'Alcohol consumption',
			'have_consumed' => array(
				'title' => 'Proportion who have consumed alcohol in past 12 months',
				'xaxis' => 'Consumed alcohol in the last 12 months',
				'yaxis' => 'Frequency',
			),
			'audit_age' => array(
				'title' => 'Graph of mean AUDIT score by age',
				'xaxis' => 'Age groupings',
				'yaxis' => 'Mean AUDIT score',
			),
			'audit_gender' => array(
				'title' => 'Graph of mean AUDIT score by gender',
				'xaxis' => 'Gender options',
				'yaxis' => 'Mean AUDIT score',
			),
			'audit_scores' => array(
				'title' => 'Graph of AUDIT scores to show range',
				'xaxis' => 'AUDIT score',
				'yaxis' => 'Frequency',
			),
			'peak' => array(
				'title' => 'Drinks consumed at peak consumption',
				'xaxis' => 'Number of drinks',
				'yaxis' => 'Number who consumed this',
			),
		),
		'related_harm' => array(
			'_name' => 'Alcohol-related harm',
			'answered' => array(
				'title' => 'Proportion who answered these questions',
				'xaxis' => 'Questions answered',
				'yaxis' => 'Frequency',
			),
			'answered_question' => array(
				'title' => 'Proportion who answered each question',
				'xaxis' => 'Question answered',
				'yaxis' => 'Frequency',
			),
			'age' => array(
				'title' => 'Harms experienced by age',
				'xaxis' => 'Harms',
				'yaxis' => 'Frequency',
			),
			'gender' => array(
				'title' => 'Harms experienced by gender',
				'xaxis' => 'Harms',
				'yaxis' => 'Frequency',
			),
		),
		'feedback' => array(
			'_name' => 'Feedback',
			'important_reduce' => array(
				'title' => 'How important is it to you that you reduce your drinking?',
				'xaxis' => '1 (Not at all important) - 10 (Very important)',
				'yaxis' => 'Frequency',
			),
			'confident_reduce' => array(
				'title' => 'How confident are you that you can reduce your drinking?',
				'xaxis' => '1 (Not at all confident) - 10 (Very confident)',
				'yaxis' => 'Frequency',
			),
			'important_talk' => array(
				'title' => 'How important do you think it is that you talk to a health professional about your drinking?',
				'xaxis' => '1 (Not at all important) - 10 (Very important)',
				'yaxis' => 'Frequency',
			),
			'ready_talk' => array(
				'title' => 'How ready are you to talk to a health professional?',
				'xaxis' => '1 (Not at all ready) - 10 (Very ready)',
				'yaxis' => 'Frequency',
			),
		),
	);

	public $age_groups = array(
		array(
			'name' => '16-17',
			'query' => '01_age >= 16 AND 01_age <= 17',
		),
		array(
			'name' => '18-25',
			'query' => '01_age >= 18 AND 01_age <= 25',
		),
		array(
			'name' => '26-34',
			'query' => '01_age >= 26 AND 01_age <= 34',
		),
		array(
			'name' => '35-44',
			'query' => '01_age >= 26 AND 01_age <= 34',
		),
		array(
			'name' => '45-54',
			'query' => '01_age >= 45 AND 01_age <= 54',
		),
		array(
			'name' => '55-64',
			'query' => '01_age >= 55 AND 01_age <= 64',
		),
		array(
			'name' => '65-74',
			'query' => '01_age >= 65 AND 01_age <= 74',
		),
		array(
			'name' => '75+',
			'query' => '01_age >= 75',
		),
	);

	public $genders = array(
		'female' => 'Female',
		'male' => 'Male',
		'transgender-ftm' => 'Transgender or transexual FtM',
		'transgender-mtf' => 'Transgender or transexual MtF',
		'genderqueer' => 'Genderqueer',
		'androgynous' => 'Androgynous',
		'intersex' => 'Intersex',
	);

	public $year_levels = array(
		'1st-year' => '1st Year',
		'2nd-year' => '2nd Year',
		'3rd-year' => '3rd Year',
		'4th-year' => '4th Year',
		'postgraduate' => 'Postgraduate',
		'not-applicable' => 'Not Applicable',
	);

	public $where_from = array(
		'perth-metro' => 'Perth (Metropolitan) student',
		'regional-wa' => 'Regional (Western Australian) student',
		'other-state' => 'Other Australian state student',
		'international' => 'International student',
	);

	public $harm_fields = array(
		'04_hangover' => 'Hangover',
		'04_emotional_outburst' => 'Emotional outburst',
		'04_vomiting' => 'Vomiting',
		'04_heated_argument' => 'Heated argument',
		'04_physically_aggressive' => 'Physically aggressive',
		'04_blackouts' => 'Blackouts',
		'04_inability_to_pay_bills' => 'Inability to pay bills',
		'04_unprotected_sex' => 'Unprotected sex',
		'04_sexual_situation_not_happy_about' => 'Sexual situation not happy about',
		'04_sexual_encounter_later_regretted' => 'Sexual encounter later regretted',
		'04_injury_requiring_medical_attention' => 'Injury requiring medical attention',
		'04_drove_car_unsafely' => 'Drove car unsafely',
		'04_passenger_of_unsafe_driver' => 'Passenger of unsafe driver',
		'04_stole_property' => 'Stole property',
		'04_committed_vandalism' => 'Committed vandalism',
		'04_removed_or_banned_from_pub_club' => 'Removed of banned from pub/club',
		'04_arrested' => 'Arrested',
	);

	/* Lookups (should be moved to database once we fold the survey into Cake. */

	public $sexual_orientations = array(
		'm' => 'Attracted to males',
		'mostly-m' => 'Mostly attracted to males',
		'f' => 'Attracted to females',
		'mostly-f' => 'Mostly attracted to females',
		'equally-mf' => 'I am equally attracted to males and females',
		'unsure' => 'Unsure',
		'skip' => 'Prefer not to say',
	);

	public $how_often_drink = array(
		'never' => 'Never',
		'lt-1pm' => 'Less than once a month',
		'1pm' => 'Once a month',
		'1p2w' => 'Once every two weeks',
		'1pw' => 'Once a week',
		'2-3pw' => 'Two or three times a week',
		'4pw' => 'Four or more times a week',
	);

	public $how_often_six_plus = array(
		'never' => 'Never',
		'1-2py' => 'Once or twice in the last year',
		'lt-1pm' => 'Less than monthly',
		'1pm' => 'Monthly',
		'1pw' => 'Weekly',
		'1pd' => 'Daily or almost daily',
	);

	public $past_year = array(
		'never' => 'Never',
		'lt-1pm' => 'Less than monthly',
		'1pm' => 'Monthly',
		'1pw' => 'Weekly',
		'1pd' => 'Daily',
	);

	public $have_you_ever = array(
		'no' => 'Never',
		'yes-nly' => 'Yes, but not in last year',
		'yes-ly' => 'Yes, during last year',
	);

	/**
	*	Default page.
	*/
	public function index() {
	}
	
	/**
	*	Drives all the individual reports.
	*	@section Mostly used for navigation/title
	*	@report The key, used to include appropriate element and data.
	*/
	public function view( $section = null, $report = null ) {

		$this->set( 'reports', $this->reports );

		//
		// Get current section and report names
		$section_name = null;
		if ( isset( $this->reports[$section] ) ) {

			$section_name = $this->reports[$section]['_name'];
		}
		else {

			throw new NotFoundException( 'Invalid reports section.' );
		}
		$this->set( 'section', $section );
		$this->set( 'section_name', $section_name );

		$report_name = null;
		if ( !empty( $report ) ) {

			if ( isset( $this->reports[$section][$report] ) ) {

				$report_name = $this->reports[$section][$report]['title'];
			}
			else {

				throw new NotFoundException( 'Invalid report.' );
			}
		}
		$this->set( 'report', $report );
		$this->set( 'report_name', $report_name );

		//
		// Try populating the from/to dates from session
		if ( $this->Session->check( 'report.from' ) ) {

			$this->request->data['from'] = $this->Session->read( 'report.from' );
		}
		if ( $this->Session->check( 'report.to' ) ) {

			$this->request->data['to'] = $this->Session->read( 'report.to' );
		}
	}

	/**
	*	CSV Export page.
	*/
	public function export() {

		//
		// Handle postback
		if ( empty( $this->data ) ) {
		
			return;
		}

		// Generate filename: "Curtin THRIVE data x-y.csv"
		$filename = "{$this->current_user['Partner']['name']} THRIVE data";
		if ( !empty( $this->data['from'] ) ) {
	
			$filename .= ' from ' . date( MYSQL_DATE, strtotime( $this->data['from'] ) );
		}
		if ( !empty( $this->data['to'] ) ) {
	
			$filename .= ' to ' . date( MYSQL_DATE, strtotime( $this->data['to'] ) );
		}
		$filename = str_replace( ' ', '_', $filename );
		$filename .= '.csv';

		// Fetch data
		$conditions = array();
		$this->_apply_common_conditions( $conditions );
		$data = $this->Entry->find( 'all', array(
			'conditions' => $conditions,
			'order' => 'Entry.id DESC',
		) );

		// Build output
		$fp = fopen( 'php://memory', 'w' ); 
		
		$headers = array(
			'ID',
			'Completed',
			'Name',
			'Gender',
			'Age',
			'Consumed alcohol last 12 months',
			'How often drink alcohol',
			'How many Standard Drinks on typical day',
			'How often 6+ Standard Drinks on one occasion',
			'Past year - unable to stop drinking',
			'Past year - failed expectations',
			'Past year - needed morning drink',
			'Past year - remorseful',
			'Past year - unable to remember',
			'Ever been injured or injured someone',
			'Others been concerned',
			'Past 4 weeks consumed alcohol',
			'Past 4 weeks largest number single occasion',
			'Past 4 weeks over how many hours', 
			'Body height (cm)',
			'Body weight (kg)',
		);

		$days = get_weekdays();
		foreach ($days as $label) {
			$headers[] = 'Drink times (past 4 weeks) - ' . $label;
		}

		foreach ($days as $label) {
			$headers[] = 'Standard drinks (past 4 weeks) - ' . $label;
		}

		foreach (range(4, 7) as $step) {
			$stage = get_stage_vars($step);
			foreach ($stage['tabular']['rows'] as $label) {
				$headers[] = $label;
			}
		}

		$headers[] = 'Tobacco - Use description';
		$headers[] = 'Tobacco - Frequency';
		$headers[] = 'Tobacco - time to init';
		$headers[] = 'Audit score';
		$headers[] = 'Feedback - How important is it to you that you reduce your drinking? 1 (Not at all important) - 10 (Very important)';
		$headers[] = 'Feedback - How confident are you that you can reduce your drinking? 1 (Not at all confident) - 10 (Very confident)';
		$headers[] = 'Feedback - How important do you think it is that you talk to a health professional (like a doctor or counsellor) about your drinking? 1 (Not at all important) - 10 (Very important)';
		$headers[] = 'Feedback - How ready are you to talk to a health professional? 1 (Not at all ready) - 10 (Very ready)';

		fputcsv( $fp, $headers );

		$days = array_keys($days);
		foreach ( $data as $entry ) {

			$row = array(
				$entry['Entry']['id'],
				$entry['Entry']['completed'],
				$entry['Entry']['00_participant_name'],
				( !empty( $entry['Entry']['01_gender'] ) ) ? $this->genders[$entry['Entry']['01_gender']] : '',
				$entry['Entry']['01_age'],
				//str_replace(array('native-american', 'asian', 'hawaiian', 'black', 'white', 'mixed-race', 'other', 'skip'), array(), $entry['Entry']['01_race']),
				//str_replace(array('hispanic-latino','not-hispanic-latino','skip'), array(), $entry['Entry']['01_ethnicity']),
				//str_replace(array('dorm', 'with-parents', 'with-roommates'), array(), $entry['Entry']['01_where']),
				//( !empty( $entry['Entry']['01_parents'] ) ) ? 'Yes' : 'No',
				//str_replace(array('uf-only', 'transfered'), array(), $entry['Entry']['01_history']),
				( !empty( $entry['Entry']['01_alcohol_last_12mths'] ) ) ? 'Yes' : 'No',
				( !empty( $entry['Entry']['02_how_often_drink_alcohol'] ) ) ? $this->how_often_drink[$entry['Entry']['02_how_often_drink_alcohol']] : '',
				$entry['Entry']['02_how_many_on_typical_day'],
				( !empty( $entry['Entry']['02_how_often_six_or_more'] ) ) ? $this->how_often_six_plus[$entry['Entry']['02_how_often_six_or_more']] : '',
				( !empty( $entry['Entry']['02_past_year_how_often_unable_to_stop'] ) ) ? $this->past_year[$entry['Entry']['02_past_year_how_often_unable_to_stop']] : '',
				( !empty( $entry['Entry']['02_past_year_how_often_failed_expectations'] ) ) ? $this->past_year[$entry['Entry']['02_past_year_how_often_failed_expectations']] : '',
				( !empty( $entry['Entry']['02_past_year_needed_morning_drink'] ) ) ? $this->past_year[$entry['Entry']['02_past_year_needed_morning_drink']] : '',
				( !empty( $entry['Entry']['02_past_year_how_often_remorseful'] ) ) ? $this->past_year[$entry['Entry']['02_past_year_how_often_remorseful']] : '',
				( !empty( $entry['Entry']['02_past_year_how_often_unable_to_remember'] ) ) ? $this->past_year[$entry['Entry']['02_past_year_how_often_unable_to_remember']] : '',
				( !empty( $entry['Entry']['02_been_injured_or_injured_someone'] ) ) ? $this->have_you_ever[$entry['Entry']['02_been_injured_or_injured_someone']] : '',
				( !empty( $entry['Entry']['02_others_concerned_about_my_drinking'] ) ) ? $this->have_you_ever[$entry['Entry']['02_others_concerned_about_my_drinking']] : '',
				( !empty( $entry['Entry']['03_past_4wk_consumed_alcohol'] ) ) ? 'Yes' : 'No',

				$entry['Entry']['03_past_4wk_largest_number_single_occasion'],
				$entry['Entry']['03_past_4wk_hours_amount_drank'],
				$entry['Entry']['03_body_height_cm'],
				$entry['Entry']['03_body_weight_kg'],
			);

			foreach (array('', 'std_') as $prefix) {
				foreach ($days as $day) {
					$field = '03_past_4wk_' . $prefix . 'drinks_' . $day;
					$row[] = empty($entry['Entry'][$field]) ? '0' : $entry['Entry'][$field];
				}
			}

			foreach (range(4, 7) as $step) {
				$stage = get_stage_vars($step);
				$prefix = '0' . $step . '_';

				foreach (array_keys($stage['tabular']['rows']) as $field) {
					$field = $prefix . $field;
					$row[] = is_null($entry['Entry'][$field]) ? '' : str_replace(array_keys($stage['tabular']['columns']), $stage['tabular']['columns'], $entry['Entry'][$field]);
				}
			}


			$row[] = str_replace(array('never', 'used_to_smoke_regularly', 'occasionally', 'regularly'), array(
				'Never smoked cigarettes at all, or never smoked them regularly',
				'Do not smoke now but used to smoke regularly (once or more per day)',
				'Occasionally smoke (on average, less than one per day)',
				'Currently smoke cigarettes regularly (more than one per day)',
			), $entry['Entry']['08_tobacco_use']);


			$row[] = $entry['Entry']['08_tobacco_frequency'];
			$row[] = str_replace(array('0', '5', '30', '60', '61'), array('I do not smoke on a daily basis',  'Within 5 minutes', '5-30 minutes', '31-60 minutes', 'More than 60 minutes'), $entry['Entry']['08_tobacco_init']);
			$row[] = $entry['Entry']['audit_score'];
			$row[] = $entry['Entry']['rating_important_reduce_drinking'];
			$row[] = $entry['Entry']['rating_confident_reduce_drinking'];
			$row[] = $entry['Entry']['rating_important_talk_professional'];
			$row[] = $entry['Entry']['rating_ready_talk_professional'];

			fputcsv( $fp, $row );
		}

		// Output file
		fseek( $fp, 0 ); // rewind file
		header( 'Content-Type: application/csv' );
		header( "Content-Disposition: attachment; filename=\"{$filename}\"" );
		fpassthru( $fp );
		die;
	}

	/**
	*	Report data methods. Designed to be called via AJAX, will render the data
	*	for the given report.
	*/

	/**
	*	Demographic - Proportion by Age report
	*/
	public function data_demographics_age() {

		$this->_generate_query_count_report( $this->reports['demographics']['age'], $this->age_groups );
	}

	/**
	*	Demographic - Proportion by Gender report
	*/
	public function data_demographics_gender() {

		$this->_generate_field_count_report( $this->reports['demographics']['gender'], $this->genders, '01_gender' );
	}

	/**
	*	Demographic - Proportion by Staff/Student report
	*/
	public function data_demographics_staff_student() {

		$categories = array(
			'student' => 'Student',
			'staff' => 'Staff',
		);

		$this->_generate_field_count_report( $this->reports['demographics']['staff_student'], $categories, '01_staff_student' );
	}

	/**
	 *	Demographic - Proportion by Level/Class Standing report
	 */
	public function data_demographics_year_level() {

		$this->_generate_field_count_report( $this->reports['demographics']['year_level'], $this->year_levels, '01_year_level' );
	}

	/**
	 *	Demographic - Proportion by On-Campus Accommodation report
	 */
	public function data_demographics_on_campus() {

		$categories = array(
			'1' => 'Yes',
			'0' => 'No',
		);

		$this->_generate_field_count_report( $this->reports['demographics']['on_campus'], $categories, '01_on_campus' );
	}

	/**
	 *	Demographic - Proportion by Where From report
	 */
	public function data_demographics_where_from() {

		$this->_generate_field_count_report( $this->reports['demographics']['where_from'], $this->where_from, '01_where_from' );
	}

	/**
	*	Alcohol consumption - Proportion who have consumed alcohol in past 12 months report
	*/
	public function data_consumption_have_consumed() {

		$categories = array(
			'1' => 'Yes',
			'0' => 'No',
		);

		$this->_generate_field_count_report( $this->reports['consumption']['have_consumed'], $categories, '01_alcohol_last_12mths' );
	}

	/**
	*	Alcohol consumption - Mean AUDIT score by age report
	*/
	public function data_consumption_audit_age() {

		$categories = array();
		foreach ( $this->age_groups AS $age_group ) {

			$categories[] = array(
				'name' => $age_group['name'],
				'fields' => array( 'AVG( audit_score ) AS mean_audit_score' ),
				'conditions' => $age_group['query'],
			);
		}

		$this->_generate_query_average_report( $this->reports['consumption']['audit_age'], $categories );
	}

	/**
	*	Alcohol consumption - Mean AUDIT score by gender report
	*/
	public function data_consumption_audit_gender() {

		$categories = array();
		foreach ( $this->genders AS $gender_key => $gender_name ) {

			$categories[] = array(
				'name' => $gender_name,
				'fields' => array( 'AVG( audit_score ) AS mean_audit_score' ),
				'conditions' => "01_gender = '{$gender_key}'",
			);
		}

		$this->_generate_query_average_report( $this->reports['consumption']['audit_gender'], $categories );
	}

	/**
	*	Alcohol consumption - Graph of AUDIT scores to show range report
	*/
	public function data_consumption_audit_scores() {

		$categories = array();
		for ( $i = 1; $i <= 40; $i++ ) {

			$categories[$i] = $i;
		}

		$this->_generate_field_count_report( $this->reports['consumption']['audit_scores'], $categories, 'audit_score' );
	}

	/**
	*	Alcohol consumption - Drinks consumed at peak consumption report
	*/
	public function data_consumption_peak() {

		$categories = array();
		for ( $i = 1; $i < 32; $i++ ) {

			$categories[$i] = $i;
		}
		$categories['32+'] = '32+';

		$this->_generate_field_count_report( $this->reports['consumption']['peak'], $categories, '03_past_4wk_largest_number_single_occasion' );
	}

	/**
	*	Alcohol-related harm - Proportion who answered these questions report
	*/
	public function data_related_harm_answered() {

		$all_query = implode( ' IS NOT NULL AND ', array_keys( $this->harm_fields ) ) . ' IS NOT NULL';
		$some_query = "(" . implode( ' IS NOT NULL OR ', array_keys( $this->harm_fields ) ) . " IS NOT NULL ) AND NOT( $all_query )";
		$none_query = implode( ' IS NULL AND ', array_keys( $this->harm_fields ) ) . ' IS NULL';

		$categories = array(
			array(
				'name' => 'All questions',
				'query' => $all_query,
			),
			array(
				'name' => 'Some but not all',
				'query' => $some_query,
			),
			array(
				'name' => 'None',
				'query' => $none_query,
			),
		);

		$this->_generate_query_count_report( $this->reports['related_harm']['answered'], $categories );
	}

	/**
	*	Alcohol-related harm - Proportion who answered each question report
	*/
	public function data_related_harm_answered_question() {

		$series = array();

		$answered_question = array();
		$answered_yes = array();
		foreach ( $this->harm_fields as $key => $name ) {

			$answered_question[] = array(
				'name' => $name,
				'query' => "{$key} IN ('yes', 'no')",
			);
			$answered_yes[] = array(
				'name' => $name,
				'query' => "{$key} IN ('yes')",
			);
		}

		$series[] = array(
			'label' => 'Answered question',
			'data' => $answered_question,
		);
		$series[] = array(
			'label' => 'Answered yes',
			'data' => $answered_yes,
		);

		$this->_generate_multi_query_count_report( $this->reports['related_harm']['answered_question'], $series );
	}

	/**
	*	Alcohol-related harm - Harm experienced by age
	*/
	public function data_related_harm_age() {

		$series = array();
		foreach ( $this->age_groups as $group ) {

			$categories = array();
			foreach ( $this->harm_fields as $harm_key => $harm_name ) {

				$categories[] = array(
					'name' => $harm_name,
					'query' => "{$harm_key} = 'yes' AND ({$group['query']})",
				);
			}
			$series[] = array(
				'label' => $group['name'],
				'data' => $categories,
			);
		}

		$this->_generate_multi_query_count_report( $this->reports['related_harm']['age'], $series );
	}

	/**
	*	Alcohol-related harm - Harm experienced by gender
	*/
	public function data_related_harm_gender() {

		$series = array();
		foreach ( $this->genders as $gender_key => $gender_name ) {

			$categories = array();
			foreach ( $this->harm_fields as $harm_key => $harm_name ) {

				$categories[] = array(
					'name' => $harm_name,
					'query' => "{$harm_key} = 'yes' AND 01_gender = '{$gender_key}'",
				);
			}
			$series[] = array(
				'label' => $gender_name,
				'data' => $categories,
			);
		}

		$this->_generate_multi_query_count_report( $this->reports['related_harm']['gender'], $series );
	}

	/**
	 *	Feedback - How important is it to you that you reduce your drinking?
	 */
	public function data_feedback_important_reduce() {

		$categories = array();
		for ( $i = 1; $i <= 10; $i++ ) {

			$categories[$i] = $i;
		}
		$this->_generate_field_count_report( $this->reports['feedback']['important_reduce'], $categories, 'rating_important_reduce_drinking' );
	}

	/**
	 *	Feedback - How confident are you that you can reduce your drinking?
	 */
	public function data_feedback_confident_reduce() {

		$categories = array();
		for ( $i = 1; $i <= 10; $i++ ) {

			$categories[$i] = $i;
		}
		$this->_generate_field_count_report( $this->reports['feedback']['confident_reduce'], $categories, 'rating_confident_reduce_drinking' );
	}

	/**
	 *	Feedback - How important do you think it is that you talk to a health professional about your drinking?
	 */
	public function data_feedback_important_talk() {

		$categories = array();
		for ( $i = 1; $i <= 10; $i++ ) {

			$categories[$i] = $i;
		}
		$this->_generate_field_count_report( $this->reports['feedback']['important_talk'], $categories, 'rating_important_talk_professional' );
	}

	/**
	 *	Feedback - How ready are you to talk to a health professional?
	 */
	public function data_feedback_ready_talk() {

		$categories = array();
		for ( $i = 1; $i <= 10; $i++ ) {

			$categories[$i] = $i;
		}
		$this->_generate_field_count_report( $this->reports['feedback']['ready_talk'], $categories, 'rating_ready_talk_professional' );
	}

	/**
	*	Helper methods
	*/

	/**
	*	Renders a report where each category is a query used to return an average.
	*/
	private function _generate_query_average_report( $report, $categories ) {

		$conditions = array();
		$this->_apply_common_setup( $report, $conditions );

		$ticks = array();
		$values = array();

		foreach ( $categories as $category ) {

			$query = $conditions;
			$query[] = $category['conditions'];

			$value = $this->Entry->find( 'first', array(
				'fields' => $category['fields'],
				'conditions' => $query,
			) );

			$ticks[] = $category['name'];
			$mean_audit_score = $value[0]['mean_audit_score'];
			if ( empty( $mean_audit_score ) ) {

				$mean_audit_score = 0;
			}
			$values[] = $mean_audit_score;
		}
		unset( $category );

		$this->set( 'ticks', $ticks );
		$this->set( 'series', array( $values ) );
		$this->set( 'total', 0 );
		$this->render( 'report_data' );
	}

	/**
	*	Renders a report with multiple series, where each series is like a query count report.
	*/
	private function _generate_multi_query_count_report( $report, $series ) {

		$conditions = array();
		$this->_apply_common_setup( $report, $conditions );

		$results = array();
		$legends = array();
		foreach ( $series as $set ) {

			$legends[] = $set['label'];

			$result = array();
			foreach ( $set['data'] as $category ) {

				$query = $conditions;
				$query[] = $category['query'];

				$result[] = $this->Entry->find( 'count', array(
					'conditions' => $query,
				) );
			}
			$results[] = $result;
		}

		$ticks = array();
		foreach ( $series[0]['data'] as $category ) {

			$ticks[] = $category['name'];
		}

		$this->set( 'legends', $legends );
		$this->set( 'ticks', $ticks );
		$this->set( 'series', $results );
		$this->set( 'total', 0 ); // No totals for series
		$this->render( 'report_data' );
	}

	/**
	*	Renders a report where each category is a query used to return a count.
	*/
	private function _generate_query_count_report( $report, $categories, $hide_total = false ) {

		$conditions = array();
		$this->_apply_common_setup( $report, $conditions );

		$ticks = array();
		$values = array();
		$total = 0;

		foreach ( $categories as $category ) {

			$query = $conditions;
			$query[] = $category['query'];

			$value = $this->Entry->find( 'count', array(
				'conditions' => $query,
			) );

			$ticks[] = $category['name'];
			$values[] = $value;
			$total += $value;
		}
		unset( $category );

		// For some reports, total doesn't make sense to show.
		if ( $hide_total ) {

			$total = 0;
		}

		$this->set( 'ticks', $ticks );
		$this->set( 'series', array( $values ) );
		$this->set( 'total', $total );
		$this->render( 'report_data' );
	}

	/**
	*	Renders basic category data around a single field.
	*/
	private function _generate_field_count_report( $report, $categories, $entry_field ) {

		$conditions = array();
		$this->_apply_common_setup( $report, $conditions );
		$data = $this->Entry->find( 'all', array(
			'conditions' => $conditions,
			'fields' => array( 
				"{$entry_field} AS key",
				'COUNT(*) AS value',
			),
			'group' => array( $entry_field ),
		) );

		$ticks = array();
		$values = array();
		$total = 0;

		foreach ( $categories as $key => $name ) {

			$ticks[] = $name;
			$value = 0;

			foreach ( $data as $datum ) {

				// Cast key to string so null (not answered) isn't the same as 0
				if ( $datum['Entry']['key'] == (string)$key ) {

					$value = $datum[0]['value'];
					$total += $value;
					break;
				}
			}

			$values[] = $value;
		}
		$this->set( 'ticks', $ticks );
		$this->set( 'series', array( $values ) );
		$this->set( 'total', $total );
		$this->render( 'report_data' );
	}

	/**
	*	Does the common set-up logic for each report.
	*/
	private function _apply_common_setup( $report, &$conditions ) {

		$this->_apply_common_conditions( $conditions );

		$report_title = $report['title'];

		// From
		if ( !empty( $_GET['from'] ) ) {

			$report_title .= ' from ' . date( TEXT_DATE, strtotime( $_GET['from'] ) );
		}
		// To
		if ( !empty( $_GET['to'] ) ) {

			$report_title .= ' to ' . date( TEXT_DATE, strtotime( $_GET['to'] ) );
		}

		// Populate page title and axis
		if ( !empty( $_GET['from'] ) || !empty( $_GET['to'] ) ) {

			$report_title .= ' (inclusive)';	
		}
		$this->set( 'report_title', $report_title );
		$this->set( 'xaxis', $report['xaxis'] );
		$this->set( 'yaxis', $report['yaxis'] );
	}

	/**
	*	Provides conditions to filter for date, partner and completed survey state.
	*/
	private function _apply_common_conditions( &$conditions = array() ) {

		// From
		if ( !empty( $_GET['from'] ) ) {

			$conditions['Entry.completed >='] = $_GET['from'];
			$this->Session->write( 'report.from', $_GET['from'] );
		}
		else {
			// Clear (not delete) session value
			$this->Session->write( 'report.from', '' );
		}

		// To
		if ( !empty( $_GET['to'] ) ) {

			// Because to is inclusive, add a day to the actual query
			$conditions['Entry.completed <='] = date( MYSQL_DATE, strtotime( $_GET['to'] ) + DAY );
			$this->Session->write( 'report.to', $_GET['to'] );
		}
		else {
			// Clear (not delete) session value
			$this->Session->write( 'report.to', '' );
		}

		// Partner
		$conditions['Entry.partner_id'] = $this->current_user['Partner']['id'];

		// State
		$conditions['Entry.completed !='] = 'NULL';

		// Exclude tests
		$conditions['Entry.is_test'] = '0';
	}
	
	/**
	*	Callbacks
	*/
	
	/**
	*	Called before each action.
	*/
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		// Nothing is public.
		$this->Auth->deny();

		// Admin cannot access reports.
		$this->restrict_to_user();
	}
}

?>
