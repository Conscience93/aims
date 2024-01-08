<?php
    ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	date_default_timezone_set('Asia/Kuala_Lumpur');

	$dbhost		= "localhost";	//your database server
	$dbuser		= "root";		//user to access your database
	$dbpassword	= ""; 			//password to access your database
	$dbname		= "aims"; 		//name of database
	$db_audit   = 'aims_audit';

	//MySQL connection
	$con = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
	$con_audit = mysqli_connect($dbhost, $dbuser, $dbpassword, $db_audit);
?>
	