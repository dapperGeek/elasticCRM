<<<<<<< HEAD
<?php
session_start();
session_destroy();

//$host= "http://localhost/TenauiCRM/";
unset($_COOKIE["i_am2309384384304302349438933"]);
setcookie("i_am2309384384304302349438933",'',time() - (8640000 * 10),"/");
include("data/DBConfig.php");
header('location:'.$host);
=======
<?php
session_start();
session_destroy();

//$host= "http://localhost/TenauiCRM/";
unset($_COOKIE["i_am2309384384304302349438933"]);
setcookie("i_am2309384384304302349438933",'',time() - (8640000 * 10),"/");
include("data/DBConfig.php");
 header('location:'.$host);

?>
>>>>>>> 48136f1b63a2e7fb659fed72c5bf93f60ec79592
