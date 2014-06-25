<?php

	// Display all errors and warnings including notices!
	// Comment out when the code is in production.
	
	ini_set("display_errors", TRUE);
	error_reporting(E_ALL);

	require_once("functions.php");

	$connection = mysql_connect("localhost", "root", "");

	if (!$connection) 
	{ 
		apologize("Could not connect to database server. <br>Check DB_NAME, DB_PASS, and DB_USER in constants.php.");
	}

	if (!(mysql_select_db("trader"))) 
	{
		apologize("Could not connect to the database");
	}

?>