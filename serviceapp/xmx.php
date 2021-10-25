<<<<<<< HEAD

<?php
 include("../data/DBConfig.php");
$ddate = "2012-10-18";
$date = new DateTime($ddate);
$week = $date->format("W");
echo "Weeknummer: $week";

// Delimiters may be slash, dot, or hyphen
$date = "04/30/1973";

?>
<br/>
<hr/>

<?php 
echo $database->purchaseListForMachineCollectedDaily(date('d'),date('n'),date('Y'));

?>

=======

<?php
 include("../data/DBConfig.php");
$ddate = "2012-10-18";
$date = new DateTime($ddate);
$week = $date->format("W");
echo "Weeknummer: $week";

// Delimiters may be slash, dot, or hyphen
$date = "04/30/1973";

?>
<br/>
<hr/>

<?php 
echo $database->purchaseListForMachineCollectedDaily(date('d'),date('n'),date('Y'));

?>

>>>>>>> 48136f1b63a2e7fb659fed72c5bf93f60ec79592
