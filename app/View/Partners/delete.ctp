<?php
$this->set( 'title_for_layout', htmlentities( "Delete partner '{$partner['Partner']['name']}'" ) );
$this->Html->meta( 'description', '', array( 'inline' => false ) );
$this->Html->meta( 'keywords', '', array( 'inline' => false ) );
?>

<p class="breadcrumb">
	<a href="<?php echo $this->webroot; ?>admin">Dashboard</a> /
	<a href="<?php echo $this->webroot; ?>partners/view">Partners</a> /
	<strong>Delete</strong>
</p>
<h1>Delete partner '<?php p( $partner['Partner']['name'] ); ?>'</h1>

<form method="post">
	<p>Please confirm you wish to delete this partner. Past survey responses will remain in the database for reporting.</p>
	<div class="submit">
		<?php
		echo $this->Form->hidden( 'delete' );
		?>
		<input type="submit" value="Delete" />
	</div>
	<br />
</form>

<?php
if ( isset( $this->request->query['return'] ) ) {
	?>
	<p><a href="<?php p( $this->request->query['return'] ); ?>">Back</a></p>
	<?php
}
else {
	?>
	<p><a href="<?php echo $this->webroot; ?>partners/view">Back</a></p>
	<?php
}
?>
