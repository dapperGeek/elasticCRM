<?php
/**
 * Created by PhpStorm.
 * User: Uthman A. Bakar
 * Date: 14-Jul-20
 * Time: 12:41 PM
 */

require_once("../data/DBConfig.php");

    $id = $database->test_input($_POST['productID']);
    $newMain = $database->test_input($_POST['newMain']);
    $newAbj = $database->test_input($_POST['newAbj']);
    $newOffice = $database->test_input($_POST['newOffice']);
    $newDamaged = $database->test_input($_POST['newDamaged']);
    $mainEdit = $database->test_input($_POST['mainEdit']);
    $officeEdit = $database->test_input($_POST['officeEdit']);
    $abjEdit = $database->test_input($_POST['abjEdit']);
    $dmgEdit = $database->test_input($_POST['dmgEdit']);
    $mainSwitch = $database->test_input($_POST['mainSwitch']);
    $officeSwitch = $database->test_input($_POST['officeSwitch']);
    $abjSwitch = $database->test_input($_POST['abjSwitch']);
    $dmgSwitch = $database->test_input($_POST['dmgSwitch']);
    $remarks = $database->test_input($_POST['remarks']);

    $database->updateStock($id, $newMain, $newOffice, $newDamaged, $newAbj, $mainEdit, $officeEdit, $abjEdit, $dmgEdit, $mainSwitch, $officeSwitch, $abjSwitch, $dmgSwitch, $remarks);
