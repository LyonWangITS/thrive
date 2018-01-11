<?php
$this->set( 'title_for_layout', 'Login' );
$this->Html->meta( 'description', 'Thrive - Your Health Online. Alcohol Survey', array( 'inline' => false ) );
$this->Html->meta( 'keywords', 'Alcohol Survey, University', array( 'inline' => false ) );
?>

<p class="breadcrumb">
	<strong>Login</strong>
</p> 

<div id="content">

<h1>Login</h1>

	<div class="content-padding login">
	
		<?php echo $this->Session->flash(); ?>
		
		<?php 
		echo $this->Form->create( 'Account' );
		echo $this->Form->input( 'email', array( 'label' => 'Email <span class="required">*</span>' ) );
		echo $this->Form->input( 'password', array( 'label' => 'Password <span class="required">*</span>' ) );
		echo $this->Form->end( 'Login' );
		?>
		
		<div class="link-wrap">
			<p class="left"><a href="mailto:edgelab@hhp.ufl.edu">Forgotten password?</a></p>
		</div>
	
	</div>
	
</div>
