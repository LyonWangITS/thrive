<?php
/**
*	This is the partner form, which gets used in several places.
*/

//pr( $this->validationErrors );

if ( $is_pending ) {

	echo '<div class="content-padding">';

	echo '<p><strong>The form below includes pending changes that have not been reviewed. <a href="' . $this->here . '?skip_pending=1">View last approved</a>.</strong></p>';
	if ( !empty( $current_user ) && !empty( $current_user['Account']['is_admin'] ) ) {

		echo '<p>To approve the pending changes, simply save the form now.</p>';
	}
	echo '</div>';
}
else if ( $has_pending ) {

	echo '<div class="content-padding">';

	echo '<p><strong>You are viewing the last approved form below but there are pending changes. <a href="' . $this->here . '">Click to view</a>.</strong>';
	if ( !empty( $current_user ) && !empty( $current_user['Account']['is_admin'] ) ) {

		echo '<p>To discard the pending changes, simply save the form now.</p>';
	}
	
	echo '</div>';
}

echo $this->Form->create( 'Partner', array( 'type' => 'file', 'action' => null ) );
echo '<h2 class="first">Contact and organisation details <span>Your basic details</span></h2>';
echo '<div class="content-padding">';
echo $this->Form->input( 'Account.name', array( 'label' => 'Your name <span class="required">*</span>' ) );
echo $this->Form->input( 'Account.role_id', array( 'label' => 'Your role <span class="required">*</span>', 'options' => $role_options, 'empty' => true ) );
echo $this->Form->input( 'Account.phone', array( 'label' => 'Contact phone number <span class="required">*</span>' ) );
echo $this->Form->input( 'Partner.name', array( 'label' => 'Organisation <span class="required">*</span>' ) );

// Admin only
if ( !empty( $current_user['Account']['is_admin'] ) ) {
	
	echo $this->Form->input( 'Partner.slug', array( 'label' => 'Directory <span class="required">*</span>', 'after' => '<p>This sets the public URL for this partner. E.g. \'<em>example</em>\' would mean participants go to <em>http://thrivehealth.org.au/example</em>.</p>' ) );
}

echo $this->Form->input( 'Partner.website', array( 'label' => 'Website' ) );
echo '</div>';


echo '<h2>Personalise THRIVE <span>Organisation settings</span></h2>';
echo '<div class="content-padding clearfix">';
	echo '<div class="left">';
		echo '<h3>Current Logo</h3>';
		echo '<p class="small">In order for us to personalise the THRIVE website for your organisation please upload a high resolution organisational logo. Please ensure that you have organisational approval. The logo will appear in the bottom right corner of the THRIVE website.</p>';

		// Logo
		echo '<div class="logo_wrapper">';

		if ( !empty( $partner['Partner']['logo_path'] ) ) {

			echo '<img src="' . $this->WebImage->resize( $partner['Partner']['logo_path'], 200, null, 'min' ) . '?y=' . time() . '" width="200" alt="" />';
		}
		echo $this->Form->input( 'Partner.file', array( 'type' => 'file', 'label' => 'Logo file', 'after' => '<p class="small">(JPG, PNG and GIF formats accepted.)</p>' ) );
		echo '</div>';
		$no_logo = ( !empty( $partner ) && empty( $partner['Partner']['logo_path'] ) );
		echo $this->Form->input( 'Partner.no_logo', array( 'type' => 'checkbox', 'label' => 'Tick this box if you do not want to include your organisation\'s logo on the website.', 'default' => $no_logo ) );

		if ( $has_pending && !$is_pending ) {

			echo $this->Form->hidden( 'keep_old_logo', array( 'value' => 1 ) );
		}

	echo '</div>';

	echo '<div class="right">';

		echo $this->Form->input( 'Partner.is_staff_student', array( 'type' => 'checkbox', 'label' => 'Allow staff members to take the survey as well as students. Otherwise it is assumed all participants are students.' ) );

		// Content
		echo $this->Form->input( 'Partner.confidentiality_text', array(
			'label' => 'Confidentiality text',
			'after' => "<p class=\"small\">Please provide content for the 'About Confidentiality' pop-up that appears on the first page of the survey.</p>",
			'default' => '',
		) );

	echo '</div>';
echo '</div>';
?>

<h2>Optional survey questions<span>Enable additional demographic and feedback questions</span></h2>
<div class="content-padding clearfix" id="optional-questions">

	<h3>Feedback</h3>
	<p>You can enable a set of feedback questions displayed on the result screen of the survey. Answers are optional and given as a star rating from 0 to 10 for each question.</p>
	<?php
	echo $this->Form->input( 'Partner.is_feedback_enabled', array(
		'type' => 'checkbox',
		'label' => '<strong>Enable feedback questions</strong> <span class="extra">How important is it to you that you reduce your drinking? <br />How confident are you that you can reduce your drinking? <br />How important do you think it is that you talk to a health professional (like a doctor or counsellor) about your drinking)? <br />How ready are you to talk to a health professional?</span>'
	) );
	?>

</div>

<?php
echo '<h2>Account details <span>Your account log-in information</span></h2>';
echo '<div class="content-padding">';

// For new partners
echo $this->Form->input( 'Account.email', array( 'label' => 'Your email <span class="required">*</span>', 'after' => '<p class="small">This will also be used to log in should you wish to update details later.</p>' ) );
if ( empty( $partner ) ) {

	echo $this->Form->input( 'Account.password', array( 'label' => 'Password <span class="required">*</span>' ) ); 
	echo $this->Form->input( 'Account.retype_password', array( 'type' => 'password', 'label' => 'Confirm password <span class="required">*</span>' ) ); 
}
// If not admin
else if ( empty( $current_user['Account']['is_admin'] ) ) {

	echo '<h3>Change password</h3>';
	echo '<p>You can <a href="' . $this->webroot . 'admin/change_password">change your password here</a>.</p>';
}

echo '</div>';

// Admin only
if ( !empty( $current_user['Account']['is_admin'] ) ) {

	echo '<h2>Administration <span>Admin only</span></h2>';
	echo '<div class="content-padding clearfix">';
	echo $this->Form->input( 'Partner.lu_partner_state_id', array( 'label' => 'Status <span class="required">*</span>', 'options' => $status_options, 'empty' => false ) );
	echo '</div>';
}


echo '<h2>Support services <span>Local support services you offer</span></h2>';
echo '<div class="content-padding">';
echo '<p>Please enter the details of any local support services that you would like THRIVE to refer your participants to. These may include on-site health services, specialist alcohol and other drug (AOD) services and/or AOD information and counselling phonelines. Please ensure that these services are aware that you will be referring participants to them and you may need to consider their service capacity.</p>';

// Services
$count = 0;
if ( !empty( $this->data['Service'] ) ) {

	$count = max( $count, count( $this->data['Service'] ) );
}
$hidden_class = 'hidden';
echo '<div id="services">';
for ( $i = -1; $i < $count; $i++ ) {

	echo "<div class=\"service {$hidden_class}\">";
	echo '<h3>Support service <span class="number">' . ( $i + 1 ). '</span></h3>';
	echo $this->Form->hidden( "Service.{$i}.id" );
	echo $this->Form->input( "Service.{$i}.name", array( 'label' => 'Service name <span class="required">*</span>' ) );
	echo $this->Form->input( "Service.{$i}.contact_numbers", array( 'label' => 'Contact number(s)', 'rows' => 3 ) );
	echo $this->Form->input( "Service.{$i}.address", array( 'label' => 'Address', 'rows' => 3 ) );
	echo $this->Form->input( "Service.{$i}.opening_hours", array( 'label' => 'Opening hours', 'rows' => 3 ) );
	echo $this->Form->input( "Service.{$i}.fees", array( 'label' => 'Fees' ) );
	echo $this->Form->input( "Service.{$i}.website", array( 'label' => 'Website' ) );
	echo $this->Form->input( "Service.{$i}.additional_info", array( 'label' => 'Additional information', 'rows' => 3 ) );
	echo ' <a class="delete-service btn d-purple sm" href="#"><i class="icn trash"></i> Delete</a>';
	echo '</div>';
	$hidden_class = '';
}
echo '</div>';
echo '<a id="add-service" href="#"><i class="icn plus"></i> Add service</a>';

// For new partners and not admin
if ( empty( $partner ) && empty( $current_user['Account']['is_admin'] ) ) {
	echo '<div class="terms">';
	echo $this->Form->input( 'Account.read_terms', array( 'type' => 'checkbox', 'label' => 'I agree to the THRIVE <a href="' . $this->webroot . 'about/terms" target="_blank">Terms of Use</a>. <span class="required">*</span>' ) );
	echo '</div>';
}
echo '</div>';
echo $this->Form->end( 'Submit' );



?>

<script type="text/javascript">

//
// Add/delete services
$( '#services div.service.hidden input, #services div.service.hidden textarea' ).attr( 'disabled', 'disabled' );

function delete_service() {

	if ( !confirm( 'Really delete this service?' ) ) {
	
		return false;
	}
	$( this ).closest( 'div' ).remove();
	return false;
}
$( '.delete-service' ).click( delete_service );

var next_row_id = <?php echo $count; ?>;

$( '#add-service' ).click( function() {

	var wrapper = $( '#services div.service.hidden' ).clone();
	wrapper.html( wrapper.html().replace( /-1/g, next_row_id ) );
	
	$( '#services' ).append( wrapper );
	$( '#services div.service.hidden h3 span.number' ).last().html( next_row_id + 1 );
	$( '#services div.service.hidden' ).last().find( 'input, textarea' ).removeAttr( 'disabled' );
	$( '#services div.service.hidden' ).last().removeClass( 'hidden' );
	$( '.delete-service' ).unbind( 'click' ).click( delete_service );

	next_row_id++;
	return false;
} );

//
// Toggle display of logo fields
function toggle_logo_wrapper() {

	if ( $( '#PartnerNoLogo' ).is( ':checked' ) ) {

		$( '.logo_wrapper' ).hide();
	}
	else {

		$( '.logo_wrapper' ).show();
	}
}
$( '#PartnerNoLogo' ).change( toggle_logo_wrapper );
toggle_logo_wrapper();

</script>
