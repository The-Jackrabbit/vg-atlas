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
		 <script src="./Assets/jquery.min.js"></script>

		<style>
			#map {
				position: fixed;
				top:0;
				left:0;
				width: 100%;
				height: 100%;
			}
			input.search {
				width: 100%;
			}
			div.nav-toggle {
				width: 30pt;
				height: 30pt;
				border-radius: 30pt;
				position: fixed;
				right:12;
				top:12;
				background-color: rgba(230, 230, 230, 0.4);
				text-align: center;
				line-height: 30pt;
				cursor: pointer;
			}
			.nav-sidebar {
				position: fixed;
				right:0;
				top:0;
				height: 100%;
				width: 200pt;
				background-color: rgba(250, 250, 250, 0.4);
				display: none;
			}
			.sidebar-header {
				width: 100%;
				height: 50pt;
				background-color: rgba(250, 250, 250, 0.8);
				margin-bottom: 4pt;
			}
			.sidebar-header span.minify {
				line-height: 50pt;
				color: black;
				padding-left: 25pt;
				font-size: 18pt;
				cursor: pointer;
			}

			#sidebar div.link  .link-item  {
				text-decoration: none;
				color: black;
				font-size: 18pt;

			}

			#sidebar div.link {
				padding: 24pt 12pt;
				background-color: white;
				margin-bottom: 4pt;
			}

			.playthrough {
				margin: 0pt 12pt;
				padding: 12pt 0pt;
				border-bottom: 1pt solid gray;
				cursor: pointer;
				display: block;
				width: 100%;
				text-decoration: none;
				color: black;
			}

			a.playthrough:hover {
				background-color: rgba(255, 0, 0, 0.2);
			}

			.playthrough:last-child {
				border-bottom: 0pt solid gray;
			}
			.playthrough-container {
				padding-top: 4pt;
			}
			#toggle-playthrough {
				cursor: pointer;
			}
			span.add {
				float: right;
				color: #7ADB7C;
				font-weight: bold;
			}
			.playthrough input[type=text] {
				border-radius: 0pt;
				width: 90%;
			}
			.playthrough input[type=submit] {
				margin-top: 12pt;
				background-color: dodgerblue !important;
				color: white;
				border: none;
			}
			#mapmenu {
				position: absolute;
				display: none;
				z-index: 100;
			}
			.add-point {
				width: 100% !important;
				background-color: lightgreen !important;
				border: none !important;
				color: white;
			}
			.hidden-inputs {
				display:none;
			}
			.hidden-inputs input, .hidden-inputs select {
				margin-top: 12pt;
			}
			.hidden-inputs input[type=submit] {
				width: 100% !important;
				background-color: #FFDD4A !important;
				border: none !important;
				color: white;
			}
		</style>
		<script>
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
		<div id="mapmenu">
			hello
		</div>
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
							$zero = 0;
							include("./Helpers/connectToDatabase.php");
							if (is_null($_GET["mapId"])) {
								$_GET["mapId"] = 0;
							}
							$items = mysqli_query($con, "
								SELECT *
								FROM videoGameMarkers
								WHERE videoGameId = $_GET[gameId]
								AND status = 'canon'
								UNION
								SELECT *
								FROM videoGameMarkers
								WHERE videoGameId = $_GET[gameId]
								AND userId = $_SESSION[userId]
								AND mapId = 0
								UNION
								SELECT *
								FROM videoGameMarkers
								WHERE videoGameId = $_GET[gameId]
								AND userId = $_SESSION[userId]
								AND mapId = $_GET[mapId];
								;
							");
							include("./Helpers/disconnectFromDatabase.php");
							if ($items->num_rows > 0) {
								while ($row = $items->fetch_assoc()) {
									$res = getImageSize("./Assets/Markers/$row[assetId]");
									echo "var $row[idString]_icon = L.icon({
										iconUrl: './Assets/Markers/$row[assetId]',
									});";
									echo "
									var marker = L.marker([$row[y] + $res[1],$row[x] - $res[0]], {icon: $row[idString]_icon});
									var popup = L.popup({minWidth: 100, maxWidth: 500, offset: L.point($res[0]/2, 0)}).setContent('<h2>$row[title]</h2><p>$row[body]</p>');
									marker.bindPopup(popup);
									marker.addTo(map);";
								}
							}
						?>
						map.setMaxBounds(bounds);
						map.on('drag', function() {
							map.panInsideBounds(bounds, { animate: false });
						});
						
						var menu = L.popup({minWidth: 100});
						map.on('click', function(e) {
							menu.setLatLng(L.latLng(e.latlng.lat, e.latlng.lng));
							menu.setContent(
								`<form action="./Helpers/submitAddPoint.php" method="POST">
									<div class="mapmenu">
										<p>x: ` + e.latlng.lat + `,  y: ` + e.latlng.lng + `</p>
										<input type="button" id="add-point" value="New Point" class="add-point">
										<input type="hidden" name="x" value=" ` + e.latlng.lat + `">
										<input type="hidden" name="y" value=" ` + e.latlng.lng + `">
										<div class="hidden-inputs" id="hidden-inputs">
											<input type="text" placeholder="Title" name="title">
											<input type="text" placeholder="Description" name="description">
											<select name="playthrough">
												<option value="0" selected>All</option>
											</select>
											<select name="status">
												<option value="private" selected>Private</option>
												<option value="public" >Public</option>
											</select>
											<select name="asset">
												<option value="safe_zone.png" selected>Safe</option>
												<option value="neutral_zone.png">Neutral</option>
												<option value="danger_zone.png">Danger</option>
											</select>
											<?php
												echo "<input type='hidden' name='gameId' value='$_GET[gameId]'>";
												if (!is_null($_GET[mapId])) {
													echo "<input type='hidden' name='mapId' value='$_GET[mapId]'>";
												} else {
													echo "<input type='hidden' name='mapId' value='0'>";
												}
											?>
											<input type="submit" value="Add Point">
											
										</div>
									</div>
								</form>`);
							map.openPopup(menu);
    
						});
 						map.setView(xy(width/2, height/2), -1);
						 map.setMinZoom( map.getBoundsZoom( map.options.maxBounds ) );
						
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
			<div class="nav-toggle" id="expand-sidebar">
					=
			</div>
			<div class="nav-sidebar" id="sidebar">
				<div class="sidebar-header">
					<span id="minify-sidebar" class="minify">x</span>
				</div>
				<div class="links">
					<div class="link">
						<a  class="link-item"  href="./usermaps.php">Your Library</a>
					</div>
					<div class="link">
						<p class="link-item" id="toggle-playthrough">Playthroughs<span class="add" id="add-playthrough">+</span></p>
						<!-- loop through user playthroughs -->
						<div class="playthrough-container" id="playthrough-container">
							<?php 
								include("./Helpers/connectToDatabase.php");
								$items = mysqli_query($con, "
									SELECT *
									FROM userPlaythroughs
									WHERE videoGameId = '$_GET[gameId]'
									AND userId = '$_SESSION[userId]'; 
								");
								include("./Helpers/disconnectFromDatabase.php");
								if ($items->num_rows > 0) {
									while ($row = $items->fetch_assoc()) {
										echo "<a class='playthrough' href='?gameId=$row[videoGameId]&mapId=$row[mapId]'><span>$row[title]</span></a>";
									}
								}
								
							?>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<script>
			$('#expand-sidebar, #minify-sidebar').click(function() {
				$('#sidebar').animate({width: 'toggle'});
				$('#expand-sidebar').toggle();
			})
			$('#toggle-playthrough').click(function() {
				$(this).next().slideToggle();
			}).find("#add-playthrough").click(function(e) {
					return false;
			})
			$("#add-playthrough").click(function() {
				$(this).toggle();
				$("#playthrough-container").append(
					`
						<form action='./Helpers/submitAddPlaythrough.php' method='POST' class='playthrough'>
							<input required type='text' placeholder='Playthrough Title' name='title'>
							<input type='submit' value='Add Playthrough'>
							<?php
								echo "<input type='hidden' value=$_GET[gameId] name='gameId'>";
							?>
						</form>`
				)
			})
			$(document).on("click", "#add-point", function(e) {
				$("#add-point").toggle();
				$(".leaflet-popup-content").css("width", "min-content");
				var init_width = $(this).parents(".leaflet-popup").css("width");
				$(this).parent().find('#hidden-inputs').slideToggle();
					//class="leaflet-popup-content"
			})
		</script>
   </body>
</html>