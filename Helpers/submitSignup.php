<?php 
	//print_r($_POST);
	include("connectToDatabase.php");
	$checkNameAvailability = mysqli_query($con,"
		SELECT username 
		FROM users 
		WHERE username='$_POST[username]';");

	$checkEmailAvailability = mysqli_query($con,"
		SELECT email 
		FROM users 
		WHERE email='$_POST[email]';");
	$email = ($checkEmailAvailability->num_rows === 0?1:0);
	$name_result = ($checkNameAvailability->num_rows === 0?1:0);
	
	if ($email && $name_result) {
		$addUser = mysqli_query($con,"
			INSERT INTO users(username, email, password, firstName, lastName)
			VALUES
			('$_POST[username]', '$_POST[email]', '$_POST[password]', '$_POST[firstName]', '$_POST[lastName]');
		");
		header("Location: http://localhost:9999/home.php");
	} else {
		header("Location: http://localhost:9999/signup.php?user=$name_result&email=$email");
	}
		include("disconnectFromDatabase.php");
?>