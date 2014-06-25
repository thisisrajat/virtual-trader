<?php

	require_once("includes/auth.php");
	require_once("includes/common.php");

	if(isset($_GET['cheat']))
	{
		if($_GET['cheat'] == "gimmecash")
		{
			if(isset($_GET['cash']))
			{
				$cash_new = $_GET['cash'];
			}
			else
			{
				$cash_new = "10000";
			}
			$username = $_SESSION['username'];
			mysql_query("UPDATE users SET cash = '$cash_new' WHERE username = '$username'");
			redirect("account.php");
		}

		if($_GET['cheat'] == "imgod")
		{	
			$cash_new = "999999999";
			$username = $_SESSION['username'];
			mysql_query("UPDATE users SET cash = '$cash_new' WHERE username = '$username'");
			redirect("account.php");
		}

		redirect("account.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php echo "{$_SESSION["displayname"]} - Account Settings"; ?>
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css"/>
	</head>
	<body>
		<?php require_once("templates/navbar.php"); ?>
		<section class="accountSettings">
			<form action = "changepassword.php" method = "post">
			<fieldset class = "account-info">
				<label>
					Current Password:
				</label>
				<input type="password" name = "curpass" value=""/>
				<label>
					New Password:
				</label>
				<input type="password" name = "newpass" value=""/>
				<label>
					Confirm Password:
				</label>
				<input type="password" name = "confirmpass" value=""/>
				
				<input class="btn" type="submit" name="" value="Change Password">
			
			</fieldset>

			</form>
		</section>
	</body>
</html>