<?php 
	session_start();
	session_destroy();
 ?>

<!DOCTYPE html>
<html>
	<head>
		<title>
			Login
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css"/>
	</head>
	<body>

		<section class="loginHeading">Welcome to Virtual Trader</section>

		<div id="middle">
			<form action="login2.php" method="post">
				  <fieldset class="account-info">
				    <label>
				      Username
				      <input align="center" type="text" name="username" required>
				    </label>
				    <label>
				      Password
				      <input align="center"type="password" name="password" required>
				    </label>
				  </fieldset>
				  <fieldset class="account-action">
				    <input class="btn" type="submit" name="submit" value="Login">
				  </fieldset>
				  <span>Don't have an account? <a href="register.php">Register</a></span>
			</form>
		</div>
		
		<div id="footer">
			
		</div>
	</body>
</html>