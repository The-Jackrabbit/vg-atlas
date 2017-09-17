<?php 
	session_start();
	session_destroy();
	header("Location: http://localhost:9999/login.php"); /* Redirect browser */
	
?>