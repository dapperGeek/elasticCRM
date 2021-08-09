<?php
include 'includes/header.php';

$Department = $myData['Department'];

if ($myData['AccessLevel'] == "1"){
        echo "<center><h1>WELCOME TO $Department  </h1></center>";
        ViewLoader::loadView($Department);
    }
    else{
        include 'font.php';
    }
?>

    <br><br> <br><br>
<?php
    if ($myData['DepartmentID'] == "5" || ($myData['DepartmentID'] == "4" && $myData['AccessLevel'] > 5)) {
        include 'productBelowfourquantity.php';
    }
    if (strtolower($Department) == 'customer care'){
        $loadFooterJS = 2 ;
    }
    include 'includes/footer.php';
?>