<?php

	session_start();
	//Check whether the session variable LOGGEDIN is present or not
	if(!isset($_SESSION['loggedin']) || (trim($_SESSION['loggedin']) == '')) {
		header("location: login.php");
		exit();
	}

	// Require connection

	require_once("includes/common.php");

	// Calculate Apparent Cash of every user
	$query = "SELECT * FROM users";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result))
	{	
		$uname = $row['username'];
		$actual_cash = $row['cash'];
		$cash = 0;
		$q = "SELECT * FROM portfolio WHERE username = '$uname'";
		$r = mysql_query($q);
		while($j = mysql_fetch_array($r))
		{
			$symb = $j["symbol"];
			$q2 = "SELECT price FROM cache WHERE symbol = '$symb'";
			$r2 = mysql_query($q2);
			$j2 = mysql_fetch_array($r2);
			$cash = $cash + $j2['price']*$j['number_of_share'];
		}
		$cash += $actual_cash;
		mysql_query("UPDATE users SET apparent_cash = '$cash' WHERE username ='$uname'");
	}

	$query = "SELECT * FROM users ORDER BY apparent_cash DESC";
	$result = mysql_query($query);

?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Leaderboard
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css"/>
	</head>
	<body>
		<?php require_once("templates/navbar.php"); ?>
		<div class = "center">
			<table>
				<thead>
				    <tr>
				    	<th scope="col">Rank</th>
				      	<th scope="col" colspan="3">Name</th>
				      	<th scope="col">Username</th>
				      	<th scope="col">Cash</th>
				    </tr>
				</thead>
				<tbody>
					<?php
						$i=1;
						while($row = mysql_fetch_array($result))
						{	
							echo "
							<tr>
							<td>
							<strong class=\"symbolname\">$i</strong>
							</td>
							<td class=\"item-stock\" colspan=\"3\">{$row["displayname"]}</td>
							<td class=\"item-stock\">{$row["username"]}</td>
							<td class=\"item-stock\">{$row["apparent_cash"]}</td>
							</tr>";
							$i++;
						}
					?>
				</tbody>
			</table>
		</div>
	</body>
</html>