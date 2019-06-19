<?php 
	
	ob_start();
	session_start();

	$timezone = date_default_timezone_set("Asia/Karachi");

	$con = mysqli_connect("localhost", "root", "", "apollo");
	
	if(mysqli_connect_errno()) {
		echo "Failed to connect: " . mysql_connect_errno();
	}

 ?>