<?php session_start();?>
<html lang="en">
   <head>
      <link rel="stylesheet" href="./Assets/reset.css" />
      <link rel="stylesheet" href="./Assets/styles.css" />
		<link rel="icon" href="./Assets/favicon.ico" />
		<link href="https://fonts.googleapis.com/css?family=Work+Sans:200" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lora" rel="stylesheet">
		<script src="./Assets/jquery.min.js"></script>
		<style>
			.signup {
				background-color: #F0AF45 !important;
				padding:  5pt 15pt !important;
				border-radius: 50pt !important;
				border: none !important;
				color: white;
				font-weight: bold;
				margin: 0 auto;
			}
			
		</style>
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
				<?php include("./Components/timeline/timeline.php"); ?>
			<hr>
			<form "./signup.php" style="margin: 0 auto; width: min-content;">
				<input class="signup" type="submit" value="Sign Up">
			</form>
		</div>
   </body>
</html>
