<?php

/**
*	Stores pending changes to a partner.
*/
class PendingChange extends AppModel {

	public $actsAs = array(
		'Upload' => array(
			'is_required' => false,
			'save_directory' => '/images/pending/',
			'save_field' => 'logo_path',
			'allowed_extensions' => array( 'jpg', 'jpeg', 'png', 'gif' ),
		),
	);

	public $belongsTo = array(
		'Partner',
	);
}
