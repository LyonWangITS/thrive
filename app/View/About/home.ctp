<?php
$this->set( 'title_for_layout', 'THRIVE Alcohol Survey' );
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
		
			<h1>Welcome to the homepage for the THRIVE Alcohol Survey</h1>
		
			<p>If you would like to participate in the survey, please click on your university or polytech's name, below.</p>
			
			<p><small><a href="<?php echo $this->webroot; ?>about">More information about THRIVE</a></small></p>

		</div>
		
		<div class="partners right">
		
			<ul>
				<li class="heading"><i class="icn pin-tack"></i>Our Partners</li>
				<?php
				foreach ( $partners as $partner ) {
			
					echo "<li><a href=\"" . $this->webroot . "{$partner['Partner']['slug']}\">{$partner['Partner']['name']} <i class=\"icn right-arrow\"></i></a></li>";
				}
				?>
			</ul>
		
		</div>

	</div>

</div><!-- home -->
