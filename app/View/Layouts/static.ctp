<!doctype html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<meta name="viewport" content="user-scalable=yes, width=device-width">
	<?php echo $this->fetch('meta'); ?>

	<title><?php echo $title_for_layout; ?> - THRIVE</title>
	
	<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/ui-lightness/jquery-ui-1.10.3.custom.css" type="text/css">
	<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/draft.css" type="text/css">
	<?php echo $this->fetch( 'css' ); ?>
	<link rel="shortcut icon" href="<?php echo $this->webroot; ?>images/favicon.ico">
	
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
	
	<?php echo $this->fetch( 'script' ); ?>
   
</head>
<body>
	<div class="top-border"></div>
	
	
	<div class="container">
		
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch( 'content' ); ?>
			<div class="clear"></div>

	
			<div class="push"></div>
	</div>
	
	
		
	<div id="footer">
	
		<p id="footer-copyright">&copy;<?php echo date( 'Y' ); ?> THRIVE</p>
		
	</div>
	
	<div class="clear"></div>
	
	
	<?php echo $this->element('sql_dump'); ?>



</body>
</html>
