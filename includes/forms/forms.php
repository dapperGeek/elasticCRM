<?php
/**
 * Created by PhpStorm.
 * User: Bakar U.A
 * Date: 10/4/2019
 * Time: 12:20 PM
 */

    if (isset($_POST['update-pass'])){
        $password = password_hash($database->test_input($_POST['password']), PASSWORD_BCRYPT);
        $id = $_POST['id'];
        $update_pass = $database->updatePassword($id, $password);
        $ps_msg = $update_pass == null ? 'Error updating password' : $update_pass;
    }