<?php
  include("../data/DBConfig.php");
  include_once("../data/sessioncheck.php");
   $yr_ = date("Y");
    
     if($myData['storeID']== 0){
        $database->redirect_to($host);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sell Goods</title>
<!-- Bootstrap -->
    <link href="<?php echo $host;?>assets/css/morris.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="<?php echo $host;?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $host;?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="<?php echo $host;?>assets/css/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $host;?>assets/css/bootstrap-select.min.css" />
    <!-- slimscroll -->
    <link href="<?php echo $host;?>assets/css/jquery.slimscroll.css" rel="stylesheet">
    <!-- Fontes -->
    <link href="<?php echo $host;?>assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $host;?>assets/css/simple-line-icons.css" rel="stylesheet">
    <!-- all buttons css -->
    <link href="<?php echo $host;?>assets/css/buttons.css" rel="stylesheet">
    <!-- animate css -->
<link href="<?php echo $host;?>assets/css/animate.css" rel="stylesheet">
<!-- top nev css -->
<link href="<?php echo $host;?>assets/css/page-header.css" rel="stylesheet">
<!-- adminui main css -->
    <link href="<?php echo $host;?>assets/css/main.css" rel="stylesheet">
    <!-- aqua black theme css -->
    <link href="<?php echo $host;?>assets/css/aqua-black.css" rel="stylesheet">
    <!-- media css for responsive  -->
    <link href="<?php echo $host;?>assets/css/main.media.css" rel="stylesheet">

    <!-- Ion Range Slider -->
    <link rel="stylesheet" href="<?php echo $host;?>assets/css/normalize.css" />
    <link rel="stylesheet" href="<?php echo $host;?>assets/css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="<?php echo $host;?>assets/css/ion.rangeSlider.skinFlat.css" />

<!--[if lt IE 9]> <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
<!--[if lt IE 9]> <script src="dist/html5shiv.js"></script> <![endif]-->
</head>
<?php include("../includes/header_.php");?>


<div class="page-content-wrapper animated fadeInRight">
  <div class="page-content" >
    <div class="row wrapper border-bottom page-heading">
      <div class="col-lg-12">

      <?php
                            if(isset($_POST['btnSubmitNewProduct'])){
                               
                                $supplier = $database->test_input($_POST['txtSupplier']);
                                $deliveryMode = $database->test_input($_POST['delivery-option']);
                                if(isset($_POST['delivery-option']) && $deliveryMode == 'in-house=pickup'  ){
                               
                                  $deliveryStatus = "DELIVERED";

                                 }else{

                                 $deliveryStatus = $database->test_input($_POST['txtDelStatus']);

                                 }  
                                $invoiceNo = $database->test_input($_POST['txtInvoiceNo']);
                                $fileRef = $database->test_input($_POST['txtFileReference']);
                                $storeID = $database->test_input($_POST['txtStore']);
                                $DriversName1 = $database->test_input($_POST['txtRoadTenauiDriversName']);
                                $DriversNumber1 = $database->test_input($_POST['txtRoadTenauiDriversNumber']);
                                $tenauiDriversVehicleNumber = $database->test_input($_POST['txtRoadTenauiDriversVehicleNumber']);
                                $logisticCompanyName = $database->test_input($_POST['txtLogisticName']);
                                $deliveryWayBillNumber1 = $database->test_input($_POST['txtLogisticWayBillNumber']);
                                $logisticCoyPhoneNum = $database->test_input($_POST['txtLogisticPhoneNumber']);
                                $contactNameAir = $database->test_input($_POST['txtAirContactName']);
                                $wayBillNumberAir = $database->test_input($_POST['txtAirWayBillNumber']);
                                $phoneNumberAir = $database->test_input($_POST['txtAirPhoneNumber']);
                                $driverName2 = $database->test_input($_POST['txtInterBusDriverName']);
                                $driverNumber2 = $database->test_input($_POST['txtInterBusDriverPhoneNumber']);
                                $departureLocation = $database->test_input($_POST['txtParkAddress']);
                                $inHouseCustomerName = $database->test_input($_POST['txtInHouseCustomerName']);
                                $inHouseCustomerNumber = $database->test_input($_POST['txtInHouseCustomerPhoneNumber']);
                                $inHouseCustomerAddress = $database->test_input($_POST['txtInHouseCustomerAddr']);

                                $productInputTotalPrice = $database->test_input($_POST['productInputTotalPrice']);
                                
                                $_SESSION['product_total_price'] = $productInputTotalPrice;

                                
                                 

                                $senderName = $database->test_input($_POST['txtSenderName']);
                                $save = 1;
                                $invoiceDate = str_pad($_POST['txtDay'],2,"0",STR_PAD_LEFT)."/".str_pad($_POST['txtMonth'],2,"0",STR_PAD_LEFT)."/".$_POST['txtYear'];
                                   $product=$qty=$unitPrice=$amount=array();
                                        if(isset($_POST['txtProduct'])){
                                            $product = $_POST['txtProduct'];
                                            $qty = $_POST['txtProductQty'];
                                            $amount = $_POST['txtProductAmount'];
                                            $unitPrice = $_POST['txtUnitPrice'];
                                            
                                   }
                                 $_SESSION['amount'] = $amount;
                                 $_SESSION['unitPrice'] = $unitPrice;
                                  //var_dump($unitPrice);
                                  // exit;

                                  if(isset($_POST['txtProduct']) && !empty($_POST['txtProduct']) && $invoiceNo != "" && $fileRef !=""){
                                       if($database->checkInvoiceNo($invoiceNo) &&  $myData['storeID'] != 3 ){
                                        $myValue = $database->SellProductStock($supplier,$invoiceNo,$fileRef,$storeID,$product,$qty,$save,$invoiceDate,1,1,$productInputTotalPrice);
                                        unset($_POST);
                                        $database->showMsg('', "SALES HAS BEEN MADE SUCCESSFULLY", 2);

                                         $lastSellProductStockEntry = (array)$database->getLastSellProductStock();

                                      foreach($lastSellProductStockEntry as $entry){

                                                     $lastSellProductStockOrderId = $entry['id'];
                                                     $lastSellProductStockOrderTicketNo = $entry['TicketNo'];
                                                 }

                                       $msg = $database->createDeliveryTracking($lastSellProductStockOrderId,$lastSellProductStockOrderTicketNo,$deliveryStatus,$deliveryMode,$DriversName1,$DriversNumber1,$tenauiDriversVehicleNumber,$logisticCompanyName,$deliveryWayBillNumber1,$logisticCoyPhoneNum,$contactNameAir,$wayBillNumberAir,$phoneNumberAir,$driverName2,$driverNumber2,$departureLocation,$senderName,$inHouseCustomerName,$inHouseCustomerNumber,$inHouseCustomerAddress);
                                 //}

                                  }else if ($myData['storeID'] == 3 ){

                                    $invoiceNo = "SOF";
                                     $myValue = $database->SellProductStock($supplier,$invoiceNo,$fileRef,$storeID,$product,$qty,$save,$invoiceDate,1,1,$productInputTotalPrice);
                                        unset($_POST);
                                        $database->showMsg('', "SALES HAS BEEN MADE SUCCESSFULLY", 2);

                                         $lastSellProductStockEntry = (array)$database->getLastSellProductStock();

                                      foreach($lastSellProductStockEntry as $entry){

                                                     $lastSellProductStockOrderId = $entry['id'];
                                                     $lastSellProductStockOrderTicketNo = $entry['TicketNo'];
                                                 }
                                        $grt = $database->getIndGoodsRemoved($lastSellProductStockOrderId);
                                        //var_dump($grt);
                                        //exit;
                                        $totalAmount = $_SESSION['product_total_price'];
                                        $eachAmount   =  $_SESSION['amount'];
                                        $eachUnitPrice  = $_SESSION['unitPrice'];

                                        //Send email

                                        $email = "abuja_office_accounts@tenaui.com";



$subject = "SOF from ABUJA With Ticket No $lastSellProductStockOrderTicketNo";

$message = "Dear Customer Care, \n<br> Please be informed that a service call has been followed up by engineer  for custormer ticket No \n<br> Kindly find details in the followed up call. \n<br> \n<br> Please do not reply to this email, this address is not monitored. Please Contact customer care.";
    
    $html ="<p name='mydata'> good \n";
     //$html.= htmlspecialchars($data)."\n";
     $html.= "</p>";
     
    $table = "<table width='80%' align='center'  border=0>
    <tr>
        <th colspan='2'>"; 
        
        if ($grt['invoiceNo'] == "TRANSFER") {
          $table.= "<h2>TRANSFER TICKET</h2>";
       }else{ $table.= "<h2>ELECTRONIC SOF</h2>"; } 
       
      $table.="</th>
    </tr>
  <tr>
    <td>
        <b>DATE:</b>".$grt['invoiceDate']. "<br/>
        <b>CUSTOMER NAME:</b>".$grt['supplierID']. "<br/>
        <b>DELIVERY ADDRESS:</b>".$grt['FileReference']."<br/>
        <b>ORDER ID:</b>".str_pad($grt['id'],5,"0",STR_PAD_LEFT)."<br/>
        <b>TICKET NO:</b>".$grt['TicketNo']."<br/>
        <b>STORE:</b>".$grt['storeName']."<br/>
      </td>
    <td align='right'><img src='http://elastic25.com/img/tenaui-logo.jpg' width='100' height='100'></td>
  </tr>
</table>";

  $table.= "<table border=1 style='width:80%;font-size:13px' align='center' cellpadding='2' cellspacing='0'>

 <tr>
          <th colspan='8' style='background-color: #CCCCCC;text-align: center'> COMMODITY DESCRIPTION</th>
 </tr>
       <tr>
           <th>S/N</th>
              <th colspan='2'>PRODUCT </th>
               <th>Code </th>
              <th>QTY</th>
              <th>PRICE</th>
              <th>UNIT </th>
           <th colspan='2'>AMOUNT</th>

      </tr>";

      
            $myCollect = (array)$database->getAllGoodsAddedForRecieve($lastSellProductStockOrderId);
            $N = 1;
            $j =0;
            foreach($myCollect as $mc){
            /*for($i=0; $i < 7; $i++) {
                $N++;
                echo $N;
            $j++;}*/
            //for($i=0; $i < 7; $i++) {
      $table.= " <tr>
           <th>".$N."</th>
              <td colspan='2' align='center'>".$mc['productName']."</td>
              <td  align='center'>".$mc['Code']."</td>
              <td align='center'>".$mc['AddedQty']."</td>
              <td align='center'>". number_format($eachUnitPrice[$j], 2)."</td>
              <td align='center'>".$mc['unitName']."</td>
              
           <td align='center' colspan='2'><b>N<b>".number_format($eachAmount[$j], 2)."</td>

      </tr>";

           $N++;
            $j++;}
     

           
      
      $table.= "<tr>
          <th colspan='7' style='text-align: center'><b>TOTAL</b></th>
          <th>'<b>N<b>'".number_format($totalAmount, 2)."</th>
 </tr>

      <tr>
          <th colspan='8' style='text-align: center'>&nbsp;</th>
 </tr>
<tr>
          <th colspan='8' style='text-align: center'>PREPARE BY :".$grt['fullname']."</th>
 </tr>
 <tr>
          <th colspan='8' style='text-align: center'>&nbsp;</th>
 </tr>


  </table>";

    
                                    // use actual sendgrid username and password in this section
  $url = 'https://api.sendgrid.com/'; 
  $user = 'elastic25'; // place SG username here
  $pass = 'Bonke@4445'; // place SG password here

 // note the above parameters now referenced in the 'subject', 'html', and 'text' sections
    // make the to email be your own address or where ever you would like the contact form info sent

    $json_string = array(

      'to' => array('kolade.bello@tenaui.com','talal@tenaui.com','victor@tenaui.com','islamyoussry@tenaui.com','anoop@tenaui.com','kemi@tenaui.com','rukayat@tenaui.com'),
      'category' => 'test_category'
    );

    $params = array(
        'api_user'  => "$user",
        'api_key'   => "$pass",
        'x-smtpapi' => json_encode($json_string),
        'to'        => "$email",
        'replyto'        => "$email",
        'subject'   => "$subject", // Either give a subject for each submission, or set to $subject
        'html'      => "<html><head><title>Contact Form</title><body>
        $table <body></title></head></html>", // Set HTML here.  Will still need to make sure to reference post data names
        'text'      => "
       
        $table",
        'from'      => $email, // set from address here, it can really be anything
      );

        curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        $request =  $url.'api/mail.send.json';
        // Generate curl request
        $session = curl_init($request);
        // Tell curl to use HTTP POST
        curl_setopt ($session, CURLOPT_POST, true);
        // Tell curl that this is the body of the POST
        curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        // obtain response
        $response = curl_exec($session);
        curl_close($session);
        // Redirect to thank you page upon successfull completion, will want to build one if you don't alreday have one available
      //$this->createActivityNotifications($message,$mID,$aID);

        // print everything out
       // print_r($response);



                                       $msg = $database->createDeliveryTracking($lastSellProductStockOrderId,$lastSellProductStockOrderTicketNo,$deliveryStatus,$deliveryMode,$DriversName1,$DriversNumber1,$tenauiDriversVehicleNumber,$logisticCompanyName,$deliveryWayBillNumber1,$logisticCoyPhoneNum,$contactNameAir,$wayBillNumberAir,$phoneNumberAir,$driverName2,$driverNumber2,$departureLocation,$senderName,$inHouseCustomerName,$inHouseCustomerNumber,$inHouseCustomerAddress);


                                   }else{$database->showMsg('', "INVOICE NUMBER ALREADY EXIST", 1);}
                                  }else{

                                        $database->showMsg('', 'All fields are required to create a supply ticket', 1);
                                    }



                            }

                        ?>

        <h1 style="text-align: center"><span class="btn btn-warning">SELL GOODS TICKET FOR WARE HOUSE   -   <?php echo strtoupper($store[1]);?></span></h1>
         <h4 style="text-align: center">GOODS BEEN SOLD BY <?php echo strtoupper($myData['fullname']); ?></h4>

      </div>
    </div>
    <div class="wrapper-content ">
      <div class="row">

<script>
       var displaySubTotal = 0;
       var DiscountVal = 0;
       var totalProductPrice = 0;
       var count = 0;

        function addRow(){
          
          var productID =  document.getElementById('nProduct');
          var storeID =  document.getElementById('txtStoreID').value;
          var id = productID.value;
          if(id > 0 && storeID == 3){
              var nID = '<input type="hidden" name="txtProduct[]" value="'+id+'" /> ';
              var selectText =  productID.options[productID.selectedIndex].text;
              var productname =  selectText.substr(selectText.indexOf("---- ")+4,selectText.length);
              var qty_ = document.getElementById('nQty').value;
              var unitName = document.getElementById('nPrice').value;
              var unitPrice_ = document.getElementById('nProductPrice').value;
              var productcode = selectText.substr(0,selectText.indexOf("----"));
              totalProductPrice += (qty_*unitPrice_);
              var nQty = '<input type="hidden" placeholder="QTY." required  onkeyup = "javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)"  name="txtProductQty[]" class="form-control required" value="'+qty_+'" />';
              var nQtyDisabled = '<input type="text" placeholder="QTY." required  onkeyup = "javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)"  name="txtProductQty2[]" class="form-control required" value="'+qty_+'" disabled/>';
              var nUnitPrice = '<input type="hidden" placeholder="UNITPRICE." required  onkeyup = "javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)"  name="txtUnitPrice[]" class="form-control required" value="'+unitPrice_ +'" />';
              var nUnitPriceDisabled = '<input type="text" placeholder="QTY." required  onkeyup = "javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)"  name="txtUnitPrice2[]" class="form-control required" value="'+unitPrice_ +'" disabled/>';
               var nProductAmount = '<input type="hidden" placeholder="PRICE." required  onkeyup = "javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)"  name="txtProductAmount[]" class="form-control required" value="'+qty_*unitPrice_+'" />';
              var nProductAmountDisabled = '<input type="text" placeholder="PRICE." required  onkeyup = "javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)"  name="txtProductAmount2[]" class="form-control required" value="'+qty_*unitPrice_+'" disabled />';
              var nPrice = '<input type="text" placeholder="UNITS" name="txtProductPcs[]" class="form-control required" value="'+unitName+'" />';
              var cal =   unitName;
              var Action = "<input type='button' class='btn btn-outline btn-round dark btn-sm black' onclick='removeRow("+20+");' value='Remove Row'/>";
              var table = document.getElementById('table');
              //var table = document.getElementById('tableDeliveryData');
              var newRow = table.insertRow(1);
              var cel1 = newRow.insertCell(0);
              var cel2 = newRow.insertCell(1);
              var cel3 = newRow.insertCell(2);
              var cel4 = newRow.insertCell(3);
              var cel5 = newRow.insertCell(4);
              var cel6 = newRow.insertCell(5);
              var cel7 = newRow.insertCell(6);

              
              cel1.innerHTML = productcode+nID;
              cel2.innerHTML = productname;

              cel3.innerHTML = nQtyDisabled+nQty;
              cel4.innerHTML = cal;
              cel5.innerHTML = nUnitPriceDisabled + nUnitPrice;
              cel6.innerHTML = nProductAmountDisabled + nProductAmount;
              cel7.innerHTML = Action;
               
              
              

              if(count < 1){
              var totalLabel = '<input type="text" placeholder="ALL GOODS TOTAL PRICE" required  onkeyup = "javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)"  class="form-control required" value="ALL GOODS TOTAL PRICE" disabled/>';
              var nProductTotalPrice = '<input type="text" placeholder="ALL GOODS TOTAL PRICE" required  onkeyup = "javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)"  name="txtTotalPrice" id="txtTotalPrice" class="form-control required" value="'+totalProductPrice+'" disabled />';  

              var newRow2 = table.insertRow(2);
              var cel6 = newRow2.insertCell(0);
              var cel7 = newRow2.insertCell(1);
              var cel8 = newRow2.insertCell(2);
              var cel9 = newRow2.insertCell(3);
              var cel10 = newRow2.insertCell(4);
              var cel11 = newRow2.insertCell(5);

              cel10.innerHTML = totalLabel;
              cel11.innerHTML = nProductTotalPrice;
              document.getElementById('productInputTotalPrice').value = totalProductPrice;
              }else{
                //console.log(totalProductPrice);
                // table.deleteRow(index);
                //cel10.innerHTML = totalProductPrice;
                document.getElementById('txtTotalPrice').value = totalProductPrice;
                document.getElementById('productInputTotalPrice').value = totalProductPrice;
              }

              count++;

              document.getElementById('nPrice').value = "";
              document.getElementById('nQty').value = "";
              document.getElementById('nProductPrice').value = "";
              document.getElementById('nProduct').value = 0;


          } else if (id > 0 && storeID != 3){
            var nID = '<input type="hidden" name="txtProduct[]" value="'+id+'" /> ';
              var selectText =  productID.options[productID.selectedIndex].text;
              var productname =  selectText.substr(selectText.indexOf("---- ")+4,selectText.length);
              var qty_ = document.getElementById('nQty').value;
              var unitName = document.getElementById('nPrice').value;
              var productcode = selectText.substr(0,selectText.indexOf("----"));
              var nQty = '<input type="text" placeholder="QTY." required  onkeyup = "javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)"  name="txtProductQty[]" class="form-control required" value="'+qty_+'" />';
              var nPrice = '<input type="text" placeholder="UNITS" name="txtProductPcs[]" class="form-control required" value="'+unitName+'" />';
              var cal =   unitName;
              var Action = "<input type='button' class='btn btn-outline btn-round dark btn-sm black' onclick='removeRow("+20+");' value='Remove Row'/>";
              var table = document.getElementById('table');
              //var table = document.getElementById('tableDeliveryData');
              var newRow = table.insertRow(1);
              var cel1 = newRow.insertCell(0);
              var cel2 = newRow.insertCell(1);
              var cel3 = newRow.insertCell(2);
              var cel4 = newRow.insertCell(3);
              var cel5 = newRow.insertCell(4);

              
              cel1.innerHTML = productcode+nID;
              cel2.innerHTML = productname;

              cel3.innerHTML = nQty;
              cel4.innerHTML = cal;
              cel5.innerHTML = Action;


              document.getElementById('nPrice').value = "";
              document.getElementById('nQty').value = "";
              document.getElementById('nProduct').value = 0;

          }

          else{
              alert("PLEASE SELECT A PRODUCT");
          }

        }

        function removeRow(id) {
            var index, table = document.getElementById('table');
            for(var i = 1; i < table.rows.length; i++)
            {
               table.rows[i].cells[5].onclick = function()
               {
                   var c = confirm("do you want to delete this row ?");
                   if(c=== true){

                       //alert("we are removing "+id);
                       displaySubTotal = displaySubTotal - id;
                           index = this.parentElement.rowIndex;
                           table.deleteRow(index);
                           document.getElementById('subtotalAmount').value = addComma(displaySubTotal);
                           displayDiscount();
                     }
               };
            }
        }

        function updateDiscount(val){
             DiscountVal = val;
             displayDiscount();
        }

        function amountedTotal(disval){
            var amounted__ = displaySubTotal - disval;
            document.getElementById("amountedTotal").value = addComma(amounted__);
        }

        function displayDiscount(){
          var disVal = (DiscountVal/100)*displaySubTotal;
          document.getElementById('discountView').value = addComma(disVal);
          amountedTotal(disVal);
        }

        function selectionChange(info){
            var np =  document.getElementById('nPrice');
            if(info > 0){np.readOnly = true;}else{np.readOnly = false;}
            info = info.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                  np.value = info;
           // alert(info);
        }

        function addComma(x){
           // var part = x.toString().split(".");
           // part[0] = part[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
           // return part.join(".");
           return x.toLocaleString();
        }

        var currentValue = 0;
        function handleClick(myRadio) {
        //alert('Old value: ' + currentValue);
       //alert('New value: ' + myRadio.value);
        var x = document.getElementById("tableDeliveryDataTenauiDriver");
        var y = document.getElementById("tableDeliveryThirdPartyLogistic");
        var z = document.getElementById("tableDeliveryAir");
        var xy = document.getElementById("tableInterStateBus");
        var zx = document.getElementById("tableInHousePickUp");
        currentValue = myRadio.value;
        if (x.style.display === "none" && currentValue == "by-road-tenaui-driver") {
                  x.style.display = "block";
                      } else {
                  x.style.display = "none";
                }
        

        if (x.style.display === "block" && currentValue == "by-road-tenaui-driver") {
                  x.style.display = "block";
                      } else {
                  x.style.display = "none";
                }


         if (y.style.display === "none" && currentValue == "third-party-logistic-company") {
                  y.style.display = "block";
                      } else {
                  y.style.display = "none";
                }

         if (z.style.display === "none" && currentValue == "airways") {
                  z.style.display = "block";
                      } else {
                  z.style.display = "none";
                }

         if (xy.style.display === "none" && currentValue == "inter-state-bus") {
                  xy.style.display = "block";
                      } else {
                  xy.style.display = "none";
                }

          if (zx.style.display === "none" && currentValue == "in-house=pickup") {
                  zx.style.display = "block";
                      } else {
                zx.style.display = "none";
                }
       


        }

</script>

        <div class="col-lg-12 top20 bottom20">
          <div class="widgets-container">

                    <div class="form-group">
                         <label class="col-lg-2 control-label">CONSUMABLE & SPARE PARTS</label>
                <div class="col-lg-4">
                  <?php  //var_dump($myData['storeID']); ?>
                  <select class="_select form-control" name="nProduct" id="nProduct" onchange="selectionChange(this.options.item(this.selectedIndex).getAttribute('info'))">
                       <optgroup>
                           <option value="0">----SELECT AN ITEM YOU WANT TO SELL----</option>
                       </optgroup>
                          <?php

                            $products = (array)$database->getAllProductsForDropDownWareHouse();
                            $vamp = 0;
                            foreach ($products as $dpt) {
                                $value = "";
                                $ptype = $dpt['ProductType'];
                                if($vamp != $ptype){
                          ?>
                       </optgroup>
                       <optgroup label="<?php echo $dpt['type'];?>">
                           <?php

                                $vamp = $ptype; }
                               
                                $qty = $database->getProductStoreQty($dpt['id'],$myData['storeID']);

                           ?>
                        <option info="<?php echo $qty." ".$dpt['unitName'];?>" value="<?php echo $dpt['id'];?>"><?php echo $dpt['Code'].' ---- '.$dpt['productName'];?></option>
                      <?php  }?>
                       </optgroup>
            </select>

                </div>
                <div class="col-md-2">
                                <input type="text" name="nPrice" disabled="disabled" value="" placeHolder="CURRENT QUANTITY" id="nPrice" class="form-control" value="1">

                                <input  class="form-control m-b" name="txtStoreID" id="txtStoreID" value="<?php echo $myData['storeID'];?>" type="hidden">
                 </div>

                 <div class="col-md-1">

                        <input type="text" name="nQty"
                        value="" class="form-control" id="nQty" placeHolder="QTY" required onKeyPress="return isNumberKey(event)" value="1">

                </div>
                 <?php if($myData['storeID'] == 3 ){  ?>  
                <div class="col-md-1">

                        <input type="text" name="nProductPrice"
                        value="" class="form-control" id="nProductPrice" placeHolder="Unit Price" required onKeyPress="return isNumberKey(event)" value="1">

                </div>
              <?php }  ?>
                <div class="col-md-2">
                             <button class="btn  blue btn-block btn-outline " onclick="addRow();">Add Item</button>
                </div>



        </div>
     <hr>        <form action="" method="post">
                 <div class="borderedTable">
                  <div class="table-scrollable">

                      <div class="row">
               <div class="col-md-3"></div>
               <div class="col-md-6">
                    <div class="form-group">
                                            <label class="col-sm-3 control-label">CUSTOMER NAME:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control m-b" name="txtSupplier" value="<?php if(isset($_POST['txtSupplier'])){echo $_POST['txtSupplier'];}?>" required data-validation-required-message="Customer Name is required">
                                            </div>
                                        </div>
                      <?php if($myData['storeID'] != 3 ){  ?>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">INVOICE NO</label>
                        <div class="col-sm-9">
                         <input type="text" class="form-control m-b" name="txtInvoiceNo" value="<?php if(isset($_POST['txtInvoiceNo'])){echo $_POST['txtInvoiceNo'];}?>" required data-validation-required-message="Invoice No is required">
                        </div>
                    </div>

                      <?php   }else { ?>

                        <input type="hidden" class="form-control m-b" name="txtInvoiceNo" value="SOF" required data-validation-required-message="Invoice No is required">
                       
                      <?php }  ?>

                    <div class="form-group">
                      <?php if($myData['storeID'] != 3 ){ ?>
                        <label class="col-sm-3 control-label">INVOICE DATE</label>
                         <?php } else {  ?>

                           <label class="col-sm-3 control-label">SOF DATE</label>

                          <?php   }    ?>
                        <div class="col-sm-9">
                            
                                <div class="col-md-4">
                                                    <select name="txtDay" class="form-control">
                                                        <?php for($i=1;$i < 32;$i++){ ?>
                                                        <option <?php if($i == date('d')){echo "selected";}?>>
                                                            <?php echo $i;?>
                                                        </option>
                                                        <?php }?>
                                                    </select>
                                </div>
                             


                           
                                <div class="col-md-4">
                                    <select class="form-control" name="txtMonth">
                                        <?php for($i=1;$i < 13;$i++){ ?>
                                        <option value="<?php echo $i;?>" <?php if($i == date('m')){echo "selected";}?>>
                                            <?php echo date('F', mktime(0, 0, 0, $i, 10))?>
                                        </option>
                                        <?php }?>
                                    </select>
                                </div>
                                 <div class="col-md-4">
                                            <select name="txtYear" class="form-control">
                                                <option>
                                                    <?php echo date('Y');?>
                                                </option>
                                            </select>
                                 </div>

                    </div>
                  </div>

               <div class="form-group">
                            <label class="col-sm-3 control-label">STORE</label>
                            <div class="col-sm-9">
                               <select class="_select form-control m-b" name="txtStore" required data-validation-required-message="Supplier is required" onChange="contractCheck();">
                                  <?php
                                       // $mySuppliers = (array)$database->getAllStores();

                                     //   foreach($mySuppliers as $ms){ ?>
                                     <?php //if(isset($_POST['txtStore']) && $_POST['txtStore'] == $ms['id']){echo "seleccted";} ?>
                                           <option value="<?php echo $store[0];?>"><?php echo $store[1]." - ".strtoupper($store['2']);?></option>
                                       <?php //} ?>

                               </select>
                               </div>
                </div>
                <div class="form-group">
                            <label class="col-sm-3 control-label">DELIVERY ADDRESS:</label>
                            <div class="col-sm-9">
                             <textarea name="txtFileReference" class="form-control m-b"  required data-validation-required-message="File Reference is required"><?php if(isset($_POST['txtFileReference'])){echo $_POST['txtFileReference'];}?></textarea>
                            </div>
                        </div>
                  <div class="form-group">
                            <label class="col-sm-3 control-label">DELIVERY OPTION:</label>
                            <div class="col-sm-12">
                              IN-HOUSE PICK UP:
                        <input type="radio" name="delivery-option" value="in-house-customer-pickup" <?php if(isset($grt['deliveryMode']) && $grt['deliveryMode'] == "in-house-customer-pickup" ){ echo "checked";}?>  required onclick="handleClick(this);";/>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              BY ROAD (INTERNAL):
                             <input type="radio" name="delivery-option" value="by-road-tenaui-driver"  <?php if(isset($grt['deliveryMode']) && $grt['deliveryMode'] == "by-road-tenaui-driver" ){ echo "checked";}?> required onclick="handleClick(this);";/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <!--THIRD PARTY LOGISTIC COMPANY:--> BY ROAD (THIRD PARTY)
                             <input type="radio" name="delivery-option" value="third-party-logistic-company" <?php if(isset($grt['deliveryMode']) && $grt['deliveryMode'] == "third-party-logistic-company" ){ echo "checked";}?>  required onclick="handleClick(this);";/> 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                             AIR: 
                              <input type="radio" name="delivery-option" value="airways"  
                        <?php if(isset($grt['deliveryMode']) && $grt['deliveryMode'] == "airways" ){ echo "checked";}?> required onclick="handleClick(this);";/>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        INTER STATE:
                        <input type="radio" name="delivery-option" value="inter-state-bus" <?php if(isset($grt['deliveryMode']) && $grt['deliveryMode'] == "inter-state-bus" ){ echo "checked";}?>  required onclick="handleClick(this);";/> 

                       
                        
                            </div>

                        </div>
                        <p> &nbsp;</p> 
                        <p> &nbsp;</p>
                         <div class="form-group">
                        
                               <table  id="tableDeliveryDataTenauiDriver" class="table table-striped table-bordered table-advance table-hover"
                               style="width: 1200px; display: none;">

                      <thead>

                        <tr>
                          <th> <i class="fa fa-briefcase"></i> DRIVER NAME </th>
                          <th class="hidden-xs"> <i class="fa fa-user"></i> DRIVER NUMBER </th>
                         <!-- <th> <i class="fa fa-shopping-cart"></i> Price </th>-->
                          <th> <i class="fa fa-hand-peace-o"></i> VEHICLE NUMBER </th>
                          <th> <i class="fa fa-shopping-cart"></i> SENDER NAME </th>

                          <th> </th>
                        </tr>
                      </thead>
                      <tbody>
                         <tr>
                             <td><input type="text" value=" " name="txtRoadTenauiDriversName"  class="form-control" required>
                                                  
                                                   </td>
                             <td><input type="text"  name="txtRoadTenauiDriversNumber" 
                                                value=" " class="form-control" required>
                                                  
                                                    </td>
                             <td><input type="text" name="txtRoadTenauiDriversVehicleNumber" 
                                                value=" " class="form-control" required>
                                                  
                                                   </td>
                             <td><input type="text" name="txtSenderName" 
                                                value=" " class="form-control" required>
                                                  
                                                </td>

                         </tr>




                      </tbody>
                      </table>

                       <table  id="tableDeliveryThirdPartyLogistic" class="table table-striped table-bordered table-advance table-hover"
                               style="width: 1200px; display: none;">

                      <thead>

                        <tr>
                          <th> <i class="fa fa-briefcase"></i>DRIVER NAME: </th>
                          <th class="hidden-xs"> <i class="fa fa-user"></i> Delivery Way Bill Number: </th>
                         <!-- <th> <i class="fa fa-shopping-cart"></i> Price </th>-->
                          <th> <i class="fa fa-hand-peace-o"></i> DRIVER's NUMBER: </th>
                          <th> <i class="fa fa-shopping-cart"></i> SENDER NAME </th>

                          <th> </th>
                        </tr>
                      </thead>
                      <tbody>
                         <tr>
                             <td><input type="text" name="txtLogisticName" 
                                                value=" " class="form-control" required>
                                                  
                                                    </td>
                             <td><input type="text"  name="txtLogisticWayBillNumber" 
                                                value=" " class="form-control" required>
                                                  
                                                   </td>
                             <td><input type="text" name="txtLogisticPhoneNumber" 
                                                value=" " class="form-control" required>
                                                  
                                                   </td>
                             <td><input type="text" name="txtSenderName" 
                                                value=" " class="form-control" required>
                                                  
                                                    </td>

                         </tr>




                      </tbody>
                      </table>


                      <table  id="tableDeliveryAir" class="table table-striped table-bordered table-advance table-hover"
                               style="width: 1200px; display: none;">

                      <thead>

                        <tr>
                          <th> <i class="fa fa-briefcase"></i>Contact Name: </th>
                          <th class="hidden-xs"> <i class="fa fa-user"></i> Way Bill Number: </th>
                         <!-- <th> <i class="fa fa-shopping-cart"></i> Price </th>-->
                          <th> <i class="fa fa-hand-peace-o"></i> Phone Number: </th>
                          <th> <i class="fa fa-shopping-cart"></i> SENDER NAME </th>

                          <th> </th>
                        </tr>
                      </thead>
                      <tbody>
                         <tr>
                             <td><input type="text" name="txtAirContactName" 
                                                value=" " class="form-control" required>
                                                  
                                                    </td>
                             <td><input type="text"  name="txtAirWayBillNumber" 
                                                value=" " class="form-control" required>
                                                  
                                                   </td>
                             <td><input type="text" name="txtAirPhoneNumber" 
                                                value=" " class="form-control" required>
                                                  
                                                   </td>
                             <td><input type="text" name="txtSenderName" 
                                                value=" " class="form-control" required>
                                                  
                                                    </td>

                         </tr>




                      </tbody>
                      </table>


                      <table  id="tableInterStateBus" class="table table-striped table-bordered table-advance table-hover"
                               style="width: 1200px; display: none;">

                      <thead>

                        <tr>
                          <th> <i class="fa fa-briefcase"></i>Driver's Name:</th>
                          <th class="hidden-xs"> <i class="fa fa-user"></i> Driver Phone Number: </th>
                         <!-- <th> <i class="fa fa-shopping-cart"></i> Price </th>-->
                          <th> <i class="fa fa-hand-peace-o"></i> Motor Park Location/Address: </th>
                          <th> <i class="fa fa-shopping-cart"></i> SENDER NAME </th>

                          <th> </th>
                        </tr>
                      </thead>
                      <tbody>
                         <tr>
                             <td><input type="text" name="txtInterBusDriverName" 
                                                value=" " class="form-control" required>
                                                  
                                                    </td>
                             <td><input type="text"  name="txtInterBusDriverPhoneNumber" 
                                                value=" " class="form-control" required>
                                                  
                                                   </td>
                             <td><input type="text" name="txtParkAddress" 
                                                value=" " class="form-control" required>
                                                  
                                                   </td>
                             <td><input type="text" name="txtSenderName" 
                                                value=" " class="form-control" required>
                                                  
                                                    </td>

                         </tr>




                      </tbody>
                      </table>


                          
                          <table  id="tableInHousePickUp" class="table table-striped table-bordered table-advance table-hover"
                               style="width: 1200px; display: none;">

                      <thead>

                        <tr>
                          <th> <i class="fa fa-briefcase"></i>Customer Name:</th>
                          <th class="hidden-xs"> <i class="fa fa-user"></i> Customer Phone Number: </th>
                         <!-- <th> <i class="fa fa-shopping-cart"></i> Price </th>-->
                          <th> <i class="fa fa-hand-peace-o"></i> Customer Address: </th>
                          <th> <i class="fa fa-shopping-cart"></i> SENDER NAME </th>

                          <th> </th>
                        </tr>
                      </thead>
                      <tbody>
                         <tr>
                             <td><input type="text" name="txtInHouseCustomerName" 
                                                value=" " class="form-control" required>
                                                  
                                                    </td>
                             <td><input type="text"  name="txtInHouseCustomerPhoneNumber" 
                                                value=" " class="form-control" required>
                                                  
                                                   </td>
                             <td><input type="text" name="txtInHouseCustomerAddr" 
                                                value=" " class="form-control" required>
                                                  
                                                   </td>
                             <td><input type="text" name="txtSenderName" 
                                                value=" " class="form-control" required>
                                                  
                                                    </td>

                         </tr>




                      </tbody>
                      </table>


                         




                         </div>
                        <p> &nbsp;  </p>

                         <label class="col-sm-3 control-label">UPDATE DELIVERY STATUS:</label>
                                            <div class="col-sm-5">
                                                <select class="form-control m-b" name="txtDelStatus" required data-validation-required-message="select payment status">
                                                                  <?php
                                                                        $cases = (array)$database->getDeliveryStatus();
                                                                        foreach($cases as $case){
                                                                     ?>

                                                         <option <?php if(isset($grt['deliveryStatus']) && ($case['dstatus']== $grt['deliveryStatus'])){echo "selected";}?>   > <?php echo $case['dstatus'];?></option>
                                                         <?php }?>
                                                        </select>
                                            </div>
                                             <p> &nbsp;  </p>
                                              <p> &nbsp;  </p>
                                               <p> &nbsp;  </p>
                                                <p> &nbsp;  </p>
                    </div>
                </div>
               </div>

           </div>
           <p>&nbsp; </p>
                    <table id="table" class="table table-striped table-bordered table-advance table-hover">

                      <thead>

                        <tr>
                          <th> <i class="fa fa-briefcase"></i> CODE </th>
                          <th class="hidden-xs"> <i class="fa fa-user"></i> PRODUCT NAME </th>
                         <!-- <th> <i class="fa fa-shopping-cart"></i> Price </th>-->
                          <th> <i class="fa fa-hand-peace-o"></i> QTY </th>
                          <th> <i class="fa fa-shopping-cart"></i> UNIT </th>
                           <?php if($myData['storeID'] == 3 ){  ?>
                          <th> <i class="fa fa-shopping-cart"></i> UNIT PRICE </th>
                          <th> <i class="fa fa-shopping-cart"></i> TOTAL PRICE</th>

                        <?php } ?>

                           <input type="hidden" name="productInputTotalPrice" id="productInputTotalPrice" value=" " />
                          <th> </th>
                        </tr>
                      </thead>
                      <tbody>



                      </tbody>
                      </table>
                           <br/>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-5">
                                 <!--<button type="submit" class="btn btn-warning col-lg-12" name="btnSaveNCont"><i class="fa fa-plus-o"></i>Save and Continue Later</button>-->
                            </div>
                            <div class="col-md-2">&nbsp;</div>
                             <div class="col-md-5">
                                 <button type="submit" class="btn btn-success col-lg-12" name="btnSubmitNewProduct"><i class="fa fa-plus-o"></i>SELL!</button>
                            </div>
                        </div>

                      </div>
                      </form>
                 </div>

          </div>
        </div>
        <!--All form elements  End -->
      </div>
    </div>


  </div>
</div>
<!-- Go top -->
<a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>
<!-- Go top -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo $host;?>assets/js/vendor/jquery.min.js"></script>
    <!-- bootstrap js -->
    <script src="<?php echo $host;?>assets/js/vendor/bootstrap.min.js"></script>
    <!-- slimscroll js -->
    <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jquery.slimscroll.js"></script>
    <script src="<?php echo $host;?>assets/js/vendor/select2.min.js"></script>
    <script src="<?php echo $host;?>assets/js/vendor/bootstrap-select.min.js"></script>
    <!-- pace js -->
<script src="<?php echo $host;?>assets/js/vendor/pace/pace.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $host;?>assets/js/vendor/jquery.sparkline.min.js"></script>
<!-- main js -->
<script src="<?php echo $host;?>assets/js/vendor/ion.rangeSlider.js"></script>

    <script src="<?php echo $host;?>assets/js/main.js"></script>
    <script type="text/javascript">

        $(function() {

         $("#range").ionRangeSlider({
            min: 0,
            max: 100
        });

            $('._select').select2();
            var data = [{
                id: 0,
                text: 'enhancement'
            }, {
                id: 1,
                text: 'bug'
            }, {
                id: 2,
                text: 'duplicate'
            }, {
                id: 3,
                text: 'invalid'
            }, {
                id: 4,
                text: 'wontfix'
            }];

            $(".js-example-data-array").select2({
                data: data
            })

            $(".js-example-data-array-selected").select2({
                data: data
            })

            $('.selectpicker').selectpicker({
                style: 'defaultSelectDrop',
                size: 4
            });

            $('.selectpickerprimary').selectpicker({
                style: 'btn-primary',
                size: 4
            });
            $('.selectpickerinfo').selectpicker({
                style: 'btn-info',
                size: 4
            });
            $('.selectpickersuccess').selectpicker({
                style: 'btn-success',
                size: 4
            });
            $('.selectpickerwarning').selectpicker({
                style: 'btn-warning',
                size: 4
            });
            $('.selectpickerdanger').selectpicker({
                style: 'btn-danger',
                size: 4
            });

        });
    </script>

</body>
</html>
