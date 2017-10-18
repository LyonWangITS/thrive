<?php
$this->Html->meta( 'description', '', array( 'inline' => false ) );
$this->Html->meta( 'keywords', '', array( 'inline' => false ) );


if ( empty( $partner ) ) {

	$this->set( 'title_for_layout', "Add partner" );
	?>
	
	<p class="breadcrumb">
		<a href="<?php echo $this->webroot; ?>portal">Dashboard</a> /
		<a href="<?php echo $this->webroot; ?>partners/view">Partners</a> /
		<strong>Add partner</strong>
	</p>
	<div id="content" class="reg-form">
	<h1>Add partner</h1>
	<?php
}
else {

	$this->set( 'title_for_layout', htmlentities( "Edit partner '{$partner['Partner']['name']}'" ) );
	?>
	<p class="breadcrumb">
		<a href="<?php echo $this->webroot; ?>portal">Dashboard</a> /
		<a href="<?php echo $this->webroot; ?>partners/view">Partners</a> /
		<strong><?php p( $partner['Partner']['name'] ); ?></strong>
	</p>
	<div id="content" class="reg-form">
	<h1>Edit partner '<?php p( $partner['Partner']['name'] ); ?>'</h1>
	<?php
}


echo $this->element( 'partner-form' );
?>

<?php
if ( isset( $this->request->query['return'] ) ) {
	?>
	<a class="btn d-purple sm" href="<?php p( $this->request->query['return'] ); ?>">Back</a>
	<?php
}
else {
	?>
	<a class="btn d-purple sm" href="<?php echo $this->webroot; ?>partners/view">Back</a>
<?php
}
?>

</div>
