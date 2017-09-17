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
			#map {
				width: 100%;
				height: 400pt;
				margin: 0 auto;
			}
		</style>
		
		<script src="./Assets/jquery.min.js"></script>
		<style>
			input.search {
				width: 100%;

			}
		</style>
		<script>
			$(document).ready(function() {
				
			})
		</script>
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

			include("./Helpers/connectToDatabase.php");
			$items = mysqli_query($con, "
				SELECT mapPath 
				FROM videoGames
				WHERE videoGameId = '$_GET[gameId]'; 
			");
			include("./Helpers/disconnectFromDatabase.php");
			if ($items->num_rows > 0) {
				while ($row = $items->fetch_assoc()) {
					echo "<div style='display: none'>
						<img id='the-map-img' src='./Assets/$row[mapPath]'>
					</div>";
				}
			}
      ?>
		
		<div class="max-inline">
			
			<div id="map">
				<script>
					var img = document.getElementById('the-map-img'); 
				//or however you get a handle to the IMG
					img.onload = function() {
						$('#map').width()
						var width  = img.naturalWidth;
						var height = img.naturalHeight;

						var map = L.map('map', {
							crs: L.CRS.Simple,
							minZoom: -1,
							maxZoom: 1,
							maxBoundsViscosity: 1.0
						});
						var img_url;
						<?php
							include("./Helpers/connectToDatabase.php");
							$items = mysqli_query($con, "
								SELECT mapPath 
								FROM videoGames
								WHERE videoGameId = '$_GET[gameId]'; 
							");
							include("./Helpers/disconnectFromDatabase.php");
							if ($items->num_rows > 0) {
								while ($row = $items->fetch_assoc()) {
									echo "img_url = './Assets/$row[mapPath]'; ";
								}
							}
						?>

						var yx = L.latLng;

						var xy = function(x, y) {
							if (L.Util.isArray(x)) {    // When doing xy([x, y]);
								return yx(x[1], x[0]);
							}
							return yx(y, x);  // When doing xy(x, y);
						};

						var bounds = [xy(0, 0), xy(width, height)];
						var image = L.imageOverlay(img_url, bounds).addTo(map);

						<?php
							include("./Helpers/connectToDatabase.php");
							$items = mysqli_query($con, "
								SELECT *
								FROM videoGameMarkers
								WHERE videoGameId = $_GET[gameId];
							");
							include("./Helpers/disconnectFromDatabase.php");
							if ($items->num_rows > 0) {
								while ($row = $items->fetch_assoc()) {
									echo "var $row[idString]_icon = L.icon({
										iconUrl: './Assets/Markers/$row[assetId]',
									});";
									echo "L.marker([$row[y],$row[x]], {icon: $row[idString]_icon}).addTo(map).bindPopup('$row[title]');";
								}
							}
						?>
						
						map.setView(xy(width/2, height/2), -1);
					}
					function onMapClick(e) {
    gib_uni();
    marker = new L.marker(e.latlng, {id:uni, icon:redIcon, draggable:'true'});
    marker.on('dragend', function(event){
            var marker = event.target;
            var position = marker.getLatLng();
            console.log(position);
            marker.setLatLng(position,{id:uni,draggable:'true'}).bindPopup(position).update();
    });
    map.addLayer(marker);
};
				</script>
			</div>
		</div>
   </body>
</html>