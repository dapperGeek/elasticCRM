<?php
    include("../data/DBConfig.php");
    include_once("../data/sessioncheck.php");
        $id = 0;
    if(!isset($_GET['id']) || $_GET['id'] == ""){
        $database->redirect_to($host."view-machine");
    }else{
        $id = $_GET['id'];

        $machineInfo = $database->getSingleMachineInformation($id);
        if($machineInfo == null){
            $database->redirect_to($host."view-machine");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from adminui-v1.0.bittyfox.com/default/aqua-black/layout_blank_page.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Jul 2017 16:01:32 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $machineInfo['machine_code']." | ".$machineInfo['Name']; ?></title>
    <!-- Bootstrap -->
    <link href="<?php echo $host;?>assets/css/bootstrap.min.css" rel="stylesheet">
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
                        <h2><?php echo $machineInfo['machine_code']; ?> </h2>
                        <ol class="breadcrumb">
                            <li> <a><?php echo $machineInfo['machine_code']; ?></a> </li>
                            <li> <a><?php echo $machineInfo['productName']; ?> </a> </li>
                            <li class="active"> <strong><?php echo $machineInfo['Name']; ?></strong> </li>
                            <li> <a><?php echo $machineInfo['c_name']; ?></a> </li>
                            <li> <a><?php echo $machineInfo['Address']; ?> </a> </li>
                            <li>.</li>
                            <a href="<?php echo $host;?>purchase-item/<?php echo $machineInfo['id'];?>" class="btn btn-success">Make Purchase</a>
                        </ol>
                    </div>
                </div>
                <div class="wrapper-content ">
                     <!-- tabs -->
          <div class="col-lg-10 top20">
            <div class="tabs-container">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-1" data-toggle="tab" >BASIC INFO</a></li>
                <li ><a href="#tab-2" data-toggle="tab" >SERVICE CALLS </a></li>
                <li role="presentation" class="dropdown"> <a  href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop1-contents">ORDERS<span class="caret"></span></a>
                  <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                    <li><a href="#tab-3"   data-toggle="tab" >COLLECTED</a></li>
                    <li><a href="#tab-4"  data-toggle="tab" >NOT COLLECTED</a></li>
                  </ul>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab-1">
                  <div class="panel-body">

                  <h2><?php echo $machineInfo['machine_code']; ?></h2>
                                     <h4><?php echo $machineInfo['productName']; ?></h4>
                                    <p><?php echo $machineInfo['Name']; ?></p>
                  <div class="row">
                                        <div class="col-md-2"><b>ACCOUNT</b></div>
                                        <div class="col-md-4"><?php echo $machineInfo['Name']; ?></div>


                                </div>
                                <br/>
                                <div class="row">
                                        <div class="col-md-2"><b>MACHINE CODE</b></div>
                                        <div class="col-md-4"><?php echo $machineInfo['machine_code']; ?></div>
                                        <div class="col-md-2"><b>MACHINE TYPE</b></div>
                                        <div class="col-md-4"><?php echo $machineInfo['productName']; ?></div>

                                </div>
                                 <br/>
                                 <div class="row">
                                        <div class="col-md-2"><b>SERIAL NO</b></div>
                                        <div class="col-md-4"><?php echo $machineInfo['serialNo']; ?></div>
                                        <div class="col-md-2"><b>D.O.I </b></div>
                                        <div class="col-md-4"><?php echo $machineInfo['doi']; ?></div>

                                </div>
                                      <br/>
                                 <div class="row">
                                        <div class="col-md-2"><b>CON. START</b></div>
                                        <div class="col-md-4"><?php echo $machineInfo['contractStart']; ?></div>
                                        <div class="col-md-2"><b>CON. END</b></div>
                                        <div class="col-md-4"><?php echo $machineInfo['contractEnds']; ?></div>

                                </div>
                                <br/>

                                 <div class="row">
                                        <div class="col-md-2"><b>ADDRESS</b></div>
                                        <div class="col-md-4"><?php echo $machineInfo['Address']; ?></div>
                                </div>
                                <br/>

                                 <div class="row">
                                        <div class="col-md-2"><b>AREA</b></div>
                                        <div class="col-md-4"><?php echo $machineInfo['areaname']; ?></div>
                                        <div class="col-md-2"><b>STATE</b></div>
                                        <div class="col-md-4"><?php echo $machineInfo['state']; ?></div>

                                </div>
                                 <br/>
                                    <div class="row">
                                        <div class="col-md-2"><b>DEPARTMENT</b></div>
                                        <div class="col-md-10"><?php echo $machineInfo['department']; ?></div>


                                    </div>

                    </div>
                </div>
                <div class="tab-pane" id="tab-2">
                  <div class="panel-body">

                                <div class="table-responsive">
                                    <table id="myExample" style="font-size: 12px;" class="dataTables-example display myExample table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Ticket</th>
                                                <th>Account</th>
                                                <th>Machine</th>
                                                <th>Reported</th>
                                                <th>OpenDate</th>
                                                <th>Purchase</th>
                                                <th>Payment</th>
                                                <th>Status</th>
                                                <th>CaseStatus</th>
                                                <th>CloseDate</th>
                                                <th>Lasted</th>
                                            </tr>
                                            </thead>
                                        <tbody> <?php
                                        $activities = (array)$database->getMachineServiceCall($machineInfo['id']);
                                        if($activities!= null){

                                        foreach($activities as $act){
                                ?>
                                     <tr>
                                         <td><?php echo str_pad($act['id'],5,"0",STR_PAD_LEFT);?></td>
                                                 <td><a href="<?php echo $host;?>ticket-info/<?php echo $act['ticketNo']?>"><?php echo strtoupper($act['ticketNo']);?></a></td>
                                                 <td><?php echo $act['AccountName'];?></td>
                                                <td><a href="<?php echo $host;?>machine-info/<?php echo $act['MachineID']?>"><?php echo $act['machine_code'];?></a></td>
                                                <td><?php echo $act['ReportedBy'];?></td>
                                                <td><?php echo $act['openedDateTime'];?></td>
                                                 <td><?php if ($act['purchase']==1){
                                                     $ticketNo_ = $database->getServiceProductOrderCall($act['id'])[0]['ticketNo']; ?>

                                                 <?php echo "<a href='".$host."purchase-invoice/". $ticketNo_."' class='badge badge-info col-md-12'>". $ticketNo_."</a>";}?>

                                                 </td>
                                                <td> <span class="badge badge-<?php if($act['paymentStatus']=='PAID'){echo 'success';}else if($act['paymentStatus']=='UNPAID'){echo 'danger';}else{ echo 'info';}?> col-lg-12">
                                                 <?php echo $act['paymentStatus'];?></span></td>
                                                <td>
                                                    <?php if($act['closedBy'] == 0){?>
                                                    <a class="badge badge-warning" href="<?php echo $host;?>follow-up/<?php echo $act['ticketNo'];?>">FOLLOW-UP</a>

                                                    <?php }else{?>
                                                    <a class="badge badge-info col-lg-12" data-toggle="modal" data-target=".bs-example-modal-lg-2-<?php echo $act['ticketNo'];?>">CLOSED</a>
                                                    <?php }?>
                                                </td>
                                                <td><?php echo $act['caseName'];?></td>
                                                <td><?php echo $act['closedDateTime'];?></td>
                                                <td><?php echo $database->time_space($act['closedTimeStamp'],$act['openedTimeStamp']);?></td>

                                            <?php include('followup/closed.php');?>


                                     </tr>
                                     <?php }}else{?>
                                               <tr>
                                         <td colspan="12">NO DATA FOUND</td>
                                     </tr>
                                     <?php }?>


                                        </tbody>
                                    </table>

                                    </div>





                    </div>
                </div>
                <div class="tab-pane" id="tab-3">
                  <div class="panel-body">
                       <h1><strong>COLLECTED ORDERS</strong></h1>
                          <div class="table-responsive">
                              <table class="table table-bordered table-hover bottom0 ">
                                 <thead>
                                    <tr>
                                       <th>Order #</th>
                                       <th>Order Date</th>
                                       <th>SubTotal (NGN)</th>
                                        <th>VAT 5%</th>
                                       <th>Discount %</th>

                                       <th>Amount (NGN)</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php

                                        $myOrder = (array)$database->purchaseListForMachineCollected($machineInfo['id'],1);
                                            if($myOrder != null){
                                              //  echo count($myOrder);
                                                foreach($myOrder as $mo){
                                                    $vat = 0;
                                                    $vatv_ = "NO VAT";

                                     ?>
                                     <tr>
                                       <td><?php echo $mo['ticketNo'];?></td>
                                       <td><?php echo $mo['orderCollectedDate'];?></td>
                                       <td><?php echo $database->convertToMoney($mo['myAmount']);?></td>
                                       <td><?php if($mo['vat'] == 1){$vat = 0.05 *$mo['myAmount'];$vatv_ = "5%";}
                                            echo $vatv_. " - ".$database->convertToMoney($vat);
                                            $added = $mo['myAmount'] + $vat;
                                       ?></td>
                                       <td><?php
                                               $discount = ($mo['discount']/100) * $added;
                                               echo $mo['discount']."% - ".$database->convertToMoney($discount);
                                            ?>
                                       </td>

                                       <td><?php

                                                $finalAmount = $added - $discount;

                                       echo $database->convertToMoney($finalAmount);?></td>
                                    </tr>

                                     <?php } ?>

                                     <?php }else{?>
                                          <tr>
                                       <td colspan="6">NO ORDER  YET</td>

                                    </tr>
                                     <?php } ?>

                                 </tbody>
                              </table>
                              <div class="panel-footer text-right"><a href="#" class="btn aqua btn-sm">View All Transactions</a></div>
                           </div>

                  </div>
                </div>
                <div class="tab-pane" id="tab-4">
                  <div class="panel-body">
                  <h1><strong>UNCOLLECTED ORDERS</strong></h1>
                          <div class="table-responsive">
                              <table class="table table-bordered table-hover bottom0 ">
                                 <thead>
                                    <tr>
                                       <th>Order #</th>
                                       <th>Order Date</th>
                                       <th>SubTotal (NGN)</th>
                                        <th>VAT 5%</th>
                                       <th>Discount %</th>

                                       <th>Amount (NGN)</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php

                                        $myOrder = (array)$database->purchaseListForMachineCollected($machineInfo['id'],0);
                                            if($myOrder != null){
                                              //  echo count($myOrder);
                                                foreach($myOrder as $mo){
                                                    $vat = 0;
                                                    $vatv_ = "NO VAT";

                                     ?>
                                     <tr>
                                       <td><?php echo $mo['ticketNo'];?></td>
                                       <td>PENDING</td>
                                       <td><?php echo $database->convertToMoney($mo['myAmount']);?></td>
                                       <td><?php if($mo['vat'] == 1){$vat = 0.05 *$mo['myAmount'];$vatv_ = "5%";}
                                            echo $vatv_. " - ".$database->convertToMoney($vat);
                                            $added = $mo['myAmount'] + $vat;
                                       ?></td>
                                       <td><?php
                                               $discount = ($mo['discount']/100) * $added;
                                               echo $mo['discount']."% - ".$database->convertToMoney($discount);
                                            ?>
                                       </td>

                                       <td><?php

                                                $finalAmount = $added - $discount;

                                       echo $database->convertToMoney($finalAmount);?></td>
                                    </tr>

                                     <?php } ?>

                                     <?php }else{?>
                                          <tr>
                                       <td colspan="6">NO ORDER  YET</td>

                                    </tr>
                                     <?php } ?>

                                 </tbody>
                              </table>
                              <!--<div class="panel-footer text-right"><a href="#" class="btn aqua btn-sm">View All Transactions</a></div> -->
                           </div>



                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- tabs -->



                </div>


            </div>
        </div>
    </div>
    <!-- Go top -->
    <a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>
    <!-- Go top -->
 <script src="<?php echo $host;?>assets/js/vendor/jquery.min.js"></script>
    <!-- bootstrap js -->
    <script src="<?php echo $host;?>assets/js/vendor/bootstrap.min.js"></script>
    <!-- slimscroll js -->
    <script type="<?php echo $host;?>text/javascript" src="assets/js/vendor/jquery.slimscroll.js"></script>
    <!-- pace js -->
<script src="<?php echo $host;?>assets/js/vendor/pace/pace.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $host;?>assets/js/vendor/jquery.sparkline.min.js"></script>
<!-- main js -->
    <script src="<?php echo $host;?>assets/js/main.js"></script>
</body>
</body>
</html>