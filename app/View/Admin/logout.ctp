<?php
$this->set( 'title_for_layout', 'You are now logged out' );
$this->Html->meta( 'description', '', array( 'inline' => false ) );
$this->Html->meta( 'keywords', '', array( 'inline' => false ) );
$this->set( 'header_element', 'account' );
?>

<p class="breadcrumb">
	<a href="/admin/login">Login</a> /
	<strong>Log out</strong>
</p>

<div id="content">

<h1>You are now logged out</h1>
    
    
   <div class="content-padding admin">
	   
	   <a class="btn d-purple" href="/admin/login">Return to Login</a>
	
   </div>

</div>

