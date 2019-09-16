<?php

require_once "Mail.php"; // PEAR Mail package
require_once('Mail/mime.php'); // PEAR Mail_Mime packge

class MySQLDatabase
{
    
    private $db;
    public $host;
    
    function __construct($DB_con,$Host)
    {
        $this->db = $DB_con;
        $this->host = $Host;
    }
      
    public function getException($errorMessage)
    {
        //$_SERVER['REMOTE_ADDR'],date("d-m-Y h:i:s A"),time()
        return $this->showMsg("Error!", "A system error has occured, we will fix it<br/>" . $errorMessage, 1);
    }

    public function redirect_to($host){
        header("location:".$host);
    }


     function authenticateStaff($username, $password){

        $sql = "select * from staff where username =? and password = ?";
         $handle = $this->db->prepare($sql);
         $handle->bindValue(1,$username);
         $handle->bindValue(2,$password);
         $handle->execute();
         if($handle->rowCount()>0){
            $row = $handle->fetch(PDO::FETCH_ASSOC);
                    return array($row['id'],$row['active']);
            }else{
                return array(0,0);
            }

    }
    
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    function returnSalesStageColor($stage)
    {
        if ($stage < 30) {
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
        $sql    = "select * from `accounts` where `Name` = ?";
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
        
        $sql    = "insert into `accounts` (leadID,Name,Address,areaID,ContactName1,ContactName2,ContactName3,phone1,phone2,phone3,email1,email2,email3,desig1,desig2,desig3,`timestamp`,`dateTime`,industryID) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
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

    public function updateAccountInfo($accID, $name, $address, $areaID, $contactName1, $contactName2, $contactName3, $phone1, $phone2, $phone3, $email1, $email2, $email3, $desig1, $desig2, $desig3, $ind){
       $sql = "update `accounts` set Name = ?,Address= ?,areaID= ?,ContactName1= ?,ContactName2= ?,ContactName3= ?,phone1= ?,phone2= ?,phone3= ?,email1= ?,email2= ?,email3= ?,desig1= ?,desig2= ?,desig3= ?,industryID= ? where id = ?";
      //17
       $handle = $this->db->prepare($sql);
         echo $sql;
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
        $msg = "editted basic information about ".$name;
        $this->createActivityNotifications($msg,0,$accID);
    }
    function generateRandomString($length = 10) {
        $characters = '3456789BCDGHIJKLMPQSUVWXY';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
     }

    public function createTicketNo(){
        $leadName = "EL25-";
        $leadName.= $this->generateRandomString(5);
        return $leadName;
    }

    function createServiceCall($accountID,$machineID,$reportedBy,$eng,$cost,$paystatus,$issues,$user_id,$CaseStatus,$schD,$schT){
        $sql = "insert into `service_call` (ticketNo, account_id, machine_id, ReportedBy,engineer,cost,paymentStatus,issues,purchase,openedBy,openedDateTime,openedTimeStamp,closedBy,CaseStatus,schDate,schTime)
        values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $purchase = 0;
        $ticket = $this->createTicketNo();
         $handle = $this->db->prepare($sql);
        $handle->bindValue(1,$ticket);
        $handle->bindValue(2, $accountID);
        $handle->bindValue(3, $machineID);
        $handle->bindValue(4, $reportedBy);
        $handle->bindValue(5, $eng);
        $handle->bindValue(6, $cost);
        $handle->bindValue(7, $paystatus);
        $handle->bindValue(8, $issues);
        $handle->bindValue(9, $purchase);
        $handle->bindValue(10, $user_id);
        $handle->bindValue(11, date("l jS \of F Y h:i:s A"));
        $handle->bindValue(12, time());
        $handle->bindValue(13, 0);
        $handle->bindValue(14, $CaseStatus);
        $handle->bindValue(15,$schD);
         $handle->bindValue(16,$schT);
        $handle->execute();
        $lasID = $this->db->lastInsertId();
        $accountName = $this->getSingleAccountInformation($accountID)['Name'];
        $machineName = $this->getSingleMachineInformation($machineID)['machine_code'];
        $message = "added a new service call for   : <a href='".$this->host."machine-info/".$machineID."'></a>".$machineName. "</a> assigned to <a href='".$this->host."account-info/".$accountID."'>".$accountName."</a>";
        $this->createActivityNotifications($message,$machineID,$accountID);

        return 'SERVICE CALL HAS BEEN LOGGED WITH TICKET NUMBER :<a href="'.$this->host.'ticket-info/'.$ticket.'" class="btn btn-success">'.$ticket.'</a>';



  }

  function getPaymentStatus(){
      $sql = "select * from payment_status";
      $myArray = array();
      $handle = $this->db->prepare($sql);
      $handle->bindValue(1,$id);
      $handle->execute();
        if ($handle->rowCount() > 0) {
            while($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                   $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }
  }

  function AddNewPurchase($product,$qty,$amount,$machineID,$accountID, $scID,$discount){
        if(count($product) > 0){
                    if($scID >0){
                        $this->updateFollowUpPurchase($scID);
                     }
                    $this->addMachineDemandProduct($scID,$product,$qty,$amount,$machineID,$accountID,$discount);
                }
  }

  function updateFollowUpPurchase($scID){
      $sql = "update service_call set purchase = 1 where id = ?";
      $handle = $this->db->prepare($sql);
      $handle->bindValue(1, $scID);
      $handle->execute();
  }
  function followUpCall($id,$paystatus,$closeby,$closedate,$closetime,$casestatus,$workdone,$mID, $aID,$engineer,$issues,$schD,$schT){
      $sql = "update service_call set paymentStatus=?, closedBy =?, closedDateTime =?, closedTimeStamp =?,CaseStatus=?, workDone =?,engineer =?,issues =?, schDate =?, schTime = ? where id =?";
      $handle = $this->db->prepare($sql);
      $handle->bindValue(1, $paystatus);
      $handle->bindValue(2, $closeby);
      $handle->bindValue(3, $closedate );
      $handle->bindValue(4, $closetime);
      $handle->bindValue(5, $casestatus);
      $handle->bindValue(6, $workdone);
      $handle->bindValue(7, $engineer);
      $handle->bindValue(8, $issues);
      $handle->bindValue(9, $schD);
      $handle->bindValue(10, $schT);
      $handle->bindValue(11, $id);
      $handle->execute();
        $message = "followed up a service call for ".$this->getSingleAccountInformation($aID)['Name']." Machine : ".$this->getSingleMachineInformation($mID)['machine_code'];
      $this->createActivityNotifications($message,$mID,$aID);

  }

   function deleteMachineProduct($id){
        $sql = "delete from service_product where id =?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1,$id);
        $handle->execute();
        $message = "";
        $this->createActivityNotifications($message);
    }

  function getMachineActivities($id){
      $myArray = array();
      $sql = "select * from `activities` where accountID = ? order by timeStamp desc";
      $handle = $this->db->prepare($sql);
      $handle->bindValue(1,$id);
      $handle->execute();
        if ($handle->rowCount() > 0) {
            while($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                   $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }


  }

  function getCaseStatus(){
      $sql = "select * from casestatus order by `range`";
      $myArray = array();
      $handle = $this->db->prepare($sql);
      $handle->bindValue(1,$id);
      $handle->execute();
        if ($handle->rowCount() > 0) {
            while($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                   $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }

  }

  function getMachineServiceCall($id){
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
       where sc.machine_id = ? order by sc.id desc";

      $handle = $this->db->prepare($sql);
      $handle->bindValue(1,$id);
      $handle->execute();
        if ($handle->rowCount() > 0) {
            while($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                   $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }


  }

  function getAllServiceCall(){
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
       order by sc.id desc";

      $handle = $this->db->prepare($sql);
      $handle->execute();
        if ($handle->rowCount() > 0) {
            while($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                   $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }


  }

  function getAllResolvedServiceCall(){
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
            while($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                   $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }


  }

  function dateDiff($time1, $time2, $precision = 6) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }

    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }

    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
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

  function getAllServiceCallForFollowUp($id){
      $myArray = array();
       $str = " = 0";
      if($id== 0){$str = " = 0";}else{ $str = " > 0 ";}
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
      where closedBy ".$str."
       order by sc.id desc";

      $handle = $this->db->prepare($sql);
      $handle->execute();
        if ($handle->rowCount() > 0) {
            while($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                   $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }


  }

  function getAccountServiceCall($id){
      $myArray = array();
      $sql = "select sc.*,mif.machine_code,cs.caseName from `service_call` sc
      JOIN machine_in_field mif on mif.id = sc.machine_id
      JOIN casestatus cs on cs.id = sc.CaseStatus

       where sc.account_id = ? order by sc.id desc";
      $handle = $this->db->prepare($sql);
      $handle->bindValue(1,$id);
      $handle->execute();
        if ($handle->rowCount() > 0) {
            while($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                   $myArray[] = $row;
            }
            return $myArray;
        } else {
            return false;
        }


  }


  function createActivityNotifications($message,$machineID=0,$accountID=0){
        $user_id = $_SESSION['user_id'];
        $sql = "insert into `activities` (user_id,activities,timeStamp, dateTime,accountID,machineID,Ymd) values (?,?,?,?,?,?,?)";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1,$user_id);
        $handle->bindValue(2,$message);
        $handle->bindValue(3,time());
        $handle->bindValue(4,date("l jS \of F Y h:i:s A"));
        $handle->bindValue(5,$machineID);
        $handle->bindValue(6,$accountID);
        $handle->bindValue(7, date('Y').date('m').date('d'));
        $handle->execute();
    }

   public function addMachineDemandProduct($lasID,$product,$qty,$amount,$machineID,$accountID,$discount){
        $leadDemandID = $this->enterProductDemand($lasID,1,"",$machineID,$accountID,$discount);
        $count = count($product);
            if ($count >0 && !empty($product)) {
                    for ($i=0; $i< $count; $i++) {
                        $productID = $product[$i];
                        $qty1 = $qty[$i];
                        $amount1 = str_replace(',','',$amount[$i]);
                        $this->insertLeadProducts($lasID,$product[$i],$qty[$i],$amount1,$leadDemandID,$machineID);
                    }
                     $accountName = $this->getSingleAccountInformation($accountID)['Name'];
                     $machineName = $this->getSingleMachineInformation($machineID)['machine_code'];
                     $message = "added a new purchase for a machine : ".$machineName. " assigned to ".$accountName;
                     $this->createActivityNotifications($message);
                }


    }

    public function purchaseListForMachineCollected($id,$oc){
        $sql = "select md.*, sum(sp.qty * sp.Amount) as myAmount from `machine_demand` md
        join service_product sp on md.id = sp.leadDemandID
        where md.machineID = ? and md.orderCollect = ? group by md.id";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1,$id);
        $handle->bindValue(2,$oc);

         $handle->execute();
        if ($handle->rowCount() > 0) {
            while($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }



    }

     public function purchaseListForAccountCollected($id,$oc){
        $sql = "select md.*, sum(sp.qty * sp.Amount) as myAmount from `machine_demand` md
        join service_product sp on md.id = sp.leadDemandID
        where md.accountID = ? and md.orderCollect = ? group by md.id";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1,$id);
        $handle->bindValue(2,$oc);

         $handle->execute();
        if ($handle->rowCount() > 0) {
            while($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }



    }

     public function purchaseListForMachineCollectedAll($oc){
        $sql = "select md.*, sum(sp.qty * sp.Amount) as myAmount, mif.machine_code, ac.Name from `machine_demand` md
        join machine_in_field mif on mif.id = md.machineID
        join accounts ac on ac.id = md.accountID
        join service_product sp on md.id = sp.leadDemandID
        where md.orderCollect = ? group by md.id";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        //$handle->bindValue(1,$id);
        $handle->bindValue(1,$oc);

         $handle->execute();
        if ($handle->rowCount() > 0) {
            while($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }



    }

    public function purchaseListForMachineCollectedToday($ocDay,$ocMonth,$ocYear){
        $sql = "select md.*, sum(sp.qty * sp.Amount) as myAmount from `machine_demand` md
        join service_product sp on md.id = sp.leadDemandID
        where md.ocDay = ? and md.ocMonth=? and md.ocYear =? and md.orderCollect = 1 group by md.id";
        $myArray = array();
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1,$ocDay);
        $handle->bindValue(2,$ocMonth);
        $handle->bindValue(3,$ocYear);

         $handle->execute();
        if ($handle->rowCount() > 0) {
            while($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
                $myArray[] = $row;
            }
            return $myArray;
        } else {
            return null;
        }



    }


    public function purchaseListForMachineCollectedDaily($ocDay,$ocMonth,$ocYear){
        $sql = "select md.*, sum(sp.qty * sp.Amount) as myAmount from `machine_demand` md
        join service_product sp on md.id = sp.leadDemandID
        where md.ocDay = ? and md.ocMonth=? and md.ocYear =? and md.orderCollect = 1 group by md.id";
        $myArray = array();

        $totalToday = 0;

        $handle = $this->db->prepare($sql);
        $handle->bindValue(1,$ocDay);
        $handle->bindValue(2,$ocMonth);
        $handle->bindValue(3,$ocYear);

         $handle->execute();
        if ($handle->rowCount() > 0) {
            while($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
              $vat = 0;
              if($row['vat'] == 1){$vat = 0.05 *$row['myAmount'];}
              $added = $row['myAmount'] + $vat;
               $discount = ($row['discount']/100) * $added;
               $finalAmount = $added - $discount;
               $totalToday = $totalToday + $finalAmount;
               // $myArray[] = $row;

            }
            return $totalToday;
        } else {
            return 0;
        }



    }
    public function purchaseListForMachineCollectedMonthly($ocMonth,$ocYear){
        $sql = "select md.*, sum(sp.qty * sp.Amount) as myAmount from `machine_demand` md
        join service_product sp on md.id = sp.leadDemandID
        where md.ocMonth=? and md.ocYear =? and md.orderCollect = 1 group by md.id";
        $myArray = array();

        $totalToday = 0;

        $handle = $this->db->prepare($sql);
        
        $handle->bindValue(1,$ocMonth);
        $handle->bindValue(2,$ocYear);

         $handle->execute();
        if ($handle->rowCount() > 0) {
            while($row = $handle->fetch(PDO::FETCH_ASSOC))
            {
              $vat = 0;
              if($row['vat'] == 1){$vat = 0.05 *$row['myAmount'];}
              $added = $row['myAmount'] + $vat;
               $discount = ($row['discount']/100) * $added;
               $finalAmount = $added - $discount;
               $totalToday = $totalToday + $finalAmount;
               // $myArray[] = $row;

            }
            return $totalToday;
        } else {
            return 0;
        }



    }









     function time_elapsed_string($ptime){
        $etime = time() - $ptime;
        if($etime <1){
            return 'a moment ago';
        }

        $a = array( 365*24*60*60=>'year', 30*24*60*60=>'month', 7*24*60*60=>'week', 24*60*60=>'day', 60*60=>'hr', 60=>'min',1=>'second');
        $a_plural = array('year'=>'years', 'month'=>'months','week'=>'weeks', 'day'=>'days','hr'=>'hrs','min'=>'mins','second'=>'seconds');

        foreach($a as $secs=>$str){
            $d = $etime/$secs;
            if($d>=1){
                $r =  round($d);
                return $r.' '.($r >1 ? $a_plural[$str] : $str).' ago';
            }
        }
    }

    function getServiceProductOrderOnLeadDemand($machineID,$serviceDemandID){
        $myArray = array();
            $sql = "SELECT sp.id,sp.productID, p.productName, p.Code, p.color, p.ProductType, sp.qty, sp.Amount, sd.ticketNo,
                    sd.orderCollect, sd.orderCollectedDate, sd.ocDay, sd.ocMonth,sd.ocYear, st.salestype, st.st, sd.description
                    FROM service_product sp
                    JOIN products p ON sp.productID = p.id
                    JOIN machine_demand sd on sp.leadDemandID = sd.id
                    JOIN sales_type st on sd.sales_type_id = st.id
                    where sp.machineID = ? and sd.id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1,$machineID);
        $handle->bindValue(2,$serviceDemandID);
        $handle->execute();
        if($handle->rowCount()>0){
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)){
                $myArray[] = $row;
            }
            return $myArray;
         }

    }

    function getServiceProductOrderCall($id){
        $myArray = array();
            $sql = "SELECT sp.id,sp.productID, p.productName, p.Code, p.color, p.ProductType, sp.qty, sp.Amount, sd.ticketNo,
                    sd.orderCollect, sd.orderCollectedDate, sd.ocDay, sd.ocMonth,sd.ocYear, st.salestype, st.st, sd.description
                    FROM service_product sp
                    JOIN products p ON sp.productID = p.id
                    JOIN machine_demand sd on sp.leadDemandID = sd.id
                    JOIN sales_type st on sd.sales_type_id = st.id
                    where sp.serviceCallID = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1,$id);
        $handle->execute();
        if($handle->rowCount()>0){
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)){
                $myArray[] = $row;
            }
            return $myArray;
         }

    }


    function getPurchaseTicketForServiceCall($serviceCallID){
        $myArray =array();
        $sql = "select * from machine_demand where serviceCallID = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1,$serviceCallID);
        $handle->execute();
        if($handle->rowCount() >0){
             while($row = $handle->fetch(PDO::FETCH_ASSOC)){
                 $myArray[] = $row;
             }
             return $myArray;
        }
    }


    function getServiceTicket($ticket){
        $sql = "select sc.*, ac.Name as AccountName, mif.machine_code, al.areaname, l.lga, s.state,
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
        $handle->bindValue(1,$ticket);
        $handle->execute();
        if($handle->rowCount() > 0){
            return $handle->fetch(PDO::FETCH_ASSOC);
        }else{
            return null;
        }
    }
    function getBillingType($id=""){
        $myArray = array();
        $sql = "";
        if($id==""){
            $sql = "select * from billingtype";
        }else{
            $sql = "select * from billingtype where `value` = {$id}";
        }
        $handle = $this->db->prepare($sql);
        $handle->execute();
        if($handle->rowCount()>0){
            if($id!= ""){
                return $handle->fetch(PDO::FETCH_ASSOC);
            }else{
                while ($row = $handle->fetch(PDO::FETCH_ASSOC)){
                    $myArray[] = $row;
                }
                return $myArray;
             }

         }

    }

    function getIssueWithId($id){
        $sql = "select issues from call_issues where id =?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1,$id);
        $handle->execute();
        if($handle->rowCount() > 0){
            return $handle->fetch(PDO::FETCH_ASSOC);
        }
    }

    function getPurchaseTicket($ticket){

        $sql = "select * from machine_demand where ticketNo = ?";

        $handle = $this->db->prepare($sql);
        $handle->bindValue(1,$ticket);
        $handle->execute();
        if($handle->rowCount() >0){
                $row = $handle->fetch(PDO::FETCH_ASSOC);
                    if($row['machineID'] == 0){
                         $sql = "select md.*,ac.Name as AccountName, 'NONE' as machine_code, al.areaname, l.lga, s.state,
                                mif.serialNo, ac.Address, ct.c_name as contract, '' as machineBrand from machine_demand md
                                join accounts ac on ac.id = md.accountID
                                right join machine_in_field mif on mif.id = md.machineID
                                right join contracts ct on ct.id = 1
                                right join area_location al on al.id = ac.areaID
                                join lga l on l.id = al.lgaID
                                join states s on s.id = l.stateID
                                where md.ticketNo = ?";
                                 return $this->getPurchaseTicket2($sql,$ticket);

                    }else{
                            $sql = "select md.*,ac.Name as AccountName, mif.machine_code, al.areaname, l.lga, s.state,
                            mif.serialNo, mif.Address, ct.c_name as contract, p.productName as machineBrand from machine_demand md
                            join accounts ac on ac.id = md.accountID
                            right join machine_in_field mif on mif.id = md.machineID
                            join contracts ct on ct.id = mif.contractID
                            join products p on p.id = mif.machine_type
                            join area_location al on al.id = mif.areaID
                            join lga l on l.id = al.lgaID
                            join states s on s.id = l.stateID
                            where md.ticketNo = ?";
                            return $this->getPurchaseTicket2($sql,$ticket);

                    }
            }else{
                return null;
            }


    }

    function getPurchaseTicket2($sql,$ticket){

        $handle = $this->db->prepare($sql);
        $handle->bindValue(1,$ticket);
        $handle->execute();
            if($handle->rowCount() >0){
                return $handle->fetch(PDO::FETCH_ASSOC);
            }else{
                return null;
            }
    }

     function getPurchaseProductOrderCall($id){
        $myArray = array();
            $sql = "SELECT sp.id,sp.productID, p.productName, p.Code, p.color, p.ProductType, sp.qty, sp.Amount, sd.ticketNo,
                    sd.orderCollect, sd.orderCollectedDate, sd.ocDay, sd.ocMonth,sd.ocYear,sd.vat, st.salestype, st.st, sd.description
                    FROM service_product sp
                    JOIN products p ON sp.productID = p.id
                    JOIN machine_demand sd on sp.leadDemandID = sd.id
                    JOIN sales_type st on sd.sales_type_id = st.id
                    where sp.leadDemandID = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1,$id);
        $handle->execute();
        if($handle->rowCount()>0){
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)){
                $myArray[] = $row;
            }
            return $myArray;
         }

    }


    function convertToMoney($amount){
        return '₦'.number_format($amount,2);
    }
    function convertToMoney2($amount){
        return 'N '.number_format($amount,2);
    }

    function returnTimeDiff($time1,$time2){
        $etime = $time1 - $time2;
        return $etime;
    }

    function secondsToTime($seconds) {
        $hours = floor($seconds / 3600);
        $seconds -= $hours * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;

        return "<b>$hours hrs, $minutes mins </b>";

   // $dtF = new \DateTime('@0');
   // $dtT = new \DateTime("@$seconds");
   // return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
   // return $dtF->diff($dtT)->format('%a days, %h hours');
    }

    function getSecondsColor($secs){
        if($secs < 172800){
            return "success";
        }else if($secs > 172800 && $secs < 432000){
            return "warning";
        }else if ($secs >432000){
            return "danger";
        }
    }

    function getPercentage($secs){
        $extime = ($secs /1036800) * 100;
        return $extime;
    }

    function time_space($time1, $time2){
          $etime = $time1 - $time2;

        if($time1 == ""){
            return '';
        }
        if($etime <1){
            return 'a moment ago';
        }

        $a = array( 365*24*60*60=>'year', 30*24*60*60=>'month', 7*24*60*60=>'week', 24*60*60=>'day', 60*60=>'hr', 60=>'min',1=>'second');
        $a_plural = array('year'=>'years', 'month'=>'months','week'=>'weeks', 'day'=>'days','hr'=>'hrs','min'=>'mins','second'=>'seconds');

        foreach($a as $secs=>$str){
            $d = $etime/$secs;
            if($d>=1){
                $r =  round($d);
                return $r.' '.($r >1 ? $a_plural[$str] : $str);
            }
        }
    }

    function updateOrderCollected($id,$ocDay,$ocMonth,$ocYear,$vat,$machineID,$accID){
        $sql = "update machine_demand set orderCollect = 1, orderCollectedDate = ?, ocDay = ?, ocMonth = ?, ocYear = ?,ocDMY= ?,
         dateTime = ?, vat = ?, collectedBy=? where id = ?";
        $person = $this->getMyUserInformation($_SESSION['user_id'])['fullname'];
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1,date("l jS \of F Y h:i:s A"));
        $handle->bindValue(2,$ocDay,PDO::PARAM_INT);
        $handle->bindValue(3,$ocMonth,PDO::PARAM_INT);
        $handle->bindValue(4,$ocYear,PDO::PARAM_INT);
        $handle->bindValue(5,$ocYear.$ocMonth.$ocDay);
        $handle->bindValue(6,time());
        $handle->bindValue(7,$vat,PDO::PARAM_INT);
        $handle->bindValue(8,$_SESSION['user_id']);
        $handle->bindValue(9,$id,PDO::PARAM_INT);

        $handle->execute();

        $accountName = $this->getSingleAccountInformation($accID)['Name'];
        $mac_name = $this->getSingleMachineInformation($machineID)['machine_code'];
        $msg = " successfully collected an order from ".$accountName." for purchase made for ".$mac_name;
        $this->createActivityNotifications($msg,$machineID,$accID);
       // $this->

    }



     public function enterProductDemand($serviceCallID,$salestypeID,$description="",$machineID,$accountID,$discount){
        $sql = "insert into machine_demand (adminID,serviceCallID,ticketNo,sales_type_id,description,machineID,accountID,discount) values(?,?,?,?,?,?,?,?)";
        $handle = $this->db->prepare($sql);
        $ticketGen = $this->createTicketNo();
        $handle->bindValue(1,$_SESSION['user_id']);
        $handle->bindValue(2,$serviceCallID);
        $handle->bindValue(3, "S-".$ticketGen);
        $handle->bindValue(4,$salestypeID);
        $handle->bindValue(5,$description);
        $handle->bindValue(6,$machineID,PDO::PARAM_INT);
        $handle->bindValue(7,$accountID,PDO::PARAM_INT);
        $handle->bindValue(8,$discount);
        $handle->execute();
         $this->showMsg('Success', 'This purchase has been made on this ticket <a href="'.$this->host.'purchase-invoice/S-'.$ticketGen.'">S-'.$ticketGen.'</a>',2);

        return $this->db->lastInsertId();
    }


        function insertLeadProducts($leadID,$productID,$qty,$amount,$leadDemandID,$machineID){
                $handle = $this->db->prepare("insert into service_product(serviceCallID,leadDemandID,productID,qty,`Amount`,machineID) values(?,?,?,?,?,?)");
                $handle->bindValue(1,$leadID,PDO::PARAM_INT);
                $handle->bindValue(2,$leadDemandID,PDO::PARAM_INT);
                $handle->bindValue(3,$productID,PDO::PARAM_INT);
                $handle->bindValue(4,$qty,PDO::PARAM_INT);
                $handle->bindValue(5,str_replace(',','',$amount),PDO::PARAM_INT);
                $handle->bindValue(6,$machineID,PDO::PARAM_INT);
                $handle->execute();
        }

    public function ValidateCompanyAgainst($companyName, $companyID)
    {
        $sql    = "select * from leads where companyName = ? and id != ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $companyName);
        $handle->bindValue(2, $companyID);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            $row = $handle->fetch(PDO::FETCH_ASSOC);
            return true;
        } else {
            return false;
        }

    }

    public function getMyUserInformation($id)
    {
        $sql    = "select st.*,
        ds.dptID,ds.dptaccessLevel,ds.designation,d.Department

        from staff st
        join dpt_designation ds on st.designationID = ds.id
        join department d on st.DepartmentID = d.id
        where st.id =  ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);

        $handle->execute();
        if ($handle->rowCount() > 0) {
            return $row = $handle->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
        
    }
    
    function getArrayStates()
    {
        $mystring = "";
        $handle   = $this->db->prepare("select * from states order by id asc");
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
        $handle   = $this->db->prepare("select * from states order by id asc");
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
        $handle   = $this->db->prepare("select * from states order by id asc");
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
        $handle   = $this->db->prepare("select * from lga where stateID = ? order by lga asc");
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
        $handle   = $this->db->prepare("select * from area_location where stateID = ? order by areaname asc");
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
        if ($num == 1) {
            
            echo '<div class="alert alert-danger alert-transparent no-margin">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon-cross2"></i>
                <strong>' . $header . '</strong> ' . $msg . '.
            </div>';
            
            
        } else if ($num == 2) {
            echo '<div class="alert alert-success alert-transparent no-margin">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-"></i></button><i class="icon-cross2"></i>
                <strong>' . $header . '</strong> ' . $msg . '.
                </div>';
        }
    }
    
    
    function getAllAcounts()
    {
        $myArray = array();
        $handle  = $this->db->prepare("select * from `accounts`  order by `Name` asc");
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
        $handle   = $this->db->prepare("select * from `accounts` order by Name asc");
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
        $handle  = $this->db->prepare("select * from industries  order by `sector` asc");
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
        $handle  = $this->db->prepare("select * from `contracts`");
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
    
    function getAllProducts()
    {
        $myArray = array();
        $handle  = $this->db->prepare("select * from products where active = 1 order by ProductType asc, productName asc, color asc");
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
       function getProductInformationWithID($id){
        $sql = "select * from products where id = ?";
         $handle = $this->db->prepare($sql);
        $handle->bindValue(1, $id);
        $handle->execute();
        if($handle->rowCount() > 0){
            return $handle->fetch(PDO::FETCH_ASSOC);
        }

    }

    function getAllProductsForDropDown()
    {
        $myArray = array();
        $handle  = $this->db->prepare("select p.*, pt.type from products p join producttype pt on pt.id = p.ProductType where p.active = 1 and p.ProductType > 1 order by p.ProductType asc, p.productName asc");
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
    function getAllProductsWithCode()
    {
        $myArray = array();
        $handle  = $this->db->prepare("select * from products where active = 1 and Code!='' order by ProductType asc, productName asc, color asc");
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
    
    function checkMachineAvailable($machineCode)
    {
        $sql    = "select * from machine_in_field where machine_code = ?";
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
        $sql    = "select * from machine_in_field where machine_code = ? and id != ?";
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

    function createAMachine($acc, $machineCode, $machineModel, $machineSerialNo, $contractType, $doi, $cstart, $cend, $address, $area, $contactN1, $contactP1, $contactE1, $contactD1, $contactN2, $contactP2, $contactE2, $contactD2, $contactN3, $contactP3, $contactE3, $contactD3, $dpt)
    {

        $sql = "insert into machine_in_field (account_id, machine_code,machine_type,serialNo,doi,contractStart,contractEnds,contractID,Address,areaID,department,contactName1,contactEmail1,contactPhone1,contactDesig1,contactName2,contactEmail2,contactPhone2,contactDesig2,contactName3,contactEmail3,contactPhone3,contactDesig3,`timestamp`,`dateTime`)
                values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
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

        $handle->execute();

     }

     function EditAMachine($acc, $machineCode, $machineModel, $machineSerialNo, $contractType, $doi, $cstart, $cend, $address, $area, $contactN1, $contactP1, $contactE1, $contactD1, $contactN2, $contactP2, $contactE2, $contactD2, $contactN3, $contactP3, $contactE3, $contactD3, $dpt,$id)
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




     function getAllAccountInformation(){
         $myArray = array();
         $sql = "select acc.*,al.areaname,al.stateID,st.state,ind.sector from `accounts` acc
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
        $handle   = $this->db->prepare("select mif.*,c.c_name from `machine_in_field` mif JOIN `contracts` c on mif.contractID = c.id where account_id = ? ");
        $handle->bindValue(1, $id);
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $mystring .= "[" . $row['id'] . ",'" . $row['machine_code']." - ".$row['c_name'] . "'],";
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
        $handle   = $this->db->prepare("select * from `accounts` order by Name asc");
        $handle->execute();
        if ($handle->rowCount() > 0) {
            while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $mystring .= "" . $this->getMachineByIDArray($row['id']) . ",";
                $myArray[] = $row;
            }
            return "[" . $mystring . "]";
        } else {
            return false;
        }
    }

    function getAllEngineers(){
        $myArray = array();
        $handle  = $this->db->prepare("select * from `staff` where `engineer` =1");
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

    function getAllIssues(){
        $myArray = array();
        $handle  = $this->db->prepare("select * from `call_issues` order by issues asc");
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

    function getAllMachineInformation(){
        $myArray = array();
        $sql = "select mif.*,a.Name, p.productName,al.areaname,al.stateID, st.state, c.c_name from `machine_in_field` mif
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

    function getAllMachineForAccount($id){
        $myArray = array();
        $sql = "select mif.*, p.productName,al.areaname,al.stateID, st.state, c.c_name from `machine_in_field` mif
        JOIN products p on mif.machine_type = p.id
        JOIN area_location al on mif.areaID = al.id
        JOIN `states` st on al.stateID = st.id
        JOIN  contracts c on mif.contractID = c.id
        WHERE mif.active = 1 and account_id = ?";
        $handle = $this->db->prepare($sql);
        $handle->bindValue(1,$id);
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

    function getSingleAccountInformation($id){
        $sql = "select ac.*, al.stateID, al.areaname, st.state, ind.sector from `accounts` ac
                JOIN `area_location` al on ac.areaID = al.id
                JOIN `states` st on al.stateID = st.id
                JOIN `industries` ind on ac.industryID = ind.id
                WHERE ac.id = ?";

        $handle = $this->db->prepare($sql);
        $handle->bindValue(1,$id);
        $handle->execute();
        if($handle->rowCount() > 0){
            return $handle->fetch(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }

    function getTeamAllOrderCollected(){
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

    function getSingleMachineInformation($id){
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

    public function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
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
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . $this->convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
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
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}
    
    
    
    
}



?>
   
 
​ 