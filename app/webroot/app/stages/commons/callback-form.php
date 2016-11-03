
<form class="callback" method="post" action="callback.php?t=<?= urlencode( ifne( $page_meta, 'token' ) ) ?>">
	
	<input type="hidden" name="submit" value="callback" />

	<i class="phone icn"></i>

	<p class="title">Request a Call Back</p>
	
	<p>Complete the form below so an ADIS worker can call you back at a more suitable time.</p>
	
	<fieldset class="left">
	
		<legend>Please fill in the following form</legend>
		
		<div class="field clearfix">
		
			<input type="text" name="callback-firstname" placeholder="First Name*" title="Please enter your first name" />
			<input type="text" name="callback-phone" placeholder="Phone Number*" title="Please enter your phone number" />
			
		</div>
		
		<div class="field radio-set clearfix">
		
			<p>Ok to leave a message/send a text to this number?</p>
			
			<div class="input-wrap">
				<input type="radio" name="callback-message-ok" id="contact-yes" value="Yes" />
				<label for="contact-yes"><span>Yes</span></label>
				<input type="radio" name="callback-message-ok" id="contact-no" value="No" />
				<label for="contact-no"><span>No</span></label>
			</div>
		
		</div><!-- field -->
	
	</fieldset>
	
	<fieldset class="right">
	
		<legend>Please state when the best time to call you is.</legend>
							
		<div class="field time-call clearfix">
		
			<p>When is the best time for ADIS to call you?</p>
		
			<div class="input-wrap">

				<p>Weekdays</p>
			
				<div class="styled">
					<select name="callback-weekdays" title="Please select the time of day that best suits you on a weekday.">
						<option value="anytime">Anytime</option>
						<option value="morning">Morning</option>
						<option value="afternoon">Afternoon</option>
						<option value="evening">Evening</option>
					</select>
				</div>
			
			</div>
			
			<div class="input-wrap right">

				<p>Weekends</p>
			
				<div class="styled">
					<select name="callback-weekends" title="Please select the time of day that best suits you on a weekend.">
						<option value="anytime">Anytime</option>
						<option value="morning">Morning</option>
						<option value="afternoon">Afternoon</option>
						<option value="evening">Evening</option>
					</select>
				</div>
			
			</div>
		</div>							

		<div class="field submit">
		
			<p class="success"></p>
			<p class="error"></p>
		
			<button type="submit">Send Request</button>
			
			
		
		</div>					
	
	</fieldset>
	
	<div class="additional-info">
			
				<p><strong>Additional info</strong></p>
				<p>When ADIS calls, "Private Number" will display on mobile phones.</p>
				<p>If there is no answer, two more attempts will be made to contact you. No more attempts will be made but you are welcome to call ADIS at any time.</p>
			
			</div>

</form>