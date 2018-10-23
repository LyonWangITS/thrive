<div class="field slider clearfix">

	<i class="icn number">01</i>

	<p>In the <strong>last four weeks</strong> what is the largest number of standard drinks you have consumed on a single occasion?</p>

	<div class="slider-wrapper">
		<div id="standard-drinks-slider" class="slider dragdealer">
			<div class="red-bar handle">drag me</div>
			<div class="selected-area"></div>
			<div class="tooltip">Select</div>
			<div class="left-value slider-value"></div>
			<div class="right-value slider-value">36+</div>
		</div>
	</div>

	<input type="hidden" name="past_4wk_largest_number_single_occasion" value="-1" />

</div><!-- field -->

<div class="field slider hours clearfix">

	<i class="icn number">02</i>

	<p>Over how many hours did you drink this amount (to the nearest hour)?</p>

	<div class="slider-wrapper">
		<div id="drinking-hours-slider" class="slider dragdealer">
			<div class="red-bar handle">drag me</div>
			<div class="selected-area"></div>
			<div class="tooltip">Select</div>
			<div class="left-value slider-value"></div>
			<div class="right-value slider-value">24+</div>
		</div>
	</div>

	<input type="hidden" name="past_4wk_hours_amount_drank" value="0" />

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

	<i class="icn number">03</i>

	<p>In order for us to calculate your Blood Alcohol Concentration please give your best estimate of your height and weight:</p>

	<div class="height clearfix">

		<p>Height</p>
		<input type="text" name="body_height-feet" placeholder="feet" id="height-feet" title="Please enter your height in feet">
		<input type="text" name="body_height-inches" placeholder="inches" id="height-inches"  title="Please enter your inches">

		<p class="or">or</p>

		<input type="text" name="body_height-cm" placeholder="cm" id="height-cm" title="Please enter your height">

	</div><!-- height -->

	<div class="weight clearfix">

		<p>Weight</p>

		<input type="text" name="body_weight-number" id="weight" title="Please enter your weight" />

		<div class="select styled">
			<select name="body_weight-unit" title="Please select whether your weight is in kg or lbs.">
				<option value="lbs">lbs</option>
				<option value="kg">kg</option>
			</select>
		</div>

	</div>

</div><!-- field -->
