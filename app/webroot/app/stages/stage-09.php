<?php $the_audit_score = ifne( $page_meta, 'audit_score' ); ?>

<section class="summary">

	<p>Some of the questions you answered regarding your drinking come from the Alcohol Use Disorders Identification Test, a questionnaire developed by the World Health Organisation to determine whether a person's drinking might be becoming problematic. Your answers to these questions provivided the following result.</p>

</section>

<section class="score clearfix">

	<?php
		$audit_range = '';
		$donut_class = '';
		if ( ( $the_audit_score >= 0 ) && ( $the_audit_score <= 7 ) ) {
			$audit_range = '0-7';
			$donut_class = 'moderate';
			$audit_result_label = 'Moderate Drinking';
		} else if ( ( $the_audit_score >= 8 ) && ( $the_audit_score <= 15 ) ) {
			$audit_range = '8-15';
			$donut_class = 'hazardous';
			$audit_result_label = 'Hazardous Drinking';
		} else if ( ( $the_audit_score >= 16 ) && ( $the_audit_score <= 19 ) ) {
			$audit_range = '16-19';
			$donut_class = 'harmful';
			$audit_result_label = 'Harmful Drinking';
		} else if ( ( $the_audit_score >= 20 ) ) {
			$audit_range = '20-40';
			$donut_class = 'dependence';
			$audit_result_label = 'Alcohol Dependence';
		}

	?>

	<div class="donut <?php echo $donut_class ?>">

		<div class="slice top-left"></div>
		<div class="slice top-right"></div>
		<div class="slice bottom-left"></div>
		<div class="slice bottom-right"></div>

		<div class="text">
			<p><strong><?php echo $audit_range ?></strong> <?php echo $audit_result_label ?></p>
		</div>

	</div>

	<div class="score-text <?php echo $donut_class ?>">

		<h2>Your audit score is <strong><?php echo $the_audit_score ?></strong></h2>

		<div class="description">

			<p class="range">You fall into the <strong><?php echo $audit_range ?> <?php echo $audit_result_label ?> Range</strong></p>

			<?php
				if ( ( $the_audit_score >= 0 ) && ( $the_audit_score <= 7 ) ) {
					//0-7 Moderate Drinking
			?>
				<p>Low risk of alcohol related harm</p>
			<?php
				} else if ( ( $the_audit_score >= 8 ) && ( $the_audit_score <= 15 ) ) {
					//8-15 Hazardous drinking
			?>
				<p>High risk of experiencing alcohol related harm and some people in this range may already be experiencing significant harm.</p>
			<?php
				} else if ( ( $the_audit_score >= 16 ) && ( $the_audit_score <= 19 ) ) {
					//16-19 Harmful drinking
			?>
				<p>A person scoring in this range will already be experiencing significant alcohol related harm.</p>
			<?php
				} else if ( ( $the_audit_score >= 20 ) ) {
					//2-40 Alcohol dependence
			?>
				<p>A person scoring in this range may be alcohol dependent and advised to have a clinical assessment of their drinking.</p>
			<?php
				}
			?>

			<p>
				The main way to reduce your risk level (and AUDIT score) is to reduce the number of drinks you consume per occasion.
			</p>

		</div>

	</div>

</section>

<section class="score-range clearfix">

	<div class="range moderate<?php echo ( ( $the_audit_score >= 0 ) && ( $the_audit_score <= 7 ) ) ? ' active' : '' ?>">

		<span class="icn dot"></span>

		<div class="text">

			<strong>0-7</strong>

			<p>Moderate Drinking</p>

		</div>

	</div><!-- moderate -->

	<div class="range hazardous<?php echo ( ( $the_audit_score >= 8 ) && ( $the_audit_score <= 15 ) ) ? ' active' : '' ?>">

		<span class="icn dot"></span>

		<div class="text">

			<strong>8-15</strong>

			<p>Hazardous Drinking</p>

		</div>

	</div><!-- moderate -->

	<div class="range harmful<?php echo ( ( $the_audit_score >= 16 ) && ( $the_audit_score <= 19 ) ) ? ' active' : '' ?>">

		<span class="icn dot"></span>

		<div class="text">

			<strong>16-19</strong>

			<p>Harmful Drinking</p>

		</div>

	</div><!-- moderate -->

	<div class="range dependence<?php echo ( ( $the_audit_score >= 20 ) ) ? ' active' : '' ?>">

		<span class="icn dot"></span>

		<div class="text">

			<strong>20-40</strong>

			<p>Alcohol Dependence</p>

		</div>

	</div><!-- moderate -->

</section>

<?php

include_once( 'commons/compare.php' );

$bac = round( floatval( ifne( $page_meta, 'bac' ) ), 2 );
if ( ( $bac != '' ) && ( $bac > 0 ) ){
	include_once( 'commons/bac.php' );
}

$expenses = ifne( $page_meta, 'expenses' );
$expenses_from = ifne( $expenses, 'from' );
$expenses_to = ifne( $expenses, 'to' );

if ( ( $expenses_to != 0 ) || ( $expenses_from != 0 ) ){
	include_once( 'commons/expenses.php' );
}

// Optionally include feedback questions
if ( !empty( $partner->data['is_feedback_enabled'] ) ) {
	?>
	<section class="thrive-feedback">


		<div class="heading">
			<h2>Some quick questions</h2>
			<p>These questions are optional. Answering helps give us feedback.</p>
		</div>

		<!-- <p class="title lg">Feedback (optional)</p> -->


		<div class="field question slider green">

			<p>How important is it to you that you reduce your drinking?</p>

			<div class="slider dragdealer">

				<ul class="clearfix score">
					<li><span>n/a</span></li>
					<li><span>1</span></li>
					<li><span>2</span></li>
					<li><span>3</span></li>
					<li><span>4</span></li>
					<li><span>5</span></li>
					<li><span>6</span></li>
					<li><span>7</span></li>
					<li><span>8</span></li>
					<li><span>9</span></li>
					<li><span>10</span></li>
				</ul>

				<div class="controls-wrap" id="rating-important-reduce-drinking">
					<div class="red-bar handle" style="left: 0px;">drag me</div>
					<div class="selected-area" style="width: 19px;"></div>
					<span class="not-important">Not at all important</span>
					<span class="very-important">Very important</span>
				</div>
				<input type="hidden" name="rating_important_reduce_drinking" value="<?php echo $page_vars['rating_important_reduce_drinking']; ?>">
			</div>

		</div>

		<div class="field question slider red">

			<p>How confident are you that you can reduce your drinking?</p>

			<div class="slider dragdealer">

				<ul class="clearfix score">
					<li><span>n/a</span></li>
					<li><span>1</span></li>
					<li><span>2</span></li>
					<li><span>3</span></li>
					<li><span>4</span></li>
					<li><span>5</span></li>
					<li><span>6</span></li>
					<li><span>7</span></li>
					<li><span>8</span></li>
					<li><span>9</span></li>
					<li><span>10</span></li>
				</ul>

				<div class="controls-wrap" id="rating-confident-reduce-drinking">
					<div class="red-bar handle" style="left: 0px;">drag me</div>
					<div class="selected-area" style="width: 19px;"></div>
					<span class="not-important">Not at all confident</span>
					<span class="very-important">Very confident</span>
				</div>
				<input type="hidden" name="rating_confident_reduce_drinking" value="<?php echo $page_vars['rating_confident_reduce_drinking']; ?>">
			</div>

		</div>

		<?php
		// The next two feedback questions only get shown if audit score is 20+
		if ( $the_audit_score >= 20 ) {
			?>
			<div class="field question slider purple">

				<p>How important do you think it is that you talk to a health professional <br />(like a doctor or counsellor) about your drinking?</p>

				<div class="slider dragdealer">

					<ul class="clearfix score">
						<li><span>n/a</span></li>
						<li><span>1</span></li>
						<li><span>2</span></li>
						<li><span>3</span></li>
						<li><span>4</span></li>
						<li><span>5</span></li>
						<li><span>6</span></li>
						<li><span>7</span></li>
						<li><span>8</span></li>
						<li><span>9</span></li>
						<li><span>10</span></li>
					</ul>

					<div class="controls-wrap" id="rating-important-talk-professional">
						<div class="red-bar handle" style="left: 0px;">drag me</div>
						<div class="selected-area" style="width: 19px;"></div>
						<span class="not-important">Not at all important</span>
						<span class="very-important">Very important</span>
					</div>
					<input type="hidden" name="rating_important_talk_professional" value="<?php echo $page_vars['rating_important_talk_professional']; ?>">
				</div>

			</div>

			<div class="field question slider blue">

				<p>How ready are you to talk to a health professional?</p>

				<div class="slider dragdealer">

					<ul class="clearfix score">
						<li><span>n/a</span></li>
						<li><span>1</span></li>
						<li><span>2</span></li>
						<li><span>3</span></li>
						<li><span>4</span></li>
						<li><span>5</span></li>
						<li><span>6</span></li>
						<li><span>7</span></li>
						<li><span>8</span></li>
						<li><span>9</span></li>
						<li><span>10</span></li>
					</ul>

					<div class="controls-wrap" id="rating-ready-talk-professional">
						<div class="red-bar handle" style="left: 0px;">drag me</div>
						<div class="selected-area" style="width: 19px;"></div>
						<span class="not-important">Not at all ready</span>
						<span class="very-important">Very ready</span>
					</div>
					<input type="hidden" name="rating_ready_talk_professional" value="<?php echo $page_vars['rating_ready_talk_professional']; ?>">
				</div>

			</div>
			<?php
		}
		?>

	</section>
	<?php
}

if ( !empty( $partner->data['is_adis_enabled'] ) ) {
	?>
	<section class="learn-more clearfix">
		<p class="title lg">Do you want to learn more?</p>

		<p>Alcohol and Drug Information Service (ADIS) staff are available between 7am and 11pm, 7 days a week to answer any questions about alcohol or other drugs you may have after completing this survey. </p>

		<div class="clip contact-details">

			<i class="icn green-phone"></i>

			<div class="text">
				<p>You can call ADIS now on 9442 5000 or<br />1800 198 024 (Country toll free from landlines) or send them an email <a href="mailto:adis@health.wa.gov.au">adis@health.wa.gov.au</a></p>
			</div>

		</div>

		<a class="clip chat" href="http://www.drugaware.com.au/" target="_blank">

			<i class="icn chat"></i>
			<div class="text">
				<p class="title">Livechat</p>
				<p>Chat with an ADIS worker now</p>
			</div>


		</a>

		<div class="clear"></div>

		<?php
		include_once( 'commons/callback-form.php' );
		?>
	</section>
	<?php
}

if ( $partner->data['slug'] == POLYTECHNIC_WEST_SLUG ) {
	?>
	<section class="win">

		<p class="title">Here’s your chance to win that $500!</p>

		<p>Click on <a href="https://curtin.asia.qualtrics.com/SE/?SID=SV_2tufYYwxz3p0V7v" title="Click here for your chance to win $500" target="_blank">this link</a> to enter your email and accept the terms and conditions.</p>

	</section>
<?php
}

?>

</div><!-- content -->

<section class="facts accordian">
<div class="heading">
	<p>Facts</p>
	<i class="icn down-arrow"></i>
</div>
<div class="acc-content">

	<section>

		<p>Drinking alcohol can be part of an enjoyable night out, but drinking safely will ensure you have good memories. Safe drinking guidelines have been developed to help you protect your health - both physically and socially. Everyone is faced with some risk when consuming alcohol but thinking before you drink can lead to an enjoyable and safe experience.</p>

		<h3>Standard Drinks</h3>
		<p>Alcohol comes in all different types, colours and containers. Regardless of this, a standard drink is about 10 grams or 12.5mL of pure alcohol. Alcohol labels are displayed on the bottle to tell you how many standard drinks it contains. Remember one bottle/can/glass doesn't always equal one standard drink.</p>

		<ul>
			<li>Men and women shouldn't drink more than 2 standard drinks on any day to avoid long-term harm from alcohol related injury or disease. Remembering to have regular alcohol-free days.</li>
			<li>Men and women should drink no more than 4 standard drinks on any single drinking occasion to reduce alcohol related injury.</li>
		</ul>

	</section>

	<section>

		<h3>Alcohol and your body</h3>

		<p>People come in all different shapes and sizes, so depending on your gender, age, weight and other factors; you may be affected by alcohol more than others. Get to know your body in relation to the standard drink guidelines.</p>

		<p><strong>How does alcohol affect your body?</strong></p>

		<p><span>Skin:</span> Alcohol can dehydrate your skin. Drinking alcohol can deprive you skin of vital vitamins and nutrients and excessive alcohol can make your face look bloated and puffy.</p>

		<p><span>Heart:</span> Long term and heavy alcohol consumption can increase your risk of high blood pressure, weakening of the heart muscle heart failure and heart disease.</p>

		<p><span>Pancreas:</span> Continuous and excessive drinking can cause pancreatitis which is when the pancreas blood vessels, cells and tissue become damaged and can prevent proper digestion.</p>

		<p><span>Bowel:</span> Alcohol can cause bowel irritation and can trigger symptoms of irritable bowel syndrome. There are also links between alcohol consumption and bowel cancer.</p>

		<p><span>Bladder:</span> Alcohol is diuretic and can lead to dehydration, so remember to drink water. </p>

		<p><span>Immune System:</span> Drinking too much can weaken your immune system making you more susceptible to disease and illness.</p>

		<p><span>Brain:</span> Alcohol is a depressant and interferes with the brains communication pathways, making it hard for you to think clearly and move with coordination. The immediate effects of alcohol can include slurred speech, blurred vision, changes in mood, loss of balance and clumsiness. Excessive alcohol misuse may cause alcohol related brain impairment such as memory loss, and adversely affect mental health. The effects are greater with increasing amounts of alcohol consumed. More serious effects can be unconsciousness, alcohol poisoning, coma or death.</p>

		<p><span>Stomach:</span> Alcohol is absorbed directly into the bloodstream through the stomach and the small intestine. Short term effects of consuming alcohol can lead to nausea, vomiting, and diarrhoea. Food in the stomach can slow down the rate of absorption but it does not prevent drunkenness. Long term heavy drinking has been associated with increased risk of stomach cancer.</p>

		<p><span>Liver:</span> Regular drinking may result in Steatosis or fatty liver which can negatively affect your liver function. Continued heavy and excessive drinking may result in the liver becoming inflamed causing alcohol hepatitis, permanent liver scarring (cirrhosis), and liver cancer.</p>

		<p><span>Kidneys:</span> Alcohol is a diuretic, meaning that it acts on the kidneys to make you urinate more often. Drinking too much means your kidneys have to work harder to remove toxins from your blood.</p>

		<p><span>Breast:</span> Long term alcohol consumption can increase a women’s risk of breast cancer.</p>

		<p><span>Male reproductive system:</span> Drinking alcohol decreases sex drive and performance. Alcohol reduces testosterone levels and heavy consumption may lead to a reduction in sperm production. </p>

		<p><span>Female reproductive system:</span> Drinking heavy or excessive amounts of alcohol affects a woman's menstrual cycle and ovulation making it difficult to conceive. </p>

		<p><span>Women and pregnancy:</span> It is recommended that you avoid alcohol altogether when you are pregnant.</p>

	</section>

	<section>

		<h3>Alcohol and the Law - Driving Under the Influence (DUI)</h3>

		<p>Alcohol can impair your judgement, which can lead to doing something you wouldn't when sober. Across Australia it is an offence to drive with a BAC limit over 0.05% and if you are a novice driver a zero BAC applies. Penalties apply for breaking the law and differ between state.</p>

		<ul>
			<li><a href="http://www.police.wa.gov.au/Traffic/Drinkdriving/Penalties/tabid/989/Default.aspx" target="_blank" title="Western Australia">Western Australia</a></li>
			<li><a href="http://www.vicroads.vic.gov.au/Home/SafetyAndRules/RoadRules/Penalties/DrinkDrivingPenalties.htm" target="_blank" title="Victoria">Victoria</a></li>
			<li><a href="http://www.dpti.sa.gov.au/roadsafety/Safer_behaviours/Drink_and_drug_driving_penalties" target="_blank" title="South Australia">South Australia</a></li>
			<li><a href="http://www.qld.gov.au/transport/safety/road-safety/drink-driving/penalties/" target="_blank" title="Queensland">Queensland</a></li>
			<li><a href="http://transport.nt.gov.au/safety/road-safety/our-safer-road-users/alcohol-and-drugs" target="_blank" title="Northern Territory">Northern Territory</a></li>
			<li><a href="http://www.rms.nsw.gov.au/usingroads/penalties/alcoholanddrugs.html" target="_blank" title="New South Wales">New South Wales:</a></li>
			<li><a href="http://www.police.act.gov.au/roads-and-traffic/drink-driving.aspx" target="_blank" title="ACT">Australian Capital Territory</a></li>
		</ul>

		<p>These facts have been adapted from Australian Drug Foundation and the Drug and Alcohol Office.</p>

	</section>


</div>
</section>
<section class="tips accordian">
<div class="heading">
	<p>Tips</p>
	<i class="icn down-arrow"></i>
</div>
<div class="acc-content">

	<section>

		<h3>Look after yourself and your friends</h3>

		<ul>

			<li><strong>Look out for your friends</strong> - Don’t leave your mates on their own. Make it easy for them to look after you by sticking with them or letting them know where you’re going.</li>
			<li><strong>Be yourself</strong> - If you don't feel like another drink or want to drink at your own pace speak up, real friends should respect that.
			<li><strong>Plan your way home</strong> – Before you go out discuss with your friends who is going to be the designated driver. If no-one wants to drive make sure you have enough money to get a taxi home. Remember drinking and driving doesn’t mix, not for you and not for your friends. Make sure your driver knows that it is not OK to drink if they have been designated to get everyone home.
			<li><strong>Charge your phone</strong> – before you go out just in case you get separated from your friends or you need to call someone for help.
			<li><strong>Trust your instincts</strong> – if you don’t feel safe you probably aren’t.</li>
			<li><strong>Say no to violence</strong> – report violence or threats of violence to police.</li>
			<li><strong>Drink spiking</strong> – watch your drinks. Drink spiking happens - to girls and guys. To protect yourself, only accept drinks from people you don't know if they are unopened cans or bottles. Never leave your drink unattended and keep a thumb over the top of your bottle, if you are unsure if your drink has been spiked, leave it.</li>
			<li><strong>No means no</strong> – it’s OK to say no to sex and pressuring someone else into having sex is sexual assault and illegal. If there's any possibility that you may end up in bed with someone - carry a condom with you.</li>

		</ul>

	</section>

	<section>

		<h3>How many have you had?</h3>

		<p>Do you know what a <a href="http://alcohol.gov.au/internet/alcohol/publishing.nsf/Content/standard" target="_blank" title="Standard Drink information">standard drink</a> is? It's a measurement of alcohol and it isn't always the same as a bottle/can/glass. Most drinks are more than a single 'standard drink' so you could be consuming more than you think. Safe drinking guidelines are based on this measurement so it pays to know what they are. Set a limit at the start of the night and stick to it. Avoid topping up your drink so you can actually keep track.</p>

	</section>

	<section>

		<h3>Think before drinking</h3>

		<ul>

			<li><strong>Eat and drink water</strong> - if you drink alcohol make sure you eat beforehand, and drink water between alcoholic drinks. Spacing your drinks with water or soft drinks will keep you hydrated and in control. </li>
			<li><strong>Stay on the right side of the law </strong>- giving your friends who are under 18 alcohol is illegal. Penalties may apply. </li>
		</ul>
	</section>

	<section>
		<h3>Know what to do if you get in trouble</h3>
		<ul>
			<li><strong>Learn basic first aid </strong> –  if a friend is drunk or sick, stay with them. If they want to lie down, put them on their side in case they vomit.</li>
			<li><strong>Call triple zero (000)</strong> – if someone passes out or looks like they’re in trouble. Paramedics don’t need to involve the police.</li>

		</ul>

		<p>These tips were adapted from the <a href="http://theothertalk.org.au/safe-partying-tips-for-schoolies" target="_blank" title="Australian Drug Foundation">Australian Drug Foundation</a>, the <a href="http://www.alcohol.gov.au/internet/alcohol/publishing.nsf/Content/C6738D5F231CC231CA25767200820337/$File/young.pdf" target="_blank" title="Department of Health and Aging">Department of Health and Aging</a> and the <a href="http://www.alcohol.gov.au/internet/alcohol/publishing.nsf/Content/guide-young" target="_blank" title="Department of Health">Department of Health</a>.</p>

	</section>

</div>
</section>
<?php
$services = Partner::loadServices( $partner->data['id'] );
if ( !empty( $services ) ) {
?>
<section class="support accordian">
	<div class="heading">
		<p>Support</p>
		<i class="icn down-arrow"></i>
	</div>
	<div class="acc-content">
		<section>

			<div class="support-info">

				<?php
				foreach ( $services as $service ) {
					?>

					<div class="contact-group">

						<h4><?php echo htmlentities( $service['name'] ); ?></h4>
						<ul>
							<li><i class="icn green-phone-sm"></i><strong>Phone</strong> <span><?php echo nl2br( htmlentities( $service['contact_numbers'] ) ); ?></span>
							</li>
							<li><i class="icn green-pins"></i><strong>Address</strong> <span><?php echo nl2br( htmlentities( $service['address'] ) ); ?></span></li>
							<li><i class="icn green-clock"></i><strong>Opening hours</strong> <span><?php echo nl2br( htmlentities( $service['opening_hours'] ) ); ?></span></li>
							<li><i class="icn green-fees"></i><strong>Fees</strong> <span><?php echo htmlentities( $service['fees'] ); ?></span></li>
							<?php
							if ( !empty( $service['website'] ) ) {
								?>
								<li><i class="icn green-globe"></i><strong>Website</strong> <span><a href="<?php echo htmlentities( $service['website'] ); ?>"><?php echo htmlentities( $service['website'] ); ?></a></span></li>
							<?php
							}
							if ( !empty( $service['additional_info'] ) ) {
								?>
								<li><i class="icn green-additional"></i><strong>Additional info</strong> <span><?php echo nl2br( htmlentities( $service['additional_info'] ) ); ?></span></li>
							<?php
							}
							?>
						</ul>
					</div>
				<?php
				}
				?>

			</div>

		</section>
	</div>
</section>
	<?php
}
?>
