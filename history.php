<?php
	// Include the connection and redirection file
	require_once("includes/auth.php");
	require_once("includes/common.php");

	// The basics

	$username = $_SESSION['username'];
	$query = "SELECT * FROM archive WHERE username = '$username'";
	$res = mysql_query($query);
	
	if(mysql_num_rows($res) == 0 || $res == false)
	{
		apologize("You don't have any transactions. Consider buying/selling stock and then checking this page out!");
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php echo "{$_SESSION['displayname']}'s Archive of Transactions"; ?>
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css"/>
	</head>
	<body>
		<?php require_once("templates/navbar.php"); ?>
		<div class = "center">
			<table>
				<thead>
				    <tr>
				      	<th scope="col">Symbol</th>
				      	<th scope="col">Shares</th>
				      	<th scope="col">Price</th>
				      	<th scope="col">Time</th>
				      	<th scope="col">Transaction</th>
				    </tr>
				</thead>
				<tbody>
					<?php
						while($row = mysql_fetch_array($res))
						{
							echo "
							<tr>
							<td>
							<strong class=\"symbolname\">{$row["symbol"]}</strong>
							</td>
							<td class=\"item-stock\">{$row["number_of_share"]}</td>
							<td class=\"item-stock\">{$row["price"]}</td>
							<td class=\"item-stock\">" . gmdate("H:i d-m-Y", $row["time"]) . "</td>
							<td class=\"item-stock\">{$row["transaction"]}</td>
							</tr>";
						}
					?>    	
				</tbody>
			</table>
		</div>
	</body>
</html>