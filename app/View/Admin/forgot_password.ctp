<?php
$this->set( 'title_for_layout', 'Forgot password' );
$this->Html->meta( 'description', 'Thrive - Your Health Online. Alcohol Survey', array( 'inline' => false ) );
$this->Html->meta( 'keywords', 'Alcohol Survey, University, Tertiary, Polytechnic.', array( 'inline' => false ) );
?>

<p class="breadcrumb">
	<a href="<?php echo $this->webroot; ?>admin/login">Login</a> /
	<strong>Forgot Password</strong>
</p>

<div id="content">
	
	<h1>Forgot password</h1>
	
	<div class="content-padding login forgot-password">

		<?php echo $this->Session->flash(); ?>
		<p>Enter the email address associated with your account and we will email you instructions to reset your password.</p>
		
		<?php
		echo $this->Form->create( 'Account' );
		echo $this->Form->input( 'Account.email', array( 'label' => 'Email address <span class="required">*</span>' ) );
		?>
		<div class="row full">
			<input type="submit" value="Submit" class="submit">
		</div>
		<?php
		echo $this->Form->end();
		?>
		
		<div class="link-wrap">
			<p><a href="<?php echo $this->webroot; ?>admin/login">Return to Login</a></p>
		</div>
		
	</div>

</div>
