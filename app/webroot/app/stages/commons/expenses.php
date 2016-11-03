
<?
	$expenses = ifne( $page_meta, 'expenses' );
	$expenses_from = ifne( $expenses, 'from' );
	$expenses_to = ifne( $expenses, 'to' );
?>
<section class="spend clearfix">
	
	<div class="cash">
		<img class="cash-img cash-one" src="<?php echo BASE_URL; ?>images/cash-5.png" alt="cash" />
		<img class="cash-img cash-two" src="<?php echo BASE_URL; ?>images/cash-10.png" alt="cash" />
		<img class="cash-img cash-three" src="<?php echo BASE_URL; ?>images/cash-50.png" alt="cash" />
		<img class="cash-img cash-four" src="<?php echo BASE_URL; ?>images/cash-100.png" alt="cash" />
		<img class="cash-img cash-five" src="<?php echo BASE_URL; ?>images/cash-20.png" alt="cash" />
	</div>
	
	<div class="text">
		<p class="title">Depending on where you buy your drinks, you have spent between <strong>$<?= $expenses_from ?> and $<?= $expenses_to ?></strong> on alcohol in the last year</p>
			
	</div>
	
</section><!-- spend -->