<html>
<head>
</head>
<body>
	<style>
	h1 {
		color: black;
		font-family: arial, sans-serif;
		font-size: 23px;
		line-height: 24px;
	}
	h2 {
		color: black;
		font-family: arial, sans-serif;
		font-size: 19px;
		line-height: 24px;
	}
	h3 {
		color: black;
		font-family: arial, sans-serif;
		font-size: 19px;
		line-height: 24px;
	}
	p {
		color: black;
		font-family: arial, sans-serif;
		font-size: 14px;
		line-height: 24px;
	}
	a {
		color: black;
	}
	</style>
	<div>
		<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/images/email-logo.jpg" alt="THRIVE" width="198" height="142"></a>
	</div>

	<?php echo $this->fetch( 'content' ); ?>

	<p>Kind regards,<br />
	THRIVE</p>

	<p>Sent by THRIVE: <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>">http://<?php echo $_SERVER['HTTP_HOST']; ?></a></p>
</body>
</html>