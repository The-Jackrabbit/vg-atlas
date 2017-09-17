<?php session_start();?>
<html lang="en">
   <head>
      <link rel="stylesheet" href="./Assets/reset.css" />
      <link rel="stylesheet" href="./Assets/styles.css" />
		<link href="https://fonts.googleapis.com/css?family=Work+Sans:200" rel="stylesheet">
		<script src="./Assets/jquery.min.js"></script>
		<link rel="icon" href="./Assets/favicon.ico" />
	</head>
      <body>
             <?php
			$actionLinks = Array(
				"login.php" => "Login",
				"signup.php" => "Signup"
			);
			if ($_SESSION["userId"] !== null) {
				$actionLinks = Array(
					"./Helpers/logout.php" => "Sign Out"
				);
			}
         	$pkg = Array(
            	"title" => "BackLog",
				"title_url" => "dashboard.php",
				"links" => Array(
					"usermaps.php" => "Maps",
					"create.php" => "Create"
				),
				"activeLink" => "",
               	"actionLinks" => $actionLinks
            );
        	include("./Components/header/header.php");
      	?>
		<div class="max-inline">
			
		</div>
   </body>
</html>
