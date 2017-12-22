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
			<?php foreach (range(18, 24) as $i): ?>
				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div><!-- field -->

<div class="field race radio-set clearfix">
	<i class="icn number">03</i>
	<p>Which of the following best describes your race?</p>
	<div class="select styled">
		<select name="race" id="race">
			<option value="">Please select</option>
			<option value="native-american"> American Indian or Alaskan Native</option>
			<option value="asian">Asian</option>
			<option value="hawaiian">Native Hawaiian or Other Pacific Islander</option>
			<option value="black">Black or African American</option>
			<option value="white">White/Caucasian</option>
			<option value="mixed-race">Mixed Race</option>
			<option value="other">Other</option>
			<option value="skip">I Choose Not to Answer</option>
		</select>
	</div>
</div>

<div class="field ethnicity">
	<i class="icn number">04</i>
	<p>What is your ethnicity?</p>
	<div class="select styled">
		<select name="ethnicity" id="ethnicity">
			<option value="">Please select</option>
			<option value="hispanic-latino">Hispanic or Latino(a)</option>
			<option value="not-hispanic-latino">Not Hispanic or Latino(a)</option>
			<option value="skip">I Choose Not to Answer</option>
		</select>
	</div>
</div>

<div class="field where select-left" id="on-campus-wrapper">
	<i class="icn number">05</i>
	<p>Where are you living right now?</p>
	<div class="select styled">
		<select name="where" id="where">
			<option value="">Please select</option>
			<option value="dorm">Dorm</option>
			<option value="with-parents">Apartment or house with parents or other relatives</option>
			<option value="with-roommates">Apartment or house with friends or roommates</option>
		</select>
	</div>
	<i class="icn accom"></i>
</div><!-- field -->

<div class="field drinks-last-year radio-set clearfix">

	<i class="icn number">08</i>

	<p>Have you had an alcoholic drink of any kind in the last 12 months?</p>

	<div class="input-wrap">
		<input type="radio" name="alcohol_last_12mths" id="drinks-yes" value="yes">
		<label for="drinks-yes">Yes</label>
		<input type="radio" name="alcohol_last_12mths" id="drinks-no" value="no">
		<label for="drinks-no">No</label>
	</div>

	<div class="calendar">
		<i class="icn cal"></i>
		<span><?php echo date( 'F' ); ?></span>
		<div class="icn shadow"></div>
	</div>
</div><!-- field -->
