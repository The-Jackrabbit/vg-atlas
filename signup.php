<html lang="en">
   <head>
      <link rel="stylesheet" href="./Assets/reset.css" />
      <link rel="stylesheet" href="./Assets/styles.css" />
		<link rel="icon" href="./Assets/favicon.ico" />
		<script src="./Assets/jquery.min.js"></script>
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
				background-color: red;
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
			div.login-form input[type=text], div.login-form input[type=password] {
				margin: 4pt 0pt;
				height: 30pt;
				width: 200pt;
			}
			a.signup-redirect {
				font-size: 7pt;
				
			}
			rect, path {
				fill: white;
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
				fill: dodgerblue;
				
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
		<div class="login-banner">
			<p class="banner-text">Signup</p>
			<?php
				include("compass-map.svg");
			?>
			
		</div>
		<div class="banner-padding"></div>
		<div class="max-inline">
			<div class="login-form">
				
				<form action="./Helpers/submitSignup.php" method="POST" id='signup-form'>
					<input type="text" placeholder="First Name" name="firstName">
					<input type="text" placeholder="Last Name" name="lastName">
					<input type="text" placeholder="Email" name="email" id="email">
					<input type="text" placeholder="Username" name="username" id="username">
					<input required type="password" placeholder="Password" name="password" id="password">
					<input required type="password" placeholder="Confirm Password" id="password-confirmation">
					<input type="submit" value="Sign Up">
				</form>
			</div>
		</div>
		<script>
			$("#signup-form").submit(function() {
				var password = $('#password').val();
				var confirmedPassword = $('#password-confirmation').val();
				if (password !== confirmedPassword){
					$('#password-confirmation').css('background-color', '#FFB2AD');
					return false;
				}
			});
			$('input').focus(function() {
				if ($(this).css("background-color") === 'rgb(255, 178, 173)') {
					$(this).css("background-color", "#FFEC9C");
				}
			});
			<?php
				if($_GET['email']=== '0') {
					echo '$("#email").css("background-color", "rgb(255, 178, 173)").attr("placeholder", "Email already in use");';
				}
				if ($_GET['user']=== '0') {
					echo '$("#username").css("background-color", "rgb(255, 178, 173)").attr("placeholder", "Username taken");';
				}
			?>
			
		</script>
   </body>
</html>
