<?php 
	session_start();
	if (!is_null($_SESSION['userId'])) {
		header("Location: http://localhost:9999/home.php"); /* Redirect browser */
	}
?>
<html lang="en">
   <head>
      <link rel="stylesheet" href="./Assets/reset.css" />
      <link rel="stylesheet" href="./Assets/styles.css" />
		<link rel="icon" href="./Assets/favicon.ico" />
		<style>
			div.login-form {
				background-color: white;
				padding: 12pt;
				text-align: center;
			}
			div.login-form input[type=submit] {
				width: 100%;
				max-width: 200pt;
				height: 40pt;
				border: none;
				border-radius: 6pt !important;
				background-color: dodgerblue;
				color: white;
				margin-top: 24pt;
			}
			div.login-form input {
				width: 100%;
				border-radius: 0pt !important;
				border: none;
				margin: 4pt;
				border-bottom: 1pt solid lightgray;
			}
			a.signup-redirect {
				font-size: 7pt;
				
			}
			.login-banner {
				height: 200pt;
				width: 100%;
				background-color: white; 
				position: absolute;
			}
			.login-banner svg {
				width: 200pt;
				height: 200pt;
				position: relative;
				top: -60pt;
				transform: rotate(-30deg);
			}
			.login-banner svg path {
				stroke: none;
				fill: red;
				
			}
			.banner-text {
				z-index: 100;
				font-size: 48pt;
				font-weight: lighter;
				text-align: center;
				position: relative;
				top: 50%;
				transform: translateY(-50%);
			}
			.banner-padding {
				padding-bottom: 200pt;
			}
			body {
				background-color: white;
			}
		</style>
	</head>
   <body>
		<?php
			$actionLinks = Array(
				"login.php" => "Login",
				"signup.php" => "Signup"
			);
			if (!is_null($_SESSION['userId'])) {
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
		<div class="login-banner">
			<p class="banner-text">Login</p>
			<?php
				include("compass.svg");
			?>
			
		</div>
			<div class="banner-padding"></div>
		<div class="max-inline">
			<?php
				if ($_GET["redirect"]) {
					echo '<h1>you goofed, try again bozo</h1>';
				}
			?>
			<div class="login-form">
				<form action="./Helpers/submitLogin.php" method="POST">
					<input required type="text" placeholder="username" name="username">
					<input required type="password" placeholder="password" name="password">
					<input type="submit" value="Log In">
					<div><a href="./signup.php" class="signup-redirect">Don't have an account?</a></div>
				</form>
			</div>
		</div>
   </body>
</html>
