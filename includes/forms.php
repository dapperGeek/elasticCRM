<?php
/**
 * Created by PhpStorm.
 * User: Bakar U.A
 * Date: 10/4/2019
 * Time: 12:20 PM
 */

    $err = $msg = '';
    $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

//    month variables
    $lastMonth = date('n', strtotime('last month'));
    $lastMonthDouble = date('m', strtotime('last month'));

// IT/Admin update user password form script
    if (isset($_POST['update-pass']))
    {
        $password = password_hash($database->test_input($_POST['password']), PASSWORD_BCRYPT);
        $id = $_POST['id'];
        $update_pass = $database->updatePassword($id, $password);
        $ps_msg = $update_pass == null ? 'Error updating password' : $update_pass;
    }

    // User password update script
    if(isset($_POST['btnEditPassword']))
    {
        $pass1 = $database->test_input($_POST['txtpass1']);
        $pass2 = $database->test_input($_POST['txtpass2']);
        $pass3 = $database->test_input($_POST['txtpass3']);

        if($pass1 != "" && $pass2 != "" && $pass3 != "")
        {
            if($pass2 == $pass3){
                if(password_verify($pass1, $myData['password']))
                {
                    $database->updateStaffUserPassword($myData['id'],$pass2);
                    $msg = "Password successfully changed! You will now be  logged out";
                }
                else
                {
                    $err = "Old password does not match";
                }
            }
            else
            {
                $err = "passwords do not match";
            }
        }
        else
        {
            if($pass1 == ""){$err.= "<li>Enter old password</li>";}
            if($pass2 == ""){$err.= "<li>Enter new password</li>";}
            if($pass3 == ""){$err.= "<li>re-enter old password</li>";}
        }
    }

    // implementation of advanced search for the service calls
    if (isset($_POST['btnFilterCalls']))
    {
        $curYear = date('Y');
        $days30 = array(4, 6, 9, 11);
        $lastDay = in_array($lastMonth, $days30) ? 30 : 31;
        $period = $_POST['period'];
        $engID = $_POST['engineer'];
        $eng = $engID == 0 ? ' != ' . 0 : ' = ' . $engID;
        $yearInReview = $period > 4
            ? $curYear
            : $_POST['year'] == 0 ? date('Y') : $_POST['year'];
        $quarterStart = $yearInReview . '-01-01';
        $quarterEnd = $yearInReview . '-12-30';
        $quarter = '';
        $index = ($period - 5) < 10 ? 0 . ($period - 5) : ($period - 5);

        switch ($period)
        {
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
            case 5:
                $quarterStart = "$curYear-$lastMonthDouble-01";
                $quarterEnd = "$curYear-$lastMonthDouble-$lastDay";
                $quarter = 'Last month';
                break;
            case 6:
                $quarterStart = date('Y-m-') . '01' ;
                $quarterEnd = date('Y-m-d');
                $quarter = 'This month';
                break;
        }
        $serviceCalls = $database->getAdvancedServiceCallSearch($quarterStart, $quarterEnd, $eng);
    }
    else
    {
        if ($_SESSION['dptID'] == 6 && $_SESSION['access'] < 8)
        {
            $serviceCalls = $database->getAllServiceCallForFollowUp($_SESSION['user_id']);
        }
        else
        {
            // get all service calls if no search is done
            $serviceCalls = $myData['typeID'] == 0
               ? $database->getAllServiceCallForFollowUp()
               : $database->getAccountServiceCallForFollowUp() ;
        }
    }

    // implementation of advanced search for the service calls
    if (isset($_POST['btnFilterStoreSales'])){
        $curYear = date('Y');
        $days30 = array(4, 6, 9, 11);
        $lastDay = in_array($lastMonth, $days30) ? 30 : 31;
        $period = $_POST['period'];
        $storeID = $_POST['store'];
        $store = $storeID == 0 ? ' != ' . 0 : ' = ' . $storeID;
        $yearInReview = ($period == 5)
            ? $curYear
            : $_POST['year'] == 0 ? date('Y') : $_POST['year'];
        $quarterStart = $yearInReview . '-01-01';
        $quarterEnd = $yearInReview . '-12-30';
        $quarter = '';
        $index = ($period - 5) < 10 ? 0 . ($period - 5) : ($period - 5);

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
            case 5:
                $quarterStart = "$curYear-$lastMonthDouble-01";
                $quarterEnd = "$curYear-$lastMonthDouble-$lastDay";
                $quarter = 'Last month';
                break;
            case 7:
                $quarterStart = "$yearInReview-02-01";
                $quarterEnd = "$yearInReview-02-28";
                $quarter = 'February';
                break;
            default:
                $quarterStart = "$yearInReview-$index-01";
                $quarterEnd = "$yearInReview-$index-$lastDay";
                $quarter = $months[($period - 6)];
                break;
        }
        $myOrder = $database->getFilteredStoreSales($quarterStart, $quarterEnd, $store);
    }

    // implementation of Store stock filtering
    if (isset($_POST['btnFilterStoreStock'])){
        $storeID = $database->test_input($_POST['store']);
        $categoryID = $database->test_input($_POST['category']);
        $products = array();
        switch ($storeID){
            case 0:
                $products =  (array) $database->getProductsByCategory($categoryID);
                break;
            default:
                $products = (array) $database->filterStoreStock($storeID, $categoryID);
        }
//        echo 'The store is ' . $storeID . '</br> The category is ' . $categoryID ;

        return $products;
    }

    // Implementation Create service call
    if(isset($_POST['btnRegisterCall']))
    {
        $accountID = $database->test_input($_POST['txtAccount']);
        $machineID = $database->test_input($_POST['txtMachine']);
        $reportedBy = $database->test_input($_POST['txtReporter']);
        $eng = $database->test_input($_POST['txtEngineer']);

        $cost = isset($_POST['txtAmount'])
            ? $database->test_input(str_replace(',','',$_POST['txtAmount']))
            : 0;
        $CaseStatus = $database->test_input($_POST['txtCaseStatus']);

        $paystatus = $database->test_input($_POST['txtPayStatus']);
        $issues = "";
        $user_id = $_SESSION['user_id'];
        $createdBy = $user_id;

        if(isset($_POST['issues']))
        {
            if(is_array($_POST['issues']))
            {
                foreach($_POST['issues'] as $an_issue)
                {
                    $issues = $issues.",".$database->test_input($an_issue);
                }
            }
            else
            {
                $issues = $database->test_input($_POST['issues']);
            }
        }
        $schDD = $database->test_input($_POST['txtSchDate']);
        $schD = explode("/",$schDD);

        if($accountID != "" && $machineID != "" && $reportedBy != "" && $eng != ""
            && $paystatus != "" && $issues != "" && $schDD != "")
        {
            $msg = $database->createServiceCall($accountID,$machineID,$reportedBy,$eng,$cost,$paystatus,$issues,$user_id,$CaseStatus,$schD[0],$schD[1]);

            unset($_POST);
            $lastServiceCallEntry = (array)$database->getLastServiceCall();

            foreach($lastServiceCallEntry as $entry)
            {
                $lastServiceCallTicketId = $entry['ticketNo'];
            }
            echo "<script type=\"text/javascript\">
                window.open('".$host."ticket-info/".$lastServiceCallTicketId."', '_blank')
               </script>";
        }
        else
        {
            $err = 'All fields are required to create a case';
        }
    }