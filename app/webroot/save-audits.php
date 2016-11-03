<?php

require_once( 'app/config.php' );
require_once( 'app/db.php' );
require_once( 'app/helpers.php' );
require_once( 'app/Survey.class.php' );

//
// Find and fix each record
$sql = "SELECT *
	FROM entries 
	WHERE entries.audit_score IS NULL
	AND entries.completed IS NOT NULL
";

try {

	$db = getConnection();
	$stmt = $db->prepare( $sql );
	$stmt->execute();
	
	while ( $result = $stmt->fetch( PDO::FETCH_ASSOC ) ) {

		$survey = new Survey();
		$survey->id = $result['id'];
		$survey->data = $result;
		$survey->save( array(
			'audit_score' => $survey->calculateAuditScore(),
		) );
	}
	
} catch( PDOException $e ){
	
	echo $e->getMessage();
	die;
}
?>
<h1>Done!</h1>
<p>We have calculated and saved the audit scores for existing survey responses.</p>
<p>You may now delete this file: <em><?php echo __FILE__; ?></em></p>
