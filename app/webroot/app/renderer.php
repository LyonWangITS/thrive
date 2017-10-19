<?php
/*

	View Rendering Functions
	- Wrap stage renderer within a function so we can protect the scope of the global vars in caller

*/
function renderStage( $target_stage, $page_vars ){
	$page_meta = $page_vars;

	// White-label
	$partner = Partner::getCurrentPartner();

	if ($target_stage === 'thanks'){
		include_once 'stages/stage-thanks.php';
	}
	elseif ($target_stage === 0) {
		include_once 'stages/stage-00.php';
	}
	else {
		include_once 'stages/commons/stage.php';
	}
}

