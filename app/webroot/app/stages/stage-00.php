<? include_once( 'commons/header.php' ) ?>

<body>
<div class="overlay"></div>
<div class="colours"></div>
<div class="bgimage"></div>

<section id="container">
	
	<div class="start wrap">
	
		<div class="logo">
			<a href="./" title="THRIVE Student Health Online">
				<img src="<?php echo BASE_URL; ?>images/logo.png" alt="THRIVE Alcohol Survey" />
			</a>
		</div>
		
		<h1>Welcome to the Alcohol Survey</h1>
		<p>This survey will ask questions about your alcohol use and provide you personalised feedback on your drinking. It will take approximately 5 to 10 minute to complete.</p>
		
		<?php
		/*
		if ( !empty( $partner->data['welcome_text'] ) ) {

			echo $partner->data['welcome_text'];
		}
		*/
		?>
		
		<p>In order for us to personalise this survey for you, please enter a name in the box below.</p>
		
		<form method="post" class="stage-form">
			
			<input type="hidden" name="survey-stage" value="0" />
					
			<p>(It doesn't have to be your real name!)</p>

			<fieldset title="Please fill in these fields">
				<legend>Please enter your name to continue</legend>
			
				<div class="field">
					<label for="name">Your name</label>
					<input type="text" id="name" name="participant_name" />
				</div>

				<button type="submit">Let's go! <i class="icn white-arrow"></i></button>		

			</fieldset>
			
			<fieldset class="researcher">
				<legend>Please indicate whether you are a researcher or health administrator.</legend>

				<input type="checkbox" name="is_test" id="is_test" value="1" />
				<label for="is_test">Select this box if you are a researcher or health service administrator reviewing THRIVE for use in your own organisation.</label>
			
			</fieldset>
		
		</form>
	
	</div><!-- start -->
	
	<div class="push"></div>
	
</section><!-- container -->

<? include_once( 'commons/footer.php' ) ?>