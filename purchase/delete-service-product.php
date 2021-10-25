<<<<<<< HEAD

<?php
include("../data/DBConfig.php");
//@mysql_connect("localhost","root","") or die("Demo is not available, please try again later".mysql_error());
//@mysql_select_db("tenauicrm") or die("Application not available");
$id=$_POST['id'];

$database->deleteLeadProduct($id);

//mysql_query("delete from lead_product where id='$id'") or die(mysql_error());



?>
=======

<?php
include("../data/DBConfig.php");
//@mysql_connect("localhost","root","") or die("Demo is not available, please try again later".mysql_error());
//@mysql_select_db("tenauicrm") or die("Application not available");
$id=$_POST['id'];

$database->deleteLeadProduct($id);

//mysql_query("delete from lead_product where id='$id'") or die(mysql_error());



?>
>>>>>>> 48136f1b63a2e7fb659fed72c5bf93f60ec79592
