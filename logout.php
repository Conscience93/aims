<?php
	session_start();

	// Clear all session variables
	session_unset();

	// Destroy the session
	session_destroy();

	// Redirect to the base URL after session destruction
	header('location: /aims/');
	
	exit;
?>
