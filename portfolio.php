<?php
	// Include the mysql connection

	require_once("includes/auth.php");	
	require_once("includes/common.php");

	// Lets query the database and return a result set in RESULT

	$username = $_SESSION['username'];
	$query = "SELECT * FROM portfolio WHERE username = '$username'";
	$result = mysql_query($query);

	if ($result == true)
	{
		$do = true;
	}
	else
	{
		$do = false;
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Portfolio
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
				      	<th scope="col" colspan ="2">Name</th>
				      	<th scope="col">Shares</th>
				      	<th scope="col">Price</th>
				      	<th scope="col">Total</th>
				    </tr>
				</thead>
				<tbody>
				    <?php 	
				    	if ($do)
				    	{
				    		$total=0.00;
				    		while($row = mysql_fetch_array($result))
				    		{	
				    			$subtotal = (float) $row["number_of_share"] * $row["price"];
				    			$total= $total + $subtotal;
				    			echo "<tr>
									<td>
										<strong class=\"symbolname\">{$row["symbol"]}</strong>
									</td>
									<td class=\"item-stock\" colspan=\"2\">{$row["name_of_company"]}</td>
									<td class=\"item-stock\">{$row["number_of_share"]}</td>
									<td class=\"item-stock\">"; echo number_format($row["price"],2); echo "</td>
									<td class=\"item-stock\">"; echo number_format($subtotal,2); echo "</td>
								</tr>";
				    		}
				    	}

				    ?>

				    <!--
				    <tr>
						<td>
						<strong class="symbolname">AAPL</strong>
						</td>
						<td class="item-stock" colspan="2">Apple Inc.</td>
						<td class="item-stock">10</td>
						<td class="item-stock">$94.42</td>
						<td class="item-stock">$944.2</td>
					</tr>
					-->
					
				  </tbody>
				  <tfoot>
				    <tr>
				      <td style="text-align:left" colspan="5">Total</td>
				      <td><?php print number_format($total, 2); ?></td>
				    </tr>
				  </tfoot>
			</table>
		</div>
	</body>
</html>