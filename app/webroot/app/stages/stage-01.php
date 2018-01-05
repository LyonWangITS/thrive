<div class="field gender radio-set clearfix">
	<i class="icn number">01</i>

	<p>What was your gender assigned at birth?</p>
	<div class="gender-wrap">
		<div class="input-wrap male">
			<input type="radio" name="gender" id="gender-male" value="Male">
			<label for="gender-male">Male</label>
		</div>
		<i class="icn male"></i>
		<div class="input-wrap female">
			<input type="radio" name="gender" id="gender-female"value="Female">
			<label for="gender-female">Female</label>
		</div>
		<i class="icn female"></i>
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

<div class="field text-right clearfix">
	<i class="icn number">06</i>
	<p>What was the name of your first pet?</p>
	<input type="text" id="first-pet" name="first_pet" />
</div>

<div class="field text-right clearfix">
	<i class="icn number">07</i>
	<p>What was the first music concert you attended?</p>
	<input type="text" id="first-concert" name="first_concert" />
</div>

<div class="field text-right clearfix">
	<i class="icn number">08</i>
	<p>What are the 2nd and 3rd letters in your Mother's name?</p>
	<input type="text" id="mother-letters" name="mother_letters" maxlength="2" />
</div>

<div class="field text-right clearfix">
	<i class="icn number">09</i>
	<p>What are the 4th and 5th digits in your cell phone number?</p>
	<input type="text" id="phone-digits" name="phone_digits" maxlength="2" />
</div>
