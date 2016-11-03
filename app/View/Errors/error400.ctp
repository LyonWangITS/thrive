<?php
//
// There's no controller behind this view currently.

$this->layout = 'static';
$this->set( 'title_for_layout', '404 Partner not found' );

$this->Partner = ClassRegistry::init( 'Partner' );
$partners = $this->Partner->find( 'all', array(
	'conditions' => array(
		'Partner.lu_partner_state_id' => LU_PARTNER_STATE_APPROVED,
	),
	'order' => array( 'Partner.name' => 'asc' ),
) );

?>

<h1>404 - Partner not found</h1>

<p>Sorry, this URL does not match an organisation participating in THRIVE.</p>

<p>Please click on your university or polytech's name, below. If it is not listed but you would like to know more about how you can support your friends to cut down on their drinking and stay safe when doing so check out the <a href="http://alcoholthinkagain.com.au/Home.aspx">Alcohol Think Again website</a>.</p>

<ul>
	<?php
	foreach ( $partners as $partner ) {

		echo "<li><a href=\"/{$partner['Partner']['slug']}\">{$partner['Partner']['name']}</a></li>";
	}
	?>
</ul>

