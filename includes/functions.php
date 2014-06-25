<?php 
	
    //Encodes the Post Data. 
    function mysql_encode_url($string)
    {
        $is_active = get_magic_quotes_gpc();
        $check_version = function_exists("mysql_real_escape_string");
        if($check_version)
        {
            if($is_active)
            {
                $string = mysql_real_escape_string($string);
            }
        }
        else
        {
            if(!$is_active)
            {
                $string = addslashes($string);
            }
        }
        return $string;
    }


    //Loads apology.php and sends out an message
	function apologize($message) 
	{	
		require_once("templates/apology.php");
		exit;
	}


    //Redirects to destination. From www.php.net
	function redirect($destination) 
    {
	   // handle URL
    	if (preg_match("/^http:\/\//", $destination))
    		header("Location: " . $destination);

    	// handle absolute path
    	else if (preg_match("/^\//", $destination)) {
    		$protocol = (@$_SERVER["HTTPS"]) ? "https" : "http";
    		$host = $_SERVER["HTTP_HOST"];
    		header("Location: $protocol://$host$destination");
    }

	// handle relative path
	else {
		// adapted from http://www.php.net/header
		$protocol = (@$_SERVER["HTTPS"]) ? "https" : "http";
		$host = $_SERVER["HTTP_HOST"];
		$path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
		header("Location: $protocol://$host$path/$destination");
	}

	// exit immediately since we're redirecting anyway
	exit;
}	
//Pulls stock price, name etc from Yahoo! Finance.
function lookup($symbol)
    {
        // reject symbols that start with ^
        if (preg_match("/^\^/", $symbol))
        {
            return false;
        }

        // reject symbols that contain commas
        if (preg_match("/,/", $symbol))
        {
            return false;
        }

        // open connection to Yahoo nsl1op snl1&
        //http://download.finance.yahoo.com/d/quotes.csv?f=nsl1op&s=%40%5EDJI,
        $handle = @fopen("http://download.finance.yahoo.com/d/quotes.csv?f=sl1d1t1c1ohgn&s=$symbol", "r");
        if ($handle === false)
        {
            // trigger (big, orange) error
            /*trigger_error("Could not connect to Yahoo!", E_USER_ERROR);
            exit;*/
            apologize("Could not connect to Yahoo! Check your Internet Connection");
        }

        // download first line of CSV file
        $data = fgetcsv($handle);
        if ($data === false || count($data) == 1)
        {
            return false;
        }

        // close connection to Yahoo
        fclose($handle);

        // ensure symbol was found
        if ($data[2] === "0.00")
        {
            return false;
        }

        // return stock as an associative array
        return [
            "symbol" => $data[0],
            "name" => trim($data[8]),
            "price" => $data[1],
            "open" => $data[5],
            "high" => $data[6],
            "low" => $data[7],
            "change" => $data[4]
        ];
    }

    function lookup2($symbol)
    {   
        $string = "http://finance.google.com/finance/info?client=ig&q=NSE:";
        $string .= $symbol;
        $json = file_get_contents("$string");
        $string = "[";
        $string .= preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t](//).*)#", '', $json); 
        //echo $string. "<br>";
        // now, process the JSON string 
        $result = json_decode($string, true);
        echo "<pre>"; var_dump($result); echo "</pre>";
        return [
                "symbol" => $result[0]["t"],
                "price" => $result[0]["l_cur"],
                "change" => $result[0]["c"]
            ];
    }


    function reload_price($symbol)
    {
        $s = lookup($symbol);
        
        if (!$s || $s['price'] == 0) 
        {
            $s = lookup2($symbol);
            $price = $s['price'];
            $change = $s['change'];
            $symbol = $s['symbol'];
        }
        else
        {
            $price = $s['price'];
            $change = $s['change'];
            $symbol = $s['symbol'];
        }

         $query = "UPDATE cache SET price = '$price' WHERE symbol = '$symbol'";
         mysql_query($query);
    }


    function logout()
    {
        // unset any session variables
        $_SESSION = [];

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        session_destroy();
    }

?>