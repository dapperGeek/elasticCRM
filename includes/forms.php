<?php
/**
 * Created by PhpStorm.
 * User: Bakar U.A
 * Date: 10/4/2019
 * Time: 12:20 PM
 */

    $err = $msg = '';

    // IT/Admin update user password form script
    if (isset($_POST['update-pass'])){
        $password = password_hash($database->test_input($_POST['password']), PASSWORD_BCRYPT);
        $id = $_POST['id'];
        $update_pass = $database->updatePassword($id, $password);
        $ps_msg = $update_pass == null ? 'Error updating password' : $update_pass;
    }

    // User password update script
    if(isset($_POST['btnEditPassword'])){
        $pass1 = $database->test_input($_POST['txtpass1']);
        $pass2 = $database->test_input($_POST['txtpass2']);
        $pass3 = $database->test_input($_POST['txtpass3']);


        if($pass1 != "" && $pass2 != "" && $pass3 != ""){
            if($pass2 == $pass3){
                if(password_verify($pass1, $myData['password'])){
                    $database->updateStaffUserPassword($myData['id'],$pass2);
                    $msg = "Password successfully changed! You will now be  logged out";}
                else{
                    $err = "Old password does not match";
                }

            }else{
                $err = "passwords do not match";
            }

        }else{
            if($pass1 == ""){$err.= "<li>Enter old password</li>";}
            if($pass2 == ""){$err.= "<li>Enter new password</li>";}
            if($pass3 == ""){$err.= "<li>re-enter old password</li>";}
        }

    }

    // implementation of advanced search for the service calls
    if (isset($_POST['calls_search'])){
        $period = $_POST['period'];
        $engID = $_POST['engineer'];
        $eng = $engID == 0 ? ' != ' . 0 : ' = ' . $engID;
        $yearInReview = $_POST['year'] == 0 ? date('Y') : $_POST['year'] ;
        $quarterStart = $yearInReview . '-01-01';
        $quarterEnd = $yearInReview . '-12-30';
        $quarter = '';

        switch ($period){
            case 0:
                $quarterStart = "$yearInReview-01-01";
                $quarterEnd = "$yearInReview-12-30";
                break;
            case 1:
                $quarterStart = "$yearInReview-01-01";
                $quarterEnd =  "$yearInReview-03-31";
                $quarter = '1st Quarter';
                break;
            case 2:
                $quarterStart = "$yearInReview-04-01";
                $quarterEnd = "$yearInReview-06-30";
                $quarter = '2nd Quarter';
                break;
            case 3:
                $quarterStart = "$yearInReview-07-01";
                $quarterEnd = "$yearInReview-09-30";
                $quarter = '3rd Quarter';
                break;
            case 4:
                $quarterStart = "$yearInReview-10-01";
                $quarterEnd = "$yearInReview-12-31";
                $quarter = '4th Quarter';
                break;
        }

        $serviceCalls = $database->getAdvancedServiceCallSearch($quarterStart, $quarterEnd, $eng);
    }
    else{
        // get all service calls if no search is done
        $serviceCalls = $database->getAllServiceCallForFollowUp();
    }
