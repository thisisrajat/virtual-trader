<!DOCTYPE html>
<html>
	<head>
		<title>
			Register
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css"/>
	</head>
	<body>
		<section class="loginHeading">Register for Virtual Trader</section>
		<div id="middle">
			<form action="register2.php" method="post">
				  <fieldset class="account-info">
				    <label>
				      Display Name
				      <input type="text" name="displayname" required>
				    </label>
				    <label>
				      Username
				      <input type="text" name="username" required>
				    </label>
				    <label>
				   		Password
				      <input type="password" name="password" required>
				    </label>
				    <label>
				      Confirm Password
				      <input type="password" name="confirmpassword" required>
				    </label>
				  </fieldset>
				  <fieldset class="account-action">
				    <input class="btn" type="submit" name="submit" value="Register">
				  </fieldset>
				  <span>Already have an account? <a href="login.php">Login</a></span>
			</form>
		</div>	
		<div id="footer">

		</div>
	</body>
</html>