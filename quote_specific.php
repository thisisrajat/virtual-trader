<?php
	require_once("includes/auth.php");
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
		<div id="main">
			<form action="quote_specific2.php" method="get">
				<fieldset class="account-info">
					<label>Symbol Name:</label>
					<input type="text" name="symbol" value=""/>
				</fieldset>
				<fieldset class="account-action">
				    <input class="btn" type="submit" name="" value="Get Quote">
				</fieldset>
			</form>
		</div>
		<div id="footer">
			Disclamier: This site uses <a href="http://finance.yahoo.com/">Yahoo! Finance</a>. Symbols valid there, are valid here.
		</div>
	</body>
</html>