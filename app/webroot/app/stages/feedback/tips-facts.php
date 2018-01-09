<section>
	<h2><?php echo $sections['intro']['label']; ?></h2>
	<?php if (!empty($sections['intro']['content'])): ?>
		<p><?php echo $sections['intro']['content']; ?></p>
	<?php endif; ?>
</section>

<?php foreach ($sections['content'] as $section): ?>
	<section>
		<h3><?php echo $section['label']; ?></h3>
		<?php if (!empty($section['content'])): ?>
			<?php $rows = is_array($section['content']) ? $section['content'] : array($section['content']); ?>
			<?php foreach ($rows as $row): ?>
				<p><?php echo $row; ?></p>
			<?php endforeach; ?>
		<?php endif; ?>
		<?php if (!empty($section['list'])): ?>
			<ul>
				<?php foreach ($section['list'] as $item): ?>
					<li><?php echo $item; ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<?php if (!empty($section['secondary_content'])): ?>
			<?php $rows = is_array($section['secondary_content']) ? $section['secondary_content'] : array($section['secondary_content']); ?>
			<?php foreach ($rows as $row): ?>
				<p><?php echo $row; ?></p>
			<?php endforeach; ?>
		<?php endif; ?>
	</section>
<?php endforeach; ?>
