<?php
	// Include MYSQL connection
	require_once("includes/auth.php");
	require_once("includes/common.php");

	// Error checking if any field was left empty

	if(!isset($_GET['symbol']) || empty($_GET['symbol']))
	{
		apologize("Provide a symbol in its respective field");
	}

	if(!isset($_GET['qty']) || empty($_GET['qty']))
	{
		apologize("Provide number of stocks you wanna buy in its respective field");
	}

	// Check if symbol is valid

	if(!preg_match("/^[a-zA-Z0-1\._-]+$/", $_GET['symbol'])) 
	{
	 	apologize("Uhm! That don't look like a valid symbol.");
	}

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

	// Okay, now lets buy!
	
	$symbol = mysql_encode_url($_GET['symbol']);
	$qty = (int) $_GET['qty'];
	$username = $_SESSION['username'];
	
	// Check if enough cash to make this purchase
	
	$query = "SELECT * FROM users WHERE username = '$username'";
	
	$result = mysql_query($query);
	
	if($result && mysql_num_rows($result)==1)
	{	
		$row = mysql_fetch_array($result);
		$cash_at_hand = $row['cash'];
		
		if($cash_at_hand<0 || !$cash_at_hand)
		{
			apologize("You're either broke or I can't figure out how much money do you have!");
		}
	}

	$stock = lookup($symbol);

	if(!$stock || $stock['price'] == 0)
	{
		apologize("Doesn't appear to be valid symbol");
	}
	
	$cost = $stock['price'] * $qty;

	if ($cash_at_hand < $cost)
	{
		apologize("Nope! You don't have enough money to buy {$qty} shares of {$stock['symbol']}'s stock");
	}

	// Update Cash when you're at it

	$difference = (float) ($cash_at_hand-$cost);
	echo $difference . "<br>" . $username;
	$query = "UPDATE users SET cash = '$difference' WHERE username = '$username'";
	$result = mysql_query($query);
	if(!$result)
	{
		apologize("Error. Couldn't update cash.");
	}

	
	// *** The most important part ***
	// Insert symbol into the portfolio table. 
 	$stock_name = $stock['name'];
	$stock_symbol = strtoupper($stock['symbol']);
	$time = time()+19800;
	$price = $stock['price'];
	$transaction = "BUY";
	// $username for username and $qty for number_of_share

	$query = "INSERT INTO portfolio (username, symbol, name_of_company, number_of_share, price, time) VALUES 
		('$username', '$stock_symbol', '$stock_name','$qty', '$price', '$time')
		ON DUPLICATE KEY UPDATE time = VALUES(time) ,
		number_of_share = number_of_share + VALUES(number_of_share)";

	$result = mysql_query($query);

	if(!$result)
	{
		apologize("Oh, that didn't went well. Looks like your portfolio wasn't updated on our part");
	}

	// Let's archive this transaction into Archive Table for later referral.

	$query = "INSERT INTO archive (username, symbol, price, number_of_share, time, transaction) VALUES ('$username', '$stock_symbol', '$price', '$qty', '$time', '$transaction')";

	$result = mysql_query($query);

	if(!$result)
	{
		apologize("Oh, that didn't went well. Looks like that stock wasn't added to your history!");
	}

	// Also when we are at it, let's update the current value of stock in cache table

	$query = "INSERT INTO cache (symbol, price) VALUES ('$stock_symbol','$price') ON DUPLICATE KEY 
			UPDATE price = VALUES(price)";
	mysql_query($query);

	redirect("portfolio.php"); 
?>