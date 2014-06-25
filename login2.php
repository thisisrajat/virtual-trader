<?php
	
	// Starts Session

	session_start();

	require_once("includes/common.php");
	// TODO - Embed it into PHP_SELF

	// Grabs username and password
	
	$username = mysql_encode_url($_POST['username']);
	$password = md5($_POST['password']);

	// Prepare query and execute it.

	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";

	$res = mysql_query($query);

	if($res && mysql_num_rows($res)>0)
	{	
		// Login Successful
		$row = mysql_fetch_array($res);
		session_regenerate_id();
		$_SESSION['username'] = $row['username'];
		$_SESSION['displayname'] = $row['displayname'];
		$_SESSION['loggedin'] = 1;
		session_write_close();
		header("location: index.php");
		exit();
	}	
	else
	{
		apologize("Invalid Username and/or Password!");
	}
?>