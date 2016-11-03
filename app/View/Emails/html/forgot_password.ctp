<?php 
$link = 'http://' . $_SERVER['HTTP_HOST'] . '/admin/reset_password/' . $account['Account']['id'] . '/' . $reset_code;
?>

<p>Hello <?php p( $account['Account']['name'] ); ?>,</p>

<p>You have received this email because somebody has made a request to reset your THRIVE password.</p>

<p>If this was not you, please ignore this email.</p>

<p>To reset your password, visit the following link:<br /> <a href="<?php echo $link; ?>"><?php echo $link; ?></a></p>
