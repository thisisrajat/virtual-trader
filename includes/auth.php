<?php

	session_start();

	//Check whether the session LOGGEDIN is set or not and if set, check its value

	if(!isset($_SESSION['loggedin']) || (trim($_SESSION['loggedin']) == '')) {
		header("location: login.php");
		exit();
	}

 ?>