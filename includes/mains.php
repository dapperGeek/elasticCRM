<?php
/**
 * Created by PhpStorm.
 * User: Uthman A. Bakar
 * Date: 27-Feb-20
 * Time: 12:19 PM
 */

if (file_exists("data/DBConfig.php")){
    include("data/DBConfig.php");
    include_once("data/sessioncheck.php");
    require_once ("Utils/UtilFunctions.php");
    include_once('includes/forms.php');
    include_once ('Utils/PageHeaders.php');
    include_once ('Utils/ViewLoader.php');
}
else{
    include("../data/DBConfig.php");
    include_once("../data/sessioncheck.php");
    require_once ("../Utils/UtilFunctions.php");
    include('../includes/forms.php');
    include_once ('../Utils/PageHeaders.php');
    include_once ('../Utils/ViewLoader.php');
}

