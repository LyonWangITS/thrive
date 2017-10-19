<section class="compare">
	<?php
	$consumption = ifne( $page_meta, 'consumption' );

	$consumption_typical_day = ifne ( $consumption, 'typical_day' );
	$consumption_per_week = ifne( $consumption, 'per_week' );
	$consumption_per_month = ifne( $consumption, 'per_month' );

	if ( $consumption_typical_day > $page_meta['average_per_occasion'] || $consumption_per_week > $page_meta['average_per_week'] ) {
		?>
		<p class="title">How do you compare?</p>

		<div class="compare-wrap">

			<?php if ( $consumption_typical_day > $page_meta['average_per_occasion'] ){ ?>
				<p>You reported having approximately <?php echo h( number_format( $consumption_typical_day, 2 ) ) ?> drinks on a typical occasion. This is a comparison with other people your age.</p>
				<div class="bar-set set-one clearfix">

					<div class="label">
						Standard drinks on a typical occasion
					</div>

					<div class="bar-wrap">


						<div class="bar avg-score" data-width="<?php echo number_format( $page_meta['average_per_occasion'] / $consumption_typical_day * 100, 2 ) ?>"><div class="bar-label avg">Avg</div><span><?php echo number_format( $page_meta['average_per_occasion'], 2 ) ?></span></div>

						<div class="bar your-score" data-width="100"><div class="bar-label you">You</div><span><?php echo h( number_format( $consumption_typical_day, 2 ) ) ?></span></div>

					</div>

				</div><!-- set-one -->
			<?php  } ?>

			<?php  if ( $consumption_per_week > $page_meta['average_per_week'] ) { ?>
				<p>You reported consuming approximately <?php echo h( number_format( $consumption_per_week, 2 ) ) ?> drinks per week, and <?php echo h( number_format( $consumption_per_month, 2 ) ) ?> drinks per month. This is a comparison with other people your age.</p>
				<div class="bar-set set-two clearfix">

					<div class="label">
						Standard drinks per week
					</div>

					<div class="bar-wrap">

						<div class="bar avg-score" data-width="<?php echo number_format( $page_meta['average_per_week'] / $consumption_per_week * 100, 2 ) ?>"><div class="bar-label avg">Avg</div><span><?php echo number_format( $page_meta['average_per_week'], 2) ?></span></div>
						<div class="bar your-score" data-width="100"><div class="bar-label your">You</div><span><?php echo h( number_format( $consumption_per_week, 2 ) ) ?></span></div>

					</div>

				</div>
			<?php  } ?>

		</div>
		<?php
	}
	?>

</section>
