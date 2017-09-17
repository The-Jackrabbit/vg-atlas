<?php 
	$username = $_POST["username"];
	include("connectToDatabase.php");

	// Perform queries 
	$result = mysqli_query($con,"
		SELECT * 
		FROM users 
		WHERE username='$username'");
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			if ($_POST["password"] == $row["password"]) {
				//echo "eyyyyyyyy";
				session_start();
				$_SESSION["userId"] = $row["userId"];
				$_SESSION["firstName"] = $row["firstName"];
				$_SESSION["username"] = $username;
				header("Location: http://localhost:9999/home.php"); /* Redirect browser */
				
			} else {
				//echo "ya fucked up kid";
				
			}
		}
		
	} else {
		header("Location: http://localhost:9999/login.php?redirect=true"); /* Redirect browser */
		
	}
?>