
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
    $headcheck = 1;
?>

<?php

    $closeBy = 0;
    $closeDate = "";
    $closeTimeStamp = "";
        if(isset($_POST['btnRegisterCall'])){
           $serviceID = $_POST['serviceID'];
           $paymentStatus = $database->test_input($_POST['txtPayStatus']);
           $CaseStatus = $database->test_input($_POST['txtCaseStatus']);
           if($CaseStatus == 8 || $CaseStatus == 9){$closeBy = $user_id; $closeDate = date("l jS \of F Y h:i:s A");$closeTimeStamp = time();}
           $workDone = $database->test_input($_POST['txtWrkDone']);
           $database->followUpCall($serviceID,$paymentStatus,$closeBy,$closeDate,$closeTimeStamp,$CaseStatus,$workDone,$_POST['machineID'],$_POST['AccountID']);
           $database->showMsg("","This Ticket has been followed Up", 2);

        }

?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="img/favicon.ico">
        <title><?php echo $machineInfo['machine_code']." | ".$machineInfo['Name']; ?></title>

         <link href="<?php echo $host;?>css/bootstrap.min.css" rel="stylesheet" media="screen">
         <link href="<?php echo $host;?>css/main.css" rel="stylesheet" media="screen">
         <link href="<?php echo $host;?>fonts/icomoon/icomoon.css" rel="stylesheet">

</head>

<body>


<?php include("../includes/header.php");?>

            <div class="top-bar clearfix">
                <div class="page-title">
                    <h4><?php echo $machineInfo['machine_code'];?></h4></div>
                <ul class="topbar-stats">
                    <li>
                        <div class="sales-block hidden-sm"><span id="overallIncome"></span></div>
                        <div class="sales-details">
                            <h4><span>$9579</span> <i class="icon-arrow-up-right2 up"></i></h4>
                            <h5>Overall Income</h5></div>
                    </li>
                </ul>
            </div>
            <div class="main-container">
                <div class="row gutter">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="panel panel-light">
                            <div class="panel-body">
                                <div class="user-account">
                                    <div class="user-pic"><img src="<?php echo $host;?>img/printer.png" class="img-responsive" alt="<?php echo $machineInfo['machine_info'];?>"></div>
                                    <h4><?php echo $machineInfo['machine_code']; ?></h4>
                                     <h4><?php echo $machineInfo['productName']; ?></h4>
                                    <p><?php echo $machineInfo['Name']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <div class="panel panel-light">
                            <div class="panel-heading">
                                <div class="col-md-6">
                                         <h4>Basic Information</h4>
                                 </div>
                                   <div class="col-md-6">
                                       <a href="<?php echo $host;?>edit-machine/<?php echo $machineInfo['id'];?>" class="label-light label label-success">Edit Machine</a>

                                 </div>
                                </div>
                            <div class="panel-body">


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

                              <!-- <div id="area-chart3" class="chart-height3"></div>  -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gutter">
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <div class="panel panel-light">
                            <div class="panel-heading">
                                <h4>Service Calls</h4></div>
                            <div class="panel-body">
                                 <div class="table-responsive">
                                    <table id="myExample" style="font-size: 12px;" class="dataTables-example display myExample table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Ticket</th>
                                                <!--<th>Machine</th>-->
                                                <th>Reported</th>
                                                <th>OpenDate</th>
                                                <th>Payment</th>
                                                <th>Status</th>
                                                <th>CaseStatus</th>
                                                <th>CloseDate</th>
                                                <th>Lasted</th>
                                            </tr>
                                            </thead>


                                <?php
                                        $activities = (array)$database->getMachineServiceCall($machineInfo['id']);

                                        foreach($activities as $act){
                                ?>

                                             <tr>
                                                 <td><a href="<?php echo $host;?>ticket-info/<?php echo $act['ticketNo']?>"><?php echo strtoupper($act['ticketNo']);?></a></td>

                                                <!--<td><a href="<?php echo $host;?>machine-info/<?php echo $act['MachineID']?>"><?php echo $act['machine_code'];?></a></td>
                                               --> <td><?php echo $act['ReportedBy'];?></td>
                                                <td><?php echo $act['openedDateTime'];?></td>
                                                <td> <span class="badge badge-<?php if($act['paymentStatus']=='PAID'){echo 'success';}else if($act['paymentStatus']=='UNPAID'){echo 'danger';}else{ echo 'info';}?> col-lg-12">
                                                 <?php echo $act['paymentStatus'];?></span></td>
                                                <td><?php if($act['closedBy'] == 0){?> <!--<span class="badge badge-danger">OPEN</span>--> <a class="badge badge-warning" data-toggle="modal" data-target="#myModal<?php echo $act['ticketNo'];?>">FOLLOW-UP</a>  <?php }else{?><a class="badge badge-info col-lg-12" data-toggle="modal" data-target="#myModal2<?php echo $act['ticketNo'];?>">CLOSED</a><?php }?></td>
                                                <td><?php echo $act['caseName'];?></td>
                                                <td><?php echo $act['closedDateTime'];?></td>
                                                 <td><?php echo $database->time_space($act['closedTimeStamp'],$act['openedTimeStamp']);?></td>
                                                <div class="modal fade" id="myModal<?php echo $act['ticketNo'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLarge">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">FOLLOW UP CALL ON <?php echo $act['ticketNo'];?> OPENED ON : <?php echo $act['openedDateTime'];?> </h4></div>
                                                         <!---- the beginning of the form-->
                                                                    <form action="" method="post">
                                                          <div class="modal-body">


                                                                        <div class="row gutter">

                                                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                                                    <div class="panel panel-blue">
                                                                                        <div class="panel-heading">
                                                                                            <h4>Service Calls</h4>
                                                                                        </div>
                                                                                        <div class="panel-body">
                                                                                            <div class="form-group">
                                                                                            <div class="row gutter">
                                                                                                <div class="col-md-12">
                                                                                                    <input type="text" class="form-control m-b" value="<?php echo $act['AccountName'];?>" readonly="readonly">
                                                                                                        <input type="hidden" name="serviceID" value="<?php echo $act['id'];?>" />
                                                                                                         <input type="hidden" name="ticketNo" value="<?php echo $act['ticketNo'];?>" />
                                                                                                         <input type="hidden" name="machineID" value="<?php echo $act['MachineID'];?>" />
                                                                                                         <input type="hidden" name="AccountID" value="<?php echo $act['accountID'];?>" />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="form-group">
                                                                                            <div class="row gutter">
                                                                                                <div class="col-md-12">
                                                                                                    <label class="control-label">MACHINE</label>
                                                                                                    <input type="text" class="form-control m-b" value="<?php echo $act['machine_code'];?>" readonly="readonly">

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                         <div class="form-group">
                                                                                            <div class="row gutter">
                                                                                                <div class="col-md-12">
                                                                                                    <label class="control-label">COST</label>
                                                                                                    <input type="text" class="form-control m-b" value="<?php echo $act['cost'];?>" readonly="readonly">

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                         <div class="form-group">
                                                                                            <div class="row gutter">
                                                                                                <div class="col-md-12">
                                                                                                    <label class="control-label">PAYMENT</label>
                                                                                                    <select class="form-control m-b" name="txtPayStatus" required data-validation-required-message="select payment status">
                                                                                                        <option <?php if($act['paymentStatus'] == 'UNPAID'){echo "selected";} ?>>UNPAID</option>
                                                                                                        <option <?php if($act['paymentStatus'] == 'WAIVE'){echo "selected";} ?>>WAIVE</option>
                                                                                                        <option <?php if($act['paymentStatus'] == 'FOC'){echo "selected";} ?>>FOC</option>
                                                                                                        <option <?php if($act['paymentStatus'] == 'PAID'){echo "selected";} ?>>PAID</option>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                         <div class="form-group">
                                                                                            <div class="row gutter">
                                                                                                <div class="col-md-12">
                                                                                                    <label class="control-label">CASE STATUS</label>
                                                                                                    <select class="form-control m-b" name="txtCaseStatus" required data-validation-required-message="select payment status">
                                                                                                     <?php
                                                                                                        $cases = (array)$database->getCaseStatus();
                                                                                                        foreach($cases as $case){
                                                                                                     ?>

                                                                                                     <option value="<?php echo $case['id'];?>" <?php if($case['id']== $act['CaseStatus']){echo "selected";}?>><?php echo $case['caseName'];?></option>
                                                                                                     <?php }?>
                                                                                                    </select>

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>








                                                                                        </div>

                                                                                    </div>


                                                                        </div>

                                                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                                                    <div class="panel panel-orange">
                                                                                        <div class="panel-heading">
                                                                                            <h4>Service Calls</h4>
                                                                                            <a href="<?php echo $host;?>pur"></a>
                                                                                        </div>
                                                                                        <div class="panel-body">

                                                                                            <div class="form-group">

                                                                                                                <label class="control-label">ISSUES</label>
                                                                                                            <?php
                                                                                                                $issues = explode(",",$act['issues']);
                                                                                                                $i = 0;
                                                                                                                foreach($issues as $iss){
                                                                                                                if($iss == "")continue;
                                                                                                            ?>
                                                                                                                <input type="text" class="form-control m-b" value="<?php echo $database->getIssueWithId($iss)['issues'];?>" readonly="readonly">
                                                                                                             <?php }  ?>

                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                            <div class="row gutter">
                                                                                                <div class="col-md-12">
                                                                                                    <label class="control-label">WORK DONE DESCRIPTION</label>
                                                                                                   <textarea  class="form-control" id="txtWrkDone" placeholder="Work Done Description" rows="3"></textarea>

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        </div>

                                                                                    </div>


                                                                        </div>
                                                                        </div>


                                                                    <!--- the end of the form -->

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Dismiss</button>
                                                                <input type="submit" value="Save Changes" name="btnRegisterCall" class="btn btn-success" />

                                                            </div>
                                                        </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="myModal2<?php echo $act['ticketNo'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLarge">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">CALL STATUS FOR <?php echo $act['ticketNo'];?> OPENED ON : <?php echo $act['openedDateTime'];?>, CLOSED ON </h4>
                                                            </div>
                                                         <!---- the beginning of the form-->

                                                          <div class="modal-body">
                                                               <div class="invoice">
                            <div class="panel no-margin">
                                <div class="panel-body">
                                    <!--<div class="row gutter">
                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                            <a href="#"><img src="<?php echo $host;?>img/logo.png" alt="Bluemoon Logo" class="logo"></a>
                                        </div>
                                        <div class="col-md-9 col-sm-8 col-xs-12">
                                            <div class="right-text">
                                                <p><b>Invoice ID</b> - <?php echo $act['ticketNo'];?></p>

                                                <p><b>Payment status</b>  <span class="badge badge-<?php if($act['paymentStatus']=='PAID'){echo 'success';}else if($act['paymentStatus']=='UNPAID'){echo 'danger';}else{ echo 'info';}?> ">
                                                 <?php echo $act['paymentStatus'];?></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <br>
                                    <br> -->
                                    <div class="row gutter">
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                              <address class="to"><h4> <?php echo $act['ticketNo'];?></h4>
                                              <p> <span class="badge badge-<?php if($act['paymentStatus']=='PAID'){echo 'success';}else if($act['paymentStatus']=='UNPAID'){echo 'danger';}else{ echo 'info';}?> col-md-12">
                                                 <?php echo $act['paymentStatus'];?></span></p>
                                              <p><?php echo $act['caseName'];?></p>
                                               <p><?php echo $act['ReportedBy'];?></p>
                                         </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12"><address class="from"><h4><b>Tenaui Africa Limited</b></h4><abbr title="email">E-mail:</abbr> <a href="mailto:#" data-original-title="" title="">support.ng@tenaui.com</a><br><abbr title="Phone">Phone:</abbr> (123) 333-444-555<br><abbr title="Fax">Fax:</abbr> (123) 333-444-555</address></div>
                                        <div class="col-md-5 col-sm-5 col-xs-12"><address class="to"><h4>
                                            <b><?php echo $act['AccountName'] ?></b></h4>
                                            <abbr title="email">E-mail:</abbr> <a href="mailto:#" data-original-title="" title=""><?php echo $act['contactEmail1'];?></a><br>
                                            <abbr title="Phone">Phone:</abbr> <?php echo $act['contactPhone1'];?><br>
                                        <abbr title="Fax">Contact Person:</abbr> <?php echo $act['contactName1'];?></address>
                                        </div>


                                </div>

                                    <div class="row">
                                        <div class="col-md-4"><b>Machine Code :</b> <?php echo $act['machine_code'];?></div>
                                        <div class="col-md-4"><b>Machine Model :</b> <?php echo $act['machineBrand'];?> </div>
                                        <div class="col-md-4"><b>Contract Type :</b> <?php echo $act['contract'];?> </div>
                                    </div>
                                     <div class="row">
                                        <div class="col-md-4"><b>Engineer :</b><?php echo $database->getMyUserInformation($act['engineer'])['fullname'];?></div>
                                        <div class="col-md-8"><b>Machine Address :</b><?php echo $act['Address'].", ".$act['areaname'].", ".$act["lga"]." L.G.A, ".$act['state'];?> </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4"><b>Opened Date :</b> <?php echo $act['openedDateTime'];?></div>
                                        <div class="col-md-4"><b>Closed Date :</b> <?php echo $act['closedDateTime'];?> </div>
                                        <div class="col-md-4"><b>Duration :</b> <?php echo $database->time_space($act['closedTimeStamp'],$act['openedTimeStamp']);?> </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center"><b><h4 style="text-align: center">Issues</h4></b></div>
                                                <?php
                                                        $issues = explode(",",$act['issues']);
                                                        $i = 0;
                                                        foreach($issues as $iss){
                                                        if($iss == "")continue;
                                                          ?>
                                                           <div class="col-md-6" style=" background-color: #CC0000; color: #ffffff;text-align: center"><?php echo $database->getIssueWithId($iss)['issues'];?></div>

                                                 <?php  if($i%2 != 0 && $i!= 0){ ?>
                                                    </div> <div class="row">

                                                       <?php  }  $i++; }  ?>
                                             </div>

                                        <div class="col-lg-12">
                                            <h4 style="text-align: center">Work Done Description</h4>
                                            <p style="text-align: center"><?php echo $act['workDone'];?></p>
                                        </div>

                                        <div class="col-lg-12">

                <div class="row">

                        <div class="col-md-4" style="border-style: inset"><p style="text-align: center"><b>Item</b></p></div>
                        <div class="col-md-3" style="border-style: inset"><p style="text-align: center">Code</p></div>
                        <div class="col-md-2" style="border-style: inset"><p style="text-align: center">Rate</p></div>
                        <div class="col-md-1" style="border-style: inset"><p style="text-align: center">Qty</p></div>
                        <div class="col-md-2" style="border-style: inset"><p style="text-align: center">Price</p></div>
                    </div>


                    <?php
                     $amounted = 0;
                     $amount_ = 0;
                            if($act['purchase'] == 1){
                            $n = 1;

                            $salesorder = (array)$database->getServiceProductOrderCall($act['id']);
                            foreach ($salesorder as $order) {
                    ?>
                                <div class="row">
                                    <div class="col-md-4" style="border-style: inset"><p style="text-align: center"><?php echo $order['productName'];?><?php if($order['ProductType']>1){echo " - ".$order['color'];}?></p></div>
                                    <div class="col-md-3" style="border-style: inset"><p style="text-align: center"><?php echo $order['Code'];?></p></div>
                                    <div class="col-md-2" style="border-style: inset"><p style="text-align: center"> <?php echo $database->convertToMoney($order['Amount']);?></p></div>
                                    <div class="col-md-1" style="border-style: inset"><p style="text-align: center"><?php echo $order['qty'];?></p></div>
                                    <div class="col-md-2" style="border-style: inset"><p style="text-align: center"><?php
                                                            $amount_ = $order['qty'] * $order['Amount'];
                                                    echo $database->convertToMoney($amount_);?></p></div>
                                </div>

                     <?php $n++; $amounted += $amount_;}?>
                    <?php }else{?>
                        <div class="row" ><p style="text-align: center">No Consumable purchased for this ticket</p></div>
                    <?php }?>
                     <div class="row">
                             <div class="col-md-8" style="border-style: inset">&nbsp;</div>
                             <div class="col-md-2" style="border-style: inset">PURCHASE </div>
                             <div class="co-md-2" style="border-style: inset"> <?php
                             $sub_total =$amounted;
                             echo  $database->convertToMoney($sub_total);
                        ?></div>

                         </div>
                           <div class="row">
                             <div class="col-md-8" style="border-style: inset">&nbsp;</div>
                             <div class="col-md-2" style="border-style: inset">SERV-CHARGE </div>
                             <div class="co-md-2" style="border-style: inset"><span style="text-align: center"><?php echo $database->convertToMoney($act['cost']);?></span></div>

                         </div>
                         <div class="row">
                             <div class="col-md-8" style="border-style: inset; ">&nbsp;</div>
                             <div class="col-md-2" style="border-style: inset">TOTAL </div>
                             <div class="co-md-2" style="border-style: inset"><?php $total = $act['cost'] + $sub_total; echo $database->convertToMoney($total); ?></div>

                         </div>
                             <div class="row" style="border-style: inset">
                                  <p style="text-align: center">
                  <b>Amount in words :</b> <?php echo ucwords($database->convert_number_to_words($total));?> Naira Only
                   </p>
                             </div>
                    </div>

                     </div>
                                                           </div>
                                                          </div>
                                                          <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Dismiss</button>


                                                            </div>

                                                        </div>
                                                    </div>
</div>


                                     </tr>

                                <?php
                                        }
                                ?>
                                </table>
                                  </div>

                            </div>
                        </div>
                        <div class="row gutter">
                           <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="panel panel-light">
                                    <div class="panel-heading">
                                        <h4>Activity</h4></div>
                                    <div class="panel-body">
                                        <ul class="project-activity">
                                             <?php
                                                        $activities = (array)$database->getMachineActivities($machineInfo['id']);
                                                        foreach($activities as $act){
                                                ?>
                                            <li class="activity-list success">
                                                <div class="detail-info"><small class="text-muted"><?php echo $database->time_elapsed_string($act['timeStamp']);?></small>
                                                    <p class="message"><a class="text-success"><?php echo $database->getMyUserInformation($act['user_id'])['fullname'];?></a>&nbsp;<?php  echo $act['activities'];?></p>
                                                </div>
                                            </li>
                                            <?php }?>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                        <div class="panel panel-light">
                            <div class="panel-heading">
                                <div class="row">
                                 <a href="<?php echo $host;?>purchase-item/<?php echo $machineInfo['id'];?>" class="btn btn-success col-md-12">Make Purchase</a>
                                  </div>
                        </div>


                                 <div class="panel-body">
                                <ul class="task-list">
                                    <?php
                                            $purchases = (array)$database->purchaseListForMachine($machineInfo['id']);
                                            foreach($purchases as $pur){
                                    ?>
                                    <li class="list"><a href="<?php echo $host;?>purchase-invoice/<?php echo $pur['ticketNo'];?>"><?php echo $pur['ticketNo'];?></a></li>

                                   <?php }?>
                                </ul>
                            </div>
                        </div>
                        <!--<div class="panel panel-light">
                            <div class="panel-heading">
                                <h4>Bookmarks</h4></div>
                            <div class="panel-body">
                                <ul class="articles">
                                    <li><a href="#"><span class="label-bullet">&nbsp;</span> Bootstrap admin Template</a></li>
                                    <li><a href="#" class="no-border overflow-text" data-original-title="" title=""><span class="label-bullet">&nbsp;</span> Top admin Template</a></li>
                                    <li><a href="#" class="no-border overflow-text" data-original-title="" title=""><span class="label-bullet">&nbsp;</span> Best admin Template 2017</a></li>
                                    <li><a href="#" class="no-border overflow-text" data-original-title="" title=""><span class="label-bullet">&nbsp;</span> Javascript Libraries</a></li>
                                </ul>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

        </div>
        
    </div>
    <script src="<?php echo $host;?>js/jquery.js"></script>
    <script src="<?php echo $host;?>js/bootstrap.min.js"></script>
    <script src="<?php echo $host;?>js/sparkline/retina.js"></script>
    <script src="<?php echo $host;?>js/scrollup.min.js"></script>
    <script src="<?php echo $host;?>js/flot/jquery.flot.min.js"></script>
    <script src="<?php echo $host;?>js/flot/jquery.flot.tooltip.min.js"></script>
    <script src="<?php echo $host;?>js/flot/jquery.flot.time.min.js"></script>
    <script src="<?php echo $host;?>js/flot/jquery.flot.resize.min.js"></script>
    <script src="<?php echo $host;?>js/flot/custom/profile-area.js"></script>
    <script src="<?php echo $host;?>js/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="<?php echo $host;?>js/jvectormap/gdp-data.js"></script>
    <script src="<?php echo $host;?>js/jvectormap/usa.js"></script>
    <script src="<?php echo $host;?>js/jvectormap/custom/usa-profile.js"></script>
    <script src="<?php echo $host;?>js/common.js"></script>
</body>

</html>