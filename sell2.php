<?php
	// Common includes
	require_once("includes/auth.php");
	require_once("includes/common.php");

	// Error Checking, exact same as implemented in BUY2,php.

	if (!isset($_GET['symbol']) || empty($_GET['symbol'])) 
	{
		apologize("You must provide a symbol.");
	}
	
	if (!isset($_GET['qty']) || empty($_GET['qty'])) 
	{
		apologize("No quantity provided.");
	}

	if (!preg_match("/^[a-zA-Z0-1\._-]+$/", $_GET["symbol"])) 
	{
		apologize("That does not appear to be a valid symbol.");
	}

	// The basics

	$username = $_SESSION['username'];
	$symbol = mysql_real_escape_string($_GET['symbol']);
	$qty = (int) $_GET['qty'];

	// Check length of the symbol. Should be less than 20 to be safe.

	if(strlen($_GET['symbol']) > 20)
	{
		apologize("Symbol name too big");
	}

	// Check to see if qty is greater than 0

	if ((int)$_GET['qty'] < 0)
	{
		apologize("Number of stock less than Zero");
	}

	// Check if the specified quantity by the user is more than what he owns!
	// Also added a variable that knows if QTY is equal to NUMBER OF SHARES
	$query = "SELECT number_of_share FROM portfolio WHERE username = '$username' AND symbol = '$symbol'";
	$result = mysql_query($query);
	if($result && mysql_num_rows($result) == 1)
	{
		$row = mysql_fetch_array($result);
		if ( $qty > $row['number_of_share'])
		{
			apologize("You don't have that many shares to sell. You can sell atmost {$row['number_of_share']} shares of this stock.");
		}
		else if ($qty == $row['number_of_share'])
		{
			$qty_is_equal = true;
		}
	}

	// Let's do the selling now. 
	// First lookup function to get latest price of the stock. 

	$stock = lookup($symbol);
	$current_price = $stock['price'];

	// Calculate cash earned by selling the stock

	$cash_earned = (float) $current_price * $qty;

	// Add this cash earned to the user's cash now.
	$query = "UPDATE users SET cash = cash + '$cash_earned' WHERE username = '$username'";
	$result = mysql_query($query);
	if(!$result && !(mysql_affected_rows()===1))
	{
		apologize("Cash wasn't updated in your money.");
	}

	// Remove that stock from the table.
	// If number_of_share == quantity, do a DELETE query
	// Else do an update query.. 
	
	if ($qty_is_equal) // Do a DELETE query!
	{
		$query = "DELETE FROM portfolio WHERE username = '$username' AND symbol = '$symbol'";
		$result = mysql_query($query);
	}
	else // Do an UPDATE query!!
	{
		$query = "UPDATE portfolio SET number_of_share = number_of_share - '$qty' WHERE username = '$username' AND symbol = '$symbol'";
		$result = mysql_query($query);
	}

	// Todo : Add this transcation in the Archive Table filed under SELL
	// $username, $symbol, $current_price, $qty
	$time = time()+19800;
	$transaction = "SELL";
	$query = "INSERT INTO archive (username, symbol, price, number_of_share, time, transaction)
				VALUES ('$username','$symbol','$current_price','$qty','$time','$transaction')";

	mysql_query($query);

	// Since we are at it let's update the stock's current price in cache table

	$query = "INSERT INTO cache (symbol, price) VALUES ('$symbol','$current_price') ON DUPLICATE KEY 
			UPDATE price = VALUES(price)";
	mysql_query($query);

	redirect("portfolio.php");

?>