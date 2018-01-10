<section>
	<h2><?php echo $section['intro']['label']; ?></h2>
	<?php if (!empty($section['intro']['content'])): ?>
		<p><?php echo $section['intro']['content']; ?></p>
	<?php endif; ?>
</section>

<?php foreach ($section['content'] as $sub_section): ?>
	<section>
		<h3><?php echo $sub_section['label']; ?></h3>
		<?php if (!empty($sub_section['content'])): ?>
			<?php $rows = is_array($sub_section['content']) ? $sub_section['content'] : array($sub_section['content']); ?>
			<?php foreach ($rows as $row): ?>
				<p><?php echo $row; ?></p>
			<?php endforeach; ?>
		<?php endif; ?>
		<?php if (!empty($sub_section['list'])): ?>
			<ul>
				<?php foreach ($sub_section['list'] as $item): ?>
					<li><?php echo $item; ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<?php if (!empty($sub_section['secondary_content'])): ?>
			<?php $rows = is_array($sub_section['secondary_content']) ? $sub_section['secondary_content'] : array($sub_section['secondary_content']); ?>
			<?php foreach ($rows as $row): ?>
				<p><?php echo $row; ?></p>
			<?php endforeach; ?>
		<?php endif; ?>
	</section>
<?php endforeach; ?>
