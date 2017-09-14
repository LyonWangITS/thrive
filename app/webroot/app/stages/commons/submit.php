<?php $vars = isset($page_vars['submit']) ? $page_vars['submit'] : array('include_incomplete_flag' => true); ?>

<div class="field submit">

	<?php if (!empty($vars['include_incomplete_flag'])): ?>
		<p class="incomplete"><i class="icn cross"></i> Please answer all questions</p>
		<p class="complete" style="display: none;"><i class="icn tick"></i> All questions have been answered</p>
	<?php endif; ?>

	<button type="submit"><?php echo empty($vars['title']) ? 'Next section' : $vars['title']; ?></button>

</div>
