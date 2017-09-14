<?php include_once 'header.php'; ?>

<body>
<div class="overlay"></div>
<div class="colours"></div>
<div class="bgimage internal"></div>

<section id="container">

	<div class="survey wrap">

		<?php include_once 'stage_header.php'; ?>

		<div class="content">

			<?php include_once 'progress_bar.php'; ?>
			<?php include_once 'intro.php'; ?>

			<?php if (!empty($page_vars['include_drinks_guide'])): ?>
				<?php include_once 'drinks-guide.php'; ?>
			<?php endif; ?>

			<section class="questions">

				<form class="stage-form<?php echo empty($page_vars['optional']) ? '' : ' optional'; ?>" method="post" action="survey.php?t=<?php echo h(urlencode(ifne($page_meta, 'token'))); ?>">

					<input type="hidden" name="survey-stage" value="<?php echo $target_stage; ?>" />

					<fieldset title="Please fill in the fields below">
						<legend><?php echo $page_vars['legend']; ?></legend>

						<?php if (!empty($page_vars['tabular'])): ?>
							<?php include 'tabular.php'; ?>
						<?php endif; ?>

						<?php $path = dirname(dirname(__FILE__)) . '/stage-0' . $target_stage . '.php'; ?>
						<?php if (file_exists($path)): ?>
							<?php include_once $path; ?>
						<?php endif; ?>

						<?php include_once 'submit.php'; ?>

					</fieldset>

				</form>

			</section><!-- questions -->

		</div><!-- content -->

	</div><!-- survey wrap -->

	<div class="push"></div>

</section><!-- container -->

<?php include_once 'footer.php'; ?>
