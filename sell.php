<?php
	require_once("includes/auth.php");
	require_once("includes/common.php");

	$username = $_SESSION['username'];

	$query = "SELECT * FROM portfolio WHERE username = '$username'";

	$result = mysql_query($query);

	if ($result && mysql_num_rows($result) > 0)
		$cond = true;
	else
	{
		apologize("You don't have any stock. It doesn't take a genius to figure out you need to buy some stocks first. kthnxbai!");
	}

	if(isset($_GET['symbol']))
	{
		$symbol_to_sell = $_GET['symbol'];
	}

	if(isset($symbol_to_sell))
	{
		$do = true;

	}
	else
		$do = false;

?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Sell Stock
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css"/>
	</head>
	<body>
		<?php require_once("templates/navbar.php"); ?>
		<div id="main">
			<form action="sell2.php" method="get">
				<fieldset class="account-info">
					<label>Stocks you own:</label>
					<select name="symbol">
						<option>
							<?php if($do) echo "{$symbol_to_sell}";
									else echo "Select an option"; 
							?>
						</option>
						<?php
							while($row = mysql_fetch_array($result))
							{
								if($row['symbol'] != $symbol_to_sell) echo "<option>{$row["symbol"]}</option>";
							}
						?>
					</select>
					<label>Specify Quantity</label>
					<input type="text" name="qty" value="" />
				</fieldset>
				<fieldset class="account-action">
				    <input class="btn" type="submit" name="" value="Okay, Sell!">
				</fieldset>
			</form>
	</body>
</html>