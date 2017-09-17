<?php session_start();?>
<html lang="en">
   <head>
        <link rel="stylesheet" href="./Assets/reset.css" />
    	<link rel="stylesheet" href="./Assets/styles.css" />
		<link rel="icon" href="./Assets/favicon.ico" />
		<link href="https://fonts.googleapis.com/css?family=Lora" rel="stylesheet">	
		<link href="https://fonts.googleapis.com/css?family=Work+Sans:200" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lora" rel="stylesheet">		
		<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" integrity="sha512-M2wvCLH6DSRazYeZRIm1JnYyh22purTM+FDB5CsyxtQJYeKq83arPe5wgbNmcFXGqiSH2XR8dT/fJISVA1r/zQ==" crossorigin=""/>
    	<script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js" integrity="sha512-lInM/apFSqyy1o6s89K4iQUKg6ppXEgsVxT35HbzUupEVRh2Eu9Wdl4tHj7dZO0s1uvplcYGmt3498TtHq+log==" crossorigin=""></script>
		 <style>
			input.search {
				width: 100%;

			}
			table.cover {
				display: inline-block;
				margin: 12pt;
				text-align: center;
			}
			img.cover {
				width: 120pt;
				height: 200pt;
			}
			div.game-library {
				margin: 0 auto;
			}
			tr.title {
				max-width: 120pt;
			}
			tr.title  td {
				padding: 12pt;
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
			<?php 
				include("./Helpers/connectToDatabase.php");
				$items = mysqli_query($con, "
					SELECT *
					FROM videoGames
					WHERE videoGameId in (
						SELECT distinct(videoGameId)
						FROM userMaps
						WHERE userId = $_SESSION[userId]
					);
				");
				include("./Helpers/disconnectFromDatabase.php");
				if ($items->num_rows > 0) {
					while ($row = $items->fetch_assoc()) {
						echo "<a href='./map.php?gameId=$row[videoGameId]'><table class='cover'>
									<tr class='cover'>
										<td>
											<img class='cover' src='./Assets/GameCovers/$row[coverPath]'>
										</td>
									</tr>
									<tr class='title'>
										<td>
											$row[name]
										</td>
									</tr>
								<td>
									
								</td>";
						
						echo "</table></a>";
					}
				}
			?>
			<form action="./search.php" method="POST">
				<input class="search" type="text" placeholder="Search..." name="search">
			</form>
			<?php 
				include("./Helpers/connectToDatabase.php");
				$items = mysqli_query($con, "
					SELECT *
					FROM videoGames
					WHERE videoGameId NOT in (
						SELECT distinct(videoGameId)
						FROM userMaps
						WHERE userId = $_SESSION[userId]
					);
				");
				include("./Helpers/disconnectFromDatabase.php");
				if ($items->num_rows > 0) {
					while ($row = $items->fetch_assoc()) {
						echo "<a href='./map.php?gameId=$row[videoGameId]'><table class='cover'>
									<tr class='cover'>
										<td>
											<img class='cover' src='./Assets/GameCovers/$row[coverPath]'>
										</td>
									</tr>
									<tr class='title'>
										<td>
											$row[name]
										</td>
									</tr>
								<td>
									
								</td>";
						
						echo "</table></a>";
					}
				}
			?>
		</div>
   </body>
</html>