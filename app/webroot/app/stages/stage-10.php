<?php $the_audit_score = ifne( $page_meta, 'audit_score' ); ?>
<script type="text/javascript" src="<?php echo BASE_URL; ?>js/final_page_scroll_detect.js" defer></script> 

<section class="summary">

	<p>Some of the questions you answered regarding your drinking come from the Alcohol Use Disorders Identification Test, a questionnaire developed by the World Health Organisation to determine whether a person's drinking might be becoming problematic. Your answers to these questions provided the following result.</p>

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

		<h2>Your AUDIT score is <strong><?php echo $the_audit_score ?></strong></h2>

		<div class="description">

			<p class="range">You fall into the <strong><?php echo $audit_range ?> <?php echo $audit_result_label ?> Range</strong></p>

			<?php if ($the_audit_score >= 0 && $the_audit_score <= 7): ?>
				<!-- 0-7 Moderate Drinking -->
				<p>Low risk of alcohol related harm</p>
			<?php elseif ($the_audit_score >= 8 && $the_audit_score <= 15): ?>
				<!-- 8-15 Hazardous drinking -->
				<p>High risk of experiencing alcohol related harm and some people in this range may already be experiencing significant harm.</p>
			<?php elseif ($the_audit_score >= 16 && $the_audit_score <= 19 ): ?>
				<!-- 16-19 Harmful drinking -->
				<p>A person scoring in this range will already be experiencing significant alcohol related harm.</p>
			<?php elseif ($the_audit_score >= 20): ?>
				<!-- //2-40 Alcohol dependence -->
				<p>A person scoring in this range may be alcohol dependent and advised to have a clinical assessment of their drinking.</p>
			<?php endif; ?>

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
?>

</div><!-- content -->

<?php foreach (get_feedback_sections() as $key => $section): ?>
	<section class="<?php echo $key; ?> accordian">
		<div class="heading">
			<p><?php echo $section['label']; ?></p>
			<i class="icn down-arrow"></i>
		</div>
		<div class="acc-content"><?php include 'feedback/section.php'; ?></div>
	</section>
<?php endforeach; ?>

<?php $services = Partner::loadServices($partner->data['id']); ?>
<?php if (!empty($services)): ?>
	<section class="support accordian">
		<div class="heading">
			<p>Support</p>
			<i class="icn down-arrow"></i>
		</div>
		<div class="acc-content"><?php include 'feedback/support.php'; ?></div>
	</section>
<?php endif; ?>
