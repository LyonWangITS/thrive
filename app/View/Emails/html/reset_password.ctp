
<p>Hello <?php p( $account['Account']['name'] ); ?>,</p>

<p>Your THRIVE password has been reset.</p>

<p>
	<strong>Email:</strong> <?php p( $account['Account']['email'] ); ?><br />
	<strong>Password:</strong> <?php echo $new_password; ?><br />
</p>
