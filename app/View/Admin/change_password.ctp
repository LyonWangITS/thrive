<?php
$this->set( 'title_for_layout', 'My account' );
$this->Html->meta( 'description', 'Thrive - Your Health Online. Alcohol Survey', array( 'inline' => false ) );
$this->Html->meta( 'keywords', 'Alcohol Survey, University, Tertiary, Polytechnic.', array( 'inline' => false ) );

//pr( $this->validationErrors );

echo '<div id="content">';

if ( !empty( $current_user['Account']['is_admin'] ) ) {

	echo '<h1>My account</h1>';
}

else {
	
	echo '<h1>Change password</h1>';
}

echo '<div class="content-padding admin">';

echo $this->Form->create( 'Account' );

	if ( !empty( $current_user['Account']['is_admin'] ) ) {

		echo '<h2>Email address</h2>';
		?>
		<div class="input text">
			<label>Registered email</label>
			<?php p( $current_user['Account']['email'] ); ?>
		</div>
		<?php
		echo $this->Form->input( 'Account.new_email', array( 'label' => 'New email', 'error' => $no_html_escape, 'autocomplete' => 'off' ) );
		echo $this->Form->input( 'Account.retype_email', array( 'label' => 'Retype email', 'error' => $no_html_escape, 'autocomplete' => 'off' ) );
	}

	echo '<h2>Change password</h2>';
	echo $this->Form->input( 'Account.new_password', array( 'type' => 'password', 'label' => 'New password', 'autocomplete' => 'off' ) ); 
	echo $this->Form->input( 'Account.retype_password', array( 'type' => 'password', 'label' => 'Confirm new password', 'required' => false, 'autocomplete' => 'off' ) ); 
	?>
	<div class="submit">
		<input class="btn green-btn" type="submit" value="Update" />
	</div>
<?php
echo $this->Form->end();
?>
</div>

</div>