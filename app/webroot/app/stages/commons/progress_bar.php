<?php $stages = get_stages(); ?>

<section class="progress step-<?php echo $stages[$page_vars['target_stage']]['number_in_letters']; ?>">

	<div class="line"></div>
	<div class="line current-pos"></div>

	<?php foreach ($stages as $stage => $info): ?>
		<div class="step <?php echo $info['name']; ?>">
			<i class="icn<?php echo empty($info['icon_class']) ? '' : ' ' . $info['icon_class']; ?>"></i>
			<?php if ($stage == $page_vars['target_stage']): ?>
				<span><?php echo $info['title']; ?></span><i class="icn arrow"></i>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>

</section><!-- progress -->
