<?php
$stages = get_stages();
$stage = $stages[$page_vars['target_stage']];
?>

<section class="progress group-<?php echo $stage['group']; ?> step-<?php echo $stage['step']; ?>">
	<div class="line"></div>
	<div class="line current-pos"></div>

	<?php foreach ($stages as $stage => $info): ?>
		<div class="step s-<?php echo $info['group']; ?>">
			<i class="icn"></i>
			<?php if ($stage == $page_vars['target_stage']): ?>
				<span><?php echo $info['title']; ?></span><i class="icn arrow"></i>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>

</section><!-- progress -->
