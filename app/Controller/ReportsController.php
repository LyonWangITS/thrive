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

	public $race = array(
		'native-american' => 'American Indian or Alaskan Native',
		'asian' => 'Asian',
		'hawaiian' => 'Native Hawaiian or Other Pacific Islander',
		'black' => 'Black or African American',
		'white' => 'White/Caucasian',
		'mixed-race' => 'Mixed Race',
		'other' => 'Other',
		'skip' => 'I Choose Not to Answer',
	);

	public $ethnicity = array(
		'hispanic-latino' => 'Hispanic or Latino(a)',
		'not-hispanic-latino' => 'Not Hispanic or Latino(a)',
		'skip' => 'I Choose Not to Answer',
	);

	public $habitation_type = array(
		'dorm' => 'Dorm',
		'with-parents' => 'Apartment or house with parents or other relatives',
		'with-roommates' => 'Apartment or house with friends or roommates',
	);

	public $history = array(
		'uf-only' => 'I have attended only UF',
		'transfered' => 'I transferred from another college/university',
	);

	public $tobacco_use = array(
		'never' => 'Never smoked cigarettes at all, or never smoked them regularly',
		'used_to_smoke_regularly' => 'Do not smoke now but used to smoke regularly (once or more per day)',
		'occasionally' => 'Occasionally smoke (on average, less than one per day)',
		'regularly' => 'Currently smoke cigarettes regularly (more than one per day)',
	);

	public $tobacco_init = array(
		'0' => 'I do not smoke on a daily basis',
		'5' => 'Within 5 minutes',
		'30' => '5-30 minutes',
		'60' => '31-60 minutes',
		'61' => 'More than 60 minutes',
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
			'Race',
			'Ethnicity',
			'Habitation type',
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

		$feedback_questions = array();
		if ( !empty( $this->current_user['Partner']['is_feedback_enabled'] ) ) {
			$headers[] = 'Feedback - How important is it to you that you reduce your drinking? 1 (Not at all important) - 10 (Very important)';
			$headers[] = 'Feedback - How confident are you that you can reduce your drinking? 1 (Not at all confident) - 10 (Very confident)';
			$headers[] = 'Feedback - How important do you think it is that you talk to a health professional (like a doctor or counsellor) about your drinking? 1 (Not at all important) - 10 (Very important)';
			$headers[] = 'Feedback - How ready are you to talk to a health professional? 1 (Not at all ready) - 10 (Very ready)';

			$feedback_questions = array(
				'rating_important_reduce_drinking',
				'rating_confident_reduce_drinking',
				'rating_important_talk_professional',
				'rating_ready_talk_professional',
			);
		}

		fputcsv( $fp, $headers );

		$days = array_keys($days);
		foreach ( $data as $entry ) {

			$row = array(
				$entry['Entry']['id'],
				$entry['Entry']['completed'],
				$entry['Entry']['00_participant_name'],
				( !empty( $entry['Entry']['01_gender'] ) ) ? $this->genders[$entry['Entry']['01_gender']] : '',
				$entry['Entry']['01_age'],
				( !empty( $entry['Entry']['01_race'] ) ) ? $this->race[$entry['Entry']['01_race']] : '',
				( !empty( $entry['Entry']['01_ethnicity'] ) ) ? $this->ethnicity[$entry['Entry']['01_ethnicity']] : '',
				( !empty( $entry['Entry']['01_where'] ) ) ? $this->habitation_type[$entry['Entry']['01_where']] : '',
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
				if ($step == 7) {
					$stage['tabular']['columns']['1'] = '1';
					$stage['tabular']['columns']['7'] = '7';
				}

				$prefix = '0' . $step . '_';

				foreach (array_keys($stage['tabular']['rows']) as $field) {
					$field = $prefix . $field;
					$row[] = is_null($entry['Entry'][$field]) ? '' : str_replace(array_keys($stage['tabular']['columns']), $stage['tabular']['columns'], $entry['Entry'][$field]);
				}
			}

			$row[] = !empty($entry['Entry']['08_tobacco_use']) ? $this->tobacco_use[$entry['Entry']['08_tobacco_use']] : '';
			$row[] = $entry['Entry']['08_tobacco_frequency'];
			$row[] = !empty($entry['Entry']['08_tobacco_init']) ? $this->tobacco_init[$entry['Entry']['08_tobacco_init']] : '';
			$row[] = $entry['Entry']['audit_score'];

			foreach ($feedback_questions as $question) {
				$row[] = $entry['Entry'][$question];
			}

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
