<? include_once( 'commons/header.php' ) ?>

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
		
			<section class="progress step-one">
			
				<div class="line"></div>
				
				<div class="line current-pos"></div>
				
				<div class="step hi"><i class="icn"></i></div>
				
				<div class="step s-one"><i class="icn"></i><span>All about you</span><i class="icn arrow"></i></div>
				
				<div class="step s-two"><i class="icn s2"></i></div>
				
				<div class="step s-three"><i class="icn s3"></i></div>
				
				<div class="step s-four"><i class="icn s4"></i></div>
				
				<div class="step s-five"><i class="icn s5"></i></div>
			
			</section><!-- progress -->
			
			<section class="intro">
			
				<h1>All about you</h1>
				
				<p>Thanks, <?= h( ifne( $page_meta, 'participant_name' ) ) ?>. First of all we'd like to know a little bit more about you...</p>
			
			</section><!-- intro -->
			
			<section class="questions">
			
				<form class="stage-form" method="post" action="survey.php?t=<?= h( urlencode( ifne( $page_meta, 'token' ) ) ) ?>">
					
					<input type="hidden" name="survey-stage" value="1" />
					
					<fieldset title="Please fill in the fields below">
						
						<legend>Please fill in these details about yourself.</legend>
				
						<?
							// New Fields
						?>

						<div class="field gender radio-set clearfix">
							
							<i class="icn number">01</i>
							
							<p>Gender?</p>
							
							<div class="gender-wrap">
							
								<i class="icn female"></i>							
								<div class="input-wrap female">
								
									<input type="radio" name="gender-mf" id="gender-female"value="Female">
									<label for="gender-female">Female</label>
								
								</div>
								<i class="icn male"></i>
								<div class="input-wrap male">
																
									<input type="radio" name="gender-mf" id="gender-male" value="Male">
									<label for="gender-male">Male</label>
								
								</div>
								
								<div class="select styled">
									<select name="gender-more" title="If other, please select from the following options.">
										<option value="">Select more options</option>
										<option value="transgender-ftm">Transgender or transexual FtM</option>
										<option value="transgender-mtf">Transgender or transexual MtF</option>
										<option value="genderqueer">Genderqueer</option>
										<option value="androgynous">Androgynous</option>
										<option value="intersex">Intersex</option>
									</select>
								</div>

							</div><!-- gender-wrap -->
							
						</div><!-- field -->
						

						<div class="field age select-right">
						
							<i class="icn number">02</i>
						
							<p>How old are you?</p>

							<div class="select styled">
								<select name="age" id="age" title="Please select your age from the drop down.">
									<option value="">Please select</option>
									<?php
									for ( $i = 17; $i <= 74; $i++ ) {

										echo "<option value=\"{$i}\">{$i}</option>";
									}
									?>
									<option value="75">75+</option>
								</select>
							</div>

						</div><!-- field -->

						<?php
						$next_question_number = 3;
						if ( !empty( $partner->data['is_staff_student'] ) ) {
							?>
							<div class="field staff-student radio-set clearfix">
							
								<i class="icn number">0<?php echo $next_question_number; ?></i>
							
								<p>Are you primarily a...</p>
								
								<div class="staff-student-wrap">
								
									<i class="icn student-card"></i>
									
									<div class="input-wrap">
										<input type="radio" name="staff_student" id="student" value="student" checked="checked">
										<label for="student">Student</label>
										
									</div>
									
									<i class="icn staff-card"></i>
									
									<div class="input-wrap">
										<input type="radio" name="staff_student" id="staff" value="staff">
										<label for="staff">Staff member</label>
									</div>

								</div>
								
							</div><!-- field -->
							<?php
							$next_question_number++;
						}
						else {
							?>
							<input type="hidden" name="staff_student" value="student">
							<?php
						}
						?>

						<div id="demographics-wrapper">

							<div class="field class-hours radio-set clearfix">
							
								<i class="icn number">0<?php echo $next_question_number++; ?></i>
							
								<p>Would you consider yourself to be studying...</p>
								
								<div class="input-wrap">
									<input type="radio" name="hours_per_week" id="ten-more" value="gt-10">
									<label for="ten-more">Full time</label>
									<input type="radio" name="hours_per_week" id="ten-less" value="lt-10">
									<label for="ten-less">Part time</label>
								</div>
								
								<i class="icn books"></i>
								
							</div><!-- field -->

							<?php
							//
							// Optional demographic questions

							// Optional year level question
							if ( !empty( $partner->data['is_year_level_question_enabled'] ) ) {
								?>
								<div class="field select-right clearfix" id="year-level-wrapper">

									<i class="icn number">0<?php echo $next_question_number++; ?></i>

									<p>What is your year level / class standing?</p>

									<div class="select styled">
										<select name="year_level" id="year_level" title="Please select your year level / class standing from the drop down.">
											<option value="">Please select</option>
											<option value="1st-year">1st Year</option>
											<option value="2nd-year">2nd Year</option>
											<option value="3rd-year">3rd Year</option>
											<option value="4th-year">4th Year</option>
											<option value="postgraduate">Postgraduate</option>
											<option value="not-applicable">Not Applicable</option>
										</select>
									</div>

								</div><!-- field -->
								<?php
							}

							// Optional accommodation question
							if ( !empty( $partner->data['is_on_campus_question_enabled'] ) ) {
								?>
								<div class="field radio-set clearfix" id="on-campus-wrapper">

									<i class="icn number">0<?php echo $next_question_number++; ?></i>

									<p>Do you live in on-campus accommodation?</p>

									<div class="input-wrap">
										<input type="radio" name="on_campus" id="on-campus-yes" value="yes">
										<label for="on-campus-yes">Yes</label>
										<input type="radio" name="on_campus" id="on-campus-no" value="no">
										<label for="on-campus-no">No</label>
									</div>

									<i class="icn accom"></i>

								</div><!-- field -->
								<?php
							}

							// Optional where from question
							if ( !empty( $partner->data['is_from_question_enabled'] ) ) {
								?>
								<div class="field select-right clearfix" id="where-from-wrapper">

									<i class="icn number">0<?php echo $next_question_number++; ?></i>

									<p>Where are you from?</p>

									<div class="select styled">
										<select name="where_from" id="where-from" title="Please select where you are from, from the drop down.">
											<option value="">Please select</option>
											<option value="perth-metro">Perth (Metropolitan) student</option>
											<option value="regional-wa">Regional (Western Australian) student</option>
											<option value="other-state">Other Australian state student</option>
											<option value="international">International student</option>
										</select>
									</div>

								</div><!-- field -->
								<?php
							}
							?>

						</div>

						<div class="field drinks-last-year radio-set clearfix">
							
							<i class="icn number">0<?php echo $next_question_number++; ?></i>
						
							<p>Have you had an alcoholic drink of any kind in the last 12 months?</p>
							
							<div class="input-wrap">
								<input type="radio" name="alcohol_last_12mths" id="drinks-yes" value="yes">
								<label for="drinks-yes">Yes</label>
								<input type="radio" name="alcohol_last_12mths" id="drinks-no" value="no">
								<label for="drinks-no">No</label>
							</div>
							
							<div class="calendar">
								<i class="icn cal"></i>
								<span><?= date( 'F' ) ?></span>
								<div class="icn shadow"></div>
							</div>
						
						</div><!-- field -->			
						
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

<? include_once( 'commons/footer.php' ) ?>