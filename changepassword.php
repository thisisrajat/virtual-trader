<?php
	session_start();
	require_once("includes/common.php");
	if(empty($_POST['curpass']) && empty($_POST['newpass']) && empty($_POST['confirmpass']))
	{
		apologize("All fields empty. Don't be a jackass. Fill up the form!");
	}

	$current = md5($_POST['curpass']);
	$new = $_POST['newpass'];
	$confirm = $_POST['confirmpass'];
	$username = $_SESSION['username'];


	// See if New and Confirm password are same!

	if(!($new == $confirm))
	{
		apologize("Error: Passwords Mismatch.");
	}
	else
	{
		$new = md5($new);
	}

	// Check if the current password and new password are different

	if($new == $current)
	{
		apologize("Same Password. Enter a new, different password for this account");
	}

	// Check to see if the current password matches the MD5

	$query = "SELECT password FROM users WHERE username = '$username'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	if ( $row['password'] != $current)
	{
		apologize("Password mismatch. Enter correct password!");
	}
	
	// Update the DB with new Password

	$query = "UPDATE users SET password = '$new' WHERE username = '$username'";
	mysql_query($query);

	redirect("index.php");


?>