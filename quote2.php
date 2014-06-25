<?php

	require_once("includes/common.php");
	require_once("includes/functions.php");
	if(isset($_GET))
	{
		reload_price($_GET["symbol"]);
		header("location: quote.php");
	}
	else
	{
		header("location: quote.php");
	}

?>