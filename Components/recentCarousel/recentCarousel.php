<?php session_start();?>
<html lang="en">
	<head>
		<link rel="stylesheet" href="./Assets/reset.css" />
		<link rel="stylesheet" href="./Assets/styles.css" />
		<link rel="icon" href="./Assets/favicon.ico" />	
		
		<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script type="text/javascript" src="/Assets/slick/slick/slick.min.js"></script>
		<link rel="stylesheet" type="text/css" href="/Assets/slick/slick/slick.css"/>
		<link rel="stylesheet" type="text/css" href="/Assets/slick/slick/slick-theme.css"/>		
		<style>
			.recent-carousel-container {
				height: 200pt;
				padding: 8pt;
				background: rgb(0, 0, 0); /* For browsers that do not support gradients */
				background: -webkit-linear-gradient(rgb(0, 0, 0), rgb(50, 50, 50)); /* For Safari 5.1 to 6.0 */
				background: -o-linear-gradient(rgb(0, 0, 0), rgb(50, 50, 50)); /* For Opera 11.1 to 12.0 */
				background: -moz-linear-gradient(rgb(0, 0, 0), rgb(50, 50, 50)); /* For Firefox 3.6 to 15 */
				background: linear-gradient(rgb(0, 0, 0), rgb(50, 50, 50)); /* Standard syntax */
			}
			.recent-carousel-header {
				font-size: 18pt;
				color: white;
				border-bottom: 1pt solid lightgray;
				padding-bottom: 8pt;
			}
			#recent-carousel div {
				color: white !important;
			}
			.recent-carousel-body {
				width: 400pt;
				margin:0 auto;
				height: 180pt;
			}
			.slick-slide {
				padding: 12pt;
				height: 100%;
			}
			.slick-slide img {
				width: 100pt;
				height: 140pt;
				
			}
			.slick-list, .slick-slider, .slick-track{
				height: inherit !important;
			}
			.slick-current img {
			}
		
		</style>
		<script>
			$(document).ready(function(){
				$('#recent-carousel').slick({
					infinite: true,
					slidesToShow: 3,
					centerMode: true,
					responsive: [
						{
							breakpoint: 768,
							settings: {
							arrows: false,
							centerMode: true,
							centerPadding: '40px',
							slidesToShow: 3
							}
						},
						{
							breakpoint: 480,
							settings: {
							arrows: false,
							centerMode: true,
							centerPadding: '40px',
							slidesToShow: 1
							}
						}
					]
				});
			});
		</script>
	</head>
	<body>
		<?php
			$_SESSION["userID"] = 1;

			include("./Helpers/connectToDatabase.php");
			$query_main = "SELECT * FROM (";
			$items = mysqli_query($con, "
				SELECT distinct(gameId)
				FROM userGameVisits
				WHERE userId = $_SESSION[userId];
			");
			/*
				SELECT * FROM ((SELECT * FROM userGameVisits WHERE gameId = 1 AND userId = 1 ORDER BY visitTimeStamp desc LIMIT 1) UNION (SELECT * FROM userGameVisits WHERE gameId = 2 AND userId = 1 ORDER BY visitTimeStamp desc LIMIT 1)) AS VISITS JOIN videoGames ON VISITS.gameId = videoGames.videoGameId;
			*/
			include("./Helpers/disconnectFromDatabase.php");
			if ($items->num_rows > 0) {
				$i = 0;
				while ($row = $items->fetch_assoc()) {
					if ($i > 0) {
						$query_main = $query_main . "UNION ";
					}
					$subquery = "
						(SELECT *  
						FROM userGameVisits 
						WHERE gameId = $row[gameId] 
						AND userId = $_SESSION[userID]
						ORDER BY visitTimeStamp desc 
						LIMIT 1) ";
					$query_main = $query_main .  $subquery;
					$i++;
				}
				$query_main = $query_main . ") AS VISITS JOIN videoGames ON VISITS.gameId = videoGames.videoGameId;";
			}
			include("./Helpers/connectToDatabase.php");
			
			$items = mysqli_query($con, "$query_main");
			
		?>
		<div class="recent-carousel-container">
			
				<p class="recent-carousel-header">
					Recently Played...
				</p>
			
			<div class="recent-carousel-body">
				<div id="recent-carousel">
					<?php 
					if ($items->num_rows > 0) {
						while ($row = $items->fetch_assoc()) {
							echo "<div>
										<a href='map.php?gameId=$row[gameId]'>
											<img src='/Assets/GameCovers/$row[coverPath]'>
										</a>
									</div>";
						}
					}
				?>
				</div>
				
			</div>
		</div>
	</body>
</html>