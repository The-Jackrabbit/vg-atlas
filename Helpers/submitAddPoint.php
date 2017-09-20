<?php 
	include("./connectToDatabase.php");
	session_start();
	$items  = mysqli_query($con,
	"INSERT INTO videoGameMarkers(
		videoGameId, idString, x, y, userId, score, status, title, body, mapId, assetId
	)
	VALUES 
	($_POST[gameId], 'Whiterun_home', $_POST[y],$_POST[x], $_SESSION[userId], 0, '$_POST[status]', '$_POST[title]','$_POST[description]', $_POST[mapId], '$_POST[asset]');
	");
	include("./disconnectFromDatabase.php");
	header("Location: http://localhost:9999/map.php?gameId=$_POST[gameId]"); /* Redirect browser */
?>