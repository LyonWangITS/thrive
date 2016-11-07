<?php include_once( 'commons/header.php' ) ?>

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

			<section class="progress step-three">

				<div class="line"></div>

				<div class="line current-pos"></div>

				<div class="step hi"><i class="icn"></i></div>

				<div class="step s-one"><i class="icn"></i></div>

				<div class="step s-two"><i class="icn s2"></i></div>

				<div class="step s-three"><i class="icn s3"></i><span>In the last four weeks</span><i class="icn arrow"></i></div>

				<div class="step s-four"><i class="icn s4"></i></div>

				<div class="step s-five"><i class="icn s5"></i></div>

			</section><!-- progress -->

			<section class="intro">

				<h1>Recent Drinking</h1>

				<p>Now we'd like to ask you about your drinking in the last four weeks only.<br /> We understand that this might be difficult to remember exactly so<br />for these questions please give your best estimate.</p>

			</section><!-- intro -->

			<?php  include_once( 'commons/drinks-guide.php' ) ?>

			<section class="questions">

				<form class="stage-form" method="post" action="survey.php?t=<?= h( urlencode( ifne( $page_meta, 'token' ) ) ) ?>">

					<input type="hidden" name="survey-stage" value="3" />

					<fieldset title="Please fill in the fields below">

						<legend>Please fill in the details about your drinking habits below:</legend>

						<div class="field radio-set radio-set-right clearfix">

							<i class="icn number">01</i>

							<p>Have you consumed alcohol in the last four weeks?</p>

							<div class="input-wrap">
								<input type="radio" name="past_4wk_consumed_alcohol" id="consumed-yes" value="yes">
								<label for="consumed-yes">Yes</label>
								<input type="radio" name="past_4wk_consumed_alcohol" id="consumed-no" value="no">
								<label for="consumed-no">No</label>
							</div>

						</div><!-- field -->

						<div id="more-fields-wrapper">

							<div class="field slider clearfix">

								<i class="icn number">02</i>

								<p>In the last four weeks what is the largest number of standard drinks you have consumed on a single occasion?</p>

								<div class="slider-wrapper">
									<div id="standard-drinks-slider" class="slider dragdealer">
										<div class="red-bar handle">drag me</div>
										<div class="selected-area"></div>
										<div class="tooltip">1 drinks</div>
										<div class="left-value slider-value">1</div>
										<div class="right-value slider-value">32+</div>
									</div>
								</div>

								<input type="hidden" name="past_4wk_largest_number_single_occasion" value="1" />

							</div><!-- field -->

							<div class="field slider hours clearfix">

								<i class="icn number">03</i>

								<p>Over how many hours did you drink this amount (to the nearest hour)?</p>

								<div class="slider-wrapper">
									<div id="drinking-hours-slider" class="slider dragdealer">
										<div class="red-bar handle">drag me</div>
										<div class="selected-area"></div>
										<div class="tooltip">8 drinks</div>
										<div class="left-value slider-value">1</div>
										<div class="right-value slider-value">24+</div>
									</div>
								</div>

								<input type="hidden" name="past_4wk_hours_amount_drank" value="1" />

								<div class="watch">
									<div class="watch-main"><img src="<?php echo BASE_URL; ?>images/watch.png" alt="Wach face" /></div>
									<div class="center"><img src="<?php echo BASE_URL; ?>images/watch-center.png" alt="watch center" /></div>
									<div class="shadow"><img src="<?php echo BASE_URL; ?>images/watch-shadow.png" alt="watch shadow" /></div>
									<div class="hour"></div>
									<div class="minute"></div>
									<div class="second"></div>

								</div>

							</div>

							<div class="field clearfix">

								<i class="icn number">04</i>

								<p>In order for us to calculate your Blood Alcohol Concentration please give your best estimate of your height and weight:</p>

								<div class="height clearfix">

									<p>Height</p>
									<input type="text" name="body_height-cm" placeholder="cm" id="height-cm" title="Please enter your height">

									<p class="or">or</p>

									<input type="text" name="body_height-feet" placeholder="feet" id="height-feet" title="Please enter your height in feet">
									<input type="text" name="body_height-inches" placeholder="inches" id="height-inches"  title="Please enter your inches">

								</div><!-- height -->

								<div class="weight clearfix">

									<p>Weight</p>

									<input type="text" name="body_weight-number" id="weight" title="Please enter your weight" />

									<div class="select styled">
										<select name="body_weight-unit" title="Please select whether your weight is in kg or lbs.">
											<option value="kg">kg</option>
											<option value="lbs">lbs</option>
										</select>
									</div>

								</div>

							</div><!-- field -->

						</div> <!-- #more-fields-wrapper -->

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