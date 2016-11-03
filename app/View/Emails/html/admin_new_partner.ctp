
<p>Hello,</p>
<p>A new organisation has registered for THRIVE. Please review their account.</p>
<p>
	<strong>Organisation:</strong> <?php p( $partner['Partner']['name'] ); ?><br />
	<strong>Contact:</strong> <?php p( $partner['Account']['name'] ); ?><br />
	<strong>Email:</strong> <a href="mailto:<?php p( $partner['Account']['email'] ); ?>"><?php p( $partner['Account']['email'] ); ?></a><br />
	<strong>Phone:</strong> <?php p( $partner['Account']['phone'] ); ?><br />
	<?php
	if ( !empty( $partner['Partner']['website'] ) ) {
		?>
		<strong>Website:</strong> <?php p( $partner['Partner']['website'] ); ?><br />
		<?php
	}
	?>
</p>

<p>Please <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/login">log in</a> to review the request.</p>
