<?php
	// Include the mysql connection

	require_once("includes/auth.php");	
	require_once("includes/common.php");
	$query = "SELECT * FROM cache";
	$result = mysql_query($query);

?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Quote
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css"/>
	</head>
	<body>
		<?php require_once("templates/navbar.php"); ?>
		<section class="quote"><a href = "quote_specific.php">Quote Specific Stock</a></section>
		<div class = "center">

			<table>
				<thead>
				    <tr>
				      	<th scope="col">Symbol</th>
				      	<th scope="col">Current Price</th>
				      	<th scope="col">Buying Price</th>
				      	<th scope="col">Buy/Sell</th>
				      	<th scope="col">Reload</th>
				    </tr>
				</thead>
				<tbody>
				    <?php
				    	while($row = mysql_fetch_array($result))
				    	{
				    	echo "<tr>
						<td>
							<strong class=\"symbolname\">{$row["symbol"]}</strong>
						</td>
						<td class=\"item-stock\">{$row["price"]}</td>
						
						<td class=\"item-stock\">";

						$u = $_SESSION['username']; $s = $row['symbol']; $q = "SELECT * FROM portfolio WHERE username = '$u' AND symbol = '$s'";
						$res = mysql_query($q);
						if(mysql_num_rows($res)==0)
						{
							$the_price = "N/A";
							$can_sell = false;
						}
						else
						{	
							$r = mysql_fetch_array($res);
							$the_price = $r["price"];
							$can_sell = true;
						}


						echo "{$the_price}</td>
						<td class=\"item-stock\"><a href =\"buy.php?symbol={$s}\"><span class=\"green\">BUY</span></a>";

						if($can_sell)
						{
							echo "/<a href=\"sell.php?symbol={$s}\"><span class=\"red\">SELL</span>";
						}	

						echo "</td>
						<td class=\"item-stock\"><a href=\"quote2.php?symbol=".$s."\">Fetch Latest</a></td>
						</tr>";
				    	}
				    ?>
				</tbody>
			</table>
		</div>
	</body>
</html>