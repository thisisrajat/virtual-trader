<?php
// require common code
require_once("includes/auth.php");
require_once("includes/common.php");

	//Check whether the session variable LOGGEDIN is present or not
	if(!isset($_SESSION['loggedin']) || (trim($_SESSION['loggedin']) == '')) {
		header("location: quote2.php");
		exit();
	}
//lookup the symbol provided by the user, and display it's information

if (!isset($_GET["symbol"]) or empty($_GET["symbol"])) {
	apologize("You must provide a symbol.");
}

// check if the symbol is only the characters: a-z A-Z 0-1 . _ -
if (!preg_match("/^[a-zA-Z0-1\._-]+$/", $_GET["symbol"])) {
	apologize("That does not appear to be a valid symbol.");
}

$s = lookup($_GET["symbol"]);

if (!$s || $s['price'] == 0) {
	apologize("That does not appear to be a valid stock symbol (according to Yahoo finance).");
}

// Since Lookup was successful we'll add symbol in the table->cache
$name = $s['symbol']; $val = $s['price'];
$query = "INSERT INTO `cache` (`symbol`, `price`) VALUES ('$name','$val') ON DUPLICATE KEY 
			UPDATE `price` = VALUES(`price`)";
mysql_query($query);

?>

<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php if(isset($s)){echo "{$s['name']} ({$s['symbol']})";}  ?>
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css"/>
	</head>
	<body>
		<?php require_once("templates/navbar.php"); ?>
		<section class="quoteHeading">
		<?php 

		echo "Stock Name: {$s['name']}<br />"; 
		//echo "Symbol: {$s['symbol']}<br />";
		echo "Price in USD: \${$s['price']}<br />";
		echo "Today's Opening was at: \${$s['open']}<br />";
		if ($s['change'] < 0)
		{
			echo "Percent Change is: <span style=\"color:red;\">{$s['change']}%</span><br />";
		}
		else
		{
			echo "Percent Change is: <span style=\"color:green;\">{$s['change']}%</span><br />";
		}
		echo "Today's High is: \${$s['high']}<br />";
		echo "Today's Low is: \${$s['low']}<br />";

		?>
		</section>
		<div id="footer">
			<p style="text-decoration: none;"><a href="http://finance.yahoo.com/q?s=<?php echo "{$s['symbol']}"; ?>">Click to view this stock on Yahoo! Finance</a></p>
		</div>
	</body>
</html>