<?php
<<<<<<< HEAD
    ob_start();
    session_start();

    $host= "http://localhost/elastic25.com/";

    $DBHOST = "localhost";
    $DBNAME = "elasticc_25";
    $DBUSER = "geek0";
    $DBPASS = 'T#@C0d3G3n13!';
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
=======
ob_start();
session_start();
	  // $host= "http://192.168.1.156/TenauiService/";
	  $host= "http://localhost/elastic25.com/";

		$DBHOST = "localhost";
		$DBNAME = "elasticc_25";
		$DBUSER = "elasticc_crmUser";
		$DBPASS = "08KK=(w3N&3v";
		$metaTags = "";
		try{
			$con = new PDO("mysql:host=$DBHOST;dbname=$DBNAME", $DBUSER, $DBPASS,
			array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_PERSISTENT=>false));
			}catch(PDOException $e){
				echo $e->getMessage();
			}

   if(isset($_COOKIE["i_am2309384384304302349438933"])){
>>>>>>> 48136f1b63a2e7fb659fed72c5bf93f60ec79592
       $_SESSION['user_id'] = $_COOKIE["i_am2309384384304302349438933"];
       setcookie("i_am2309384384304302349438933", $_SESSION['user_id'], time() + (86400),"/");
   }

<<<<<<< HEAD
    include_once("MySQLDatabase.php");
    $database = new MySQLDatabase($con,$host);
=======
	include_once("MySQLDatabase.php");
	$database = new MySQLDatabase($con,$host);
>>>>>>> 48136f1b63a2e7fb659fed72c5bf93f60ec79592
