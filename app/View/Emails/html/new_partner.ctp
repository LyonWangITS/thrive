
<p>Hello <?php p( $partner['Account']['name'] ); ?>,</p>

<p>Thank you for registering <strong><?php p( $partner['Partner']['name'] ); ?></strong> with THRIVE. We will review your application and be in touch.</p>

<p>If you need to update your organisation's details, you can <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/login">log in</a> with the following details:</p>

<p>
	<strong>URL: </strong> <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/login">http://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/login</a>
	<strong>Email:</strong> <?php p( $partner['Account']['email'] ); ?><br />
	<strong>Password:</strong> <?php p( $new_password ); ?>
</p>

