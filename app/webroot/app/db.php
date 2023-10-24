<?php
/*
	Database interface
*/

function getConnection() {
	
	// $dbh = new PDO('mysql:host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);	
	$dbh = new PDO('mysql:host=mysql; dbname=app_database_standard', 'root', 'password');
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	return $dbh;
	
}

