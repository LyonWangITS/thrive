<?php $vars = $page_vars['intro']; ?>

<section class="intro">

	<h1><?php echo $vars['title']; ?></h1>

	<?php foreach ($vars['description'] as $row): ?>
		<p><?php echo $row; ?></p>
	<?php endforeach; ?>

</section><!-- intro -->
