<?php
$this->set( 'title_for_layout', "Register" );
$this->Html->meta( 'description', 'Thrive - Your Health Online. Alcohol Survey', array( 'inline' => false ) );
$this->Html->meta( 'keywords', 'Alcohol Survey, University, Tertiary, Polytechnic.', array( 'inline' => false ) );
?>

<p class="breadcrumb">
	<a href="<?php echo $this->webroot; ?>admin/login">Login</a> /
	<strong>Register</strong>
</p>

<div id="content" class="reg-form">
	
	<h1>THRIVE Registration</h1>
	
	<div class="content-padding">
	
		<p>THRIVE is a freely available online alcohol intervention developed and hosted by Curtin University. Find out more <a href="http://wachpr.curtin.edu.au/thrive/">about THRIVE</a>.</p>
	
		<p>If you would like to create a THRIVE account for your organisation please fill out the details below. Before you proceed please ensure that you are familiar with the <a href="<?php echo $this->webroot; ?>about/terms" title="Read the terms of use for THRIVE.">THRIVE terms of use</a>.</p>
		
	</div> 
	
	<?php echo $this->element( 'partner-form' ); ?>
	
</div>

