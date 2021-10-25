<?php
    $pageHeader = 'contractAccountInfo';
    include("../includes/header_with_pageHeading.php");
    $stores = $database->getAllStores();

    $id = 0;
    if(!isset($_GET['id']) || $_GET['id'] == ""){
       $database->redirect_to($host."view-machine");
    }else{
        $id = $_GET['id'];
        $machineInfo = $database->getSingleAccountInformation($id);
        if($machineInfo == null){
            $database->redirect_to($host."view-machine");
        }
    }

?>

        <div class="row wrapper border-bottom page-heading">
            <div class="col-lg-12">
                <h2><?php echo $machineInfo['Name'];?> </h2>
                 <ol class="breadcrumb">
                    <li> <a><?php echo $machineInfo['Address']; ?></a> </li>

                    <li class="active"> <strong><?php echo $machineInfo['areaname']; ?></strong> </li>
                    <li> <a><?php echo $machineInfo['state']; ?> </a> </li>
                </ol>

<!--                        Page edit contract and account buttons-->
                <div class="col-lg-3 pull-right">

                    <a href="<?php echo $host;?>edit-account/<?php echo $machineInfo['id'];?>" class="btn btn-warning pull-right">Edit Account</a>

                    <a class="btn btn-default pull-right margin-right-10"  data-toggle="modal" data-target="#contract-modal">Edit Contract</a>
                    <?php include('../views/modals/edit-contract.php') ?>
                </div>
            </div>
        </div>

        <div class="wrapper-content ">
                     <!-- tabs -->
          <div class="col-lg-8 top20">
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

                  <h2><?php echo $machineInfo['Name']; ?></h2>

                  <div class="row">
                        <div class="col-md-2"><b>ACCOUNT</b></div>
                        <div class="col-md-4"><?php echo $machineInfo['Name']; ?></div>


                </div>
                <br/>
                <div class="row">
                        <div class="col-md-2"><b>INDUSTRY</b></div>
                        <div class="col-md-4"><?php echo $machineInfo['sector']; ?></div>


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
                 <hr/>

                    <div class="row">
                        <div class="col-md-1"><b>C 1:</b></div>
                        <div class="col-md-3"><?php echo $machineInfo['ContactName1']; ?></div>
                         <div class="col-md-1"><b>C 2:</b></div>
                        <div class="col-md-3"><?php echo $machineInfo['ContactName2']; ?></div>
                         <div class="col-md-1"><b>C 3:</b></div>
                        <div class="col-md-3"><?php echo $machineInfo['ContactName3']; ?></div>


                    </div>
                    <br/>
                     <div class="row">
                        <div class="col-md-1"><b>P 1:</b></div>
                        <div class="col-md-3"><?php echo $machineInfo['phone1']; ?></div>
                         <div class="col-md-1"><b>P 2:</b></div>
                        <div class="col-md-3"><?php echo $machineInfo['phone2']; ?></div>
                         <div class="col-md-1"><b>P 3:</b></div>
                        <div class="col-md-3"><?php echo $machineInfo['phone3']; ?></div>


                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-1"><b>E 1:</b></div>
                         <div class="col-md-3 labels-inline"><span class="label-light label label-warning">
                             <?php echo wordwrap($machineInfo['email1'],15,"<br>\n");  ?>
                         </span>

                        </div>
                         <div class="col-md-1"><b>E 2:</b></div>
                          <div class="col-md-3 labels-inline"><span class="label-light label label-warning">
                             <?php echo wordwrap($machineInfo['email2'],15,"<br>\n");  ?>
                         </span>

                        </div>
                           <div class="col-md-1"><b>E 3:</b></div>
                       <div class="col-md-3 labels-inline"><span class="label-light label label-warning">
                             <?php echo wordwrap($machineInfo['email3'],15,"<br>\n");  ?>
                         </span>

                        </div>

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
                                        $activities = (array)$database->getAccountServiceCall($machineInfo['id']);
                                        if($activities!= null){

                                        foreach($activities as $act){
                                ?>
                                     <tr>
                                         <td><?php echo str_pad($act['id'],5,"0",STR_PAD_LEFT);?></td>
                                                 <td><a href="<?php echo $host;?>ticket-info/<?php echo $act['ticketNo']?>"><?php echo strtoupper($act['ticketNo']);?></a></td>

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

                                        $myOrder = (array)$database->purchaseListForAccountCollected($machineInfo['id'],1);
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

                                        $myOrder = (array)$database->purchaseListForAccountCollected($machineInfo['id'],0);
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
           <div class="col-lg-4">
                    <div class="panel panel-primary">
                      <div class="panel-heading"> Machines for <?php echo $machineInfo['Name']; ?> </div>
                      <div class="panel-body">
                         <div class="feed-activity-list">
                                    <?php
                                            $accMachine = (array)$database->getAllMachineForAccount($machineInfo['id']);
                                             foreach($accMachine as $acm){
                                    ?>
												<div class="feed-element">
                                                    <a href="<?php echo $host;?>machine-info/<?php echo $acm['id'];?>"><h4><?php echo $acm['machine_code']." - ".$acm['productName']." - ".$acm['c_name']?></h4></a>
												</div>
									<?php }?>

                </div>

            </div>

<?php include('../includes/footer.php') ;