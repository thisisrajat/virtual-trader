<?php

	session_start();
	require_once("includes/common.php");
	//Check whether the session variable LOGGEDIN is present or not
	if(!isset($_SESSION['loggedin']) || (trim($_SESSION['loggedin']) == '')) {
		header("location: login.php");
		exit();
	}
	$u = $_SESSION['username'];
	$res = mysql_query("SELECT cash FROM users WHERE username = '$u'");
	$row = mysql_fetch_array($res);
	$cash = $row['cash'];
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Welcome <?php echo "{$_SESSION["displayname"]}"; ?>
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css"/>
	</head>
	<body style="BGstyle">
		<?php require_once("templates/navbar.php"); ?>
		<section class = "index">
			<div class="nameBG">Welcome, <?php echo "{$_SESSION['displayname']}";?></div>
			<div class="leaderboardBG"><a href="leaderboard.php">See Who's on a money roll</a></div>
			<div class="buysellBG">Wanna <a href="buy.php">Buy</a>/<a href="sell.php">Sell</a> Stuff?</div>
			<div class="accountBG"><a href = "account.php">Change Account Settings</a></div>
			<div class="cashBG">Current Cash is $<?php echo $cash; ?></div>
		</section>
	</body>
</html>