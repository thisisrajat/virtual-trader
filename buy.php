<?php
	// If not logged in redirect
	require_once("includes/auth.php");
	if(isset($_GET['symbol']))
	{
		$symbol = $_GET['symbol'];
	}
	else
	{
		$symbol = "";
	}
 ?>

<!DOCTYPE html>
<html>
	<head>
		<title>
			Buy Stock
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css"/>
	</head>
	<body>
		<?php require_once("templates/navbar.php"); ?>
		<div id="main">
			<form action="buy2.php" method="get">
				<fieldset class="account-info">
					<label>Symbol of the Stock you wanna buy:</label>
					<input type="text" name="symbol" value="<?php echo $symbol ?>"/>
					<label>Specify quantity of the stock</label>
					<input type="text" name="qty" value="" />
				</fieldset>
				<fieldset class="account-action">
				    <input class="btn" type="submit" name="" value="Okay, Buy!">
				</fieldset>
			</form>
		</div>
	</body>
</html>