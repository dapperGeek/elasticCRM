<?php
include 'includes/header.php';
$Department = $myData['Department'];

    
//
//    if ($myData['AccessLevel'] == "1")
//    {
        echo '<center><h1>WELCOME TO '. $myData['Department'] .' Department  </h1></center>';
        ViewLoader::loadView($myData['Department']);
//    }
//    else
//    {
//        include 'font.php';
//    }
?>

    <br><br> <br><br>
<?php
//if ($myData['DepartmentID'] == "5" || ($myData['DepartmentID'] == "4" && $myData['AccessLevel'] > 5)) 
//{
//    include 'productBelowfourquantity.php';
//}
if (strtolower($_SESSION['department']) == 'customer support')
{
    $loadFooterJS = 2 ;
}
include 'includes/footer.php';