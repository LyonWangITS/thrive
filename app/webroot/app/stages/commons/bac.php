<section class="bac clearfix">
	<?php
		$bac = round(floatval( ifne( $page_meta, 'bac' ) ), 2);
	?>
	<div class="text">

		<p class="title">Your estimated Blood Alcohol Content (BAC) for your heaviest drinking occasion is <strong><span><?php echo number_format( $bac, 2 ) ?></span>%</strong></p>

		<?php
			// 0.0->0.02 doesn't show any memo
			if ( ( $bac >= 0.02 ) && ( $bac <= 0.04 ) ){
		?>
		<p>At a BAC between 0.05-0.09 you are 11 times more likely to be killed in a single-vehicle crash than a driver with a zero BAC.</p>
		<?php
			} elseif ( ( $bac >= 0.05 ) && ( $bac <= 0.09 ) ) {
		?>
		<p>At a BAC between 0.05-0.09 you are 11 times more likely to be killed in a single-vehicle crash than a driver with a zero BAC.</p>
		<?php
			} elseif ( ( $bac >= 0.10 ) && ( $bac <= 0.14 ) ) {
		?>
		<p>At a BAC between 0.10 to 0.14 you are 48 times more likely to be killed in a single-vehicle crash than a driver with a zero BAC.</p>
		<?php
			} elseif ( ( $bac >= 0.15 ) ) {
		?>
		<p>At a BAC between 0.15 and above you are 380 times more likely to be killed in a single- vehicle crash than a driver with a zero BAC.</p>
		<?php
			}
		?>

	</div>

	<div class="metre">
		<div class="face"></div>
		<div class="hand"></div>
	</div>

</section>

<section class="did-you-know">

	<div class="article-wrap">
		<p class="title">Did you know?</p>

		<?php /*
		<div class="cycle-slideshow"
			data-cycle-slides="> article"
			data-cycle-pager=".pager"
			data-cycle-pager-template="<a href=# class=icn> {{slideNum}} </a>"
			data-cycle-prev=".go-left"
			data-cycle-next=".go-right"
			data-cycle-fx="scrollHorz"
			data-cycle-pause-on-hover="true"
			data-cycle-speed="600"
			data-cycle-swipe="true">
		*/
		?>

		<article>
			<p>Your BAC is an indication of how intoxicated you are, with a higher BAC corresponding with a greater likelihood of experiencing alcohol-related harm, especially when driving.</p>
			<p>This estimate takes into account your gender, weight, the number of standard drinks consumed and the number of hours over which you reported drinking this amount.</p>
		</article>

		<?php /* </div> */ ?>

	</div><!-- article-wrap -->

	<?php /*
	<a href="#" class="icn go-left nav">&lt</a>
	<a href="#" class="icn go-right nav">&lt</a>

	<div class="pager"></div>
	*/ ?>

</section><!-- did you know -->
