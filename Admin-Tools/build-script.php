<?php
	include('../Helpers/connectToDatabase.php');

	// Perform queries 
	mysqli_query($con,"DROP TABLE IF EXISTS users;");
	mysqli_query($con,"DROP TABLE IF EXISTS userVideoGames;");
	mysqli_query($con,"DROP TABLE IF EXISTS videoGames;");
	mysqli_query($con,"DROP TABLE IF EXISTS videoGameMarkers;");
	mysqli_query($con,"DROP TABLE IF EXISTS assets;");
	mysqli_query($con,"DROP TABLE IF EXISTS userMaps;");
	mysqli_query($con,"DROP TABLE IF EXISTS mapMarkers;");
	
	mysqli_query($con,"CREATE TABLE users(
		userId SERIAL PRIMARY KEY,
		firstName varchar(100),
		lastName varchar(100),
		username varchar(100),
		email varchar(500),
		password varchar(500)
	);");

	mysqli_query($con,"CREATE TABLE userVideoGames(
		userVideoGameId SERIAL PRIMARY KEY,
		userId integer,
		videoGameId integer
	);");
	mysqli_query($con,"CREATE TABLE videoGames(
		videoGameId SERIAL PRIMARY KEY,
		name varchar(500),
		coverPath varchar(100),
		mapPath varchar(100)
	);");
	mysqli_query($con,"CREATE TABLE videoGameMarkers(
		videoGameMarkerId SERIAL PRIMARY KEY,
		idString varchar(500),
		videoGameId integer,
		x double precision,
		y double precision,
		userId integer,
		score double precision,
		status varchar(100),
		title varchar(500),
		body varchar(100),
		mapId integer,
		assetId varchar(500)
	);");
	mysqli_query($con,
	"INSERT INTO videoGameMarkers(
		videoGameId, idString, x, y, userId, score, status, title, body, mapId, assetId
	)
	VALUES 
	(1, 'markarth_home', 230.7, 1020.7, 0, 0.0, 'public', 'Markarth', 'Shittiest town', 0, 'Markarth.png'),
	(1,  'morthal_home',  1000.7, 1340.7, 0, 0, 'public', 'Morthal', 'Shittiest town', 0, 'Morthal.png'),
	(1,  'falkreath_home',  1050.7, 450, 0, 0, 'public', 'Falkreath', 'Shittiest town', 0, 'Falkreath.png'),
	(1,  'whiterun_home',  1350, 950, 0, 0, 'public', 'Whiterun', 'Shittiest town', 0, 'Whiterun.png'),
	(1,  'solitude_home',  830, 1600, 0, 0, 'public', 'Solitude', 'Shittiest town', 0, 'Solitude.png');
	");
	mysqli_query($con,"CREATE TABLE assets(
		assetId SERIAL PRIMARY KEY,
		filepath varchar(500),
		description varchar(500),
		type varchar(500)
	);");

	mysqli_query($con,"CREATE TABLE userMaps(
		mapId SERIAL PRIMARY KEY,
		userMapId integer,
		videoGameId integer,
		userId integer,
		dateAdded date
	);");
	mysqli_query($con,
	"INSERT INTO userMaps(
		userMapId, videoGameId, userId, dateAdded
	)
	VALUES 
	(0, 1, 1, Now()),
	(0, 4, 1, Now());
	");

	mysqli_query($con,
		"INSERT INTO users(
			firstName, lastName, username, email, password
		)
		VALUES 
		('Luke', 'Masters', 'luke', 'lsm5fm@virginia.edu', '123'), 
		('James', 'Mekavibul', 'james', 'jmk@virginia.edu', 'meka');
	");

	mysqli_query($con,
	"INSERT INTO videoGames(
		name, coverPath, mapPath
	)
	VALUES 
	('Skyrim', 'skyrim.png', 'skyrim.jpg'),
	('Breath of the Wild', 'breathofthewild.png', 'breathofthewild.jpg'),
	('Nier Automata', 'nierautomata.png', 'Nier Automata Map.png'),
	('Grand Theft Auto V', 'gtav.png', 'gtav.jpg'),
	('Xenoblade Chronicles X', 'xenobladechroniclesx.png', 'xenobladechroniclesx.jpg');
	
	");

	mysqli_close($con);
?>