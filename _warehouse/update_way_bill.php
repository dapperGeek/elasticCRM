<?php
  include("../data/DBConfig.php");
  include_once("../data/sessioncheck.php");
   $yr_ = date("Y");
    
     if($myData['storeID']== 0){
        $database->redirect_to($host);
    }

    $id = $database->test_input($_GET['id']);

 // $grt = $database->getIndGoodsRemoved($id);
    
    $grt = $database->getIndGoodsRemovedDeliveryUpdate($id);
     //echo $grt['TicketNo'];
     // if(empty($grt)){
         if($grt['TicketNo'] == null ){
       // $database->redirect_to($host."view-goods-recieve-ticket");
        $grt = $database->getIndGoodsRemoved($id);
      }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Recieve Goods Ticket</title>
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


 <!-- End page sidebar wrapper -->
    <!-- Start page content wrapper -->
     <div class="page-content-wrapper">
    <div class="page-content">
      <div class="row wrapper border-bottom page-heading">
        <div class="col-lg-12">
          <h2>Update Way Bill</h2>
          <ol class="breadcrumb">
            <li> <a href="">Home</a> </li>
            <li> <a>Delivery Tracker</a> </li>
            <li class="active"> <strong>Update Way Bill</strong> </li>
          </ol>
        </div>
        <div class="col-lg-12"> </div>
      </div>
      <div class="wrapper-content ">

      <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">

                <h5>
                    Way Bill Status
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     <?php if($myData['DepartmentID'] == 5){?>

                        <?php }else{?>
                   <!--<a href="<?php echo $host;?>sell-goods" class="btn btn-success">SELL GOODS</a>-->

                    <?php } ?>
                    
                </h5>
              </div>

              <div class="ibox-content collapse in">
                <div class="widgets-container"> 
                <!-- <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-1" data-toggle="tab" > OPENED CALLS &nbsp;&nbsp; <span class="label label-warning">NEW</span></a></li>
                <li ><a href="#tab-2" data-toggle="tab" >CLOSED CALLS &nbsp;&nbsp; <span class="label label-success">OLD</span> </a></li>
              </ul>-->
              <div class="tab-content">

      <?php
                            if(isset($_POST['btnUpdateWayBill'])){
                               
                               // echo $id;
                                //echo $grt['TicketNo'];
                                $deliveryStatus = $database->test_input($_POST['txtDelStatus']);
                                //echo $deliveryStatus;
                                $deliveryMode = $database->test_input($_POST['delivery-option']);
                                //echo $deliveryMode;
                                $ticketNumber= $database->test_input($_POST['txtTicketNumber']);
                               // echo $ticketNumber;
                                $DriversName1 = $database->test_input($_POST['txtRoadTenauiDriversName']);
                                $DriversNumber1 = $database->test_input($_POST['txtRoadTenauiDriversNumber']);
                                //echo  $DriversNumber1;
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
                                $inHouseCustomerNumber = $database->test_input($_POST['txtInHouseCustomerNumber']);
                                $inHouseCustomerAddress = $database->test_input($_POST['txtInHouseCustomerAddress']);


                                $senderName = $database->test_input($_POST['txtSenderName']);

                                echo $senderName;

                               $grt = $database->getIndGoodsRemovedDeliveryUpdate($id);

                               if($grt['TicketNo'] == null ){

                               $msg = $database->createDeliveryTracking($id,$ticketNumber,$deliveryStatus,$deliveryMode,$DriversName1,$DriversNumber1,$tenauiDriversVehicleNumber,$logisticCompanyName,$deliveryWayBillNumber1,$logisticCoyPhoneNum,$contactNameAir,$wayBillNumberAir,$phoneNumberAir,$driverName2,$driverNumber2,$departureLocation,$senderName,$inHouseCustomerName,$inHouseCustomerNumber,$inHouseCustomerAddress);
                                 }else {

                                   $msg = $database->updateDeliveryTracking($id,$ticketNumber,$deliveryStatus,$deliveryMode,$DriversName1,$DriversNumber1,$tenauiDriversVehicleNumber,$logisticCompanyName,$deliveryWayBillNumber1,$logisticCoyPhoneNum,$contactNameAir,$wayBillNumberAir,$phoneNumberAir,$driverName2,$driverNumber2,$departureLocation,$senderName,$inHouseCustomerName,$inHouseCustomerNumber,$inHouseCustomerAddress);
                                 }

                                  $grt = $database->getIndGoodsRemovedDeliveryUpdate($id);

                                }

                        ?>

       

      </div>
    </div>
    
<script>
       var displaySubTotal = 0;
       var DiscountVal = 0;

        function addRow(){
          var productID =  document.getElementById('nProduct');
          var id = productID.value;
          if(id > 0){
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
          }else{
              alert("PLEASE SELECT A PRODUCT");
          }

        }

        function removeRow(id) {
            var index, table = document.getElementById('table');
            for(var i = 1; i < table.rows.length; i++)
            {
               table.rows[i].cells[4].onclick = function()
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

</script>
<table width="80%" align="center"  border=0>
    <tr>
        <th colspan="2"><?php if ($grt['invoiceNo'] == "TRANSFER") {
          echo "<h2>TRANSFER TICKET</h2>";
        }else{ echo "<h2>ELECTRONIC WAYBILL</h2>";} ?></th>
    </tr>
  <tr>
    <td>
        <b>INVOICE NO:</b> <?php echo $grt['invoiceNo'];?><br/>
        <b>INVOICE DATE:</b> <?php echo $grt['invoiceDate'];?> <br/>
        <b>CUSTOMER NAME:</b> <?php echo $grt['supplierID'];?><br/>
        <b>DELIVERY ADDRESS:</b> <?php echo $grt['FileReference'];?><br/>
       <b>ORDER ID:</b> <?php echo str_pad($grt['id'],5,"0",STR_PAD_LEFT);?><br/>
        <b>TICKET NO:</b> <?php echo $grt['TicketNo'];?><br/>
        <b>STORE:</b> <?php echo $grt['storeName'];?><br/>

    </td>
    <td align="right"><img src="../img/tenaui-logo.jpg" width="100" height="100"></td>
  </tr>
  <tr>
    <form method="post" class="form-horizontal">
    <td style="font-size:20px">
          
          DELIVERY STATUS:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <?php if(isset($grt['deliveryStatus'])){ ?> <span class="label label-warning"> <?php echo $grt['deliveryStatus']; ?>  </span> <?php }?>
    </td>
    <td >
          
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
    </td>
  </tr>
</table>
     <br/><br/>
  <table border=1 style="width:80%;font-size:13px" align="center" cellpadding="2" cellspacing="0">

 <tr>
          <th colspan="7" style=" background-color: #CCCCCC;text-align: center"> COMMODITY DESCRIPTION</th>
 </tr>
       <tr>
           <th>S/N</th>
              <th colspan="2">PRODUCT </th>
               <th>Code </th>
              <th>QTY</th>
              <th>UNIT </th>
           <th colspan="2">REMARKS</th>

      </tr>

      <?php
            $myCollect = (array)$database->getAllGoodsAddedForRecieve($id);
            $N = 1;
            foreach($myCollect as $mc){
      ?>
      <tr>
           <th><?php echo $N;?></th>
              <td colspan="2" align="center"><?php echo $mc['productName'];?> </td>
              <td  align="center"><?php echo $mc['Code'];?> </td>
              <td align="center"><?php echo $mc['AddedQty'];?></td>
              <td align="center"><?php echo $mc['unitName'];?> </td>
           <td colspan="2"></td>

      </tr>

      <?php $N++;}?>
      <tr>
          <th colspan="7" style="text-align: center">&nbsp;</th>
 </tr>
<tr>
          <th colspan="7" style="text-align: center">PREPARE BY : <?php echo $grt['fullname'];?></th>
 </tr>
 <tr>
          <th colspan="7" style="text-align: center">&nbsp;</th>
 </tr>


  </table>


<form method="post" class="form-horizontal">

 <table border=1 style="width:80%;font-size:13px" align="center" cellpadding="2" cellspacing="0">
   <tr>
       <th style="background-color: #CCCCCC;text-align: center" colspan="3">DELIVERY DETAILS</th>
       
   </tr>
   <tr>
       <th colspan="2">
           <table border=1 style="width:100%;"  cellpadding="2" cellspacing="0">
           
             <tr>
                   <td colspan="3"><b>DELIVERY MODE</b></td>
               </tr>
               <tr>
                   <td colspan="3"  style="border-top !important; background-color: #CCCCCC;" >&nbsp;&nbsp;</td>
               </tr>
                
                 <tr>
                   <td colspan="3">
                       
                        IN-HOUSE CUSTOMER PICK UP
                        :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="delivery-option" value="in-house-customer-pickup"  <?php if(isset($grt['deliveryMode']) && $grt['deliveryMode'] == "in-house-customer-pickup" ){ echo "checked";}?> required /> 
                   </td>

               </tr>
            <tr>
                   <td><b>Customer's Name: </b></td>
                   <td><b>Customer's Number: </b></td>
                   <td><b>Customers's Address: </b></td>
               </tr>

               <tr style="height: 30px">
                   <td colspan="" rowspan="">
                    <textarea rows="2" name="txtInHouseCustomerName" 
                                                value="<?php if(isset($_POST['txtInHouseCustomerName'])){ echo $_POST['txtInHouseCustomerName'];}?>" class="form-control" required>
                                                  <?php if(isset($grt['InHouseCustomerName'])){ echo $grt['InHouseCustomerName'];}?>
                                                </textarea>
                   </td>
                   <td colspan="" rowspan="">
                        <textarea rows="2" name="txtInHouseCustomerNumber" 
                                                value="<?php if(isset($_POST['txtInHouseCustomerNumber'])){ echo $_POST['txtInHouseCustomerNumber'];}?>" class="form-control" required>
                                                   <?php if(isset($grt['InHouseCustomerNumber'])){ echo $grt['InHouseCustomerNumber'];}?>
                                                </textarea>
                                                
                   </td>
                   <td colspan="" rowspan="">
                           <textarea rows="2" name="txtInHouseCustomerAddress" 
                                                value="<?php if(isset($_POST['txtInHouseCustomerAddress'])){ echo $_POST['txtInHouseCustomerAddress'];}?>" class="form-control" required>
                                                  <?php if(isset($grt['InHouseCustomerAddress'])){ echo $grt['InHouseCustomerAddress'];}?>
                                                </textarea>
                   </td>
               </tr>
               <tr >
                   <td colspan="3" style="background-color: #CCCCCC">&nbsp;&nbsp;</td>
               </tr>

                <tr>
                   <td colspan="3">
                       
                        BY ROAD (TENAUI DRIVER)
                        :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="delivery-option" value="by-road-tenaui-driver"  <?php if(isset($grt['deliveryMode']) && $grt['deliveryMode'] == "by-road-tenaui-driver" ){ echo "checked";}?> required /> 
                   </td>

               </tr>
            <tr>
                   <td><b>Driver's Name: </b></td>
                   <td><b>Driver's Number: </b></td>
                   <td><b>Vehicle's Number: </b></td>
               </tr>

               <tr style="height: 30px">
                   <td colspan="" rowspan="">
                    <textarea rows="2" name="txtRoadTenauiDriversName" 
                                                value="<?php if(isset($_POST['txtRoadTenauiDriversName'])){ echo $_POST['txtRoadTenauiDriversName'];}?>" class="form-control" required>
                                                  <?php if(isset($grt['driverName'])){ echo $grt['driverName'];}?>
                                                </textarea>
                   </td>
                   <td colspan="" rowspan="">
                        <textarea rows="2" name="txtRoadTenauiDriversNumber" 
                                                value="<?php if(isset($_POST['txtRoadTenauiDriversNumber'])){ echo $_POST['txtRoadTenauiDriversNumber'];}?>" class="form-control" required>
                                                   <?php if(isset($grt['driverNumber'])){ echo $grt['driverNumber'];}?>
                                                </textarea>
                   </td>
                   <td colspan="" rowspan="">
                           <textarea rows="2" name="txtRoadTenauiDriversVehicleNumber" 
                                                value="<?php if(isset($_POST['txtRoadTenauiDriversVehicleNumber'])){ echo $_POST['txtRoadTenauiDriversVehicleNumber'];}?>" class="form-control" required>
                                                  <?php if(isset($grt['vehicleNumber'])){ echo $grt['vehicleNumber'];}?>
                                                </textarea>
                   </td>
               </tr>
               <tr >
                   <td colspan="3" style="background-color: #CCCCCC">&nbsp;&nbsp;</td>
               </tr>

               <tr>
                   <td colspan="3">
                       
                        BY ROAD (THIRD PARTY)
                        :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="delivery-option" value="third-party-logistic-company" <?php if(isset($grt['deliveryMode']) && $grt['deliveryMode'] == "third-party-logistic-company" ){ echo "checked";}?>  required /> 
                   </td>

               </tr>
            <tr>
                   <td><b>DRIVER NAME: </b></td>
                   <td><b>Delivery Way Bill Number: </b></td>
                   <td><b>DRIVER's NUMBER: </b></td>
               </tr>

               <tr style="height: 30px">
                   <td colspan="" rowspan="">
                    <textarea rows="2" name="txtLogisticName" 
                                                value="<?php if(isset($_POST['txtLogisticName'])){ echo $_POST['txtLogisticName'];}?>" class="form-control" >
                                                  <?php if(isset($grt['logisticCompanyName'])){ echo $grt['logisticCompanyName'];}?>

                                                  </textarea>
                   </td>
                   <td colspan="" rowspan="">
                        <textarea rows="2" name="txtLogisticWayBillNumber" 
                                                value="<?php if(isset($_POST['txtLogisticWayBillNumber'])){ echo $_POST['txtLogisticWayBillNumber'];}?>" class="form-control" >
                                                  <?php if(isset($grt['deliveryWayBillNumber1'])){ echo $grt['deliveryWayBillNumber1'];}?>
                                                </textarea>
                   </td>
                   <td colspan="" rowspan="">
                           <textarea rows="2" name="txtLogisticPhoneNumber" 
                                                value="<?php if(isset($_POST['txtLogisticPhoneNumber'])){ echo $_POST['txtLogisticPhoneNumber'];}?>" class="form-control" >
                                                  <?php if(isset($grt['logisticCoyPhoneNum'])){ echo $grt['logisticCoyPhoneNum'];}?>
                                                </textarea>
                   </td>
               </tr>

                <tr>
                  <tr >
                   <td colspan="3" style="background-color: #CCCCCC">&nbsp;&nbsp;</td>
               </tr>
                   <td colspan="3">
                       
                        AIR
                        :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="delivery-option" value="airways"  
                        <?php if(isset($grt['deliveryMode']) && $grt['deliveryMode'] == "airways" ){ echo "checked";}?> required/> 
                   </td>

               </tr>
            <tr>
                   <td><b>Contact Name: </b></td>
                   <td><b>Way Bill Number: </b></td>
                   <td><b>Phone Number: </b></td>
               </tr>

               <tr style="height: 30px">
                   <td colspan="" rowspan="">
                    <textarea rows="2" name="txtAirContactName" 
                                                value="<?php if(isset($_POST['txtAirContactName'])){ echo $_POST['txtAirContactName'];}?>" class="form-control" >
                                                  <?php if(isset($grt['contactNameAir'])){ echo $grt['contactNameAir'];}?>
                                                </textarea>
                   </td>
                   <td colspan="" rowspan="">
                        <textarea rows="2" name="txtAirWayBillNumber" 
                                                value="<?php if(isset($_POST['txtAirWayBillNumber'])){ echo $_POST['txtAirWayBillNumber'];}?>" class="form-control" >
                                                  <?php if(isset($grt['wayBillNumberAir'])){ echo $grt['wayBillNumberAir'];}?>
                                                </textarea>
                   </td>
                   <td colspan="" rowspan="">
                           <textarea rows="2" name="txtAirPhoneNumber" 
                                                value="<?php if(isset($_POST['txtAirPhoneNumber'])){ echo $_POST['txtAirPhoneNumber'];}?>" class="form-control">
                                                <?php if(isset($grt['phoneNumberAir'])){ echo $grt['phoneNumberAir'];}?>

                                              </textarea>
                   </td>
               </tr>

                <tr >
                   <td colspan="3" style="background-color: #CCCCCC">&nbsp;&nbsp;</td>
               </tr>
                   <td colspan="3">
                       
                        INTER STATE BUS:
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="delivery-option" value="inter-state-bus" <?php if(isset($grt['deliveryMode']) && $grt['deliveryMode'] == "inter-state-bus" ){ echo "checked";}?>  required/> 
                   </td>

               </tr>
            <tr>
                   <td><b>Driver's Name: </b></td>
                   <td><b>Driver Phone Number: </b></td>
                   <td><b>Motor Park Location/Address: </b></td>
               </tr>

               <tr style="height: 30px">
                   <td colspan="" rowspan="">
                    <textarea rows="2" name="txtInterBusDriverName" 
                                                value="<?php if(isset($_POST['txtInterBusDriverName'])){ echo $_POST['txtInterBusDriverName'];}?>" class="form-control" >
                                                  <?php if(isset($grt['driverName2'])){ echo $grt['driverName2'];}?>
                                                </textarea>
                   </td>
                   <td colspan="" rowspan="">
                        <textarea rows="2" name="txtInterBusDriverPhoneNumber" 
                                                value="<?php if(isset($_POST['txtInterBusDriverPhoneNumber'])){ echo $_POST['txtInterBusDriverPhoneNumber'];}?>" class="form-control" >
                                                  <?php if(isset($grt['driverNumber2'])){ echo $grt['driverNumber2'];}?>
                                                </textarea>
                   </td>
                   <td colspan="" rowspan="">
                           <textarea rows="2" name="txtParkAddress" 
                                                value="<?php if(isset($_POST['txtParkAddress'])){ echo $_POST['txtParkAddress'];}?>" class="form-control" >
                                                  <?php if(isset($grt['departureLocation'])){ echo $grt['departureLocation'];}?>
                                                </textarea>
                   </td>
               </tr>
             
             
              
                 <tr >
                   <td colspan="3" style="background-color: #CCCCCC">&nbsp;&nbsp;</td>
               </tr>
               <tr>
                   <td colspan="3"> <b>SENDER NAME: </b></td>
                   
               </tr>
               <tr>
               <td colspan="3" rowspan="">
                           <textarea  name="txtSenderName" 
                                                value="<?php if(isset($_POST['txtSenderName'])){ echo $_POST['txtSenderName'];}?>" class="form-control" >
                                                    <?php if(isset($grt['senderName'])){ echo $grt['senderName'];}?>
                                                </textarea>
                   </td>
                  </tr>
                <tr>
                   <td><b>SENDER SIGNATURE: </b></td>
                   <td><b>RECEIPIENT NAME & SIGNATURE: </b></td>
                   <td><b>PHONE NO : </b></td>
               </tr>
               <tr style="height: 100px">
                   <td colspan="" rowspan="2">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   </td>
                   <td colspan="" rowspan="2">
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   </td>
                   <td colspan="" rowspan="2">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   </td>
               </tr>
               
           </table>

       </th>

   </tr>
    <tr>
        <th style=" background-color: #CCCCCC" colspan="2">
            ALL GOODS RECIVED IN PERFECT CONDITION
        </th>
    </tr>
    
            
        
  </table>
  </div>

             <div style=" margin-left: 200px " > 
             </br>
             </br>
             <input type="hidden" name="txtTicketNumber" value="<?php echo $grt['TicketNo']; ?>" />
              <button class="btn aqua" name="btnUpdateWayBill" class="btn btn-success col-lg-12">PROCESS DELIVERY TRACKING</button>
             </div>
            </div>
          </div>

</form>
                 </div>
              </div>
            </div>
          </div>
        <!--</div>
      </div>-->

       
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
