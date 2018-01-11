<?php $vars = $page_vars['tabular']; ?>
<?php $n_cols = count($vars['columns']); ?>

<div class="field tabular-intro clearfix cols-<?php echo $n_cols . (empty($vars['image_name']) ? '' : ' with-image'); ?>">

	<i class="icn number"><?php echo $vars['section_number']; ?></i>

	<?php foreach ($vars['intro'] as $row): ?>
		<p><?php echo $row; ?></p>
	<?php endforeach; ?>

	<?php if (!empty($vars['image_name'])): ?>
		<div class="image <?php echo $vars['image_name']; ?>">
			<img src="<?php echo BASE_URL; ?>images/<?php echo $vars['image_name']; ?>.png" alt="<?php echo empty($vars['image_desc']) ? $vars['image_name'] : $vars['image_desc']; ?>" />
		</div>
	<?php endif; ?>

	<div class="labels-wrapper">
		<div class="labels-wrapper-inner">
			<div class="labels">
				<?php foreach ($vars['columns'] as $title): ?>
					<span><?php print $title; ?></span>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

</div><!-- field -->

<?php foreach ($vars['rows'] as $row_name => $title): ?>
	<div class="field radio-set tabular clearfix cols-<?php echo $n_cols; ?>">
		<p><?php print $title; ?></p>
		<div class="input-wrap">
			<?php foreach ($vars['columns'] as $col_name => $title): ?>
				<?php $id = $row_name . '-' . $col_name; ?>
				<input type="radio" name="<?php echo $row_name; ?>" id="<?php echo $id; ?>" value="<?php echo $col_name; ?>" />
				<label for="<?php echo $id; ?>"><span><?php echo $title; ?></span></label>
			<?php endforeach; ?>
		</div>
	</div><!-- field -->
<?php endforeach; ?>
