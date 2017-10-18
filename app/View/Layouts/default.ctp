<!doctype html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<meta name="viewport" content="user-scalable=yes, width=device-width">
	<?php echo $this->fetch('meta'); ?>

	<title><?php echo $title_for_layout; ?> - THRIVE</title>
	
	<link rel="stylesheet" href="<?php echo $this->webroot; ?>ui-lightness/jquery-ui-1.10.3.custom.css" type="text/css">
	<link rel="stylesheet" href="<?php echo $this->webroot; ?>js/jqplot/jquery.jqplot.css" type="text/css">
	<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/draft.css" type="text/css">
	<?php echo $this->fetch( 'css' ); ?>
	
	<link rel="shortcut icon" href="<?php echo $this->webroot; ?>images/favicon.ico">
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js" type="text/javascript"></script>
	
	<?php echo $this->fetch( 'script' ); ?>
   
</head>

<body class="admin <?php if ( strpos( $this->here, 'reports' ) ) {echo 'reports';} ?>">

	<div class="wrapper">

		<header class="clearfix">
			
			<div id="header-login">
				<?php
				if ( !empty( $current_user ) ) {
					?>
					<a class="icn logout" title="Logout" href="<?php echo $this->webroot; ?>admin/logout">Logout</a>
					<?php
				}
				?>
			</div>
			
			<a href="<?php echo $this->webroot; ?>" class="logo" title="THRIVE Portal">
				<img src="<?php echo $this->webroot; ?>images/portal-logo.png" alt="THRIVE Portal" />
			</a>
		
			<div id="nav">
				<?php
				if ( !empty( $current_user ) ) {
	
					if ( !empty( $current_user['Account']['is_admin'] ) ) {
						// Super admin nav
						?>
						<ul id="nav-top">
							<li class="<?php if ( $this->here == $this->webroot . 'admin' ) {echo 'active';} ?>"><a href="<?php echo $this->webroot; ?>admin">Dashboard</a></li>
							<li class="<?php if ( strpos( $this->here, '/partners' ) !== false ) {echo 'active';} ?>"><a href="<?php echo $this->webroot; ?>partners/view">Partners</a></li>
							<li class="<?php if ( $this->here == $this->webroot . 'admin/change_password' ) {echo 'active';} ?>"><a href="<?php echo $this->webroot; ?>admin/change_password"><i class="icn settings"></i> Account</a></li>
						</ul>
						<?php
					}
					else {
						// User nav
						?>
						<ul id="nav-top">
							<li class="<?php if ( $this->here == $this->webroot . 'admin' ) {echo 'active';} ?>"><a href="<?php echo $this->webroot; ?>admin">Dashboard</a></li>
							<li class="<?php if ( strpos( $this->here, '/reports' ) !== false ) {echo 'active';} ?>"><a href="<?php echo $this->webroot; ?>reports"><i class="icn analytics"></i> Reports</a></li>
							<li class="<?php if ( $this->here == $this->webroot . 'admin/details' ) {echo 'active';} ?>"><a href="<?php echo $this->webroot; ?>admin/details"><i class="icn settings"></i> Account</a></li>
						</ul>
						
						<?php
					}
				}
				?>
			</div>
			
		</header>
	
			
			
		<div class="container">
		
			
			<?php
			if ( strpos( $this->here, 'reports' ) ) { ?>
			<div id="sub-nav">
				
				<ul>
					<li class="<?php if ( strpos( $this->here, '/reports/view/demographics' ) !== false ) {echo 'active';} ?>"><a href="<?php echo $this->webroot; ?>reports/view/demographics"><i class="icn demographics"></i> Demographics</a></li>
					<li class="<?php if ( strpos( $this->here, '/reports/view/consumption' ) !== false ) {echo 'active';} ?>"><a href="<?php echo $this->webroot; ?>reports/view/consumption"><i class="icn consumption"></i> Alcohol consumption</a></li>
					<li class="<?php if ( strpos( $this->here, '/reports/view/related_harm' ) !== false ) {echo 'active';} ?>"><a href="<?php echo $this->webroot; ?>reports/view/related_harm"><i class="icn harm"></i> Alcohol-related harm</a></li>
					<li class="<?php if ( strpos( $this->here, '/reports/view/feedback' ) !== false ) {echo 'active';} ?>"><a href="<?php echo $this->webroot; ?>reports/view/feedback"><i class="icn feedback"></i> Participant feedback</a></li>
					<li class="<?php if ( strpos( $this->here, '/reports/export' ) !== false ) {echo 'active';} ?>"><a href="<?php echo $this->webroot; ?>reports/export"><i class="icn export"></i> Export data</a></li>
				</ul>
				</div>
				<?php
			}
			?>
		

				<?php echo $this->Session->flash(); ?>
				<?php echo $this->fetch( 'content' ); ?>
				<div class="clear"> </div>

		
			<div class="push"></div>
		
		</div>

	
	</div>
	
	<div id="footer">
	
		<p id="footer-copyright">&copy;<?php echo date( 'Y' ); ?> THRIVE</p>
		
	</div>
	
	<?php echo $this->element('sql_dump'); ?>
	
</body>
</html>
