<?php
    require_once("../data/DBConfig.php");

    $action = $_POST["action"];
    $callID = $_POST['callID'];

    return $database->deleteServiceCall($callID);