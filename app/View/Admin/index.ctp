<?php
$this->set( 'title_for_layout', 'Dashboard' );
$this->Html->meta( 'description', 'Thrive - Your Health Online. Alcohol Survey', array( 'inline' => false ) );
$this->Html->meta( 'keywords', 'Alcohol Survey, University, Tertiary, Polytechnic.', array( 'inline' => false ) );
?>

<div id="content">

<?php
if ( !empty( $current_user['Account']['is_admin'] ) ) {

	?>
	<h1>Dashboard</h1>

	<div class="content-padding admin">

	<p>
		<strong><?php echo $unapproved_count; ?></strong> unapproved partner<?php if ( $unapproved_count !== 1 ) {echo 's';} ?>.<br />
		<strong><?php echo $approved_count; ?></strong> approved partner<?php if ( $approved_count !== 1 ) {echo 's';} ?>.<br />
		<strong><?php echo $change_count; ?></strong> pending change<?php if ( $change_count !== 1 ) {echo 's';} ?> to review.<br />
	</p>

	<?php
}
else {

	echo "<h1>{$current_user['Partner']['name']} Dashboard</h1>";

	echo'<div class="content-padding admin">';

	if ( $current_user['Partner']['lu_partner_state_id'] == LU_PARTNER_STATE_UNAPPROVED ) {
		?>
		<p>Your organisation has not yet been approved. Once approved, the URL for accessing your organisation's survey will be:<br />
			<a href="<?php echo $this->webroot; p( $current_user['Partner']['slug'] ); ?>">http://<?php echo HOST; ?>/thrive/<?php p( $current_user['Partner']['slug'] ); ?></a>
		</p>
		<?php
	}
	else if ( $current_user['Partner']['lu_partner_state_id'] == LU_PARTNER_STATE_APPROVED ) {
		?>
		<p>The URL for accessing your organisation's survey is:<br />
			<a href="<?php echo $this->webroot; p( $current_user['Partner']['slug'] ); ?>">http://<?php echo HOST; ?>/thrive/<?php p( $current_user['Partner']['slug'] ); ?></a>
		</p>
		<?php
	}
}
?>
	</div>

</div>
