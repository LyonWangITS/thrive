<?php include 'commons/tabular.php'; ?>

<div class="field clearfix">

	<i class="icn number">02</i>

	<p>Thinking about only the days you consumed alcohol <strong>during the past 4 weeks</strong>, please enter the average number of <strong>standard drinks</strong> you consumed on each of those days.</p>
	<p>For example, when you drink on Tuesdays, if you usually have about 2 drinks, you would select "2" for Tuesday. When you drink on Thursdays, if you usually have about 25 drinks, you would select “25+” for Thursday.</p>

</div><!-- field -->

<?php foreach (get_weekdays() as $day => $label): ?>
	<div class="field tabular tabular-slider clearfix">
		<p><?php echo $label; ?></p>
		<div class="input-wrap">
			<div class="slider-wrapper">
				<div id="standard-drinks-slider_<?php echo $day; ?>" class="slider dragdealer">
					<div class="red-bar handle">drag me</div>
					<div class="selected-area"></div>
					<div class="tooltip">Select</div>
					<div class="left-value slider-value"></div>
					<div class="right-value slider-value">25+</div>
				</div>
				<input type="hidden" name="past_4wk_std_drinks_<?php echo $day; ?>" value="-1" />
			</div>
		</div>
	</div><!-- field -->
<?php endforeach; ?>

<div class="field slider clearfix">

	<i class="icn number">03</i>

	<p>In the <strong>last four weeks</strong> what is the largest number of standard drinks you have consumed on a single occasion?</p>

	<div class="slider-wrapper">
		<div id="standard-drinks-slider" class="slider dragdealer">
			<div class="red-bar handle">drag me</div>
			<div class="selected-area"></div>
			<div class="tooltip">Select</div>
			<div class="left-value slider-value"></div>
			<div class="right-value slider-value">25+</div>
		</div>
	</div>

	<input type="hidden" name="past_4wk_largest_number_single_occasion" value="0" />

</div><!-- field -->

<div class="field slider hours clearfix">

	<i class="icn number">04</i>

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

	<i class="icn number">05</i>

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
