<?php
	include_once('commons/header.php');

	$variables = array(
		'section_number' => '01',
		'intro' => array('As a result of drinking alcohol, have you experienced the following <strong>over the past 30 days</strong>:'),
		'image_name' => 'vessels',
		'image_desc' => 'Drinking Vessel',
		'columns' => array(
			'yes' => 'Yes',
			'no' => 'No',
			'skip' => 'I choose not to answer',
		),
		'rows' => get_tabular_rows(5),
	);
?>

<body>
<div class="overlay"></div>
<div class="colours"></div>
<div class="bgimage internal"></div>

<section id="container">

	<div class="survey wrap">

		<div class="logo">
			<a href="./" title="THRIVE Student Health Online">
				<img src="<?php echo BASE_URL; ?>images/logo.png" class="hide-mob-lnd-prt" alt="THRIVE Alcohol Survey" />
				<img src="<?php echo BASE_URL; ?>images/logo-mobile.png" class="mob-lnd-prt" alt="THRIVE Alcohol Survey" />
			</a>
		</div>

		<p class="title"><strong>Alcohol Survey</strong></p>

		<div class="content">

			<section class="progress step-five">

				<div class="line"></div>

				<div class="line current-pos"></div>

				<div class="step hi"><i class="icn"></i></div>

				<div class="step s-one"><i class="icn"></i></div>

				<div class="step s-two"><i class="icn s2"></i></div>

				<div class="step s-three"><i class="icn s3"></i></div>

				<div class="step s-four"><i class="icn s4"></i><span>Effects of Drinking</span><i class="icn arrow"></i></div>

				<div class="step s-five"><i class="icn s5"></i></div>

			</section><!-- progress -->

			<section class="intro">

				<h1>Effects of Drinking</h1>

				<p>These questions relate to your experiences when drinking. <br/>Remember your responses are anonymous.</p>
				<?php
					/*
					<p>These questions now relate to other students. <br />Remember your responses are confidential.</p>
					*/
				?>

			</section><!-- intro -->

			<section class="questions">

				<form class="stage-form optional" method="post" action="survey.php?t=<?php echo h( urlencode( ifne( $page_meta, 'token' ) ) ); ?>">

					<input type="hidden" name="survey-stage" value="4" />

					<fieldset title="Please fill in the fields below">

						<legend>Please fill in the details of your alcohol usage below.</legend>

						<?php include 'commons/tabular.php'; ?>

						<div class="field submit">
							<p class="incomplete"><i class="icn cross"></i> Please answer all questions</p>
							<p class="complete" style="display: none;"><i class="icn tick"></i> All questions have been answered</p>

							<button type="submit">Next section</button>
						</div>

					</fieldset>

				</form>

			</section><!-- questions -->

		</div><!-- content -->

	</div><!-- survey wrap -->

	<div class="push"></div>

</section><!-- container -->

<?php  include_once( 'commons/footer.php' ) ?>
