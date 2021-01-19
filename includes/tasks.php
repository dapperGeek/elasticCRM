<?php
/**
 * Created by PhpStorm.
 * User: OLUYEMI
 * Date: 15-Oct-19
 * Time: 11:54 AM
 */

// include("data/DBConfig.php");

//    $database->updatePasswords();
// echo password_hash('ta!w0t3n@ui', PASSWORD_BCRYPT);
    $state = !file_exists(dirname(__FILE__) . '/index.php') ? 'True' : 'False';
    echo $state;

//echo date("Y-m-d", '1571927688');
//$admins = $database->setUnixTimes();
