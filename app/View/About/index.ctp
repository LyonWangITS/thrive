<?php
$this->set( 'title_for_layout', 'About THRIVE Alcohol Survey' );
?>

<div class="landing-page">

	<header class="clearfix">
	
		<a class="logo" href="<?php echo $this->webroot; ?>" title="Thrive. Your health online.">
			<img src="images/admin-logo.png" alt="Thrive. Your Health Online" />
		</a>
		
		<a class="btn d-purple bold" href="<?php echo $this->webroot; ?>admin/login/">Login</a>
		
	</header>
	
	<div class="content clearfix">
	
		<div class="main-content left">

			<h1>About</h1>
			
			<p>If you are a researcher, health service provider or manager/executive and would like to offer THRIVE for your students and/or staff for free, please see the <a href="<?php echo $this->webroot; ?>admin/register">registration page</a>.</p>
		
		</div>
		
		<div class="registration-cta right">
		
			<p class="heading">Don't have an account?</p>
			
			<div class="text">
			
				<a class="btn green-btn lg" href="<?php echo $this->webroot; ?>admin/register">Start registration</a>
				
			</div>
			
		</div>
		
	</div>

</div>
