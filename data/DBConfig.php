<?php
    ob_start();
    session_start();
    // $host= "http://192.168.1.156/TenauiService/";
    $host= "https://www.elastic250.com/";

    $DBHOST = "localhost";
    $DBNAME = "elastic2_25";
    $DBUSER = "elastic2_super";
    $DBPASS = "t3n@U!3l@5t!c@2019";
    $metaTags = "";
//		$con = "";
    try
    {
			$con = new PDO("mysql:host=$DBHOST;dbname=$DBNAME", $DBUSER, $DBPASS,
			array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_PERSISTENT=>false));
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }

   if(isset($_COOKIE["i_am2309384384304302349438933"]))
   {
       $_SESSION['user_id'] = $_COOKIE["i_am2309384384304302349438933"];
       setcookie("i_am2309384384304302349438933", $_SESSION['user_id'], time() + (86400),"/");
   }

    include_once("MySQLDatabase.php");
    $database = new MySQLDatabase($con,$host);
