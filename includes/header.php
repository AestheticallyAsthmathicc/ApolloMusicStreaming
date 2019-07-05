<?php
	
	include("includes/config.php"); 
	include("includes/classes/User.php");
	include("includes/classes/Artist.php");
	include("includes/classes/Album.php");
    include("includes/classes/Song.php");
    include("includes/classes/Playlist.php");

	//session_destroy();

	if(isset($_SESSION['userLoggedIn'])) {
		$userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
		$username = $userLoggedIn->getUsername();
		$adminCheck = $userLoggedIn->adminCheck();
		echo "<script>
			userLoggedIn = '$username';
			adminCheck = '$adminCheck';
		</script>";
	} else {
		header("Location: register.php");
	}

 ?>

<!DOCTYPE html>
<html>

<head>
	<title>APOLLO Music</title>
	<link rel="stylesheet" href="assets/css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="assets/js/script.js"></script>
</head>

<body>
	<div id="mainContainer">

		<div id="topContainer">
			<?PHP include("includes/navBarContainer.php"); ?>

			<div id="mainViewContainer">
				<div id="mainContent">