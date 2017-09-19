<?php
	include('../Helpers/connectToDatabase.php');

	// Perform queries 
	mysqli_query($con,"DROP TABLE IF EXISTS users;");
	mysqli_query($con,"DROP TABLE IF EXISTS userVideoGames;");
	mysqli_query($con,"DROP TABLE IF EXISTS videoGames;");
	mysqli_query($con,"DROP TABLE IF EXISTS videoGameMarkers;");
	mysqli_query($con,"DROP TABLE IF EXISTS assets;");
	mysqli_query($con,"DROP TABLE IF EXISTS userMaps;");
	mysqli_query($con,"DROP TABLE IF EXISTS userPlaythroughs;");
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
	// whiterun 922, 1398
	// morthal 1286, 1046
	// solitude 1534, 868
	// markarth 970, 272
	// falkreath 438, 1084
	// dawnstar 1518, 1438
	// winterhold 1502, 1868
	// windhelm 1146, 2000
	// riften 392, 2268
	mysqli_query($con,
	"INSERT INTO videoGameMarkers(
		videoGameId, idString, x, y, userId, score, status, title, body, mapId, assetId
	)
	VALUES 
	(1,  'Whiterun_home', 1398, 922, 0, 0, 'canon', 'Whiterun', 'Shittiest town', 0, 'Whiterun.png'),
	(1,  'Morthal_home', 1046, 1286, 0, 0, 'canon', 'Morthal', 'Shittiest town', 0, 'Morthal.png'),
	(1,  'Solitude_home', 868, 1534, 0, 0, 'canon', 'Solitude', 'Shittiest town', 0, 'Solitude.png'),
	(1,  'Markarth_home', 272, 970, 0, 0, 'canon', 'Markarth', 'Shittiest town', 0, 'Markarth.png'),
	(1,  'Falkreath_home', 1084, 438, 0, 0, 'canon', 'Falkreath', 'Shittiest town', 0, 'Falkreath.png'),
	(1,  'dawnstar_home',  1438, 1518, 0, 0, 'canon', 'Dawnstar', 'Shittiest town', 0, 'Dawnstar.png'),
	(1,  'winterhold_home',  1868, 1502, 0, 0, 'canon', 'Winterhold', 'Shittiest town', 0, 'Winterhold.png'),
	(1,  'windhelm_home',  2000, 1146, 0, 0, 'canon', 'Windhelm', 'Shittiest town', 0, 'Windhelm.png'),
	(1,  'riften_home',  2268, 392, 0, 0, 'canon', 'Riften', 'Shittiest town', 0, 'Riften.png'),
	(1,  'angies_camp',  1310, 340, 1, 0, 'public', 'Angies Camp', 'Best Teacher <3', 1, 'Point_of_Interest.png');
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
	mysqli_query($con,"CREATE TABLE userPlaythroughs(
		playthroughId SERIAL PRIMARY KEY,
		mapId integer,
		videoGameId integer,
		userId integer,
		title varchar(500)
	);");
	mysqli_query($con,
	"INSERT INTO userPlaythroughs(
		mapId, videoGameId, userId, title
	)
	VALUES 
		(1, 1, 1, 'Thoronir'),
		(2, 1, 1, 'Malakai'),
		(3, 1, 1, 'Taako');
	");
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