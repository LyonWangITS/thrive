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

			<section class="progress step-four">

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

				<form class="stage-form optional" method="post" action="survey.php?t=<?= h( urlencode( ifne( $page_meta, 'token' ) ) ) ?>">

					<input type="hidden" name="survey-stage" value="4" />

					<fieldset title="Please fill in the fields below">

						<legend>Please fill in the details of your alcohol usage below.</legend>

						<div class="field tabular-intro clearfix">

							<i class="icn number">01</i>

							<p>As a result of drinking alcohol, have you experienced the following over the past 4 weeks:</p>

							<div class="image vessels">
								<img src="<?php echo BASE_URL; ?>images/vessels.png" alt="Drinking Vessel" />
							</div>

							<div class="labels">
								<span>No</span>
								<span>Yes</span>
								<span>Prefer not to say</span>
							</div>

						</div><!-- field -->

						<div class="field radio-set tabular clearfix">

							<p>A hangover</p>

							<div class="input-wrap">
								<input type="radio" name="hangover" id="hangover-no" value="no" />
								<label for="hangover-no"><span>No</span></label>
								<input type="radio" name="hangover" id="hangover-yes" value="yes" />
								<label for="hangover-yes"><span>Yes</span></label>
								<input type="radio" name="hangover" id="hangover-no-response" value="skip" />
								<label for="hangover-no-response"><span>Prefer not to say</span></label>
							</div>

						</div><!-- field -->

						<div class="field radio-set tabular clearfix">

							<p>An emotional outburst</p>

							<div class="input-wrap">
								<input type="radio" name="emotional_outburst" id="emotional_outburst-no" value="no" />
								<label for="emotional_outburst-no"><span>No</span></label>
								<input type="radio" name="emotional_outburst" id="emotional_outburst-yes" value="yes" />
								<label for="emotional_outburst-yes"><span>Yes</span></label>
								<input type="radio" name="emotional_outburst" id="emotional_outburst-no-response" value="skip" />
								<label for="emotional_outburst-no-response"><span>Prefer not to say</span></label>
							</div>

						</div><!-- field -->

						<div class="field radio-set tabular clearfix">

							<p>Vomiting</p>

							<div class="input-wrap">
								<input type="radio" name="vomiting" id="vomiting-no" value="no" />
								<label for="vomiting-no"><span>No</span></label>
								<input type="radio" name="vomiting" id="vomiting-yes" value="yes" />
								<label for="vomiting-yes"><span>Yes</span></label>
								<input type="radio" name="vomiting" id="vomiting-no-response" value="skip" />
								<label for="vomiting-no-response"><span>Prefer not to say</span></label>
							</div>

						</div><!-- field -->

						<div class="field radio-set tabular clearfix">

							<p>A heated argument</p>

							<div class="input-wrap">
								<input type="radio" name="heated_argument" id="heated_argument-no" value="no" />
								<label for="heated_argument-no"><span>No</span></label>
								<input type="radio" name="heated_argument" id="heated_argument-yes" value="yes" />
								<label for="heated_argument-yes"><span>Yes</span></label>
								<input type="radio" name="heated_argument" id="heated_argument-no-response" value="skip" />
								<label for="heated_argument-no-response"><span>Prefer not to say</span></label>
							</div>

						</div><!-- field -->

						<div class="field radio-set tabular clearfix">

							<p>You were physically aggressive towards someone</p>

							<div class="input-wrap">
								<input type="radio" name="physically_aggressive" id="physically_aggressive-no" value="no" />
								<label for="physically_aggressive-no"><span>No</span></label>
								<input type="radio" name="physically_aggressive" id="physically_aggressive-yes" value="yes" />
								<label for="physically_aggressive-yes"><span>Yes</span></label>
								<input type="radio" name="physically_aggressive" id="physically_aggressive-no-response" value="skip" />
								<label for="physically_aggressive-no-response"><span>Prefer not to say</span></label>
							</div>

						</div><!-- field -->

						<div class="field radio-set tabular clearfix">

							<p>A period of time that you could not remember (blackouts)</p>

							<div class="input-wrap">
								<input type="radio" name="blackouts" id="blackouts-no" value="no" />
								<label for="blackouts-no"><span>No</span></label>
								<input type="radio" name="blackouts" id="blackouts-yes" value="yes" />
								<label for="blackouts-yes"><span>Yes</span></label>
								<input type="radio" name="blackouts" id="blackouts-no-response" value="skip" />
								<label for="blackouts-no-response"><span>Prefer not to say</span></label>
							</div>

						</div><!-- field -->

						<div class="field radio-set tabular clearfix">

							<p>An inability to pay your bills as a result of spending too much money on alcohol</p>

							<div class="input-wrap">
								<input type="radio" name="inability_to_pay_bills" id="inability_to_pay_bills-no" value="no" />
								<label for="inability_to_pay_bills-no"><span>No</span></label>
								<input type="radio" name="inability_to_pay_bills" id="inability_to_pay_bills-yes" value="yes" />
								<label for="inability_to_pay_bills-yes"><span>Yes</span></label>
								<input type="radio" name="inability_to_pay_bills" id="inability_to_pay_bills-no-response" value="skip" />
								<label for="inability_to_pay_bills-no-response"><span>Prefer not to say</span></label>
							</div>

						</div><!-- field -->

						<div class="field radio-set tabular clearfix">

							<p>Unprotected sex</p>

							<div class="input-wrap">
								<input type="radio" name="unprotected_sex" id="unprotected_sex-no" value="no" />
								<label for="unprotected_sex-no"><span>No</span></label>
								<input type="radio" name="unprotected_sex" id="unprotected_sex-yes" value="yes" />
								<label for="unprotected_sex-yes"><span>Yes</span></label>
								<input type="radio" name="unprotected_sex" id="unprotected_sex-no-response" value="skip" />
								<label for="unprotected_sex-no-response"><span>Prefer not to say</span></label>
							</div>

						</div><!-- field -->

						<div class="field radio-set tabular clearfix">

							<p>A sexual situation you weren't happy about at the time</p>

							<div class="input-wrap">
								<input type="radio" name="sexual_situation_not_happy_about" id="sexual_situation_not_happy_about-no" value="no" />
								<label for="sexual_situation_not_happy_about-no"><span>No</span></label>
								<input type="radio" name="sexual_situation_not_happy_about" id="sexual_situation_not_happy_about-yes" value="yes" />
								<label for="sexual_situation_not_happy_about-yes"><span>Yes</span></label>
								<input type="radio" name="sexual_situation_not_happy_about" id="sexual_situation_not_happy_about-no-response" value="skip" />
								<label for="sexual_situation_not_happy_about-no-response"><span>Prefer not to say</span></label>
							</div>

						</div><!-- field -->

						<div class="field radio-set tabular clearfix">

							<p>A sexual encounter you later regretted</p>

							<div class="input-wrap">
								<input type="radio" name="sexual_encounter_later_regretted" id="sexual_encounter_later_regretted-no" value="no" />
								<label for="sexual_encounter_later_regretted-no"><span>No</span></label>
								<input type="radio" name="sexual_encounter_later_regretted" id="sexual_encounter_later_regretted-yes" value="yes" />
								<label for="sexual_encounter_later_regretted-yes"><span>Yes</span></label>
								<input type="radio" name="sexual_encounter_later_regretted" id="sexual_encounter_later_regretted-no-response" value="skip" />
								<label for="sexual_encounter_later_regretted-no-response"><span>Prefer not to say</span></label>
							</div>

						</div><!-- field -->

						<div class="field radio-set tabular clearfix">

							<p>You suffered an injury that required medical attention (e.g. at a hospital, your doctor, or Student Health)</p>

							<div class="input-wrap">
								<input type="radio" name="injury_requiring_medical_attention" id="injury_requiring_medical_attention-no" value="no" />
								<label for="injury_requiring_medical_attention-no"><span>No</span></label>
								<input type="radio" name="injury_requiring_medical_attention" id="injury_requiring_medical_attention-yes" value="yes" />
								<label for="injury_requiring_medical_attention-yes"><span>Yes</span></label>
								<input type="radio" name="injury_requiring_medical_attention" id="injury_requiring_medical_attention-no-response" value="skip" />
								<label for="injury_requiring_medical_attention-no-response"><span>Prefer not to say</span></label>
							</div>

						</div><!-- field -->

						<div class="field radio-set tabular clearfix">

							<p>You drove a car after you had perhaps too much to drink to be able to drive safely?</p>

							<div class="input-wrap">
								<input type="radio" name="drove_car_unsafely" id="drove_car_unsafely-no" value="no" />
								<label for="drove_car_unsafely-no"><span>No</span></label>
								<input type="radio" name="drove_car_unsafely" id="drove_car_unsafely-yes" value="yes" />
								<label for="drove_car_unsafely-yes"><span>Yes</span></label>
								<input type="radio" name="drove_car_unsafely" id="drove_car_unsafely-no-response" value="skip" />
								<label for="drove_car_unsafely-no-response"><span>Prefer not to say</span></label>
							</div>

						</div><!-- field -->

						<div class="field radio-set tabular clearfix">

							<p>You were a passenger in a vehicle where the driver had perhaps too much to drink to be able to drive safely?</p>

							<div class="input-wrap">
								<input type="radio" name="passenger_of_unsafe_driver" id="passenger_of_unsafe_driver-no" value="no" />
								<label for="passenger_of_unsafe_driver-no"><span>No</span></label>
								<input type="radio" name="passenger_of_unsafe_driver" id="passenger_of_unsafe_driver-yes" value="yes" />
								<label for="passenger_of_unsafe_driver-yes"><span>Yes</span></label>
								<input type="radio" name="passenger_of_unsafe_driver" id="passenger_of_unsafe_driver-no-response" value="skip" />
								<label for="passenger_of_unsafe_driver-no-response"><span>Prefer not to say</span></label>
							</div>

						</div><!-- field -->

						<div class="field radio-set tabular clearfix">

							<p>You stole private or public property (e.g. sign, shopping trolley)</p>

							<div class="input-wrap">
								<input type="radio" name="stole_property" id="stole_property-no" value="no" />
								<label for="stole_property-no"><span>No</span></label>
								<input type="radio" name="stole_property" id="stole_property-yes" value="yes" />
								<label for="stole_property-yes"><span>Yes</span></label>
								<input type="radio" name="stole_property" id="stole_property-no-response" value="skip" />
								<label for="stole_property-no-response"><span>Prefer not to say</span></label>
							</div>

						</div><!-- field -->

						<div class="field radio-set tabular clearfix">

							<p>You committed an act of vandalism (e.g. damaged a parking meter, fence)</p>

							<div class="input-wrap">
								<input type="radio" name="committed_vandalism" id="committed_vandalism-no" value="no" />
								<label for="committed_vandalism-no"><span>No</span></label>
								<input type="radio" name="committed_vandalism" id="committed_vandalism-yes" value="yes" />
								<label for="committed_vandalism-yes"><span>Yes</span></label>
								<input type="radio" name="committed_vandalism" id="committed_vandalism-no-response" value="skip" />
								<label for="committed_vandalism-no-response"><span>Prefer not to say</span></label>
							</div>

						</div><!-- field -->

						<div class="field radio-set tabular clearfix">

							<p>You were removed or banned from a pub or club</p>

							<div class="input-wrap">
								<input type="radio" name="removed_or_banned_from_pub_club" id="removed_or_banned_from_pub_club-no" value="no" />
								<label for="removed_or_banned_from_pub_club-no"><span>No</span></label>
								<input type="radio" name="removed_or_banned_from_pub_club" id="removed_or_banned_from_pub_club-yes" value="yes" />
								<label for="removed_or_banned_from_pub_club-yes"><span>Yes</span></label>
								<input type="radio" name="removed_or_banned_from_pub_club" id="removed_or_banned_from_pub_club-no-response" value="skip" />
								<label for="removed_or_banned_from_pub_club-no-response"><span>Prefer not to say</span></label>
							</div>

						</div><!-- field -->

						<div class="field radio-set tabular clearfix">

							<p>You were arrested</p>

							<div class="input-wrap">
								<input type="radio" name="arrested" id="arrested-no" value="no" />
								<label for="arrested-no"><span>No</span></label>
								<input type="radio" name="arrested" id="arrested-yes" value="yes" />
								<label for="arrested-yes"><span>Yes</span></label>
								<input type="radio" name="arrested" id="arrested-no-response" value="skip" />
								<label for="arrested-no-response"><span>Prefer not to say</span></label>
							</div>

						</div><!-- field -->

						<div class="field submit">

							<p>Click next to view your results</p>

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