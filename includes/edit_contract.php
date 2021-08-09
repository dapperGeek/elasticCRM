<?php
/**
 * Created by PhpStorm.
 * User: Uthman A. Bakar
 * Date: 25-Aug-20
 * Time: 12:55 PM
 */

require_once("../data/DBConfig.php");

// implementation of edit contract info
    $id = $database->test_input($_POST['accountID']);
    $contractType = $database->test_input($_POST['contractType']);
    $cumulative = $database->test_input($_POST['cumulative']);
    $rentalCharge = $database->test_input($database->RemoveComma($_POST['rentalCharge']));
    $volMono = $database->test_input($_POST['volMono']);
    $costMono = $database->test_input($_POST['costMono']);
    $exVolMono = $database->test_input($_POST['exVolMono']);
    $exCostMono = $database->test_input($_POST['exCostMono']);
    $volColor = $database->test_input($_POST['volColor']);
    $costColor = $database->test_input($_POST['costColor']);
    $exVolColor = $database->test_input($_POST['exVolColor']);
    $exCostColor = $database->test_input($_POST['exCostColor']);
    $conStart = $database->test_input($_POST['conStart']);
    $contractDuration = $database->test_input($_POST['contractDuration']);
    $billingType = $database->test_input($_POST['billingType']);

    $database->updateContract($id, $contractType, $cumulative, $rentalCharge, $volMono, $costMono, $exVolMono, $exCostMono, $costColor, $exVolColor, $exCostColor, $conStart, $contractDuration, $volColor, $billingType);
