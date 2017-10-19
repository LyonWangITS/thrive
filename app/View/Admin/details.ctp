<?php
$this->set( 'title_for_layout', "My account" );
$this->Html->meta( 'description', 'Thrive - Your Health Online. Alcohol Survey', array( 'inline' => false ) );
$this->Html->meta( 'keywords', 'Alcohol Survey, University, Tertiary, Polytechnic.', array( 'inline' => false ) );
?>
<p class="breadcrumb">
	<a href="<?php echo $this->webroot; ?>portal">Dashboard</a> /
	<strong>My account</strong>
</p>

<div id="content" class="reg-form">

	<h1>My account</h1>

	<?php echo $this->element( 'partner-form' ); ?>

</div>
