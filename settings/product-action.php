<<<<<<< HEAD
<?php
    require_once("../data/DBConfig.php");

    $action = $_POST["action"];
    $id = $database->test_input($_POST['id']);
    $catID = $database->test_input($_POST['catID']);
    $prodName = $database->test_input($_POST['prodName']);
    $prodCode = $database->test_input($_POST['prodCode']);
    $prodPrice = $database->test_input($_POST['prodPrice']);
    $unitID = $database->test_input($_POST['unitID']);
    $active = 1;
    $prodPrice = str_replace(',','',$prodPrice);


    if(!empty($action))
    {
        switch($action)
        {
            case "edit":
                $result = $database->EditProducts($id, $catID, $prodName, $prodCode, $prodPrice,$active,$unitID);
                if($result == 1){
                    return 1;
                }
            break;
            case "add":
                $result =  $database->addNewProducts($catID, $prodName, $prodCode, $prodPrice,$active,$unitID);
                 if($result == 1){
                    return 1;
                }
                break;
        }
    }
=======
<?php
require_once("../data/DBConfig.php");
//var queryString = 'action='+action+'&catID='+catID+'&prodName='+prodName+'&prodCode='+prodCode+'&prodPrice='+prodPrice+'&id='+id;

$action = $_POST["action"];
$id = $database->test_input($_POST['id']);
$catID = $database->test_input($_POST['catID']);
$prodName = $database->test_input($_POST['prodName']);
$prodCode = $database->test_input($_POST['prodCode']);
$prodPrice = $database->test_input($_POST['prodPrice']);
$unitID = $database->test_input($_POST['unitID']);
$active = 1;
$prodPrice = str_replace(',','',$prodPrice);


if(!empty($action)) {
    switch($action) {
        case "edit":

            $result = $database->EditProducts($id, $catID, $prodName, $prodCode, $prodPrice,$active,$unitID);
            if($result == 1){
                return 1;
            }
        break;
        case "add":
            $result =  $database->addNewProducts($catID, $prodName, $prodCode, $prodPrice,$active,$unitID);
             if($result == 1){
                return 1;
            }
            break;
    }
}
>>>>>>> 48136f1b63a2e7fb659fed72c5bf93f60ec79592
