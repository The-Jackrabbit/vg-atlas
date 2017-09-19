<?php 
	session_start();
	include("./connectToDatabase.php");
	$max = mysqli_query($con,
	"SELECT MAX(mapId)
	FROM userPlaythroughs");
	$max = $max + 1;
	$items  = mysqli_query($con,
	"INSERT INTO userPlaythroughs(
		mapId, videoGameId, userId, title
	)
	VALUES 
		($max, $_POST[gameId], $_SESSION[userId], '$_POST[title]');
	");
	include("./disconnectFromDatabase.php");
	header("Location: http://localhost:9999/map.php?gameId=$_POST[gameId]"); /* Redirect browser */
?>