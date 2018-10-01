<div class="field tobacco-use clearfix">

	<i class="icn number">01</i>

	<p>Which of the following best describes your use of cigarettes?</p>

	<div class="select styled">
		<select name="tobacco_use" title="Which of the following best describes your use of cigarettes?">
			<option value="">Please select</option>
			<option value="never">Never smoked cigarettes at all, or never smoked them regularly</option>
			<option value="used_to_smoke_regularly">Do not smoke now but used to smoke regularly (once or more per day)</option>
			<option value="occasionally">Occasionally smoke (on average, less than one per day)</option>
			<option value="regularly">Currently smoke cigarettes regularly (more than one per day)</option>
		</select>
	</div>

</div><!-- field -->

<div class="field tobacco-frequency select-right clearfix">

	<i class="icn number">02</i>

	<p>During the <strong>past month</strong>, how many cigarettes did you smoke on a typical day?</p>

	<div class="select styled">
		<select name="tobacco_frequency" title="During the past month, how many cigarettes did you smoke on a typical day?">
			<option value="">Please select</option>
			<option value="0">Did not smoke</option>
			<?php foreach (range(1, 50) as $i): ?>
				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endforeach; ?>
			<option value="51">51+</option>
		</select>
	</div>

</div><!-- field -->

<div class="field tobacco-first select-left clearfix">

	<i class="icn number">03</i>

	<p>How soon after waking do you smoke your first cigarette?</p>

	<div class="select styled">
		<select name="tobacco_init" title="How soon after waking do you smoke your first cigarette?">
			<option value="">Please select</option>
			<option value="0">I do not smoke on a daily basis</option>
			<option value="5">Within 5 minutes</option>
			<option value="30">5-30 minutes</option>
			<option value="60">31-60 minutes</option>
			<option value="61">More than 60 minutes</option>
		</select>
	</div>

</div><!-- field -->
