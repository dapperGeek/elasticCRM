<?php

// require_once "Mail.php"; // PEAR Mail package
// require_once('Mail/mime.php'); // PEAR Mail_Mime package

    if (file_exists('../Utils/SendGrid.php'))
    {
        require_once '../Utils/SendGrid.php';
        require_once '../Utils/UtilFunctions.php';
    }
    else
    {
        require_once 'Utils/SendGrid.php';
        require_once 'Utils/UtilFunctions.php';
    }

class MySQLDatabase
{
    private $db;
    public $host;

    function __construct($DB_con, $Host)
    {
        $this->db = $DB_con;
        $this->host = $Host;
    }

    public function getException($errorMessage)
    {
        //$_SERVER['REMOTE_ADDR'],date("d-m-Y h:i:s A"),time()
        return $this->showMsg("Error!", "A system error has occured, we will fix it<br/>" . $errorMessage, 1);
    }

    public function redirect_to($host)
    {
        header("location:" . $host);
    }

    function authenticateStaff($username, $password)
    {
        $sql = "select * from staff where username =?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $username);
        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            $row = $handle->fetch(PDO::FETCH_ASSOC);
            $pass = $row['password'];

            if (password_verify($password, $pass))
            {
                return array($row['id'], $row['active']);
            }
            else
            {
                return array(1, 1);
            }
        }
        else
        {
            return array(0, 0);
        }
    }

    function test_input($data)
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    function returnSalesStageColor($stage)
    {
        if ($stage < 30)
        {
            return "danger";
        } else if ($stage >= 30 && $stage <= 59) {
            return "warning";
        } else if ($stage >= 60 && $stage <= 79) {
            return "info";
        } else if ($stage >= 80 && $stage <= 90) {
            return "primary";
        } else {
            return "success";
        }
    }

    public function getDailySales($day, $month, $year)
    {
        $sql = "select SUM(lp.qty * lp.Amount) as Amount, ocDay,
                ld.ocMonth, ocYear from service_product lp
                join machine_demand ld on lp.leadDemandID = ld.id
                where ld.orderCollect = 1
                and ld.ocDay = ?
                and ld.ocMonth = ?
                and ocYear = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $day);
        $handle->bindValue(2, $month);
        $handle->bindValue(3, $year);
        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            return $row = $handle->fetch(PDO::FETCH_ASSOC);
        }
    }

    //GENERATE MONTHLY REPORT
    public function getMonthlySales($month, $year)
    {
        $sql = "select SUM(lp.qty * lp.Amount) as Amount,ld.ocMonth, ocYear 
                from service_product lp
                 join machine_demand ld on lp.leadDemandID = ld.id
                 where ld.orderCollect = 1
                 and ld.ocMonth = ?
                 and ocYear = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $month);
        $handle->bindValue(2, $year);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return $row = $handle->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function purchaseListForMachineCollectedAllRange($from, $to)
    {
        $sql = "select md.*, sum(sp.qty * sp.Amount) as myAmount, ac.Name from `machine_demand` md
        join accounts ac on ac.id = md.accountID
        join service_product sp on md.id = sp.leadDemandID
        where md.orderCollect = 1 and (ocDMY between ? and ?) group by md.id ORDER BY md.id desc";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $from);
        $handle->bindValue(2, $to);

        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $myArray[] = $row;
            }
            return $myArray;
        }
        else
        {
            return null;
        }
    }

    function calculatePercentage($up, $down)
    {
        if ($down > 0) {
            return round(($up / $down) * 100, 2);

        } else {
            return 0;
        }
    }

    public function ValidateCompany($companyName)
    {
        $sql = "select * from `accounts` where `Name` = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $companyName);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            $row = $handle->fetch(PDO::FETCH_ASSOC);
            return true;
        } else {
            return false;
        }
    }

    public function createAccounts($leadID, $name, $address, $areaID, $contactName1, $contactName2, $contactName3, $phone1, $phone2, $phone3, $email1, $email2, $email3, $desig1, $desig2, $desig3, $ind)
    {
        $sql = "insert into `accounts` (leadID,Name,Address,areaID,ContactName1,ContactName2,ContactName3,phone1,phone2,phone3,email1,email2,email3,desig1,desig2,desig3,`timestamp`,`dateTime`,industryID) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $leadID);
        $handle->bindValue(2, $name);
        $handle->bindValue(3, $address);
        $handle->bindValue(4, $areaID);
        $handle->bindValue(5, $contactName1);
        $handle->bindValue(6, $contactName2);
        $handle->bindValue(7, $contactName3);
        $handle->bindValue(8, $phone1);
        $handle->bindValue(9, $phone2);
        $handle->bindValue(10, $phone3);
        $handle->bindValue(11, $email1);
        $handle->bindValue(12, $email2);
        $handle->bindValue(13, $email3);
        $handle->bindValue(14, $desig1);
        $handle->bindValue(15, $desig2);
        $handle->bindValue(16, $desig3);
        $handle->bindValue(17, time());
        $handle->bindValue(18, date("l jS \of F Y h:i:s A"));
        $handle->bindValue(19, $ind);
        $handle->execute();
    }

    public function updateAccountInfo($accID, $name, $address, $areaID, $contactName1, $contactName2, $contactName3, $phone1, $phone2, $phone3, $email1, $email2, $email3, $desig1, $desig2, $desig3, $ind)
    {
        $sql = "update `accounts` set Name = ?,Address= ?,areaID= ?,ContactName1= ?,ContactName2= ?,ContactName3= ?,phone1= ?,phone2= ?,phone3= ?,email1= ?,email2= ?,email3= ?,desig1= ?,desig2= ?,desig3= ?,industryID= ? where id = ?";
        //17
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $name);
        $handle->bindValue(2, $address);
        $handle->bindValue(3, $areaID);
        $handle->bindValue(4, $contactName1);
        $handle->bindValue(5, $contactName2);
        $handle->bindValue(6, $contactName3);
        $handle->bindValue(7, $phone1);
        $handle->bindValue(8, $phone2);
        $handle->bindValue(9, $phone3);
        $handle->bindValue(10, $email1);
        $handle->bindValue(11, $email2);
        $handle->bindValue(12, $email3);
        $handle->bindValue(13, $desig1);
        $handle->bindValue(14, $desig2);
        $handle->bindValue(15, $desig3);
        $handle->bindValue(16, $ind);
        $handle->bindValue(17, $accID);

        $handle->execute();
        $msg = "edited basic information about " . $name;
        $this->createActivityNotifications($msg, 0, $accID);
    }

    function generateRandomString($length = 10)
    {
        $characters = '3456789BCDGHIJKLMPQSUVWXY';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function createTicketNo()
    {
        $leadName = "EL25-";
        $leadName .= $this->generateRandomString(5);
        return $leadName;
    }

    public function createTicketNoNew()
    {
        $lastTicketString = $this->getServiceCallDatabaseLastEntry()['ticketNo'];
        $leadName = strtoupper(date('M')) . "-";

        return $this->generateNextSerial($leadName, $lastTicketString);
    }

    public function generateNextSerial($leadName, $ticketString) : string
    {
        $suffix = '-' . date('y');
        $str_arr = explode("-", $ticketString);
        $leadFormer = $str_arr[0] . "-";
        $floatValue = '0.' . $str_arr[1];
        $floatValue1 = (float)$floatValue;
        $floatValue2 = $leadFormer == $leadName ? ($floatValue1 + 0.00001) : 0.00001;
        $floatValueString = explode(".", number_format($floatValue2, 5, '.', ''));
        return $leadName . $floatValueString[1] . $suffix;
    }

    public function createSerialNumber($officeID, $transType)
    {
        $officeTag = $officeID == 3 ? 'TENABJ' : 'TENLAG';
        $location = $officeID == 3 ? 'ABUJA' : 'LAGOS';
//        $leadString = $officeTag . strtoupper(date('M')) . '-';
        $leadString = $officeTag . '-';
        $lastTicketString = $this->getGoodsReceivedDatabaseLastEntry($leadString)['serialNumber'];
        $str_arr = explode("-", $lastTicketString);
        $leadFormer = $str_arr[0] . "-";
        // var_dump('0.'.$str_arr[1]);
        $floatValue = '0.' . $str_arr[1];
//        var_dump((float)$floatValue);
        $floatValue1 = (float)$floatValue;
        $floatValue2 = $leadFormer == $leadString ? ($floatValue1 + 0.00001) : 0.00001;
        $floatValueString = explode(".", number_format($floatValue2, 5, '.', ''));
        // var_dump(number_format($floatValue2,5,'.',''));
        $serialNumber = $leadString . $floatValueString[1];
        $serialString = $transType == 'RECIEVED' ? $location : $serialNumber;
//        var_dump($ticketNumber);
        return $serialString;
    }

    function getGoodsReceivedDatabaseLastEntry($leadString)
    {
        $sql = "SELECT * FROM `goods_recieved` WHERE `serialNumber` LIKE '$leadString%'  ORDER BY id DESC LIMIT 1";

        $handle = $this->db->prepare($sql);
        //$handle->bindValue(1,$eng);
        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            //var_dump($handle->fetch(PDO::FETCH_ASSOC));
            return $handle->fetch(PDO::FETCH_ASSOC);

        }
        else
        {
            return false;
        }
    }

    function getServiceCallDatabaseLastEntry()
    {

        $sql = "SELECT * FROM service_call ORDER BY id DESC LIMIT 1";

        $handle = $this->db->prepare($sql);
        //$handle->bindValue(1,$eng);
        $handle->execute();
        if ($handle->rowCount() > 0)
        {

            //var_dump($handle->fetch(PDO::FETCH_ASSOC));
            return $handle->fetch(PDO::FETCH_ASSOC);

        }
        else {
            return false;
        }
    }

    function getSingleUserInformation($id)
    {
        $sql = "SELECT * FROM staff WHERE id = ?";

        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            return $handle->fetch(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

    function checkDuplicateCall($accountID, $machineID, $reportedBy, $eng, $cost, $payStatus, $user_id, $CaseStatus, $schD)
    {
        $found = false;

        $checkSql = "SELECT * from service_call ORDER BY ID DESC LIMIT 20";
        $handle = $this->db->prepare($checkSql);
        $handle->execute();
        $row = $handle->fetch(PDO::FETCH_ASSOC);

        if($row['account_id'] == $accountID && $row['machine_id'] == $machineID
            && $row['reportedBy'] == $reportedBy && $row['engineer'] == $eng
            && $row['openedBy'] == $user_id
            && $row['caseStatus'] == $CaseStatus && $row['$schDate'] == $schD
            && $row['cost'] == $cost && $row['paymentStatus'] == $payStatus)
        {
            $found = true;
        }
        return $found;
    }

    function createServiceCall($accountID, $machineID, $reportedBy, $eng, $cost, $payStatus, $issues, $user_id, $CaseStatus, $schD, $schT)
    {
        $duplicate = $this->checkDuplicateCall($accountID, $machineID, $reportedBy, $eng, $cost, $payStatus, $user_id, $CaseStatus, $schD);

        if ($duplicate == false)
        {
            $sql = "insert into `service_call` (ticketNo, account_id, machine_id, ReportedBy,engineer,cost,paymentStatus,issues,purchase,openedBy,openedDateTime,openedTimeStamp,closedBy,CaseStatus,schDate,schTime)
            values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $purchase = 0;
            $ticket = $this->createTicketNoNew();
            $handle = $this->db->prepare($sql);
            $handle->bindValue(1, $ticket);
            $handle->bindValue(2, $accountID);
            $handle->bindValue(3, $machineID);
            $handle->bindValue(4, $reportedBy);
            $handle->bindValue(5, $eng);
            $handle->bindValue(6, $cost);
            $handle->bindValue(7, $payStatus);
            $handle->bindValue(8, $issues);
            $handle->bindValue(9, $purchase);
            $handle->bindValue(10, $user_id);
            $handle->bindValue(11, date("l jS \of F Y h:i:s A"));
            $handle->bindValue(12, time());
            $handle->bindValue(13, 0);
            $handle->bindValue(14, $CaseStatus);
            $handle->bindValue(15, $schD);
            $handle->bindValue(16, $schT);
            $handle->execute();
            $lasID = $this->db->lastInsertId();
            $accountName = $this->getSingleAccountInformation($accountID)['Name'];
            $machineName = $this->getSingleMachineInformation($machineID)['machine_code'];
            $engineerName = $this->getSingleUserInformation($eng)['fullname'];
            $engineerEmail = $this->getSingleUserInformation($eng)['email'];
            $message = "added a new service call for   : <a href='" . $this->host . "machine-info/" . $machineID . "'></a>" . $machineName . "</a> assigned to <a href='" . $this->host . "account-info/" . $accountID . "'>" . $accountName . "</a>";

            // use actual sendGrid username and password in this section
            $url = SendGrid::$url;
            $user = SendGrid::$username;
            $password = SendGrid::$password;
            $email = SendGrid::$supportEmail;

            $subject = "Service Call For $accountName With Ticket No $ticket";

            $message = "Dear engineer $engineerName,  \n<br> Please be informed that a service call has been assigned to you. You are to visit $accountName customer for service. \n<br> Kindly find details in the service ticket. \n<br> \n<br> Please do not reply to this email, this address is not monitored. Please Contact customer care.";

            $cMessage = "Dear " . ucwords(strtolower($accountName)) . ", Thank you for getting in touch with us. Your call has been logged and our support engineer has been deputed to resolve it. He will be in touch with you shortly.<br>Thank you for the anticipated understanding.<br>Kind regards.";
            $cEmail = $this->getSingleAccountInformation($accountID)['email1'];
            $cSubject = "Your Call Has Been Logged";
            $cJson_string = array(
                'to' => array($cEmail, $email),
                'category' => 'test_category'
            );

            $cParams = array(
                'api_user' => $user,
                'api_key' => $password,
                'x-smtpapi' => json_encode($cJson_string),
                'to' => $cEmail,
                'replyto' => "",
                'subject' => "$cSubject", // Either give a subject for each submission, or set to $subject
                'html' => "<html lang='en'><head><meta http-equiv=\"Content-Type\" content=\"text/html\"; charset=\"utf-8\"><title>Thank You For The Feedback</title></head><body>
            $cMessage </body></html>", // Set HTML here.  Will still need to make sure to reference post data names
                'text' => "$cMessage",
                'from' => $email, // set from address here, it can really be anything
            );

            // note the above parameters now referenced in the 'subject', 'html', and 'text' sections
            // make the to email be your own address or where ever you would like the contact form info sent

            $json_string = array(
                'to' => array($engineerEmail, 'talal@tenaui.com', 'elfarra@tenaui.com', 'sameh@tenaui.com'
                ),
                'category' => 'test_category'
            );

            $params = array(
                'api_user' => $user,
                'api_key' => $password,
                'x-smtpapi' => json_encode($json_string),
                'to' => $email,
                'replyto' => "",
                'subject' => "$subject", // Either give a subject for each submission, or set to $subject
                'html' => "<html lang='en'><head><title>Contact Form</title></head><body>
            $message </body></html>", // Set HTML here.  Will still need to make sure to reference post data names
            'text' => "$message",
            'from' => $email, // set from address here, it can really be anything
        );

            $request = $url . 'api/mail.send.json';
            // Generate curl request
            $session = curl_init($request);
            // set the curl SSL version
            curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
            // Tell curl to use HTTP POST
            curl_setopt($session, CURLOPT_POST, true);
            // Tell curl that this is the body of the POST
            curl_setopt($session, CURLOPT_POSTFIELDS, $params);
            curl_setopt($session, CURLOPT_POSTFIELDS, $cParams);
            // Tell curl not to return headers, but do return the response
            curl_setopt($session, CURLOPT_HEADER, false);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
            // obtain response
            curl_exec($session);
            curl_close($session);
            // Redirect to thank you page upon successful completion, will want to build one if you don't already have one available

            $this->createActivityNotifications($message, $machineID, $accountID);
            $ticketUrl = $this->host . 'ticket-info/' . $ticket;

            return 'SERVICE CALL HAS BEEN LOGGED WITH TICKET NUMBER :<a href="' . $ticketUrl . '" class="btn btn-success">' . $ticket . '</a>______TICKET HAS BEEN OPENED FOR PRINTING IN NEW TAB';

            // print everything out
            // print_r($response);
        }
    }

    function getServiceCall($callID)
    {
        $myArray = [];
        $sql = "SELECT * FROM `service_call` WHERE `id` = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $callID);
        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            $row = $handle->fetch(PDO::FETCH_OBJ);
            $myArray = $row;
        }
        return $myArray;
    }

    function updateServiceCall($accountID, $machineID, $reportedBy, $eng, $cost, $payStatus, $issues, $user_id, $CaseStatus, $schD, $schT, $callID,$ticketNo)
    {
        $sql = "update `service_call` set `account_id` = ?, `machine_id` = ?  , `ReportedBy` = ?, `engineer` = ?, `cost` = ?, `paymentStatus` = ?, `issues` = ?, `openedBy` = ?,  `CaseStatus` = ?, `schDate` = ?, `schTime` = ? where `id` = ?";

        $purchase = 0;
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $accountID);
        $handle->bindValue(2, $machineID);
        $handle->bindValue(3, $reportedBy);
        $handle->bindValue(4, $eng);
        $handle->bindValue(5, $cost);
        $handle->bindValue(6, $payStatus);
        $handle->bindValue(7, $issues);
        $handle->bindValue(8, $user_id);
        $handle->bindValue(9, $CaseStatus);
        $handle->bindValue(10, $schD);
        $handle->bindValue(11, $schT);
        $handle->bindValue(12, $callID);
        $handle->execute();
        $accountName = $this->getSingleAccountInformation($accountID)['Name'];
        $machineName = $this->getSingleMachineInformation($machineID)['machine_code'];
        $message = "Updated service call for   : <a href='" . $this->host . "machine-info/" . $machineID . "'></a>" . $machineName . "</a> assigned to <a href='" . $this->host . "account-info/" . $accountID . "'>" . $accountName . "</a>";

        $ticketUrl = $this->host . 'ticket-info/' . $ticketNo;

        return 'SERVICE CALL HAS BEEN UPDATED FOR TICKET NUMBER :<a href="' . $ticketUrl . '" class="btn btn-success">' . $ticketNo . '</a>______TICKET HAS BEEN OPENED FOR PRINTING IN NEW TAB';
    }

    function getLastServiceCall()
    {
        $sql = "SELECT * FROM `service_call` ORDER BY ID DESC LIMIT 1";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function createPreventiveMaintenanceCall($MIF_id, $accountID, $machineID, $eng, $nextSchDateTxt, $schD, $schT, $pmID, $meterReadingMono, $meterReadingColor)
    {
        $nextSchedule = date('Y-m-d', strtotime($nextSchDateTxt));

        $upSql = "update `preventive_maintenance_schedule` set `CaseStatus` = 1 where `machine_in_field_id` = $MIF_id and `account_id` = $accountID and `CaseStatus` = 0";
        $handle = $this->db->prepare($upSql);
        $handle->execute();

        $sql = "insert into `preventive_maintenance_schedule` (machine_in_field_id,account_id, machine_id,engineer,NextScheduledDateTime,CaseStatus,scheduleDate,scheduleTime,meterReadingMono,meterReadingColour,nextSchedule)
        values (?,?,?,?,?,?,?,?,?,?,?)";

        //$purchase = 0;
        $CaseStatus = 0;
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $MIF_id);
        $handle->bindValue(2, $accountID);
        $handle->bindValue(3, $machineID);
        $handle->bindValue(4, $eng);
        $handle->bindValue(5, $nextSchDateTxt);
        $handle->bindValue(6, $CaseStatus);
        $handle->bindValue(7, $schD);
        $handle->bindValue(8, $schT);
        $handle->bindValue(9, $meterReadingMono);
        $handle->bindValue(10, $meterReadingColor);
        $handle->bindValue(11, $nextSchedule);
        $handle->execute();
        $lastID = $this->db->lastInsertId();
        /*$accountName = $this->getSingleAccountInformation($accountID)['Name'];
        $machineName = $this->getSingleMachineInformation($machineID)['machine_code'];
        $engineerName = $this->getSingleUserInformation($eng)['fullname'];
         $engineerEmail = $this->getSingleUserInformation($eng)['email'];*/

//        if($pmID != false) {
//            $CaseStatus = 0;
//            $sql = "update `preventive_maintenance_schedule` set CaseStatus = ? where id = ?";
//
//            $handle = $this->db->prepare($sql);
//            $handle->bindValue(1, $CaseStatus);
//            $handle->bindValue(2, $pmID);
//
//            $handle->execute();
//        }
    }

    function getLastSellProductStock()
    {

        $sql = "SELECT * FROM `goods_recieved` ORDER BY ID DESC LIMIT 1";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function getPaymentStatus()
    {
        $sql = "select * from payment_status";
        $myArray = array();
        $handle = $this->db->prepare($sql);
//        $handle->bindValue(1,$id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function getDeliveryStatus()
    {
        $sql = "select * from delivery_status";
        $myArray = array();
        $handle = $this->db->prepare($sql);
//        $handle->bindValue(1,$id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function AddNewPurchase($product, $qty, $amount, $machineID, $accountID, $scID, $discount, $serviceCharge, $transportCharge, $salesType, $paymentMode)
    {

        if (count($product) > 0)
        {
            if ($scID > 0)
            {
                $this->updateFollowUpPurchase($scID);
            }
            $this->addMachineDemandProduct($scID, $product, $qty, $amount, $machineID, $accountID, $discount, $serviceCharge, $transportCharge, $salesType, $paymentMode);
        }
    }

    function AddNewProductStock($supplier, $invoiceNo, $fileRef, $storeID, $product, $qty, $save, $invoiceDate)
    {
        if (count($product) > 0)
        {
            $this->addNewStockToProduct($supplier, $invoiceNo, $fileRef, $storeID, $product, $qty, $save, $invoiceDate);
            //  $this->addMachineDemandProduct($scID,$product,$qty,$amount,$machineID,$accountID,$discount);
        }
    }

    function SellProductStock($supplier, $invoiceNo, $fileRef, $storeID, $product, $qty, $save, $invoiceDate, $sold, $receivingStoreId, $productAmounts = 0)
    {
        if (count($product) > 0)
        {
            $this->SellNewStockToProduct($supplier, $invoiceNo, $fileRef, $storeID, $product, $qty, $save, $invoiceDate, $sold, $receivingStoreId, $productAmounts);
            //  $this->addMachineDemandProduct($scID,$product,$qty,$amount,$machineID,$accountID,$discount);
        }
    }

    public function checkInvoiceNo($inv_num)
    {
        $sql = "select * from goods_recieved where invoiceNo = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $inv_num);
        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function AddStockItems($supplier, $invoiceNo, $fileRef, $storeID, $product, $qty, $save, $invoiceDate, $transType)
    {
        $userID = $_SESSION['user_id'];
        $officeID = $this->getMyUserOffice($userID)['officeID'];
        $mainID = 0;

        // Checks for duplicate Goods received transaction
        $duplicate = $this->checkDuplicateGROrder($supplier,$invoiceNo,$fileRef,$storeID,$invoiceDate,$transType);
        if ($duplicate == false)
        {
            $sql = "INSERT INTO goods_recieved (supplierID,invoiceNo,FileReference,storeID,doneBy,saved,TicketNo,invoiceDate,DateCreated,lastModified,transType,serialNumber)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            $handle = $this->db->prepare($sql);
            $ticketGen = "GRT-". $this->createTicketNo();
            $serialNo = $this->createSerialNumber($officeID, $transType);
            $handle->bindValue(1, $supplier);
            $handle->bindValue(2,$invoiceNo);
            $handle->bindValue(3, $fileRef);
            $handle->bindValue(4, $storeID);
            $handle->bindValue(5,$_SESSION['user_id']);
            $handle->bindValue(6, $save);
            $handle->bindValue(7,$ticketGen);
            $handle->bindValue(8, $invoiceDate);
            $handle->bindValue(9,date("l jS \of F Y h:i:s A"));
            $handle->bindValue(10, time());
            $handle->bindValue(11,$transType);
            $handle->bindValue(12,$serialNo);
            $handle->execute();
            $mainID = $this->db->lastInsertId();
            return $mainID;
        }
    }

    // Checks for duplicate Goods received transaction
    public function checkDuplicateGROrder($supplier,$invoiceNo,$fileRef,$storeID,$invoiceDate,$transType)
    {
        $found = false;
        $userID = $_SESSION['user_id'];

        $checkSql = "SELECT * from goods_recieved ORDER BY ID DESC LIMIT 20";
        $handle = $this->db->prepare($checkSql);
        $handle->execute();
        $row = $handle->fetch(PDO::FETCH_ASSOC);

        if($row['supplierID'] == $supplier && $row['FileReference'] == $fileRef
            && $row['invoiceNo'] == $invoiceNo
            && $row['storeID'] == $storeID && $row['doneBy'] == $userID
            && $row['invoiceDate'] == $invoiceDate && $row['transType'] == $transType)
        {
            $found = true;
        }
        return $found;
    }

    public function getMyUserOffice($id)
    {
        $sql = "select * from staff where id =  ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);

        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            return $row = $handle->fetch(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

    public function GoodsLog($product, $added, $transferred, $sold, $returned, $edited, $remain, $storeID, $invoiceNo, $remarks, $doneBy = 0)
    {
        $editedBy = $doneBy == 0 ? $_SESSION['user_id'] : $doneBy;
        $sql = "INSERT INTO  goodslog (productID,added,transfered,sold,returned,edited,remain,ocDay,ocMonth,ocYear,ocDMY,`dateTime`,storeID,doneBy,InvoiceNo,`remarks`)
            VALUES ( ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $handle = $this->db->prepare($sql);
        $ticketGen = $this->createTicketNo();
        $handle->bindValue(1, $product);
        $handle->bindValue(2, $added);
        $handle->bindValue(3, $transferred);
        $handle->bindValue(4, $sold);
        $handle->bindValue(5, $returned);
        $handle->bindValue(6, $edited);
        $handle->bindValue(7, $remain);
        $handle->bindValue(8, date('d'));
        $handle->bindValue(9, date('m'));
        $handle->bindValue(10, date('Y'));
        $handle->bindValue(11, date('Y') . date('m') . date('d'));
        $handle->bindValue(12, date("l jS \of F Y h:i:s A"));
        $handle->bindValue(13, $storeID);
        $handle->bindValue(14, $editedBy);
        $handle->bindValue(15, $invoiceNo);
        $handle->bindValue(16, $remarks);
        $handle->execute();
    }

    function getProductStoreQty($productID, $storeID)
    {
        $sql = "select store" . $storeID . " as qty from products where id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $productID);
        $handle->execute();
        $row = $handle->fetch(PDO::FETCH_ASSOC);
        return $row['qty'];
    }

    public function getWarehouseIdfromName($storeName)
    {
        $sql = "select id from stores where storeName = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $storeName);
        $handle->execute();
        $row = $handle->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    }

    function UpdateStoreQty($productID, $storeID, $remain)
    {
        $sql = "update products set store" . $storeID . " = ? where id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $remain);
        $handle->bindValue(2, $productID);
        $handle->execute();
    }

    function addGoodsRecievedGoods($mainID, $productID, $currentQty, $addedQty, $TransferedQty, $SoldQty, $amount = 0)
    {
        $sql = "INSERT INTO  goods_recieved_goods (goodRecievedID,productID,currentQty,AddedQty,TransferedQty,SoldQty,amount)VALUES (?,?,?,?,?,?,?)";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $mainID);
        $handle->bindValue(2, $productID);
        $handle->bindValue(3, $currentQty);
        $handle->bindValue(4, $addedQty);
        $handle->bindValue(5, $TransferedQty);
        $handle->bindValue(6, $SoldQty);
        $handle->bindValue(7, UtilFunctions::removeComma($amount));
        $handle->execute();
    }

    function updateGoodsTransferStatus($mainID, $storeID, $supplier, $invoiceNo)
    {
        $sql = "INSERT INTO  warehouse_transfer_tracking (goods_recieved_id,transfer_from_store_id,receiving_store_id,transfer_status)VALUES (?,?,?,?)";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $mainID);
        $handle->bindValue(2, $storeID);
        $handle->bindValue(3, $supplier);
        $handle->bindValue(4, $invoiceNo);
        $handle->execute();
    }

    public function getAllGoodsRecieved()
    {
        $sql = "select gr.*, sp.supplierName, stf.fullname, st.storeName  from goods_recieved gr
       join stores st on st.id = gr.storeID
       join staff stf  on stf.id = gr.doneBy
       join suppliers sp on sp.id = gr.supplierID where saved = 1 and transType = 'RECIEVED'";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        //$handle->bindValue(1,$id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    public function getAllGoodsInTransitForWareHouse($storeId)
    {
        $sql = "select wh.*, gr.*, st.storeName, stf.fullname from warehouse_transfer_tracking wh
       join goods_recieved gr on gr.id = wh.goods_recieved_id
       join stores st on st.id = wh.transfer_from_store_id
       join staff stf  on stf.id = gr.doneBy
       where transfer_status = 'TRANSFER' and receiving_store_id=?";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $storeId);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    public function getAllGoodsLeft()
    {
        $sql = "select gr.*, stf.fullname, st.storeName  from goods_recieved gr
        join stores st on st.id = gr.storeID
        join staff stf  on stf.id = gr.doneBy
        where saved = 1 and transType != 'RECIEVED' ";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        //$handle->bindValue(1,$id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    public function getAllGoodsLeft2()
    {
        $sql = "select gr.*, stf.fullname, st.storeName  from goods_recieved gr
       join stores st on st.id = gr.storeID
       join staff stf  on stf.id = gr.doneBy
       where saved = 1 and transType != 'RECIEVED'  ORDER BY id DESC";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        //$handle->bindValue(1,$id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    public function getAllGoodsLeft3()
    {
        $sql = "select gr.*, stf.fullname, st.storeName, dt.deliveryStatus  from goods_recieved gr
       join stores st on st.id = gr.storeID
       join staff stf  on stf.id = gr.doneBy
       left join delivery_tracking dt on dt.order_id = gr.id
       where saved = 1 and transType != 'RECIEVED'  ORDER BY id DESC";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        //$handle->bindValue(1,$id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function getAllProductsForDropDown()
    {
        $myArray = array();
        $handle = $this->db->prepare("select p.*, pt.type from products p join producttype pt on pt.id = p.ProductType where p.active = 1 and p.ProductType > 1 order by p.ProductType asc, p.productName asc");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }

    }

    function getAllProductsForDropDownSparePart()
    {
        $myArray = array();
        $handle = $this->db->prepare("select p.*, pt.type from products p join producttype pt on pt.id = p.ProductType where p.active = 1 and p.ProductType = 5 order by p.ProductType asc, p.productName asc");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }

    }

    function getAllMachineProducts()
    {
        $myArray = array();
        $handle = $this->db->prepare("SELECT * FROM products WHERE active = 1 ORDER BY productName");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }

    }

    function getAllUnits()
    {
        $myArray = array();
        $handle = $this->db->prepare("select * from `units`");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function getAllSupplier()
    {
        $myArray = array();
        $handle = $this->db->prepare("select * from suppliers");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        }
    }

    function getSingleTicketInformation($id)
    {
        $sql = "SELECT * FROM service_call WHERE id = ?";

        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return $handle->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    function getAllStores()
    {
        $myArray = array();
        $handle = $this->db->prepare("select * from stores");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        }
    }

    function getAllProductsForDropDownWareHouse()
    {
        $myArray = array();
        $handle = $this->db->prepare("select p.*, u.unitName, pt.type from products p
        join producttype pt on pt.id = p.ProductType
        left join units u on u.id = p.unitID
        where p.active = 1 order by p.ProductType asc, p.productName asc");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }

    }

    public function getIndGoodsRecieved($id)
    {
        $sql = "select gr.*, sp.supplierName, stf.fullname, st.storeName 
        from goods_recieved gr
       join stores st on st.id = gr.storeID
       join staff stf  on stf.id = gr.doneBy
       join suppliers sp on sp.id = gr.supplierID where saved = 1 and gr.id = ?";
        // $myArray = array();
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            return $row = $handle->fetch(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

    public function getIndGoodsRemoved($id)
    {
        $sql = "select gr.*, stf.fullname, st.storeName from goods_recieved gr
       join stores st on st.id = gr.storeID
       join staff stf  on stf.id = gr.doneBy
       where saved = 1 and gr.id = ?";
        // $myArray = array();
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            return $row = $handle->fetch(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

    public function getIndGoodsRemovedDeliveryUpdate($id)
    {
        $sql = "select gr.*, stf.fullname, st.storeName, dt.deliveryStatus, dt.deliveryMode, dt.driverName, dt.driverNumber, dt.vehicleNumber, dt.logisticCompanyName, dt.deliveryWayBillNumber1, dt.logisticCoyPhoneNum, dt.contactNameAir, dt.wayBillNumberAir, dt.phoneNumberAir, dt.driverName2, dt.driverNumber2, dt.departureLocation, dt.senderName, dt.InHouseCustomerName, dt.InHouseCustomerNumber, dt.InHouseCustomerAddress from goods_recieved gr
       join stores st on st.id = gr.storeID
       join delivery_tracking dt on dt.order_id = gr.id
       join staff stf  on stf.id = gr.doneBy
       where saved = 1 and gr.id = ?";
        // $myArray = array();
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return $row = $handle->fetch(PDO::FETCH_ASSOC);

        } else {
            return false;
        }
    }

    public function getAllGoodsAddedForRecieve($id)
    {
        $sql = "select  grg.*, p.productName, p.Code, u.unitName from goods_recieved_goods grg
       join products p on p.id = grg.productID
       left join units u on u.id = p.unitID

      where grg.goodRecievedID = ?";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    public function getAllGoodsAddedForRecieve2($id)
    {
        $sql = "select  grg.*, p.productName, p.Code, u.unitName from goods_recieved_goods grg
       join products p on p.id = grg.productID
       left join units u on u.id = p.unitID
       join goods_recieved gr on gr.id = grg.goodRecievedID
       join delivery_tracking dt on dt.order_id = grg.goodRecievedID

      where grg.goodRecievedID = ?";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    public function addNewStockToProduct($supplier, $invoiceNo, $fileRef, $storeID, $product, $qty, $save, $invoiceDate)
    {
        $mainID = $this->AddStockItems($supplier, $invoiceNo, $fileRef, $storeID, $product, $qty, $save, $invoiceDate, "RECIEVED");
        $count = count($product);
        $grt = $this->getIndGoodsRecieved($mainID);
        $productsData = (array)$this->getAllGoodsAddedForRecieve($mainID);

        if ($count > 0 && !empty($product) && $mainID > 0)
        {
            for ($i = 0; $i < $count; $i++)
            {
                $productID = $product[$i];
                $added = $qty[$i];
                $currentQty = $this->getProductStoreQty($productID, $storeID);
                $remain = $currentQty + $added;
                //$this->addGoodsRecievedGoods($mainID,$productID,$currentQty,$added);
                $this->addGoodsRecievedGoods($mainID, $productID, $currentQty, $added, 0, 0);

                if ($save == 1)
                {
                    //$this->GoodsLog($productID,$added,0,0,0,$remain,$storeID,$invoiceNo);
                    $this->GoodsLog($productID, $added, 0, 0, 0, 0, $remain, $storeID, "RECIEVED", "");
                    $this->UpdateStoreQty($productID, $storeID, $remain);
                }
            }

            // Implement notification emails to team
            SendGrid::stockEmails($grt, $productsData);

            // Show success message
            $this->showMsg('Success', 'Items successfully received <a href="' . $this->host . 'goods-recieved-ticket/' . $mainID . '"class="btn btn-success">CLICK HERE TO OPEN TICKET</a>', 2);

        }
        else
        {
            $this->showMsg('Error', 'Duplicate Received Ticket Exists', 1);
        }

    }

    public function SellNewStockToProduct($supplier, $invoiceNo, $fileRef, $storeID, $product, $qty, $save, $invoiceDate, $sold, $receivingStoreId, $productAmounts)
    {
        $sold_ = $sold == 1 ? "SOLD" : "TRANSFERED";
        /*var_dump($sold);
        var_dump($sold_);
        exit;*/
        // var_dump($product);
        $mainID = $this->AddStockItems($supplier, $invoiceNo, $fileRef, $storeID, $product, $qty, $save, $invoiceDate, $sold_);

        $count = count($product);
        if ($count > 0 && !empty($product))
        {
            for ($i = 0; $i < $count; $i++)
            {
                $productID = $product[$i];
                $added = $qty[$i];
                $productAmount = $productAmounts[$i];
                $currentQty = $this->getProductStoreQty($productID, $storeID);
                $remain = $currentQty - $added;
                if ($sold == 1)
                {
                    $this->addGoodsRecievedGoods($mainID, $productID, $currentQty, $added, 0, 0, $productAmount);
                }
                else if ($sold == 2)
                {
                    $this->addGoodsRecievedGoods($mainID, $productID, $currentQty, $added, 0, 0, $productAmount);
                    $this->updateGoodsTransferStatus($mainID, $storeID, $receivingStoreId, $invoiceNo);
                }

                // $this->addGoodsRecievedGoods($mainID,$productID,$currentQty,$added);
                if ($save == 1)
                {
                    // $product,$added,$transfered,$sold,$returned,$remain,$storeID
                    if ($sold == 1)
                    {
                        $this->GoodsLog($productID, 0, 0, $added, 0, 0, $remain, $storeID, $invoiceNo, "");
                    }
                    else if ($sold == 2)
                    {
                        $this->GoodsLog($productID, 0, $added, 0, 0, 0, $remain, $storeID, $invoiceNo, "");
                    }

                    $this->UpdateStoreQty($productID, $storeID, $remain);
                }
            }
            $this->showMsg('Success', 'This transaction has been made on this ticket <a href="' . $this->host . 'goods-sold-ticket/' . $mainID . '"class="btn btn-success" target="_blank">CLICK HERE TO OPEN WAY BILL</a>  <a href="' . $this->host . 'goods-sold-invoice/' . $mainID . '"class="btn btn-success" target="_blank">CLICK HERE TO OPEN SOF</a>', 2);
            //$accountName = $this->getSingleAccountInformation($accountID)['Name'];
            //$machineName = $this->getSingleMachineInformation($machineID)['machine_code'];
            //$message = "added a new purchase for a machine : ".$machineName. " assigned to ".$accountName;
            //$this->createActivityNotifications($message);
        }

        // Get transaction details
        $grt = $this->getIndGoodsRemoved($mainID);
        // Get product/item details
        $productsData = (array) $this->getAllGoodsAddedForRecieve($mainID);

        // Implement notification emails to team
        SendGrid::stockEmails($grt, $productsData);
    }

    function getStoreIDInfo($id)
    {
        $info = array();
        $handle = $this->db->prepare("select * from stores where id = ?");
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            $row = $handle->fetch(PDO::FETCH_ASSOC);
            $info[0] = $row['id'];
            $info[1] = $row['storeName'];
            $info[2] = $row['StoreDescription'];

        } else {
            $info[0] = 0;
            $info[1] = "NO STORE";
            $info[2] = "NO DESCRIPTION";
        }
        return $info;
    }

    function updateFollowUpPurchase($scID)
    {
        $sql = "update service_call set purchase = 1 where id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $scID);
        $handle->execute();
    }

    function createDeliveryTracking($orderID, $ticketNo, $deliveryStatus, $deliveryMode, $DriversName1, $DriversNumber1, $tenauiDriversVehicleNumber, $logisticCompanyName, $deliveryWayBillNumber1, $logisticCoyPhoneNum, $contactNameAir, $wayBillNumberAir, $phoneNumberAir, $driverName2, $driverNumber2, $departureLocation, $senderName, $inHouseCustomerName, $inHouseCustomerNumber, $inHouseCustomerAddress)
    {
        $sql = "insert into `delivery_tracking` (order_id, ticketNumber, deliveryStatus, deliveryMode, driverName, driverNumber, vehicleNumber, logisticCompanyName, deliveryWayBillNumber1, logisticCoyPhoneNum, contactNameAir, wayBillNumberAir, phoneNumberAir, driverName2, driverNumber2, departureLocation, senderName, inHouseCustomerName, inHouseCustomerNumber, inHouseCustomerAddress)
        values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";


        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $orderID);
        $handle->bindValue(2, $ticketNo);
        $handle->bindValue(3, $deliveryStatus);
        $handle->bindValue(4, $deliveryMode);
        $handle->bindValue(5, $DriversName1);
        $handle->bindValue(6, $DriversNumber1);
        $handle->bindValue(7, $tenauiDriversVehicleNumber);
        $handle->bindValue(8, $logisticCompanyName);
        $handle->bindValue(9, $deliveryWayBillNumber1);
        $handle->bindValue(10, $logisticCoyPhoneNum);
        $handle->bindValue(11, $contactNameAir);
        $handle->bindValue(12, $wayBillNumberAir);
        $handle->bindValue(13, $phoneNumberAir);
        $handle->bindValue(14, $driverName2);
        $handle->bindValue(15, $driverNumber2);
        $handle->bindValue(16, $departureLocation);
        $handle->bindValue(17, $senderName);
        $handle->bindValue(18, $inHouseCustomerName);
        $handle->bindValue(19, $inHouseCustomerNumber);
        $handle->bindValue(20, $inHouseCustomerAddress);

        $handle->execute();

    }

    function updateDeliveryTracking($orderID, $ticketNo, $deliveryStatus, $deliveryMode, $DriversName1, $DriversNumber1, $tenauiDriversVehicleNumber, $logisticCompanyName, $deliveryWayBillNumber1, $logisticCoyPhoneNum, $contactNameAir, $wayBillNumberAir, $phoneNumberAir, $driverName2, $driverNumber2, $departureLocation, $senderName, $inHouseCustomerName, $inHouseCustomerNumber, $inHouseCustomerAddress)
    {

        $sql = "update delivery_tracking set deliveryStatus=?, deliveryMode =?, driverName =?, driverNumber =?, vehicleNumber  =?, logisticCompanyName  =?, deliveryWayBillNumber1  =?, logisticCoyPhoneNum  =?, contactNameAir =?, wayBillNumberAir =?, phoneNumberAir =?, driverName2 =?, driverNumber2 =?, departureLocation =?, senderName =?, inHouseCustomerName =?, inHouseCustomerNumber =?, inHouseCustomerAddress =? where order_id =?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $deliveryStatus);
        $handle->bindValue(2, $deliveryMode);
        $handle->bindValue(3, $DriversName1);
        $handle->bindValue(4, $DriversNumber1);
        $handle->bindValue(5, $tenauiDriversVehicleNumber);
        $handle->bindValue(6, $logisticCompanyName);
        $handle->bindValue(7, $deliveryWayBillNumber1);
        $handle->bindValue(8, $logisticCoyPhoneNum);
        $handle->bindValue(9, $contactNameAir);
        $handle->bindValue(10, $wayBillNumberAir);
        $handle->bindValue(11, $phoneNumberAir);
        $handle->bindValue(12, $driverName2);
        $handle->bindValue(13, $driverNumber2);
        $handle->bindValue(14, $departureLocation);
        $handle->bindValue(15, $senderName);
        $handle->bindValue(16, $inHouseCustomerName);
        $handle->bindValue(17, $inHouseCustomerNumber);
        $handle->bindValue(18, $inHouseCustomerAddress);
        $handle->bindValue(19, $orderID);

        $handle->execute();

    }

    function followUpCall($id, $paystatus, $closeby, $closedate, $closetime, $casestatus, $workdone, $mID, $aID, $engineer, $issues, $schD, $schT, $meterReading, $colour, $Mono, $st, $et, $wd2= "")
    {
        $sql = "update service_call set paymentStatus=?, closedBy =?, closedDateTime =?, closedTimeStamp =?,CaseStatus=?, workDone =?,engineer =?,issues =?, schDate =?, schTime = ?, meterReading = ?,colour = ?, Mono = ? where id =?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $paystatus);
        $handle->bindValue(2, $closeby);
        $handle->bindValue(3, $closedate);
        $handle->bindValue(4, $closetime);
        $handle->bindValue(5, $casestatus);
        $handle->bindValue(6, $workdone);
        $handle->bindValue(7, $engineer);
        $handle->bindValue(8, $issues);
        $handle->bindValue(9, $schD);
        $handle->bindValue(10, $schT);
        $handle->bindValue(11, $meterReading);
        $handle->bindValue(12, $colour);
        $handle->bindValue(13, $Mono);
        $handle->bindValue(14, $id);
        $handle->execute();

        $this->addFollowUp($id, $workdone, $st, $et, $engineer, $schD, $meterReading, $colour, $Mono);

        $message = "followed up a service call for " . $this->getSingleAccountInformation($aID)['Name'] . " Machine : " . $this->getSingleMachineInformation($mID)['machine_code'];
        $accountName = $this->getSingleAccountInformation($aID)['Name'];
        $engineerName = $this->getSingleUserInformation($engineer)['fullname'];
        $engineerEmail = $this->getSingleUserInformation($engineer)['email'];

        $ticketNo = $this->getSingleTicketInformation($id)['ticketNo'];
        $sql = "UPDATE machine_in_field SET meterReading = ? WHERE machine_code = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $meterReading);
        $handle->bindValue(2, $this->getSingleMachineInformation($mID)['machine_code']);
        $handle->execute();

        // Send Email
        $email = $engineerEmail;
        $subject = "Followed up call for $accountName With Ticket No $ticketNo";
        $message = "Dear Customer Care, \n<br> Please be informed that a service call has been followed up by engineer $engineerName for $accountName customer ticket No $ticketNo. \n<br> Kindly find details in the followed up call. \n<br> \n<br> Please do not reply to this email, this address is not monitored. Please Contact customer care.";
        // use actual sendgrid username and password in this section
        $url = SendGrid::$url;
        $user = SendGrid::$username; // place SG username here
        $pass = SendGrid::$password; // place SG password here

        // note the above parameters now referenced in the 'subject', 'html', and 'text' sections
        // make the to email be your own address or where ever you would like the contact form info sent

        $json_string = array(

            'to' => array('support.ng@tenaui.com', 'talal@tenaui.com', 'elfarra@tenaui.com'),
            'category' => 'test_category'
        );

        $params = array(
            'api_user' => "$user",
            'api_key' => "$pass",
            'x-smtpapi' => json_encode($json_string),
            'to' => "$email",
            'replyto' => "$email",
            'subject' => "$subject", // Either give a subject for each submission, or set to $subject
            'html' => "<html><head><title>Contact Form</title><body>
        $message <body></title></head></html>", // Set HTML here.  Will still need to make sure to reference post data names
            'text' => "
       
        $message",
            'from' => $email, // set from address here, it can really be anything
        );

        $request = $url . 'api/mail.send.json';
        // Generate curl request
        $session = curl_init($request);
        // Tell curl to use HTTP POST
        curl_setopt($session, CURLOPT_POST, true);
        // Tell curl SSL_VERSION to use
//        curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        // Tell curl that this is the body of the POST
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        // obtain response
        $response = curl_exec($session);
        curl_close($session);
        // Redirect to thank you page upon successfull completion, will want to build one if you don't alreday have one available
        $this->createActivityNotifications($message, $mID, $aID);

        // print everything out
        print_r($response);
    }

    function  addFollowUp($callID, $workDone, $startTime, $stopTime, $engineer, $date, $mReading, $colour, $mono)
    {
        $followUpSql = "insert into `follow-ups`(`service-call`, `work-done`, `start-time`, `stop-time`, `engineer`, `date`, `meter_reading`, `colour`, `mono`)values(?,?,?,?,?,?,?,?,?)";
        $followHandle = $this->db->prepare($followUpSql);
        $followHandle->bindValue(1, $callID);
        $followHandle->bindValue(2, $workDone);
        $followHandle->bindValue(3, $startTime);
        $followHandle->bindValue(4, $stopTime);
        $followHandle->bindValue(5, $engineer);
        $followHandle->bindValue(6, $date);
        $followHandle->bindValue(7, $mReading);
        $followHandle->bindValue(8, $colour);
        $followHandle->bindValue(9, $mono);
        $followHandle->execute();
    }

    function getFollowUps($callID, $limit = 0)
    {
        $followArr = [];
        $sql = $limit == 0
            ? "select * from `follow-ups` where `service-call` = ? order by `id` desc"
            : "select * from `follow-ups` where `service-call` = ? order by `id` desc limit 1";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $callID);
        $handle->execute();

        if ($handle->rowCount() > 0)
        {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $followArr[] = $row;
            }
        }
        else
        {
            return false;
        }
        return $followArr;
    }

    function deleteMachineProduct($id)
    {
        $sql = "delete from service_product where id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        $message = "";
        $this->createActivityNotifications($message);
    }

//    function updateFollowUp($id, $work, $st, $et, $eng, $day)
//    {
//        $sql = "insert into `follow-ups`(`service-call`, `work-done`, `start-time`, `stop-time`, `engineer`, `date`)values(?,?,?,?,?,?)";
//        $handle = $this->db->prepare($sql);
//        $handle->bindValue(1, $id);
//        $handle->bindValue(2, $work);
//        $handle->bindValue(3, $st);
//        $handle->bindValue(4, $et);
//        $handle->bindValue(5, $eng);
//        $handle->bindValue(6, $day);
//        $handle->execute();
//    }

    function getMachineActivities($id)
    {
        $myArray = array();
        $sql = "select * from `activities` where accountID = ? order by timeStamp desc";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $myArray[] = $row;
            }
            return $myArray;
        }
        else
        {
            return false;
        }
    }

    function getCaseStatus()
    {
        $sql = "select * from casestatus order by `range`";
        $myArray = array();
        $handle = $this->db->prepare($sql);
//        $handle->bindValue(1,$id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function getMachineServiceCall($id)
    {
        $myArray = array();

        $sql = "select sc.*,mif.machine_code,mif.id as MachineID, mif.account_id as accountID, cs.caseName, 
        ac.Name as AccountName, al.areaname, l.lga, s.state,
      mif.contactName1, mif.contactEmail1, mif.contactPhone1,
        mif.serialNo, mif.Address, ct.c_name as contract, p.productName as machineBrand 
        from `service_call` sc
      JOIN machine_in_field mif on mif.id = sc.machine_id
      JOIN accounts ac on ac.id = sc.account_id
      join contracts ct on ct.id = mif.contractID
        join products p on p.id = mif.machine_type
        join area_location al on al.id = mif.areaID
        join lga l on l.id = al.lgaID
        join states s on s.id = l.stateID
      left JOIN casestatus cs on cs.id = sc.CaseStatus
       where sc.machine_id = ? order by sc.id desc";

        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }
    }

    function getAllServiceCall($month = null)
    {
        $myArray = array();
        $sql = "select sc.*,mif.machine_code,mif.id as MachineID, mif.account_id as 
            accountID, cs.caseName, ac.Name as AccountName, al.areaname, l.lga, s.state,
            mif.contactName1, mif.contactEmail1, mif.contactPhone1,
            mif.serialNo, mif.Address, ct.c_name as contract, 
            p.productName as machineBrand 
            from `service_call` sc
            JOIN machine_in_field mif on mif.id = sc.machine_id
            JOIN accounts ac on ac.id = sc.account_id
            join contracts ct on ct.id = mif.contractID
            join products p on p.id = mif.machine_type
            join area_location al on al.id = mif.areaID
            join lga l on l.id = al.lgaID
            join states s on s.id = l.stateID
            left JOIN casestatus cs on cs.id = sc.CaseStatus order by sc.id desc";

        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                if ($month != null) {
                    if (date('F-Y', $row['openedTimeStamp']) == $month . '-' . date('Y')) {
                        $myArray[] = $row;
                    } else {
                        continue;
                    }
                } else {
                    $myArray[] = $row;
                }
            }
            return $myArray;
        } else {
            return null;
        }
    }

    function getAllResolvedServiceCall($month = null)
    {
        $myArray = array();
        $sql = "select sc.*,mif.machine_code,mif.id as MachineID, mif.account_id as accountID, cs.caseName, ac.Name as AccountName, al.areaname, l.lga, s.state,
      mif.contactName1, mif.contactEmail1, mif.contactPhone1,
        mif.serialNo, mif.Address, ct.c_name as contract, p.productName as machineBrand from `service_call` sc
      JOIN machine_in_field mif on mif.id = sc.machine_id
      JOIN accounts ac on ac.id = sc.account_id
      join contracts ct on ct.id = mif.contractID
        join products p on p.id = mif.machine_type
        join area_location al on al.id = mif.areaID
        join lga l on l.id = al.lgaID
        join states s on s.id = l.stateID
      left JOIN casestatus cs on cs.id = sc.CaseStatus
      where closedBy > 0
       order by sc.id desc";

        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                if ($month != null) {
                    if (date('F-Y', $row['openedTimeStamp']) == $month . '-' . date('Y')) {
                        $myArray[] = $row;
                    } else {
                        continue;
                    }
                } else {
                    $myArray[] = $row;
                }
            }
            return $myArray;
        } else {
            return null;
        }
    }

    function dateDiff($time1, $time2, $precision = 6)
    {
        // If not numeric then convert texts to unix timestamps
        if (!is_int($time1))
        {
            $time1 = strtotime($time1);
        }
        if (!is_int($time2))
        {
            $time2 = strtotime($time2);
        }

        // If time1 is bigger than time2
        // Then swap time1 and time2
        if ($time1 > $time2)
        {
            $ttime = $time1;
            $time1 = $time2;
            $time2 = $ttime;
        }

        // Set up intervals and diffs arrays
        $intervals = array('year', 'month', 'day', 'hour', 'minute', 'second');
        $diffs = array();

        // Loop thru all intervals
        foreach ($intervals as $interval) {
            // Create temp time from time1 and interval
            $ttime = strtotime('+1 ' . $interval, $time1);
            // Set initial values
            $add = 1;
            $looped = 0;
            // Loop until temp time is smaller than time2
            while ($time2 >= $ttime) {
                // Create new temp time from time1 and interval
                $add++;
                $ttime = strtotime("+" . $add . " " . $interval, $time1);
                $looped++;
            }

            $time1 = strtotime("+" . $looped . " " . $interval, $time1);
            $diffs[$interval] = $looped;
        }

        $count = 0;
        $times = array();
        // Loop thru all diffs
        foreach ($diffs as $interval => $value) {
            // Break if we have needed precission
            if ($count >= $precision) {
                break;
            }
            // Add value and interval
            // if value is bigger than 0
            if ($value > 0) {
                // Add s if value is not 1
                if ($value != 1) {
                    $interval .= "s";
                }
                // Add value and interval to times array
                $times[] = $value . " " . $interval;
                $count++;
            }
        }
        // Return string with times
        return implode(", ", $times);
    }

    function getAllServiceCallForFollowUp($id = 0)
    {
        $myArray = array();
        $handle = null;

        switch ($id)
        {
            case 0:
                $sql = "select sc.*, sc.id as callID, mif.machine_code,mif.id as MachineID, mif.account_id as accountID, cs.caseName, ac.Name as AccountName, al.areaname, l.lga, s.state, mif.contactName1, mif.contactEmail1, mif.contactPhone1,
        mif.serialNo, mif.Address, ct.c_name as contract, p.productName as machineBrand from `service_call` sc
      JOIN machine_in_field mif on mif.id = sc.machine_id
      JOIN accounts ac on ac.id = sc.account_id
      join contracts ct on ct.id = mif.contractID
        join products p on p.id = mif.machine_type
        join area_location al on al.id = mif.areaID
        join lga l on l.id = al.lgaID
        join states s on s.id = l.stateID
                    left JOIN casestatus cs on cs.id = sc.CaseStatus 
                    where sc.active = ? order by sc.id desc";
                $handle = $this->db->prepare($sql);
                $handle->bindValue(1, 1);
                break;

            default:
                $sql = "select sc.*, sc.id as callID, mif.machine_code,mif.id as MachineID, mif.account_id as accountID, cs.caseName, ac.Name as AccountName, al.areaname, l.lga, s.state, mif.contactName1, mif.contactEmail1, mif.contactPhone1,
mif.serialNo, mif.Address, ct.c_name as contract, p.productName as machineBrand from `service_call` sc
                    JOIN machine_in_field mif on mif.id = sc.machine_id
                    JOIN accounts ac on ac.id = sc.account_id
                    join contracts ct on ct.id = mif.contractID
                    join products p on p.id = mif.machine_type
                    join area_location al on al.id = mif.areaID
                    join lga l on l.id = al.lgaID
                    join states s on s.id = l.stateID
                    left JOIN casestatus cs on cs.id = sc.CaseStatus 
                    where sc.engineer = ? AND sc.active = ? order by sc.id desc";
                $handle = $this->db->prepare($sql);
                $handle->bindValue(1, $id);
                $handle->bindValue(2, 1);
                break;
        }

        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $myArray[] = $row;
            }
            return $myArray;
        }
        else
        {
            return null;
        }
    }

    function getAccountServiceCallForFollowUp()
    {
        $myArray = array();
        $sql = "select sc.*, sc.id as callID, mif.machine_code,mif.id as MachineID, mif.account_id as accountID, cs.caseName, ac.Name as AccountName, al.areaname, l.lga, s.state,
      mif.contactName1, mif.contactEmail1, mif.contactPhone1,
        mif.serialNo, mif.Address, ct.c_name as contract, p.productName as machineBrand from `service_call` sc
      JOIN machine_in_field mif on mif.id = sc.machine_id
      JOIN accounts ac on ac.id = sc.account_id
      join contracts ct on ct.id = mif.contractID
        join products p on p.id = mif.machine_type
        join area_location al on al.id = mif.areaID
        join lga l on l.id = al.lgaID
        join states s on s.id = l.stateID
      left JOIN casestatus cs on cs.id = sc.CaseStatus 
      where mif.account_id = 265
       order by sc.id desc";

        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $myArray[] = $row;
            }
            return $myArray;
        }
        else
        {
            return null;
        }
    }

    function getAdvancedServiceCallSearch($start, $end, $eng)
    {
        $myArray = array();
        $sql = "select sc.*, sc.id as callID, mif.machine_code, mif.id as MachineID, mif.account_id as accountID, cs.caseName, ac.Name as AccountName, al.areaname, l.lga, s.state,
      mif.contactName1, mif.contactEmail1, mif.contactPhone1,
        mif.serialNo, mif.Address, ct.c_name as contract, p.productName as machineBrand from `service_call` sc
      JOIN machine_in_field mif on mif.id = sc.machine_id
      JOIN accounts ac on ac.id = sc.account_id
      join contracts ct on ct.id = mif.contractID
        join products p on p.id = mif.machine_type
        join area_location al on al.id = mif.areaID
        join lga l on l.id = al.lgaID
        join states s on s.id = l.stateID
      left JOIN casestatus cs on cs.id = sc.CaseStatus
      where (`openedTimeStamp` BETWEEN UNIX_TIMESTAMP('$start') and UNIX_TIMESTAMP('$end')) 
        and `engineer` " . $eng . " order by sc.id asc";

        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }
    }

    function getAccountServiceCall($id)
    {
        $myArray = array();
        $sql = "select sc.*,mif.machine_code,cs.caseName from `service_call` sc
      JOIN machine_in_field mif on mif.id = sc.machine_id
      JOIN casestatus cs on cs.id = sc.CaseStatus
       where sc.account_id = ? order by sc.id desc";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();

        if ($handle->rowCount() > 0)
        {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $myArray[] = $row;
            }
            return $myArray;
        }
        else
        {
            return false;
        }
    }

    function createActivityNotifications($message, $machineID = 0, $accountID = 0)
    {
        $user_id = $_SESSION['user_id'];
        $sql = "insert into `activities` (user_id,activities,`timeStamp`, `dateTime`,accountID,machineID,Ymd) values (?,?,?,?,?,?,?)";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $user_id);
        $handle->bindValue(2, $message);
        $handle->bindValue(3, time());
        $handle->bindValue(4, date("l jS \of F Y h:i:s A"));
        $handle->bindValue(5, $machineID);
        $handle->bindValue(6, $accountID);
        $handle->bindValue(7, date('Y') . date('m') . date('d'));
        $handle->execute();
    }

    public function addMachineDemandProduct($lasID, $product, $qty, $amount, $machineID, $accountID, $discount, $serviceCharge, $transportCharge, $salesType, $paymentMode)
    {
        //var_dump($lasID);
        //var_dump($salestype);

        $leadDemandID = $this->enterProductDemand($lasID, $salesType, "", $machineID, $accountID, $discount, $serviceCharge, $transportCharge, $paymentMode);
        $count = count($product);
        if ($count > 0 && !empty($product)) {
            for ($i = 0; $i < $count; $i++) {
//                $productID = $product[$i];
//                $qty1 = $qty[$i];
                $amount_ = $this->RemoveComma($amount[$i]);
                $this->insertLeadProducts($lasID, $product[$i], $qty[$i], $amount_, $leadDemandID, $machineID);
            }
            $accountName = $this->getSingleAccountInformation($accountID)['Name'];
            $machineName = $this->getSingleMachineInformation($machineID)['machine_code'];
            $message = "added a new purchase for a machine : " . $machineName . " assigned to " . $accountName;
            $this->createActivityNotifications($message);
        }
    }

    public function RemoveComma($amount)
    {
        return str_replace(',', '', $amount);
    }

    public function purchaseListForMachineCollected($id, $oc)
    {
        $sql = "select md.*, sum(sp.qty * sp.Amount) as myAmount from `machine_demand` md
        join service_product sp on md.id = sp.leadDemandID
        where md.machineID = ? and md.orderCollect = ? group by md.id";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->bindValue(2, $oc);

        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }


    }

    public function purchaseListForAccountCollected($id, $oc)
    {
        $sql = "select md.*, sum(sp.qty * sp.Amount) as myAmount from `machine_demand` md
        join service_product sp on md.id = sp.leadDemandID
        where md.accountID = ? and md.orderCollect = ? group by md.id";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->bindValue(2, $oc);

        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }


    }

    public function purchaseListForMachineCollectedAll($oc)
    {
        $sql = "select md.*, sum(sp.qty * sp.Amount) as myAmount, mif.machine_code, ac.Name from `machine_demand` md
        join machine_in_field mif on mif.id = md.machineID
        join accounts ac on ac.id = md.accountID
        join service_product sp on md.id = sp.leadDemandID
        where md.orderCollect = ? group by md.id order by ocDMY desc";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        //$handle->bindValue(1,$id);
        $handle->bindValue(1, $oc);

        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }
    }

    public function test()
    {
        $sql = "show COLUMNS from machine_demand";
        $myArray = array();
        $handle = $this->db->prepare($sql);

        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }
    }

    public function purchaseListForMachineCollectedToday($ocDay, $ocMonth, $ocYear)
    {
        $sql = "select md.*, sum(sp.qty * sp.Amount) as myAmount from `machine_demand` md
        join service_product sp on md.id = sp.leadDemandID
        where md.ocDay = ? and md.ocMonth=? and md.ocYear =? and md.orderCollect = 1 group by md.id";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $ocDay);
        $handle->bindValue(2, $ocMonth);
        $handle->bindValue(3, $ocYear);

        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }
    }

    public function purchaseListForMachineCollectedDaily($ocDay, $ocMonth, $ocYear)
    {
        $sql = "select md.*, sum(sp.qty * sp.Amount) as myAmount from `machine_demand` md
        join service_product sp on md.id = sp.leadDemandID
        where md.ocDay = ? and md.ocMonth=? and md.ocYear =? and md.orderCollect = 1 group by md.id";
        $myArray = array();

        $totalToday = 0;

        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $ocDay);
        $handle->bindValue(2, $ocMonth);
        $handle->bindValue(3, $ocYear);

        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $vat = 0;
                if ($row['vat'] == 1) {
                    $vat = 0.05 * $row['myAmount'];
                }
                $added = $row['myAmount'] + $vat;
                $discount = ($row['discount'] / 100) * $added;
                $finalAmount = $added - $discount;
                $totalToday = $totalToday + $finalAmount;
                // $myArray[] = $row;

            }
            return $totalToday;
        } else {
            return 0;
        }
    }

    public function purchaseListForMachineCollectedMonthly($ocMonth, $ocYear)
    {
        $sql = "select md.*, sum(sp.qty * sp.Amount) as myAmount 
        from `machine_demand` md
        join service_product sp on md.id = sp.leadDemandID
        where md.ocMonth=? and md.ocYear =? and md.orderCollect = 1 group by md.id";
        $myArray = array();

        $totalToday = 0;

        $handle = $this->db->prepare($sql);

        $handle->bindValue(1, $ocMonth);
        $handle->bindValue(2, $ocYear);

        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $vat = 0;
                if ($row['vat'] == 1) {
                    $vat = 0.05 * $row['myAmount'];
                }
                $added = $row['myAmount'] + $vat;
                $discount = ($row['discount'] / 100) * $added;
                $finalAmount = $added - $discount;
                $totalToday = $totalToday + $finalAmount;
                // $myArray[] = $row;

            }
            return $totalToday;
        } else {
            return 0;
        }
    }

    function time_elapsed_string($ptime)
    {
        $etime = time() - $ptime;
        if ($etime < 1) {
            return 'a moment ago';
        }

        $a = array(365 * 24 * 60 * 60 => 'year', 30 * 24 * 60 * 60 => 'month', 7 * 24 * 60 * 60 => 'week', 24 * 60 * 60 => 'day', 60 * 60 => 'hr', 60 => 'min', 1 => 'second');
        $a_plural = array('year' => 'years', 'month' => 'months', 'week' => 'weeks', 'day' => 'days', 'hr' => 'hrs', 'min' => 'mins', 'second' => 'seconds');

        foreach ($a as $secs => $str) {
            $d = $etime / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
            }
        }
    }

    function getServiceProductOrderOnLeadDemand($machineID, $serviceDemandID)
    {
        $myArray = array();
        $sql = "SELECT sp.id,sp.productID, p.productName, p.Code, p.color, p.ProductType, sp.qty, sp.Amount, sd.ticketNo,
                    sd.orderCollect, sd.orderCollectedDate, sd.ocDay, sd.ocMonth,sd.ocYear, st.salestype, st.st, sd.description
                    FROM service_product sp
                    JOIN products p ON sp.productID = p.id
                    JOIN machine_demand sd on sp.leadDemandID = sd.id
                    JOIN sales_type st on sd.sales_type_id = st.id
                    where sp.machineID = ? and sd.id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $machineID);
        $handle->bindValue(2, $serviceDemandID);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        }
    }

    function getServiceProductOrderCall($id)
    {
        $myArray = array();
        $sql = "SELECT sp.id,sp.productID, p.productName, p.Code, p.color, p.ProductType, sp.qty, sp.Amount, sd.ticketNo,
                    sd.orderCollect, sd.orderCollectedDate, sd.ocDay, sd.ocMonth,sd.ocYear, st.salestype, st.st, sd.description
                    FROM service_product sp
                    JOIN products p ON sp.productID = p.id
                    JOIN machine_demand sd on sp.leadDemandID = sd.id
                    JOIN sales_type st on sd.sales_type_id = st.id
                    where sp.serviceCallID = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        }
    }

    function getPurchaseTicketForServiceCall($serviceCallID)
    {
        $myArray = array();
        $sql = "select * from machine_demand where serviceCallID = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $serviceCallID);
        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $myArray[] = $row;
            }
            return $myArray;
        }
    }

    function getServiceTicket($ticket)
    {
        $sql = "select sc.*, sc.id as callID, ac.Name as AccountName, mif.machine_code, al.areaname, l.lga, s.state,
        mif.serialNo, mif.Address, ct.c_name as contract, p.productName as machineBrand
        from service_call sc
        right join accounts ac on ac.id = sc.account_id
        right join machine_in_field mif on mif.id = sc.machine_id
        right join contracts ct on ct.id = mif.contractID
        right join products p on p.id = mif.machine_type
        right join area_location al on al.id = mif.areaID
        right join lga l on l.id = al.lgaID
        right join states s on s.id = l.stateID
        where sc.ticketNo = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $ticket);
        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            return $handle->fetch(PDO::FETCH_ASSOC);
        }
        else
        {
            return null;
        }
    }

    function getBillingType($id = "")
    {
        $myArray = array();
        $sql = "";
        if ($id == "") {
            $sql = "select * from billingtype";
        } else {
            $sql = "select * from billingtype where `value` = {$id}";
        }
        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            if ($id != "") {
                return $handle->fetch(PDO::FETCH_ASSOC);
            } else {
                while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                    $myArray[] = $row;
                }
                return $myArray;
            }

        }

    }

    function getIssueWithId($id)
    {
        $sql = "select issues from call_issues where id =?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            return $handle->fetch(PDO::FETCH_ASSOC);
        }
    }

    function getPurchaseTicket($ticket)
    {
        $sql = "select * from machine_demand where ticketNo = ?";

        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $ticket);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            $row = $handle->fetch(PDO::FETCH_ASSOC);
            if ($row['machineID'] == 0) {
                $sql = "select md.*,ac.Name as AccountName, 'NONE' as machine_code, al.areaname, l.lga, s.state,
                                mif.serialNo, ac.Address, ct.c_name as contract, '' as machineBrand from machine_demand md
                                join accounts ac on ac.id = md.accountID
                                right join machine_in_field mif on mif.id = md.machineID
                                right join contracts ct on ct.id = 1
                                right join area_location al on al.id = ac.areaID
                                join lga l on l.id = al.lgaID
                                join states s on s.id = l.stateID
                                where md.ticketNo = ?";
                return $this->getPurchaseTicket2($sql, $ticket);

            } else {
                $sql = "select md.*,ac.Name as AccountName, ac.id as accountID, mif.machine_code, al.areaname, l.lga, s.state,
                            mif.serialNo, mif.Address, ct.c_name as contract, p.productName as machineBrand from machine_demand md
                            join accounts ac on ac.id = md.accountID
                            right join machine_in_field mif on mif.id = md.machineID
                            join contracts ct on ct.id = mif.contractID
                            join products p on p.id = mif.machine_type
                            join area_location al on al.id = mif.areaID
                            join lga l on l.id = al.lgaID
                            join states s on s.id = l.stateID
                            where md.ticketNo = ?";
                return $this->getPurchaseTicket2($sql, $ticket);

            }
        } else {
            return null;
        }
    }

    function getPurchaseTicket2($sql, $ticket)
    {
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $ticket);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return $handle->fetch(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }

    function getPurchaseProductOrderCall($id)
    {
        $myArray = array();
        $sql = "SELECT sp.id,sp.productID, p.productName, p.Code, p.color, p.ProductType, sp.qty, sp.Amount, sd.ticketNo,
                    sd.orderCollect, sd.orderCollectedDate, sd.ocDay, sd.ocMonth,sd.ocYear,sd.vat, st.salestype, st.st, sd.description
                    FROM service_product sp
                    JOIN products p ON sp.productID = p.id
                    JOIN machine_demand sd on sp.leadDemandID = sd.id
                    JOIN sales_type st on sd.sales_type_id = st.id
                    where sp.leadDemandID = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        }

    }

    function convertToMoney($amount)
    {
        return '₦' . number_format($amount, 2);
    }

    function convertToMoney2($amount)
    {
        return 'N ' . number_format($amount, 2);
    }

    function returnTimeDiff($time1, $time2)
    {
        $etime = $time1 - $time2;
        return $etime;
    }

    function secondsToTime($seconds)
    {
        $seconds = str_replace('-', '', $seconds);
//        $weeks = floor($seconds / 604800);
//        $seconds -= $weeks * 604800;
//        $days = floor($seconds / 86400);
//        $seconds -= $days * 86400;
        $hours = floor($seconds / 3600);
        $seconds -= $hours * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;
//        $dWeeks = $weeks != 0 ? "$weeks weeks, " : '';
//        $dDays = $days != 0 ? "$days days, " : '';
        $dHours = $hours != 0 ? "$hours hours, " : '';
        $dSeconds = $seconds != 0 ? "$seconds seconds." : '';

        return "<b>$dHours $dSeconds</b>";
    }

    function secondsToHours($seconds)
    {
        $seconds = str_replace('-', '', $seconds);
        $hours = floor($seconds / 3600);
        $seconds -= $hours * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;
        $dHours = $hours != 0 ? "$hours hours" : '';

        return "<b>$dHours</b>";
    }

    function secondsToDays($seconds)
    {
        $seconds = str_replace('-', '', $seconds);
        $days = floor($seconds / 86400);
        $seconds -= $days * 86400;
        $hours = floor($seconds / 3600);
        $seconds -= $hours * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;
//        $dWeeks = $weeks != 0 ? "$weeks weeks, " : '';
        $dDays = $days == 0 ? '' : ($days == 1 ? "$days day" : "$days days");
        $dHours = $hours == 0 ? '' : ($hours == 1 ? "$hours hour" : "$hours hours");

        return $days >= 1 ? "<b>$dDays</b>" : "<b>$dHours</b>";
    }

    function getSecondsColor($secs)
    {
        if ($secs < 172800) {
            return "success";
        } else if ($secs > 172800 && $secs < 432000) {
            return "warning";
        } else if ($secs > 432000) {
            return "danger";
        }
    }

    function getPercentage($secs)
    {
        $extime = ($secs / 1036800) * 100;
        return $extime;
    }

    function time_space($time1, $time2)
    {
        $etime = $time1 - $time2;

        if ($time1 == "") {
            return '';
        }
        if ($etime < 1) {
            return 'a moment ago';
        }

        $a = array(365 * 24 * 60 * 60 => 'year', 30 * 24 * 60 * 60 => 'month', 7 * 24 * 60 * 60 => 'week', 24 * 60 * 60 => 'day', 60 * 60 => 'hr', 60 => 'min', 1 => 'second');
        $a_plural = array('year' => 'years', 'month' => 'months', 'week' => 'weeks', 'day' => 'days', 'hr' => 'hrs', 'min' => 'mins', 'second' => 'seconds');

        foreach ($a as $secs => $str)
        {
            $d = $etime / $secs;
            if ($d >= 1)
            {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str);
            }
        }
    }

    function updateOrderCollected($id, $ocDay, $ocMonth, $ocYear, $vat, $machineID, $accID, $paymentMode)
    {
        $sql = "update machine_demand set orderCollect = 1, orderCollectedDate = ?, ocDay = ?, ocMonth = ?, ocYear = ?,ocDMY= ?,
         dateTime = ?, vat = ?, collectedBy=?, paymentMode = ?, ocWeek = ? where id = ?";
        $person = $this->getMyUserInformation($_SESSION['user_id'])['fullname'];
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, date("l jS \of F Y h:i:s A"));
        $handle->bindValue(2, $ocDay, PDO::PARAM_INT);
        $handle->bindValue(3, $ocMonth, PDO::PARAM_INT);
        $handle->bindValue(4, $ocYear, PDO::PARAM_INT);
        $handle->bindValue(5, $ocYear . str_pad($ocMonth, 2, "0", STR_PAD_LEFT) . str_pad($ocDay, 2, "0", STR_PAD_LEFT));
        $handle->bindValue(6, time());
        $handle->bindValue(7, $vat, PDO::PARAM_INT);
        $handle->bindValue(8, $_SESSION['user_id']);
        $handle->bindValue(9, $paymentMode);
        $handle->bindValue(10, date("W", strtotime($ocYear . "-" . $ocMonth . "-" . $ocDay)));
        $handle->bindValue(11, $id, PDO::PARAM_INT);

        $handle->execute();

        $accountName = $this->getSingleAccountInformation($accID)['Name'];
        //$mac_name = $this->getSingleMachineInformation($machineID)['machine_code'];
        $msg = " successfully collected an order from " . $accountName;
        $this->createActivityNotifications($msg, $machineID, $accID);

    }

    public function enterProductDemand($serviceCallID, $salesTypeID, $description = "", $machineID, $accountID, $discount, $serviceCharge, $transportCharge, $paymentMode)
    {
        $userID = $_SESSION['user_id'];
        $sql = "insert into machine_demand (adminID,serviceCallID,ticketNo,sales_type_id,`description`,machineID,accountID,discount,svc,transport_charge,paymentMode,collectedBy) values(?,?,?,?,?,?,?,?,?,?,?,?)";
        $handle = $this->db->prepare($sql);
        $ticketGen = $this->createTicketNo();
        $handle->bindValue(1, $_SESSION['user_id']);
        $handle->bindValue(2, $serviceCallID);
        $handle->bindValue(3, "S-" . $ticketGen);
        $handle->bindValue(4, $salesTypeID);
        $handle->bindValue(5, $description);
        $handle->bindValue(6, $machineID, PDO::PARAM_INT);
        $handle->bindValue(7, $accountID, PDO::PARAM_INT);
        $handle->bindValue(8, $this->RemoveComma($discount));
        $handle->bindValue(9, $this->RemoveComma($serviceCharge));
        $handle->bindValue(10, $this->RemoveComma($transportCharge));
        $handle->bindValue(11, $paymentMode);
        $handle->bindValue(12, $userID);
        $handle->execute();
        $this->showMsg('Success', 'This purchase has been made on this ticket <a href="' . $this->host . 'purchase-invoice/S-' . $ticketGen . '">S-' . $ticketGen . '</a>', 2);

        return $this->db->lastInsertId();
    }

    function insertLeadProducts($leadID, $productID, $qty, $amount, $leadDemandID, $machineID)
    {
        $handle = $this->db->prepare("insert into service_product(serviceCallID,leadDemandID,productID,qty,`Amount`,machineID) values(?,?,?,?,?,?)");
        $handle->bindValue(1, $leadID, PDO::PARAM_INT);
        $handle->bindValue(2, $leadDemandID, PDO::PARAM_INT);
        $handle->bindValue(3, $productID, PDO::PARAM_INT);
        $handle->bindValue(4, $qty, PDO::PARAM_INT);
        $handle->bindValue(5, $this->RemoveComma($amount), PDO::PARAM_INT);
        $handle->bindValue(6, $machineID, PDO::PARAM_INT);
        $handle->execute();
    }

    public function ValidateCompanyAgainst($companyName, $companyID)
    {
        $sql = "select * from leads where companyName = ? and id != ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $companyName);
        $handle->bindValue(2, $companyID);
        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            $row = $handle->fetch(PDO::FETCH_ASSOC);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getMyUserInformation($id)
    {
        $sql = "select st.*,
        ds.dptID,ds.dptaccessLevel as AccessLevel,ds.designation,d.Department
        from staff st
        join dpt_designation ds on st.designationID = ds.id
        join department d on st.DepartmentID = d.id
        where st.id =  ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);

        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            return $row = $handle->fetch(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

    function getArrayStates()
    {
        $mystring = "";
        $handle = $this->db->prepare("select * from states order by id asc");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $mystring .= "[" . $row['id'] . ",'" . $row['state'] . "'],";
            }
            return "[" . $mystring . "]";
            //return "[[1,\"Agriculture\"],[2,\"Basic Medical Science\"]]";
        } else {
            return false;
        }
    }

    function getLGAofStates()
    {
        $mystring = "";
        $handle = $this->db->prepare("select * from states order by id asc");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $mystring .= "" . $this->getLgaByID($row['id']) . ",";
                $myArray[] = $row;
            }
            return "[" . $mystring . "]";
        } else {
            return false;
        }
    }

    function getAreasofLGA()
    {
        $mystring = "";
        $handle = $this->db->prepare("select * from states order by id asc");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $mystring .= "" . $this->getAreaByID($row['id']) . ",";
                $myArray[] = $row;
            }
            return "[" . $mystring . "]";
        } else {
            return false;
        }
    }

    function getLgaByID($id)
    {
        $mystring = "";
        $handle = $this->db->prepare("select * from lga where stateID = ? order by lga asc");
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $mystring .= "[" . $row['id'] . ",'" . $row['lga'] . "'],";
            }

        } else {
            // return false;
        }
        return "[" . $mystring . "]";

    }

    function getAreaByID($id)
    {
        $mystring = "";
        $handle = $this->db->prepare("select * from area_location where stateID = ? order by areaname asc");
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $mystring .= "[" . $row['id'] . ",'" . $row['areaname'] . "'],";
            }

        } else {
            //  return false;
        }
        return "[" . $mystring . "]";

    }

    public function showMsg($header, $msg, $num)
    {
        if ($num == 1)
        {
            echo '<div class="alert alert-danger alert-transparent no-margin">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon-cross2"></i>
                <strong>' . $header . '</strong> ' . $msg . '.
            </div>';
        }
        else if ($num == 2)
        {
            echo '<div class="alert alert-success alert-transparent no-margin">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-"></i></button><i class="icon-cross2"></i>
                <strong>' . $header . '</strong> ' . $msg . '.
                </div>';
        }
    }

    function getAllAcounts()
    {
        $myArray = array();
        $handle = $this->db->prepare("select * from `accounts`  order by `Name` asc");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }

    }

    function getArrayAllAccounts()
    {
        $mystring = "";
        $handle = $this->db->prepare("select * from `accounts` order by Name asc");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $mystring .= "[" . $row['id'] . ",'" . strtoupper($row['Name']) . "'],";
            }
            return "[" . $mystring . "]";
            //return "[[1,\"Agriculture\"],[2,\"Basic Medical Science\"]]";
        } else {
            return false;
        }
    }

    function getAllIndustries()
    {
        $myArray = array();
        $handle = $this->db->prepare("select * from industries  order by `sector` asc");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }

    }

    function getAllContracts()
    {
        $myArray = array();
        $handle = $this->db->prepare("select * from `contracts`");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function getProductsByCategory($id)
    {
        $myArray = array();
        $productType = $id == 0 ? ' > 0 ' : " = $id ";
        $sql = "SELECT p.id, p.productName, p.Code, p.ProductType, p.active, p.store1, p.store2, p.store3, p.damaged, p.unitID , pt.type,u.unitName, p.cost FROM `products` p 
       join `producttype` pt on p.productType = pt.id 
       left join units u on u.id = p.unitID 
       where p.ProductType $productType 
       order by p.productName asc";
        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }
    }

    function filterStoreStock($storeID, $categoryID)
    {
        $myArray = array();
        $store = 'store' . $storeID;
        $category = $categoryID == 0 ? " > 0 " : " = $categoryID ";
        $sql = "SELECT p.*, p.$store as quantity, pt.type,u.unitName, cost FROM `products` p 
       join `producttype` pt on p.productType = pt.id 
       left join units u on u.id = p.unitID 
       where p.ProductType " . $category . "
       and p.$store != 0 
       order by p.ProductType asc, p.productName asc, p.color asc";
        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }
    }

    function checkCodeExist($code)
    {
        $sql = "select * from products where Code = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $code);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    function addNewProducts($catID, $prodName, $prodCode, $prodPrice, $active = 1, $unitID)
    {

        if ($this->checkCodeExist($prodCode)) {

            $sql = "insert into products (productName, Code,price,ProductType, active,unitID) values (?,?,?,?,?,?)";
            $handle = $this->db->prepare($sql);
            $handle->bindValue(1, $prodName);
            $handle->bindValue(2, $prodCode);
            $handle->bindValue(3, $prodPrice);
            $handle->bindValue(4, $catID);
            $handle->bindValue(5, $active);
            $handle->bindValue(6, $unitID);
            $handle->execute();
        } else {

        }
    }

    function EditProducts($id, $catID, $prodName, $prodCode, $prodPrice, $active = 1, $unitID)
    {
        $handle = $this->db->prepare("update products set ProductType = ?, productName = ?, Code = ?, price = ?, active = ?,unitID = ? where id = ?");
        $handle->bindValue(1, $catID);
        $handle->bindValue(2, $prodName);
        $handle->bindValue(3, $prodCode);
        $handle->bindValue(4, $prodPrice);
        $handle->bindValue(5, $active);
        $handle->bindValue(6, $unitID);
        $handle->bindValue(7, $id);
        $handle->execute();
    }

    function getProductsCategory()
    {
        $myArray = array();
        $handle = $this->db->prepare("SELECT *  from `producttype`  order by type asc");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }
    }

    function getCategoryById($id)
    {
        $sql = "select * from producttype where id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return $handle->fetch(PDO::FETCH_OBJ);
        } else {
            return false;
        }
    }

    function getProductsUnits()
    {
        $myArray = array();
        $handle = $this->db->prepare("SELECT *  from `units`  order by unitName asc");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }
    }

    function getAllProducts()
    {
        $myArray = array();
        $handle = $this->db->prepare("select * from products where active = 1 order by ProductType asc, productName asc, color asc");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }

    }

    function getProductInformationWithID($id)
    {
        $sql = "select * from products where id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return $handle->fetch(PDO::FETCH_ASSOC);
        }
    }

    function getGoodsLog($id)
    {
        $myArray = array();
        $sql = "select gl.*,p.productName,p.Code,s.storeName,st.fullname from goodslog gl
      join products p on p.id = gl.productID
      join stores s on s.id = gl.storeID
      join staff st on st.id = gl.doneBy
      where gl.productID = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function makeStockUpdateRequest($storeID, $userID, $id, $currentQtyUnits, $updateQty)
    {
        $count = sizeof($id);
        $editTicket = 'UPD-00001-21';
        $sql = "select * from `stock-edits` order by `id` desc limit 1";
        $handle = $this->db->prepare($sql);
        $handle->execute();

        if ($handle->rowCount() > 0)
        {
            $row = $handle->fetch(PDO::FETCH_ASSOC);
            $lastTicketString = $row['edit_ticket'];
            $editTicket = $this->generateNextSerial('UPD-', $lastTicketString);
        }

        $editSql = "insert into `stock-edits`(`store_id`, `edit_ticket`, `user_id`, `created_at`) values (?,?,?,?)";
        $handle = $this->db->prepare($editSql);
        $handle->bindValue(1, $storeID);
        $handle->bindValue(2, $editTicket);
        $handle->bindValue(3, $userID);
        $handle->bindValue(4, time());
        $handle->execute();
        $lastID = $this->db->lastInsertId();

        for($i = 0; $i < $count; $i++)
        {
            $st = preg_split('~ ~', $currentQtyUnits[$i]);
            $currentQty = (int) str_replace(',', '', $st[0]);
            $difference = $updateQty[$i] - $currentQty;
            $action = $currentQty > $updateQty[$i] ? 'subtract' : 'add';
            $sql = "insert into `stock-edits-products`(`edit_id`, `product_id`, `action`, `current_quantity`, `update_quantity`, `difference`)values ($lastID, $id[$i], '$action', $currentQty, $updateQty[$i], $difference)";
            $handle = $this->db->prepare($sql);
            $handle->execute();
        }

        return $lastID;
    }

    function getStockEdits()
    {
        $sql = "select se.*,(select COUNT(*) from `stock-edits-products` where `edit_id` = se.id) as itemsQty,
                (select COUNT(*) from `stock-edits` where approval = 0) as pendingEdits,
                st.fullname
                from `stock-edits` se
                join staff st on se.user_id = st.id";

        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        }
        else {
            return false;
        }
    }

    function getStockEditDetails($id, $store)
    {
        $sql = "select sep.*, (select COUNT(*) from `stock-edits-products` where `edit_id` = $id) as itemsQty,
            se.*, st.fullname, pd.productName, pd.ProductType, pd.store$store, pd.Code, pt.type, s.*
            from `stock-edits-products` sep
            join `stock-edits` se on $id = se.id
            join products pd on sep.product_id = pd.id
            join producttype pt on pd.ProductType = pt.id
            join stores s on se.store_id = s.id
            join staff st on se.user_id = st.id where sep.edit_id = $id";
        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $myArray[] = $row;
            }
            return $myArray;
        }
        else {
            return false;
        }
    }

    function approveStockEdits($editID, $store, $editTicket, $editor, $approvedBy, $products, $storeQty, $updateQty, $difference)
    {
        $sql = "update `stock-edits` SET `approval` = ?, `updated_at` = ? WHERE id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $approvedBy);
        $handle->bindValue(2, time());
        $handle->bindValue(3, $editID);
        $handle->execute();

        $count = sizeof($products);
        $remark = 'Stock edited due to irregularities in Elastic and physical quantities';
        for($i = 0; $i < $count; $i++)
        {
            $remain = $storeQty[$i] + $difference[$i];
            $this->updateStoreStock($store, $products[$i], $remain);
            $this->GoodsLog($products[$i], 0, 0, 0, 0, $difference[$i], $remain, $store, "$editTicket", "$remark", $editor);
        }
    }

    function cancelStockEdit($editID)
    {
        $sql = "delete FROM `stock-edits` where id = $editID";
        $handle = $this->db->prepare($sql);
        $handle->execute();

        $sql = "delete from `stock-edits-products` where `edit_id` = $editID";
        $handle = $this->db->prepare($sql);
        $handle->execute();
    }

    function updateStoreStock($store, $productID, $productQty)
    {
        $sql = "UPDATE `products` SET `store$store` = $productQty WHERE id = $productID";
        $handle = $this->db->prepare($sql);
        $handle->execute();
    }

    function updateStock($id, $newMain, $newOffice, $newDamaged, $newAbj, $mainEdit, $officeEdit, $abjEdit, $dmgEdit, $mainSwitch, $officeSwitch, $abjSwitch, $dmgSwitch, $remarks)
    {
        $sql = "UPDATE `products` set `store1` = ?, `store2` = ?, `store3` = ?, `damaged` = ? WHERE `id` = ? ";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $newMain);
        $handle->bindValue(2, $newOffice);
        $handle->bindValue(3, $newAbj);
        $handle->bindValue(4, $newDamaged);
        $handle->bindValue(5, $id);
        $handle->execute();

        if ($mainEdit != 0) {
            $note = $mainSwitch == true ? 'Increased' : 'Reduced';
            $this->GoodsLog($id, 0, 0, 0, 0, $mainEdit, $newMain, 1, $note, $remarks);
        }
//
        if ($officeEdit != 0) {
            $note = $officeSwitch === true ? 'Increased' : 'Reduced';
            $this->GoodsLog($id, 0, 0, 0, 0, $officeEdit, $newOffice, 2, $note, $remarks);
        }
//
        if ($abjEdit != 0) {
            $note = $abjSwitch === true ? 'Increased' : 'Reduced';
            $this->GoodsLog($id, 0, 0, 0, 0, $abjEdit, $newAbj, 3, $note, $remarks);
        }

        if ($dmgEdit != 0) {
            $note = $dmgSwitch === true ? 'Increased' : 'Reduced';
            $this->GoodsLog($id, 0, 0, 0, 0, $dmgEdit, $newDamaged, 4, $note, $remarks);
        }
    }

    function getAllProductsWithCode()
    {
        $myArray = array();
        $handle = $this->db->prepare("select * from products where active = 1 and Code!='' order by ProductType asc, productName asc, color asc");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function createPOC($name, $machineCode, $machineModel, $machineSerialNo, $contractType, $installationDate, $pocStartDate, $pocEndDate, $workDone, $industry, $address, $area, $state, $dpt, $contactN1, $contactP1, $contactE1, $contactD1, $contactN2, $contactP2, $contactE2, $contactD2, $contactN3, $contactP3, $contactE3, $contactD3, $meterReading)
    {
        $sql = "insert into poc_accounts (poc_account_name,machine_code,machine_type,serialNo,contract_type,doi,contractStart,contractEnds,workDone,industry,Address,areaID,state,department,contactName1,contactEmail1,contactPhone1,contactDesig1,contactName2,contactEmail2,contactPhone2,contactDesig2,contactName3,contactEmail3,contactPhone3,contactDesig3,`timestamp`,`dateTime`,meterReading)
                values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $name);
        $handle->bindValue(2, $machineCode);
        $handle->bindValue(3, $machineModel);
        $handle->bindValue(4, $machineSerialNo);
        $handle->bindValue(5, $contractType);
        $handle->bindValue(6, $installationDate);
        $handle->bindValue(7, $pocStartDate);
        $handle->bindValue(8, $pocEndDate);
        $handle->bindValue(9, $workDone);
        $handle->bindValue(10, $industry);
        $handle->bindValue(11, $area);
        $handle->bindValue(12, $state);
        $handle->bindValue(13, $dpt);

        $handle->bindValue(14, $address);
        $handle->bindValue(15, $contactN1);
        $handle->bindValue(16, $contactE1);
        $handle->bindValue(17, $contactP1);
        $handle->bindValue(18, $contactD1);

        $handle->bindValue(19, $contactN2);
        $handle->bindValue(20, $contactE2);
        $handle->bindValue(21, $contactP2);
        $handle->bindValue(22, $contactD2);

        $handle->bindValue(23, $contactN3);
        $handle->bindValue(24, $contactE3);
        $handle->bindValue(25, $contactP3);
        $handle->bindValue(26, $contactD3);

        $handle->bindValue(27, time());
        $handle->bindValue(28, date("d-m-Y h:i:s A"));
        $handle->bindValue(29, $meterReading);
        $handle->execute();
    }

    function checkMachineAvailable($machineCode)
    {
        $sql = "select * from machine_in_field where machine_code = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $machineCode);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return true;
        } else {
            return false;
        }

    }

    function checkMachineAvailableCompare($machineCode, $id)
    {
        $sql = "select * from machine_in_field where machine_code = ? and id != ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $machineCode);
        $handle->bindValue(2, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function createAMachine($acc, $machineCode, $machineModel, $machineSerialNo, $contractType, $doi, $cstart, $cend, $address, $area, $contactN1, $contactP1, $contactE1, $contactD1, $contactN2, $contactP2, $contactE2, $contactD2, $contactN3, $contactP3, $contactE3, $contactD3, $dpt, $meterReading)
    {
        $sql = "insert into machine_in_field (account_id, machine_code,machine_type,serialNo,doi,contractStart,contractEnds,contractID,Address,areaID,department,contactName1,contactEmail1,contactPhone1,contactDesig1,contactName2,contactEmail2,contactPhone2,contactDesig2,contactName3,contactEmail3,contactPhone3,contactDesig3,`timestamp`,`dateTime`,meterReading)
                values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $acc);
        $handle->bindValue(2, $machineCode);
        $handle->bindValue(3, $machineModel);
        $handle->bindValue(4, $machineSerialNo);
        $handle->bindValue(5, $doi);
        $handle->bindValue(6, $cstart);
        $handle->bindValue(7, $cend);
        $handle->bindValue(8, $contractType);
        $handle->bindValue(9, $address);
        $handle->bindValue(10, $area);
        $handle->bindValue(11, $dpt);
        $handle->bindValue(12, $contactN1);
        $handle->bindValue(13, $contactE1);
        $handle->bindValue(14, $contactP1);
        $handle->bindValue(15, $contactD1);

        $handle->bindValue(16, $contactN2);
        $handle->bindValue(17, $contactE2);
        $handle->bindValue(18, $contactP2);
        $handle->bindValue(19, $contactD2);

        $handle->bindValue(20, $contactN3);
        $handle->bindValue(21, $contactE3);
        $handle->bindValue(22, $contactP3);
        $handle->bindValue(23, $contactD3);

        $handle->bindValue(24, time());
        $handle->bindValue(25, date("d-m-Y h:i:s A"));
        $handle->bindValue(26, $meterReading);
        $handle->execute();
    }

    function EditAMachine($acc, $machineCode, $machineModel, $machineSerialNo, $contractType, $doi, $cstart, $cend, $address, $area, $contactN1, $contactP1, $contactE1, $contactD1, $contactN2, $contactP2, $contactE2, $contactD2, $contactN3, $contactP3, $contactE3, $contactD3, $dpt, $id)
    {

        $sql = "update machine_in_field set account_id =?, machine_code =?,machine_type = ?,serialNo =?,doi =?,contractStart =?,contractEnds =?,contractID =?,
            Address=?,areaID=?,department =?,contactName1=?,contactEmail1 =?,contactPhone1 =?,contactDesig1=?,contactName2=?,contactEmail2 =?,contactPhone2 =?,
            contactDesig2 =?,contactName3 =?,contactEmail3 = ?,contactPhone3 = ?,contactDesig3 =? where id =? ";
        //  $sql = "insert into machine_in_field (account_id, machine_code,machine_type,serialNo,doi,contractStart,contractEnds,contractID,Address,areaID,department,contactName1,contactEmail1,contactPhone1,contactDesig1,contactName2,contactEmail2,contactPhone2,contactDesig2,contactName3,contactEmail3,contactPhone3,contactDesig3,`timestamp`,`dateTime`)
        //        values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $acc);
        $handle->bindValue(2, $machineCode);
        $handle->bindValue(3, $machineModel);
        $handle->bindValue(4, $machineSerialNo);
        $handle->bindValue(5, $doi);
        $handle->bindValue(6, $cstart);
        $handle->bindValue(7, $cend);
        $handle->bindValue(8, $contractType);
        $handle->bindValue(9, $address);
        $handle->bindValue(10, $area);
        $handle->bindValue(11, $dpt);
        $handle->bindValue(12, $contactN1);
        $handle->bindValue(13, $contactE1);
        $handle->bindValue(14, $contactP1);
        $handle->bindValue(15, $contactD1);

        $handle->bindValue(16, $contactN2);
        $handle->bindValue(17, $contactE2);
        $handle->bindValue(18, $contactP2);
        $handle->bindValue(19, $contactD2);

        $handle->bindValue(20, $contactN3);
        $handle->bindValue(21, $contactE3);
        $handle->bindValue(22, $contactP3);
        $handle->bindValue(23, $contactD3);

        $handle->bindValue(24, $id);
        // $handle->bindValue(25, date("d-m-Y h:i:s A"));

        $handle->execute();
    }


    function getAllAccountInformation()
    {
        $myArray = array();
        $sql = "select acc.*,al.areaname,al.stateID,st.state,ind.sector 
            from `accounts` acc
            LEFT JOIN area_location al on acc.areaID = al.id
            LEFT JOIN `states` st on al.stateID = st.id
            LEFT JOIN `industries` ind on ind.id = acc.industryID";

        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function getMachineByIDArray($id)
    {
        $mystring = "";
        $handle = $this->db->prepare("select mif.*,c.c_name from `machine_in_field` mif JOIN `contracts` c on mif.contractID = c.id where account_id = ? ");
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $mystring .= "[" . $row['id'] . ",'" . $row['machine_code'] . " - " . $row['c_name'] . "'],";
                //$mystring .= "[" . $row['id'] . ",'" . $row['machine_code'] . ",'" . $row['c_name'] . "'],";
            }

        } else {
            //  return false;
        }
        return "[" . $mystring . "]";
    }

    function getArrayOfMachines()
    {
        $mystring = "";
        $handle = $this->db->prepare("select * from `accounts` order by Name asc");
        $handle->execute();
        if ($handle->rowCount() > 0){
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $mystring .= "" . $this->getMachineByIDArray($row['id']) . ",";
                $myArray[] = $row;
            }
            return "[" . $mystring . "]";
        }
        else {
            return false;
        }
    }

    function getAllEngineers()
    {
        $myArray = array();
        $handle = $this->db->prepare("select * from `staff` 
        where `engineer` =1 and `active` = 1");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function getAllIssues()
    {
        $myArray = array();
        $handle = $this->db->prepare("select * from `call_issues` order by issues asc");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function getAllMachineInformation()
    {
        $myArray = array();
        $sql = "select mif.*,a.Name, p.productName,al.areaname,al.stateID, st.state, c.c_name 
            from `machine_in_field` mif
            JOIN `accounts` a on mif.account_id = a.id
            JOIN products p on mif.machine_type = p.id
            JOIN area_location al on mif.areaID = al.id
            JOIN `states` st on al.stateID = st.id
            JOIN  contracts c on mif.contractID = c.id
            WHERE mif.active = 1 order by mif.machine_code ASC";

        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function getAllMachineForAccount($id)
    {
        $myArray = array();
        $sql = "select mif.*, p.productName,al.areaname,al.stateID, st.state, c.c_name from `machine_in_field` mif
        JOIN products p on mif.machine_type = p.id
        JOIN area_location al on mif.areaID = al.id
        JOIN `states` st on al.stateID = st.id
        JOIN  contracts c on mif.contractID = c.id
        WHERE mif.active = 1 and account_id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function getSingleAccountInformation($id)
    {
        $sql = "select ac.*, al.stateID, al.areaname, st.state, ind.sector from `accounts` ac
                JOIN `area_location` al on ac.areaID = al.id
                JOIN `states` st on al.stateID = st.id
                JOIN `industries` ind on ac.industryID = ind.id
                WHERE ac.id = ?";

        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return $handle->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    function getAllMachineForAccountPM($id, $mifid)
    {
        $myArray = array();
//        $sql = "select mif.*, p.productName,al.areaname,al.stateID, st.state, c.c_name, pm.scheduleDate from `machine_in_field` mif
//        JOIN products p on mif.machine_type = p.id
//        JOIN area_location al on mif.areaID = al.id
//        JOIN `states` st on al.stateID = st.id
//        JOIN  contracts c on mif.contractID = c.id
//        JOIN preventive_maintenance_schedule pm on mif.id = pm.machine_in_field_id
//        WHERE mif.active = 1 and account_id = ?";

        $sql = "select mif.*, pm.*  
                from `machine_in_field` mif
                JOIN preventive_maintenance_schedule pm on mif.id = pm.machine_in_field_id
                WHERE mif.account_id = ? and mif.id = ? 
                order by pm.id desc limit 1";

        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->bindValue(2, $mifid);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }

    }

    function verifyPreventiveMaintenanceEntryForMachine($id)
    {

        $sql = "select pm.* from `preventive_maintenance_schedule` pm WHERE  machine_in_field_id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return 1;
        } else {
            return 0;
        }

    }

    function getSingleMachineInformationPM($id)
    {
        $myArray = array();
        $sql = "select mif.*, p.productName,al.areaname,al.stateID, st.state, c.c_name, ac.Name, pm.NextScheduledDateTime, pm.scheduleDate, pm.meterReadingMono, pm.meterReadingColour, pm.id AS pm_id from `machine_in_field` mif
        JOIN products p on mif.machine_type = p.id
        JOIN area_location al on mif.areaID = al.id
        JOIN `states` st on al.stateID = st.id
        JOIN  contracts c on mif.contractID = c.id
        JOIN  accounts ac on mif.account_id = ac.id
        JOIN preventive_maintenance_schedule pm on mif.id = pm.machine_in_field_id
        WHERE mif.active = 1 and pm.CaseStatus = 1 and mif.id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function getSingleMachineInformationEmptyPM($id)
    {
        $myArray = array();
        $sql = "select mif.*, p.productName,al.areaname,al.stateID, st.state, c.c_name, ac.Name from `machine_in_field` mif
        JOIN products p on mif.machine_type = p.id
        JOIN area_location al on mif.areaID = al.id
        JOIN `states` st on al.stateID = st.id
        JOIN  contracts c on mif.contractID = c.id
        JOIN  accounts ac on mif.account_id = ac.id
        WHERE mif.active = 1 and mif.id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function getTeamAllOrderCollected()
    {
        $myArray = array();
        /* $sql = "select service_product sp join machine_demand md on mp.

         select l.id as leadID,l.assigned, l.companyName, l.email, ld.ticketNo, SUM(lp.qty * lp.Amount) as Amount,
          ld.ocDay, ld.orderCollectedDate, ld.ocMonth, ocYear, s.fullname as myadmin, ld.id as ticketID
         from machine_product lp
         join machine_demand ld on lp.leadDemandID = ld.id

         join leads l on lp.leadID = l.id
         join staff s on l.assigned = s.id
         where ld.orderCollect = 1
          GROUP BY ld.ticketNo order by ocYear desc, ocMonth desc, ocDay desc";
 // echo $user_id." m: ".$month." Y: ".$year;

         $handle = $this->db->prepare($sql);


         $handle->execute();

         if($handle->rowCount()>0){
             while ($row = $handle->fetch(PDO::FETCH_ASSOC)){
                 $myArray[] = $row;
             }
             return $myArray;

         }else{
                 return null;
         } */

    }

    function validateExistingMachineContract($id)
    {
        $sql = "select * from contractvalue where machineID = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function getLeadMPSOrderOnLeadDemand($id)
    {
        $myArray = array();
        $sql = "SELECT mps.id,mps.productID, p.productName, p.Code, p.color, p.ProductType, mps.product_qty, mps.rentalCharge, mps.cost_mono, mps.cost_color, mps.min_vol_mono, mps.min_vol_color,mps.contract_duration,mps.billingType,ld.ticketNo, ld.orderCollect, ld.orderCollectedDate, ld.ocDay, ld.ocMonth,ld.ocYear, st.salestype, st.st, ld.description, mps.accesories
        FROM mps_info mps
        JOIN products p ON mps.productID = p.id
        JOIN lead_demand ld on mps.lead_demand_id = ld.id
        JOIN sales_type st on ld.sales_type_id = st.id
        where mps.id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $myArray[] = $row;
            }
            return $myArray;
        }
    }

    // function getContractValue($id){
    //     $myArray = array();
    //     $sql = "select cv.*, mif.machine_code, mif.serialNo from contractvalue cv
    //             join machine_in_field mif on mif.id = cv.machineID
    //             where cv.contractID = ?";
    //     $handle=$this->db->prepare($sql);
    //     $handle->bindValue(1,$id);
    //     $handle->execute();
    //     if($handle->rowCount()>0){
    //         while ($row = $handle->fetch(PDO::FETCH_ASSOC)){
    //             $myArray[] = $row;
    //         }
    //         return $myArray;
    //     }
    // }

    function getContractValue($id)
    {
        $myArray = array();
        $sql = "select cv.contractID, cv.AccID, cv.machineID, cv.RentalCharge, ci.*, mif.machine_code, mif.serialNo 
                from contractvalue cv
                join contract_info ci on ci.id = cv.contractID
                join machine_in_field mif on mif.id = cv.machineID
                where cv.contractID = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $myArray[] = $row;
            }
            return $myArray;
        }
    }


    function getSumOfContractValue($id, $mid)
    {
        $myArray = array();
        $sql = "SELECT SUM(`excess_cost_mono`) as mi1 FROM `contractvalue` WHERE `contractID` = ? AND`machineID`= ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->bindValue(2, $mid);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        }


    }

    function checkM_reading($contractID, $moment)
    {
        $sql = "select * from m_reading where contractID = ? and moment = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $contractID);
        $handle->bindValue(2, $moment);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return false;
        } else {
            return true;
        }

    }

    function createM_reading($contractID, $moment, $nextmoment, $generatedBy, $generatedDate)
    {
        $sql = "INSERT INTO `m_reading` (`contractID`, `moment`, `generatedBy`, `generatedDate`, `collected`, `collectedBy`, `collectedDate`, `timestamp`,nextmoment)
        VALUES ( ?,?,?,?,?,?,?,?,?)";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $contractID);
        $handle->bindValue(2, $moment);
        $handle->bindValue(3, $generatedBy);
        $handle->bindValue(4, $generatedDate);
        $handle->bindValue(5, 0);
        $handle->bindValue(6, 0);
        $handle->bindValue(7, "");
        $handle->bindValue(8, "");
        $handle->bindValue(9, $nextmoment);
        $handle->execute();
        return $this->db->lastInsertId();
    }

    function InputBillingInformation($readingID, $contractID, $accID, $machineID, $month, $year, $currentMono, $currentColor, $moment, $copyMono, $copyColor
        , $previousMono, $previousColor, $amountMono, $amountColor, $amountRental)
    {
        $sql = "INSERT INTO meter_reading (readingID, contractID, accID, machineID, `month`, `year`, `mono`, `color`, `moment`,
        `copyMono`, `copyColor`,`previousMono`, `previousColor`, `AmountMono`, `AmountColor`, `AmountRental`)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $readingID);
        $handle->bindValue(2, $contractID);
        $handle->bindValue(3, $accID);
        $handle->bindValue(4, $machineID);
        $handle->bindValue(5, $month);
        $handle->bindValue(6, $year);
        $handle->bindValue(7, $currentMono);
        $handle->bindValue(8, $currentColor);
        $handle->bindValue(9, $moment);
        $handle->bindValue(10, $copyMono);
        $handle->bindValue(11, $copyColor);
        $handle->bindValue(12, $previousMono);
        $handle->bindValue(13, $previousColor);
        $handle->bindValue(14, $amountMono);
        $handle->bindValue(15, $amountColor);
        $handle->bindValue(16, $amountRental);
        $handle->execute();
    }

    function getLastContractMoment($contractID)
    {
        $val = 0;
        $sql = "select id, moment as mo from m_reading where contractID = ?  order by moment desc ";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $contractID);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            $row = $handle->fetch(PDO::FETCH_ASSOC);
            $val = $row['id'];
        }
        return $val;

    }

    function getPreviousMeterReading($contractID, $machineID, $reading, $color)
    {
        $val = 0;
        $sql = "select * from meter_reading where contractID = ? and machineID = ? and readingID = ?  ";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $contractID);
        $handle->bindValue(2, $machineID);
        $handle->bindValue(3, $reading);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            $row = $handle->fetch(PDO::FETCH_ASSOC);
            if ($color == 1) {
                $val = $row['mono'];
            } else {
                $val = $row['color'];
            }
        }

        return $val;
    }

    function getContractBillingMeterReading($rID, $cID, $moment)
    {
        $myArray = array();
        $sql = "select mr.*, mif.machine_code, mif.serialNo,mif.doi,mif.department,p.productName as Model from meter_reading mr
                join machine_in_field mif on mr.machineID = mif.id
                join products p on mif.machine_type = p.id
                where mr.readingID = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $rID);
        //$handle->bindValue(2, $cID);
        //  $handle->bindValue(2, $moment);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        }

    }


    //$accID,$contractType,$costmono,$c_volmono,$costcolor,$c_volcolor,$c_exvolmono,$excostmono,$c_exvolcolor,$excostcolor,$duration,$billingType,$cs
    function createContractTicket($accID, $contractType, $costmono, $volmono, $costcolor, $volcolor, $exvolmono, $excostmono, $exvolcolor, $excostcolor, $duration, $billingType, $cs, $cummul)
    {
        $sql = "insert into contract_info(contractTicket,ContractTypeID,AccountID,conStart,conEnd,cummulative,cost_mono,min_vol_mono,cost_color,min_vol_color,excess_mono,excess_cost_mono,excess_color,excess_cost_color,contract_duration,billingType)
        values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, "C-" . $this->createTicketNo());
        $handle->bindValue(2, $contractType);
        $handle->bindValue(3, $accID);
        $handle->bindValue(4, $cs);
        $handle->bindValue(5, "");
        $handle->bindValue(6, $cummul);
        $handle->bindValue(7, $this->RemoveComma($costmono));
        $handle->bindValue(8, $this->RemoveComma($volmono));
        $handle->bindValue(9, $this->RemoveComma($costcolor));
        $handle->bindValue(10, $this->RemoveComma($volcolor));
        $handle->bindValue(11, $this->RemoveComma($exvolmono));
        $handle->bindValue(12, $this->RemoveComma($excostmono));
        $handle->bindValue(13, $this->RemoveComma($exvolcolor));
        $handle->bindValue(14, $this->RemoveComma($excostcolor));
        $handle->bindValue(15, $duration);
        $handle->bindValue(16, $billingType);

        $handle->execute();
        return $this->db->lastInsertId();
    }

    function selectFromContractInfo($id)
    {
        $sql = "select ci.*, ac.Name,(select COUNT(*) from contractvalue where contractID = ci.id) as machineNum,
        ac.Address, al.stateID, al.areaname, st.state, ind.sector, c.c_name, c.contractName
          from contract_info ci
          join accounts ac on ci.AccountID = ac.id
          JOIN `area_location` al on ac.areaID = al.id
            JOIN `states` st on al.stateID = st.id
            JOIN `industries` ind on ac.industryID = ind.id
          join contracts c on ci.ContractTypeID = c.id where ci.id = ?";

        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        return $row = $handle->fetch(PDO::FETCH_ASSOC);
    }

    function selectAcctContractInfo($id)
    {
        $sql = "select ci.*, ac.Name, cv.RentalCharge, ac.Address, al.stateID, al.areaname, st.state, ind.sector, c.c_name, c.contractName
          from contract_info ci
          JOIN accounts ac on ci.AccountID = ac.id
          JOIN contractvalue cv on ci.AccountID = cv.AccID
          JOIN `area_location` al on ac.areaID = al.id
            JOIN `states` st on al.stateID = st.id
            JOIN `industries` ind on ac.industryID = ind.id
          JOIN contracts c on ci.ContractTypeID = c.id where ci.AccountID = ?";

        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        return $row = $handle->fetch(PDO::FETCH_ASSOC);
    }

    function engineerRankings()
    {
        $myArray = [];
        $dayOne = strtotime(date('Y') . '-01-01');
        $resolved = 8;
        $install = 17;
        $toner = 12;
        $preventive = 47;

        $sql = "SELECT st.id, st.fullname, "
            . "(select SUM(closedTimeStamp-openedTimeStamp) from service_call "
            . "where engineer = st.id and CaseStatus = ? "
            . "and openedTimeStamp > $dayOne)as totalTimeDiff, "
            . "(select COUNT(*) from service_call where engineer = st.id "
            . "and openedTimeStamp > $dayOne)as totalCalls,"
            . "(select COUNT(*) from service_call where engineer = st.id "
            . "and issues LIKE '%$install%' and openedTimeStamp > $dayOne)as installCalls,"
            . "(select COUNT(*) from service_call where engineer = st.id "
            . "and issues LIKE '%$preventive%' "
            . "and openedTimeStamp > $dayOne)as preventiveCalls,"
            . "(select COUNT(*) from service_call where engineer = st.id "
            . "and issues LIKE '%$toner' "
            . "and openedTimeStamp > $dayOne)as tonerCalls,"
            . "(select COUNT(*) from service_call "
            . "where engineer = st.id and CaseStatus = ? "
            . "and openedTimeStamp > $dayOne)as totalResolved "
            . "from staff st "
            . "join service_call sc on st.id = sc.engineer "
            . "where sc.CaseStatus = ? and sc.openedTimeStamp > ?"
            . "and st.active = ? group by st.id ORDER BY st.fullname ASC";

        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $resolved);
        $handle->bindValue(2, $resolved);
        $handle->bindValue(3, $resolved);
        $handle->bindValue(4, $dayOne);
        $handle->bindValue(5, 1);
        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $myArray[] = $row;
            }
            return $myArray;
        }
    }

    function updateContract($id, $contractType, $cumulative, $rentalCharge, $volMono, $costMono, $exVolMono, $exCostMono, $costColor, $exVolColor, $exCostColor, $conStart, $contractDuration, $volColor, $billingType)
    {
        $data = array();

        // update all contract machines
        $this->updateContractMachines($id, $contractType, $conStart, $contractDuration);

        $sqlCv = "update `contractvalue` set `RentalCharge` = ? where AccID = ?";
        $handle = $this->db->prepare($sqlCv);
        $handle->bindValue(1, $rentalCharge);
        $handle->bindValue(2, $id);
        $handle->execute();

        $sql = "update `contract_info` set `ContractTypeID` = ?, `conStart` = ?, `cummulative` = ?, `cost_mono` = ?, `min_vol_mono` = ?, `excess_mono` = ?, `excess_cost_mono` = ?, `cost_color` = ?,`min_vol_color` = ?, `excess_color` = ?, `excess_cost_color` = ?, `contract_duration` = ?, `billingType` = ? where AccountID = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $contractType);
        $handle->bindValue(2, $conStart);
        $handle->bindValue(3, $cumulative);
        $handle->bindValue(4, $costMono);
        $handle->bindValue(5, $volMono);
        $handle->bindValue(6, $exVolMono);
        $handle->bindValue(7, $exCostMono);
        $handle->bindValue(8, $costColor);
        $handle->bindValue(9, $volColor);
        $handle->bindValue(10, $exVolColor);
        $handle->bindValue(11, $exCostColor);
        $handle->bindValue(12, $contractDuration);
        $handle->bindValue(13, $billingType);
        $handle->bindValue(14, $id);
        if ($handle->execute()) {
            $data['success'] = true;
            $data['msg'] = 'Contract has been successfully updated';
        } else {
            $data['success'] = false;
            $data['msg'] = 'Server side error encountered. Contact the administrator';
        }

        return $data;
    }

    // Update all contract machines
    function updateContractMachines($id, $contractType, $conStart, $contractDuration)
    {
        $st = preg_split('~ ~', $conStart);
        $conEnds = $st[0] . ' ' . $st[1] . ' ' . ($st[2] + $contractDuration);
        $sql = "update `machine_in_field` set `ContractID` = ?, `contractStart` = ?, `contractEnds` = ? where 	account_id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $contractType);
        $handle->bindValue(2, $conStart);
        $handle->bindValue(3, $conEnds);
        $handle->bindValue(4, $id);
        $handle->execute();
    }

    function getAllCompanyContracts()
    {
        $myArray = array();
        $sql = "select ci.*, ac.Name,(select COUNT(*) from contractvalue where contractID = ci.id) as machineNum, c.c_name
          from contract_info ci
          join accounts ac on ci.AccountID = ac.id
          join contracts c on ci.ContractTypeID = c.id

          ";
        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        }
    }

    function getContractBillingValues()
    {
        $myArray = array();
        $sql = "select mr.*,a.Name,ci.contractTicket,ci.AccountID,ci.ContractTypeID,
        ci.conStart,ci.conEnd,ci.cummulative,ci.contract_duration,ci.billingType,
        c.contractName,c.c_name
        from m_reading mr
        join contract_info ci on mr.contractID = ci.id
        join accounts a on ci.AccountID = a.id
        join contracts c on c.id = ci.ContractTypeID";
        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        }
    }

    function getContractBillingValuesPerContractID($id)
    {
        $myArray = array();
        $sql = "select mr.*,a.Name,ci.contractTicket,ci.AccountID,ci.ContractTypeID,
        ci.conStart,ci.conEnd,ci.cummulative,ci.contract_duration,ci.billingType,
        c.contractName,c.c_name
        from m_reading mr
        join contract_info ci on mr.contractID = ci.id
        join accounts a on ci.AccountID = a.id
        join contracts c on c.id = ci.ContractTypeID where mr.contractID = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        }
    }


    function getContractBillingValuesaLL()
    {
        $myArray = array();
        $sql = "select mr.*,a.Name,ci.contractTicket,ci.AccountID,ci.ContractTypeID,
        ci.conStart,ci.conEnd,ci.cummulative,ci.contract_duration,ci.billingType,
        c.contractName,c.c_name
        from m_reading mr
        join contract_info ci on mr.contractID = ci.id
        join accounts a on ci.AccountID = a.id
        join contracts c on c.id = ci.ContractTypeID ";
        $handle = $this->db->prepare($sql);
        // $handle->bindValue(1,$id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        }
    }

    function getContractBillingValuesPerReadingID($id)
    {
        //$myArray = array();
        $sql = "select mr.*,a.Name,a.Address,al.areaname,lg.lga,st.state,ci.contractTicket,ci.AccountID,ci.ContractTypeID,
        ci.conStart,ci.conEnd,ci.cummulative,ci.contract_duration,ci.billingType, ci.cost_mono,ci.cost_color,
        ci.min_vol_mono,ci.min_vol_color,ci.excess_mono,ci.excess_cost_mono,ci.excess_color,ci.excess_cost_color,
        c.contractName,c.c_name,(select COUNT(*) from contractvalue where contractID = ci.id) as machineNum
        from m_reading mr
        join contract_info ci on mr.contractID = ci.id
        join accounts a on ci.AccountID = a.id
        join area_location al on al.id = a.areaID
        join lga lg on lg.id = al.lgaID
        join states st on st.id = al.stateID 
        join contracts c on c.id = ci.ContractTypeID where mr.id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return $handle->fetch(PDO::FETCH_ASSOC);
        }
    }

    function getGeneratedAmountOfContract($id)
    {
        $value = 0;
        $sql = "select AmountMono,AmountColor,AmountRental from meter_reading where readingID = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $cal = $row['AmountMono'] + $row['AmountColor'] + $row['AmountRental'];
                $value = $value + $cal;
            }
        }
        return $value;
    }

    function inputMachineContract($contractID, $accID, $value, $rentalCharge, $costmono, $volmono, $costcolor, $volcolor, $exvolmono, $excostmono, $exvolcolor, $excostcolor, $duration, $billingType)
    {
        $sql = "insert into contractvalue(contractId,AccID,machineID,RentalCharge,cost_mono,min_vol_mono,cost_color,min_vol_color,excess_mono,excess_cost_mono,excess_color,excess_cost_color,contract_duration,billingType)
                values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $contractID);
        $handle->bindValue(2, $accID);
        $handle->bindValue(3, $value);
        $handle->bindValue(4, $this->RemoveComma($rentalCharge));
        $handle->bindValue(5, $this->RemoveComma($costmono));
        $handle->bindValue(6, $this->RemoveComma($volmono));
        $handle->bindValue(7, $this->RemoveComma($costcolor));
        $handle->bindValue(8, $this->RemoveComma($volcolor));
        $handle->bindValue(9, $this->RemoveComma($exvolmono));
        $handle->bindValue(10, $this->RemoveComma($excostmono));
        $handle->bindValue(11, $this->RemoveComma($exvolcolor));
        $handle->bindValue(12, $this->RemoveComma($excostcolor));
        $handle->bindValue(13, $duration);
        $handle->bindValue(14, $billingType);
        $handle->execute();
    }

    function getSingleMachineInformation($id)
    {
        //$myArray = array();
        $sql = "select mif.*,a.Name, p.productName,al.areaname,al.stateID, st.state, c.c_name from `machine_in_field` mif
        left JOIN `accounts` a on mif.account_id = a.id
        left JOIN products p on mif.machine_type = p.id
        left JOIN area_location al on mif.areaID = al.id
        left JOIN `states` st on al.stateID = st.id
        left JOIN  contracts c on mif.contractID = c.id
        WHERE mif.active = 1 and mif.id = ?";

        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return $handle->fetch(PDO::FETCH_ASSOC);
            //  $myArray[] = $row;

        } else {
            return false;
        }

    }

    public function convert_number_to_words($number)
    {

        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'fourty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . $this->convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int)($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int)($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string)$fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }


    public function ForgetPassword($change_pass)
    {


        $change_pass = $_POST['change_pass'];

        if (empty($change_pass)) {
            echo "<div class='alert alert-danger'>
                               <strong>Failed!</strong>  Please fill in the required field</div>";
        } elseif (!filter_var($change_pass, FILTER_VALIDATE_EMAIL)) {

            echo "Please a valid email address";


        } else {

            $select = $this->db->query("SELECT * FROM staff WHERE email='$change_pass'");


            while ($email = $select->fetch()) {
                $usermail = $email['email'];
                $fullname = $email['fullname'];

                $userPassword = $email['password'];

// use actual sendgrid username and password in this section
                $url = SendGrid::$url;
                $user = SendGrid::$username; // place SG username here
                $pass = SendGrid::$password; // place SG password here


                $token = rand();

                $link = 'https://www.elastic25.com/forgot-password-recovery.php?email=' . $usermail . '&token=' . $token;

                $message = "<p>You have requested for your password recovery. <a href='$link' target='_blank'>Click here</a> to reset your password.</p> 
<p>If you are unable to click the link then copy the below link and paste in your browser to reset your password<br><i>$link</i></p> ";

                // note the above parameters now referenced in the 'subject', 'html', and 'text' sections
                // make the to email be your own address or where ever you would like the contact form info sent

                $json_string = array(

                    'to' => array($usermail),
                    'category' => 'test_category'
                );

                $params = array(
                    'api_user' => "$user",
                    'api_key' => "$pass",
                    'x-smtpapi' => json_encode($json_string),
                    'to' => "$usermail",
                    'replyto' => "$usermail",
                    'subject' => "Password Reset Request for $fullname", // Either give a subject for each submission, or set to $subject
                    'html' => "<html><head><title>Contact Form</title><body>
      Dear $fullname ,\n
       $message <body></title></head></html>", // Set HTML here.  Will still need to make sure to reference post data names
                    'text' => "
     
      Dear, $fullname\n
      $message",
                    'from' => $usermail, // set from address here, it can really be anything
                );

//                curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
                $request = $url . 'api/mail.send.json';
                // Generate curl request
                $session = curl_init($request);
                // Tell curl to use HTTP POST
                curl_setopt($session, CURLOPT_POST, true);
                // Tell curl that this is the body of the POST
                curl_setopt($session, CURLOPT_POSTFIELDS, $params);
                // Tell curl not to return headers, but do return the response
                curl_setopt($session, CURLOPT_HEADER, false);
                curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
                // obtain response
                $response = curl_exec($session);
                curl_close($session);
                // Redirect to thank you page upon successfull completion, will want to build one if you don't alreday have one available
                echo "<script>alert('A mail with recovery instruction has sent to your email')</script>";
                echo "<script>window.open('login.php','_self')</script>";
                exit();
                // print everything out
                print_r($response);
            }

            if ($email == '') {

                echo "<div class='alert alert-danger'>
                  <strong></strong>This email provided doesn't exist in our database. </div>";

            }


        }


    }


    public function ForgetPassworRecover($change_password_button)
    {


        $Staffemail = $_GET['email'];
        $token = $_GET['token'];

        $change_pass = $_POST['change_pass'];

        $change_pass_again = $_POST['change_pass_again'];

        if ($change_pass == $change_pass_again) {

            $update_pass = $this->db->query("UPDATE staff SET password='$change_pass' WHERE email='$Staffemail'");

            if ($update_pass) {

                echo "<div class='alert alert-success'>
            <strong></strong>Your password has changed successfully. Please login with your new passowrd.</div>";

            }


        } else {
            echo "<div class='alert alert-success'>
            <strong></strong>Password doesn't match</div>";

        }
    }

    public function getStaffDepartment()
    {
        $sql = "select * from department";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        //$handle->bindValue(1,$id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }

    }


    public function getStaffDesignation()
    {
        $sql = "SELECT * FROM dpt_designation";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        //$handle->bindValue(1,$id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }

    }


    public function getAllGoodsTranfer()
    {
        $sql = "select gr.*, stf.fullname, st.storeName  from goods_recieved gr
       join stores st on st.id = gr.storeID
       join staff stf  on stf.id = gr.doneBy
       where invoiceNo = 'TRANSFER' and transType != 'RECIEVED'";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        //$handle->bindValue(1,$id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    public function getStoreName()
    {
        $sql = "SELECT * FROM stores";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        //$handle->bindValue(1,$id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    public function getStore($id)
    {
        $sql = "select * from stores where id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return $handle->fetch(PDO::FETCH_OBJ);
        } else {
            return false;
        }
    }

    public function getStoreNameTransferOption($storeID)
    {
        $sql = "SELECT * FROM stores where id != ?";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $storeID);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }

        /*$handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return $handle->fetch(PDO::FETCH_ASSOC);
                $myArray[] = $row;

        } else {
            return false;
        }*/

    }


    public function changeUserPass($user_currentPass, $old_pass, $new_pass, $confirm_pass, $username)
    {


        if ($user_currentPass != $old_pass) {

            echo "<div class='alert alert-danger'>
            <strong></strong>Your old password is Wrong</div>";
        } elseif ($new_pass == $confirm_pass) {

            $update_pass = $this->db->query("UPDATE staff SET password='$new_pass' WHERE username='$username'");


            echo "<div class='alert alert-success'>
            <strong></strong>Password Update Sucessfully. Please Login With Your New Passowrd.</div>";

        } else {
            echo "<div class='alert alert-danger'>
            <strong></strong>Your New Password and Confirm Password is not Match</div>";

        }

    }


    public function getProductName($Product)
    {
        $sql = "SELECT * FROM products WHERE id='$Product'";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        //$handle->bindValue(1,$id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }

    }


    public function getProductsUnitsName($unitID)
    {
        $myArray = array();
        $handle = $this->db->prepare("SELECT * FROM units WHERE id='$unitID'");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }
    }


    public function UpdateCreditNote($qty, $invoiceNo, $product, $GetStoreID)
    {
        for ($i = 0; $i < count($product); $i++) {
            if ($product[$i] != "" && $qty[$i] != "") {


                $update_UpdateCreditNote = $this->db->query("UPDATE goodslog SET returned= returned +$qty[$i] ,remain= remain +$qty[$i] WHERE InvoiceNo='$invoiceNo' AND productID='$product[$i]'");


                $UpadteProduct = $this->db->query("UPDATE products SET store$GetStoreID=store$GetStoreID +$qty[$i] WHERE id=$product[$i]");
                ///echo "<div class='alert alert-success'>
                // <strong></strong>CREDIT NOTE HAS BEEN MADE SUCCESSFULLY</div>";
            }
        }
    }


    public function getProductId1($productName1)
    {
        $sql = "SELECT * FROM products WHERE productName ='$productName1'";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        //$handle->bindValue(1,$id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }


    public function checkAllInvoiceNo($invoiceNo)
    {
        $sql = "select * from goodslog where InvoiceNo = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $invoiceNo);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function InsertReturnticket($supplier, $invoiceNo, $productName1, $GetId, $nQty, $storeID, $invoiceReturnDate, $invoiceDate)
    {

        // $returnedDate = date('d-m-Y');
        $sql = "INSERT INTO creditnote
 (productId,productName,invoiceNo,custormerName,invoiceDate,returnDate,storeticketGen)
        VALUES (?,?,?,?,?,?,?)";
        $handle = $this->db->prepare($sql);
        $ticketGen = $this->createTicketNo();
        $handle->bindValue(1, $GetId);
        $handle->bindValue(2, $productName1);
        $handle->bindValue(3, $invoiceNo);
        $handle->bindValue(4, $supplier);
        $handle->bindValue(5, $invoiceReturnDate);
        // $handle->bindValue(5,$_SESSION['user_id']);

        $handle->bindValue(6, "GRT-" . $ticketGen);
        $handle->bindValue(7, $invoiceDate);

        // $handle->bindValue(8,$transType);
        $handle->execute();
        $mainID = $this->db->lastInsertId();
        return $mainID;
    }

    public function getAllReturnTicket()
    {
        // $sql = "SELECT * FROM products INNER JOIN creditnote ON products.id = creditnote.productName";
        $sql = "SELECT creditnote.productId,  creditnote.id,products.productName,products.Code,creditnote.returned,creditnote.invoiceNo,creditnote.custormerName,creditnote.invoiceDate,creditnote.returnDate,creditnote.store,creditnote.unit,creditnote.ticketGen FROM creditnote INNER JOIN products ON products.id = creditnote.productId WHERE creditnote.returned>0 ORDER BY products.id DESC";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        //$handle->bindValue(1,$id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    public function getAllReturnTicketId($id)
    {
        $sql = "SELECT * FROM creditnote WHERE ticketGen='$id'";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        //$handle->bindValue(1,$id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function getProductsBelowThreeQuantity($id)
    {
        $myArray = array();
        $sql = "SELECT p.*,pt.type,u.unitName FROM `products` p 
       join `producttype` pt on p.productType = pt.id 
       left join units u on u.id = p.unitID 
       where p.store1 < ? OR p.store1 < ?
       order by p.ProductType asc, p.productName asc, p.color asc";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->bindValue(2, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }
    }

    public function getStoreNameByLogin($GetStoreID)
    {
        $sql = "SELECT * FROM stores WHERE id = $GetStoreID";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        // $handle->bindValue(1,$id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }

    }

    //CHECK IF FILE REFERENCE ALREADY EXIST OR NOT
    public function checkFileRef($fileRef)
    {
        $sql = "select * from goods_recieved where FileReference = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $fileRef);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    function getServiceCallTickectNo($supplyTicket)
    {
        $myArray = array();
        $sql = "SELECT * FROM service_call WHERE ticketNo = ? ";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $supplyTicket);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function updateBackdatedCall($supplyTicket, $openedDateTime, $closedDateTime)
    {
        $sql = "update service_call set openedDateTime = ?, closedDateTime = ? where ticketNo = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $openedDateTime);
        $handle->bindValue(2, $closedDateTime);
        $handle->bindValue(3, $supplyTicket);
        $handle->execute();

        echo "<div class='alert alert-success'>
            <strong></strong>This Ticket has been backdated</div>";
    }

    function getAllServiceCallForengineeridFollowUp($id, $engineerid)
    {
        $myArray = array();
        $str = " = 0";
        if ($id == 0) {
            $str = " = 0";
        } else {
            $str = " > 0 ";
        }
        $sql = "select sc.*,mif.machine_code,mif.id as MachineID, mif.account_id as accountID, cs.caseName, ac.Name as AccountName, al.areaname, l.lga, s.state,
      mif.contactName1, mif.contactEmail1, mif.contactPhone1,
        mif.serialNo, mif.Address, ct.c_name as contract, p.productName as machineBrand from `service_call` sc
      JOIN machine_in_field mif on mif.id = sc.machine_id
      JOIN accounts ac on ac.id = sc.account_id
      join contracts ct on ct.id = mif.contractID
        join products p on p.id = mif.machine_type
        join area_location al on al.id = mif.areaID
        join lga l on l.id = al.lgaID
        join states s on s.id = l.stateID
      left JOIN casestatus cs on cs.id = sc.CaseStatus
      where closedBy " . $str . " AND engineer = " . $engineerid . "
       order by sc.id desc";

        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }
    }

    function UpdateProductCost($product, $cost)
    {

        for ($i = 0; $i < count($product); $i++) {
            if ($product[$i] != "" && $cost[$i] != "") {

                $sql = "update products set cost = ? where id = ?";
                $handle = $this->db->prepare($sql);
                $handle->bindValue(1, $cost[$i]);
                $handle->bindValue(2, $product[$i]);
                $handle->execute();
            }
        }
    }

    public function getProductNameByProduction($product)
    {
        for ($i = 0; $i < count($product); $i++) {
            if ($product[$i] != "") {
                $sql = "SELECT * FROM products WHERE id='$product[$i]'";
                $myArray = array();
                $handle = $this->db->prepare($sql);
                //$handle->bindValue(1,$id);
                $handle->execute();
                if ($handle->rowCount() > 0) {
                    while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                        $myArray[] = $row;
                    }
                    return $myArray;
                } else {
                    return false;
                }

            }

        }


    }


    function getProductslist($id)
    {
        $myArray = array();
        $sql = "select gl.*,p.productName,p.Code,s.storeName,st.fullname from goodslog gl
      join products p on p.id = gl.productID
      join stores s on s.id = gl.storeID
      join staff st on st.id = gl.doneBy

      where gl.productID = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }


    }


//Workshop Inventory START HERE ......

    function getAllWorkshopCategories()
    {
        $myArray = array();
        $handle = $this->db->prepare("select * from `workshop_categories`");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }

    }


    function checkMachineAvailableInworkshop($machineCode)
    {
        $sql = "select * from workshop where machine_code = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $machineCode);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return true;
        } else {
            return false;
        }

    }

    function checkMachineAvailableInShowroom($machineCode)
    {
        $sql = "select * from showroom where machine_code = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $machineCode);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return true;
        } else {
            return false;
        }

    }

    function createAWorkshopMachine($acc, $machineCode, $machineModel, $machineSerialNo, $category, $meterReading, $engineer, $doi, $reportedBy)
    {

        $sql = "insert into workshop (account_name,machine_name,machine_code,serialNo,doi,category,assign_engineer,meterReading,date_out,timestamp,dateTime,ticketGen,reportedby)
                values(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $handle = $this->db->prepare($sql);
        $ticketGen = $this->createTicketNo();
        $handle->bindValue(1, $acc);
        $handle->bindValue(2, $machineModel);
        $handle->bindValue(3, $machineCode);
        $handle->bindValue(4, $machineSerialNo);
        $handle->bindValue(5, $doi);
        $handle->bindValue(6, $category);
        $handle->bindValue(7, $engineer);
        $handle->bindValue(8, $meterReading);
        $handle->bindValue(9, 0);
        $handle->bindValue(10, time());
        $handle->bindValue(11, date("d-m-Y"));
        $handle->bindValue(12, $ticketGen);
        $handle->bindValue(13, $reportedBy);
        $handle->execute();
    }

    function createShowroomMachine($acc, $machineCode, $machineModel, $machineSerialNo, $category, $meterReading, $engineer, $doi, $reportedBy)
    {

        $sql = "insert into showroom (account_name,machine_name,machine_code,serialNo,doi,category,assign_engineer,meterReading,date_out,timestamp,dateTime,ticketGen,reportedby)
                values(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $handle = $this->db->prepare($sql);
        $ticketGen = $this->createTicketNo();
        $handle->bindValue(1, $acc);
        $handle->bindValue(2, $machineModel);
        $handle->bindValue(3, $machineCode);
        $handle->bindValue(4, $machineSerialNo);
        $handle->bindValue(5, $doi);
        $handle->bindValue(6, $category);
        $handle->bindValue(7, $engineer);
        $handle->bindValue(8, $meterReading);
        $handle->bindValue(9, 0);
        $handle->bindValue(10, time());
        $handle->bindValue(11, date("d-m-Y"));
        $handle->bindValue(12, $ticketGen);
        $handle->bindValue(13, $reportedBy);
        $handle->execute();
    }

    function getAllMachineWorkshopInformation()
    {
        $myArray = array();
        $sql = "SELECT * FROM workshop";

        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function getAllMachineShowroomInformation()
    {
        $myArray = array();
        $sql = "SELECT * FROM showroom";

        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function getWorkshopTicket($ticket)
    {
        $sql = "SELECT * FROM workshop WHERE ticketGen = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $ticket);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return $handle->fetch(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }

    function getAccountNameInfo($Name)
    {
        $sql = "SELECT * FROM accounts WHERE Name = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $Name);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return $handle->fetch(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }

    function workshopFollowUp($serviceID, $closeDate, $workDone, $engineer, $st, $et, $meterReading, $colour, $Mono)
    {
        $sql = "UPDATE workshop SET Machine_fault = ?, assign_engineer = ?, date_out = ?, schDate = ?, schTime = ?,  meterReading = ?, colour = ?, Mono = ? WHERE id =?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $workDone);
        $handle->bindValue(2, $engineer);
        $handle->bindValue(3, $closeDate);
        $handle->bindValue(4, $st);
        $handle->bindValue(5, $et);
        $handle->bindValue(6, $meterReading);
        $handle->bindValue(7, $colour);
        $handle->bindValue(8, $Mono);
        $handle->bindValue(9, $serviceID);
        $handle->execute();
    }

    function stockMonthlySummary($id, $month, $year)
    {


        $myArray = array();
        $sql = "SELECT SUM(sold) AS totalsold FROM `goodslog` WHERE `productID`= $id  AND `ocMonth` = $month AND `ocYear` = $year";
        $handle = $this->db->prepare($sql);

        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $myArray[] = $row;
            }
            // var_dump($row);
            return $myArray;
        }
        else
        {
            return false;
        }
    }

    function getGoodsLogAnalysis1($id)
    {
        $yr = date('Y');
        $myArray = array();
        $sql = "SELECT SUM(sold) AS totalsold FROM `goodslog` WHERE `productID`= $id AND `ocMonth` = 1 AND `ocYear` = $yr ";
        $handle = $this->db->prepare($sql);

        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }


    }

    function getGoodsLogAnalysis2($id)
    {
        $yr = date('Y');
        $myArray = array();
        $sql = "SELECT SUM(sold) AS totalsold FROM `goodslog` WHERE `productID`= $id AND `ocMonth` = 2 AND `ocYear` = $yr ";
        $handle = $this->db->prepare($sql);

        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function getGoodsLogAnalysis3($id)
    {
        $yr = date('Y');
        $myArray = array();
        $sql = "SELECT SUM(sold) AS totalsold FROM `goodslog` WHERE `productID`= $id AND `ocMonth` = 3 AND `ocYear` = $yr ";
        $handle = $this->db->prepare($sql);

        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $myArray[] = $row;
            }
            return $myArray;
        }
        else
        {
            return false;
        }
    }

    function getGoodsLogAnalysis4($id)
    {
        $yr = date('Y');
        $myArray = array();
        $sql = "SELECT SUM(sold) AS totalsold FROM `goodslog` WHERE `productID`= $id AND `ocMonth` =4 AND `ocYear` = $yr ";
        $handle = $this->db->prepare($sql);

        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $myArray[] = $row;
            }
            return $myArray;
        }
        else
        {
            return false;
        }
    }

    function getGoodsLogAnalysis5($id)
    {
        $yr = date('Y');
        $myArray = array();
        $sql = "SELECT SUM(sold) AS totalsold FROM `goodslog` WHERE `productID`= $id AND `ocMonth` =5 AND `ocYear` = $yr ";
        $handle = $this->db->prepare($sql);

        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $myArray[] = $row;
            }
            return $myArray;
        }
        else
        {
            return false;
        }
    }

    function getGoodsLogAnalysis6($id)
    {
        $yr = date('Y');
        $myArray = array();
        $sql = "SELECT SUM(sold) AS totalsold FROM `goodslog` WHERE `productID`= $id AND `ocMonth` =6 AND `ocYear` = $yr ";
        $handle = $this->db->prepare($sql);

        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }


    }

    function getGoodsLogAnalysis7($id)
    {
        $yr = date('Y');
        $myArray = array();
        $sql = "SELECT SUM(sold) AS totalsold FROM `goodslog` WHERE `productID`= $id AND `ocMonth` =7 AND `ocYear` = $yr ";
        $handle = $this->db->prepare($sql);

        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }


    }

    function getGoodsLogAnalysis8($id)
    {
        $yr = date('Y');
        $myArray = array();
        $sql = "SELECT SUM(sold) AS totalsold FROM `goodslog` WHERE `productID`= $id AND `ocMonth` =8 AND `ocYear` = $yr ";
        $handle = $this->db->prepare($sql);

        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }


    }

    function getGoodsLogAnalysis9($id)
    {
        $yr = date('Y');
        $myArray = array();
        $sql = "SELECT SUM(sold) AS totalsold FROM `goodslog` WHERE `productID`= $id AND `ocMonth` =9 AND `ocYear` = $yr ";
        $handle = $this->db->prepare($sql);

        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }


    }

    function getGoodsLogAnalysis10($id)
    {
        $yr = date('Y');
        $myArray = array();
        $sql = "SELECT SUM(sold) AS totalsold FROM `goodslog` WHERE `productID`= $id AND `ocMonth` =10 AND `ocYear` = $yr ";
        $handle = $this->db->prepare($sql);

        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }


    }

    function getGoodsLogAvgSold($id)
    {
        $yr = date('Y');
        $myArray = array();
        $sql = "SELECT AVG(case sold when null then 0 else sold end ) AS totalsold FROM `goodslog` WHERE sold !=0 AND `productID`= $id AND `ocMonth`> 0 AND `ocYear` = $yr";
        $handle = $this->db->prepare($sql);

        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }


    }

    function getGoodsLogCurrentForstore1($id)
    {
        $yr = date('Y');
        $myArray = array();
        $sql = "SELECT `remain` FROM `goodslog` WHERE `productID` = $id AND `storeID` = 1 ORDER by id DESC LIMIT 1";
        $handle = $this->db->prepare($sql);

        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }


    }

    function getGoodsLogCurrentForstore2($id)
    {
        $yr = date('Y');
        $myArray = array();
        $sql = "SELECT `remain` FROM `goodslog` WHERE `productID` = $id AND `storeID` = 2 ORDER by id DESC LIMIT 1";
        $handle = $this->db->prepare($sql);

        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
    }

    function getProductNameByProductType($id)
    {
        $sql = "select * from products where ProductType = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return $handle->fetch(PDO::FETCH_ASSOC);
        }

    }

    function getAllContractsByNC()
    {
        $myArray = array();
        $sql = "SELECT * FROM machine_in_field WHERE contractID = 1";
        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            echo $handle->rowCount();
        }


    }

    function getAllContractsByFMSA()
    {
        $myArray = array();
        $sql = "SELECT * FROM machine_in_field WHERE contractID = 2";
        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            echo $handle->rowCount();
        }
    }

    function getAllContractsByAMC()
    {
        $myArray = array();
        $sql = "SELECT * FROM machine_in_field WHERE contractID = 3";
        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            echo $handle->rowCount();
        }
    }

    function getAllContractsByMPS()
    {
        $myArray = array();
        $sql = "SELECT * FROM machine_in_field WHERE contractID = 4";
        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            echo $handle->rowCount();
        }
    }

    function closeCall($id, $paystatus, $closeby, $closedate, $closetime, $casestatus, $workdone, $mID, $aID, $engineer, $issues, $schD, $schT, $mReading, $colour, $mono, $wd = '')
    {
        $sql = "update service_call set paymentStatus=?, closedBy =?, closedDateTime =?, closedTimeStamp =?,CaseStatus=?, workDone =?,engineer =?,issues =?, schDate =?, schTime = ? where id =?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $paystatus);
        $handle->bindValue(2, $closeby);
        $handle->bindValue(3, $closedate);
        $handle->bindValue(4, $closetime);
        $handle->bindValue(5, $casestatus);
        $handle->bindValue(6, $workdone);
        $handle->bindValue(7, $engineer);
        $handle->bindValue(8, $issues);
        $handle->bindValue(9, $schD);
        $handle->bindValue(10, $schT);
        $handle->bindValue(11, $id);
        $handle->execute();

        $this->addFollowUp($id, $workdone, $schT, $closetime, $engineer, $schD, $mReading, $colour, $mono);

        $message = "followed up a service call for " . $this->getSingleAccountInformation($aID)['Name'] . " Machine : " . $this->getSingleMachineInformation($mID)['machine_code'];
        $accountName = $this->getSingleAccountInformation($aID)['Name'];
        $engineerName = $this->getSingleUserInformation($engineer)['fullname'];
        $engineerEmail = $this->getSingleUserInformation($engineer)['email'];

        $ticketNo = $this->getSingleTicketInformation($id)['ticketNo'];
    }

    public function getAllUsers()
    {
        $allUsers = array();
        $sql = "SELECT s.id, s.fullname, s.email, s.phoneNo, d.Department,
           dd.designation from staff s, department d, dpt_designation dd 
            where s.DepartmentID = d.id 
            and s.designationID = dd.id
            and s.active = 1
            order by s.fullname";
        $handle = $this->db->prepare($sql);
        $handle->execute();

        if ($handle->rowCount() > 0)
        {
            while ($row = $handle->fetch(PDO::FETCH_OBJ))
            {
                $allUsers[] = $row;
            }
            return $allUsers;
        }
        else
        {
            return null;
        }
    }

    public function getUser($id)
    {
        $sql = "SELECT s.id, s.fullname, s.email, s.phoneNo, 
        d.Department, dd.designation
        from staff s, department d, dpt_designation dd
        where s.DepartmentID = d.id 
        and s.designationID = dd.id
        and s.id = $id";

        $handle = $this->db->prepare($sql);
        $handle->execute();

        if ($handle->rowCount() > 0)
        {
            $row = $handle->fetch(PDO::FETCH_OBJ);
            return $row;
        }
        else
        {
            return null;
        }
    }

    // IT Admin update staff password
    public function updatePassword($id, $password)
    {
        $msg = null;
        $sql = "update staff set password = ? where id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $password);
        $handle->bindValue(2, $id);
        if ($handle->execute()) {
            $msg = 'User password updated successfully';
        }
        return $msg;
    }

    // User password self update
    public function updateStaffUserPassword($id, $password)
    {
        try {
            $sql = "UPDATE staff SET password = ?, changePass = 1 where id = ?";
            $handle = $this->db->prepare($sql);

            $handle->bindValue(1, password_hash($password, PASSWORD_BCRYPT));
            $handle->bindValue(2, $id);
            $handle->execute();

        } catch (PDOException $exp) {
            echo $this->getException($exp->getMessage());
        }
    }

    public function getAllAdmins()
    {
        $myArray = array();
        $sql = "select st.*, dpd.designation from staff st 
                join dpt_designation dpd on dpd.id = st.designationID 
                order by fullname asc";
        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
            return $myArray;
        }
    }

    public function getAdmin($id)
    {
        $myArray = array();
        $sql = "select st.*, dpd.designation from staff st 
                join dpt_designation dpd on dpd.id = st.designationID 
                where st.id = $id";
        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            return $row = $handle->fetch(PDO::FETCH_OBJ);
        }
    }

    public function getIssues($issues)
    {
        // remove first comma of string
        $issString = substr($issues, 1);
        $iss = preg_split('~,~', $issString);
//        print_r($issues);
        $display = '';
        for ($i = 0; $i < sizeof($iss); $i++) {
            $id = $iss[$i];
            $sql = "select * from `call_issues` where id = $id ";
            $handle = $this->db->prepare($sql);
            $handle->execute();
            $row = $handle->fetch(PDO::FETCH_OBJ);
            $display .= $i < (sizeof($iss) - 1) ? $row->issues
                . ',<br>' : $row->issues . '<br>';
        }
        return $display;
    }

    function getFilteredStoreSales($start, $end, $store)
    {
        $myArray = array();

        $sql = "select gr.*, stf.fullname, st.storeName  from goods_recieved gr
        join stores st on st.id = gr.storeID
        join staff stf  on stf.id = gr.doneBy
        where (`lastModified` BETWEEN UNIX_TIMESTAMP('$start') and UNIX_TIMESTAMP('$end')) AND saved = ? and transType = ? and gr.storeID $store ";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, 1);
        $handle->bindValue(2, 'SOLD');
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $myArray[] = $row;
            }
        }
        return $myArray;
    }

    public function mpsAnalytics()
    {
        $myArray = array();
        $sql = "select ci.*, ac.Name,(select COUNT(*) from machine_in_field where account_id = ci.accountID and contractID = 4 ) as numberMachines, c.c_name
          from contract_info ci
          join accounts ac on ci.AccountID = ac.id
          join contracts c on ci.ContractTypeID = c.id 
          where ci.contractTypeID = 4 group by ac.Name order by numberMachines asc";

        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0)
        {
            while ($row = $handle->fetch(PDO::FETCH_OBJ))
            {
                $thisName = str_replace(' ', '/', $row->Name);
                $name = preg_split('~/~', $thisName);
                $name = ucwords(strtolower($name[0]));
                $myArray[] = array(
                    'id' => $row->AccountID,
                    'companyName' => $row->Name,
                    'name' => $name,
                    'number' => $row->numberMachines);
            }
        }
        return $myArray;
    }

    public function getMpsContracts($accountID)
    {
        $myArray = array();
        $sql = "select ci.*, ci.id as contractID, cv.RentalCharge, 
       cv.min_vol_mono as minVolMono, cv.min_vol_color as minVolColor, 
       cv.excess_cost_mono as excessCostMono, cv.excess_cost_color as excessCostColor, 
       mif.id as machineID, mif.*
            from contract_info ci
            left join contractValue cv on ci.AccountID = cv.accID
            left join machine_in_field mif on ci.AccountID = mif.account_id 
            where ci.accountID = $accountID group by mif.machine_code";

        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_OBJ)) {
                $myArray[] = $row;
            }
        }
        return $myArray;
    }

    public function getBillingFromMeterReading($contractID, $machineID, $machineCode, $rentalCharge, $minVolMono, $minVolColor, $excessMonoCharge, $excessColorCharge)
    {
        $myArray = array();
        $sql = "select *, sum(amountMono) as amountMono, sum(amountColor) as amountColor from meter_reading where machineID = $machineID and contractID = $contractID and year = 2019";
        $handle = $this->db->prepare($sql);
        $handle->execute();
        while ($row = $handle->fetch(PDO::FETCH_OBJ)) {
            $billing = new Billing($rentalCharge, $minVolMono,
                $minVolColor, $excessMonoCharge,
                $excessColorCharge);
            $date = $row->year . '-' . str_pad($row->month, 2, '0', STR_PAD_LEFT) . '-' . '30';
            $monoReading = $row->mono;
            $colorReading = $row->color;
            $previousMono = $row->previousMono;
            $amountMono = $row->AmountMono;
            $amountColor = $row->AmountColor;
            $previousColor = $row->previousColor;
            $monthlyBill = $billing->getMonthlyBill($amountColor, $amountMono);
            $myArray[] = array(
                'date' => $date,
                'machineCode' => $machineCode,
                'rentalCharge' => $rentalCharge,
                'monoReading' => $monoReading,
                'previousMono' => $previousMono,
                'colorReading' => $colorReading,
                'previousColor' => $previousColor,
                'sumColor' => $row->amountColor,
                'sumMono' => $row->amountMono,
                'amountMono' => self::convertToMoney($amountMono),
                'amountColor' => self::convertToMoney($amountColor),
                'monthlyBill' => self::convertToMoney($monthlyBill));
        }
        return $myArray;
    }

    public function getMpsAccountBilling($id)
    {
        $myArray = array();
        $sql = "select ci.*, cv.RentalCharge,  mif.* 
        from contract_info ci
        left join contractvalue cv on ci.AccountID = cv.accID 
        left join machine_in_field mif on ci.AccountID = mif.account_id 
         where ci.accountID = $id group by ci.contractTicket";

        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_OBJ)) {
                $myArray[] = $row;
            }
        }
        return $myArray;
    }

//  public function updatePasswords(){
//
//      $sql = "select * from staff where id != null";
//      $handle = $this->db->prepare($sql);
//      $handle->execute();
//      $rows = $handle->rowCount();
//
//      for ($i = 1; $i < 100; $i++){
//          $sql = "select * from staff where id = $i";
//          $handle = $this->db->prepare($sql);
//          $handle->execute();
//
//          if ($handle->rowCount() > 0){
//              $row = $handle->fetch(PDO::FETCH_OBJ);
//              $id = $row->id;
//              $pass = password_hash($row->password, PASSWORD_BCRYPT);
//              $sql1 = "update staff set `password` = '$pass' where id = $id";
//          $handle = $this->db->prepare($sql1);
//          $handle->execute();
//          }
//      }
//  }

    public function updateSchedules()
    {
        $sql = "select id from preventive_maintenance_schedule order by id desc limit 1";
        $handle = $this->db->prepare($sql);
        $handle->execute();
        $row = $handle->fetch(PDO::FETCH_OBJ);
        $max = $row->id;

        for ($i = 1; $i <= $max; $i++) {
            $sql = "select * from `preventive_maintenance_schedule` where id = $i";
            $handle = $this->db->prepare($sql);
            $handle->execute();
            if ($handle->rowCount() > 0) {
                $row = $handle->fetch(PDO::FETCH_OBJ);
                $id = $row->id;
                $dateFormat = date('Y-m-d', strtotime($row->NextScheduledDateTime));
                $sql1 = "update `preventive_maintenance_schedule` set `nextSchedule` = '$dateFormat' where id = $id";
                $handle = $this->db->prepare($sql1);
                $handle->execute();
            }
        }
    }

    public function pmsSchedules()
    {
        $myArray = array();
        // SQL query to get results for the past month
        $oldSchedule = "select pm.*, ac.id as accID, ac.Name as brandName, 
                al.areaname,al.stateID,st.state,ind.sector, mf.* 
                from preventive_maintenance_schedule pm
                LEFT JOIN accounts ac on pm.account_id = ac.id 
                LEFT JOIN area_location al on ac.areaID = al.id
                LEFT JOIN machine_in_field mf on pm.machine_in_field_id = mf.id
                LEFT JOIN `states` st on al.stateID = st.id
                LEFT JOIN `industries` ind on ind.id = ac.industryID 
                where nextSchedule <= date_add(curdate(), interval 2 week)
                order by pm.nextSchedule asc";
        // SQL query to get results for the next month
        $newSchedule = "select pm.*, ac.id as accID, ac.Name as brandName,
                al.areaname,al.stateID,st.state,ind.sector, mf.*
                from preventive_maintenance_schedule pm
                LEFT JOIN accounts ac on pm.account_id = ac.id
                LEFT JOIN area_location al on ac.areaID = al.id
                LEFT JOIN machine_in_field mf 
                on pm.machine_in_field_id = mf.id
                LEFT JOIN `states` st on al.stateID = st.id
                LEFT JOIN `industries` ind on ind.id = ac.industryID
                where nextSchedule 
                between date_sub(curdate(), interval 1 MONTH)
                and date_add(curdate(), interval 1 MONTH)
                and CaseStatus = 0 
                order by pm.nextSchedule asc";
        $handle = $this->db->prepare($oldSchedule);
        $handle->execute();
        $pmsSchedules = $handle->rowCount();
        if ($pmsSchedules > 0) {
            while ($row = $handle->fetch(PDO::FETCH_OBJ)) {
                $myArray[UtilFunctions::$oldSchedule][] = $row;
            }
        }

        $handle = $this->db->prepare($newSchedule);
        $handle->execute();
        $pmsSchedules = $handle->rowCount();
        if ($pmsSchedules > 0) {
            while ($row = $handle->fetch(PDO::FETCH_OBJ)) {
                $myArray[UtilFunctions::$newSchedule][] = $row;
            }
        }
        return $myArray;
    }

    public function kasSpareParts($code)
    {
        $myArray = array();

        foreach ($code as $codes) {
            $sql = "update products set `productType` = 17 where `Code` LIKE  '%$codes%'";
            $handle = $this->db->prepare($sql);
            $handle->execute();

        }

        $sql = "select `productName`, `Code` from products where `productType` = 17";
        $handle = $this->db->prepare($sql);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_OBJ)) {
                $myArray[] = $row->productName . ' : ' . $row->Code;
            }
        }
        return $myArray;
    }
}