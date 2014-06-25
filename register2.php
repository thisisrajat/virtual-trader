<?php
	
	// TODO : Embed this into the PHP_SELF

	// Connection to the database and other goodies
	session_start();
	require_once("includes/common.php");

	// Error handling and checking

	if (strlen(trim($_POST["username"])) < 4) 
	{
		apologize("Please provide a username longer than 3 characters.");
	}
	
	if (strlen(trim($_POST["displayname"])) < 4) 
	{
		apologize("Please provide a displayname longer than 3 characters.");
	}

	if ($_POST["confirmpassword"] != $_POST["password"]) 
	{
		apologize("Passwords do not match");
	}

	if (strlen($_POST["password"]) < 4) 
	{
		apologize("Please provide a password longer than 3 characters.");
	}

	// Escapes username and display name	by adding backslashes. Prevents SQL injection.
	// Password is hashed using MD5

	$username = mysql_encode_url($_POST['username']); //encodes the username
	$password = md5($_POST['password']); //hashes the password
	$displayname = mysql_encode_url($_POST['displayname']); //encodes the displayname

	// Check if the username exists or not and accordingly progress

	$query = "SELECT username FROM users WHERE username = '$username'";

	$nameCheck = mysql_query($query);

	if($nameCheck === FALSE)
	{
		apologize("Something went wrong. Query was Unfinished!") ;
	} 

	if (mysql_num_rows($nameCheck) === 1)
	{
		apologize("This username is already taken. Choose another one.");
	}

	// Creates a new user

	$query = "INSERT INTO users (displayname, username, password, cash) VALUES ('$displayname','$username','$password',10000)";

	if(mysql_query($query))
	{
		redirect("index.php");
	}

	// That's all folks!

?>
