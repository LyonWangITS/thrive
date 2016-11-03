<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?= h( ifne( $page_meta, 'title' ) ) ?></title>
	<?php
	if ( !empty( $page_meta['description'] ) ) {
		?>
		<meta name="description" content="<?= h( ifne( $page_meta, 'description')) ?>" />
		<?php
	}
	if ( !empty( $page_meta['keywords'] ) ) {
		?>
		<meta name="keywords" content="<?= h( ifne( $page_meta, 'keywords' ) ) ?>" />
		<?php
	}
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="robots" content="noindex">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css?t=150127">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/skeleton.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/sprites.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/dragdealer.css">
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/ie.css">
	<![endif]-->
	
	<link rel="author" href="<?php echo BASE_URL; ?>humans.txt" />

	<!-- Favicons -->
	<link rel="shortcut icon" href="<?php echo BASE_URL; ?>images/favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo BASE_URL; ?>images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo BASE_URL; ?>images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo BASE_URL; ?>images/apple-touch-icon-114x114.png">
	
</head>