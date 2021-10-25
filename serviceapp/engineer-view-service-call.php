<?php
$pageTitle = 'My Service Calls';
$pageHeader = 'engineerViewServiceCall';
include("../includes/header_with_pageHeading.php");
$engineers = $database->getAllEngineers();
?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">

                            <div class="ibox-content collapse in">
                                <div class="widgets-container">  <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab-1" data-toggle="tab" > OPENED CALLS &nbsp;&nbsp; <span class="label label-warning">NEW</span></a></li>
                                        <li ><a href="#tab-2" data-toggle="tab" >CLOSED CALLS &nbsp;&nbsp; <span class="label label-success">OLD</span> </a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab-1">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table id="example7" style="font-size: 12px"  class="display nowrap table  responsive nowrap table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Ticket</th>
                                                            <th>Account</th>
                                                            <th>Machine</th>
                                                            <th>Lasted</th>
                                                            <th>Engineer. <?php $engineerid=$myData['id']; ?></th>
                                                            <th>Reported</th>
                                                            <th>OpenDate</th>
                                                            <th>Purchase</th>
                                                            <th>Payment</th>
                                                            <th>Status</th>

                                                            <th>CaseStatus</th>


                                                        </tr>
                                                        </thead>
                                                        <tbody> <?php

                                                        $activities = (array)$database->getAllServiceCallForengineeridFollowUp(0,$engineerid);
                                                        if($activities != null){

                                                            foreach($activities as $act){
                                                                $majTimeDif = $database->returnTimeDiff(time(),$act['openedTimeStamp']);
                                                                ?>
                                                                <tr <?php if($majTimeDif >432000 && $majTimeDif < 1036800){echo "class='warning'";}else if($majTimeDif >1036800){echo "class='danger'";} ?>>
                                                                    <td> <?php echo  $majTimeDif;?></td>
                                                                    <td><a href="<?php echo $host;?>ticket-info/<?php echo $act['ticketNo']?>"><?php echo strtoupper($act['ticketNo']);?></a></td>
                                                                    <td><?php echo $act['AccountName'];?></td>
                                                                    <td><a href="<?php if($myData['AccessLevel'] == 12){ }else{echo $host;?>machine-info/<?php echo $act['MachineID'];}?>"><?php echo $act['machine_code'];?></a></td>
                                                                    <td>
                                                                        <div style="height: 10px;" class="progress progress-striped active">
                                                                            <div style="width: <?php echo $database->getPercentage($majTimeDif);?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="80" role="progressbar" class="progress-bar progress-bar-<?php echo $database->getSecondsColor( $majTimeDif);?>"> <span class="sr-only"> 80% Complete (danger) </span> </div>
                                                                        </div>


                                                                        <?php echo $database->secondsToTime( $majTimeDif);?></td>
                                                                    <td><?php echo $database->getMyUserInformation($act['engineer'])['fullname'] ?></td>
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
                                                                            <a class="badge badge-warning" href="<?php
                                                                            if($myData['AccessLevel'] == 12){
                                                                                echo $host;?>view-service-call/<?php echo '#'; }else{ echo $host;?>follow-up/<?php echo $act['ticketNo'];}?>">FOLLOW-UP</a>


                                                                        <?php }else{?>
                                                                            <a class="badge badge-info col-lg-12" data-toggle="modal" data-target=".bs-example-modal-lg-2-<?php echo $act['ticketNo'];?>">CLOSED</a>
                                                                        <?php }?>
                                                                    </td>

                                                                    <td><?php echo $act['caseName'];?></td>



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
                                        <div class="tab-pane" id="tab-2">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table id="example6" style="font-size: 12px"  class="display nowrap table  responsive nowrap table-bordered">
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
                                                        $activities = (array)$database->getAllServiceCallForengineeridFollowUp(1,$engineerid);
                                                        if($activities != null){

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

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- start footer -->

    </div>
    </div>


    <!-- Go top -->
    <a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>
    <!-- Go top -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo $host;?>assets/js/vendor/jquery.min.js"></script>
    <!-- bootstrap js -->
    <script src="<?php echo $host;?>assets/js/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jasny-bootstrap.min.js" charset="UTF-8"></script>
    <!-- slimscroll js -->
    <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jquery.slimscroll.js"></script>
    <!-- dataTables-->
    <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jquery.dataTables.js"></script>
    <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/dataTables.bootstrap.min.js"></script>
    <!-- js for print and download -->
    <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/buttons.flash.min.js"></script>
    <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jszip.min.js"></script>
    <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/pdfmake.min.js"></script>
    <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/vfs_fonts.js"></script>
    <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/buttons.html5.min.js"></script>
    <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/buttons.print.min.js"></script>

    <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/dataTables.fixedHeader.min.js"></script>
    <!-- pace js -->
    <script src="<?php echo $host;?>assets/js/vendor/pace/pace.min.js"></script>
    <!-- Sparkline -->
    <script src="<?php echo $host;?>assets/js/vendor/jquery.sparkline.min.js"></script>
    <!-- main js -->
    <script src="<?php echo $host;?>assets/js/main.js"></script>
    <script>

        $(document).ready(function() {

            $('#example').DataTable();

            // Advanced
            $('#example7').DataTable({

                dom: 'Bfrtip',
                buttons: [{
                    text: 'copy',
                    extend: "copy",
                    className: 'btn dark btn-outline'
                }, {
                    text: 'csv',
                    extend: "csv",
                    className: 'btn aqua btn-outline'
                }, {
                    text: 'excel',
                    extend: "excel",
                    className: 'btn aqua btn-outline'
                }, {
                    text: 'pdf',
                    extend: "pdf",
                    className: 'btn yellow  btn-outline'
                }, {
                    text: 'print',
                    extend: "print",
                    className: 'btn purple  btn-outline'
                }],
                "pageLength": 20
            });
            $('#example6').DataTable({

                dom: 'Bfrtip',
                buttons: [{
                    text: 'copy',
                    extend: "copy",
                    className: 'btn dark btn-outline'
                }, {
                    text: 'csv',
                    extend: "csv",
                    className: 'btn aqua btn-outline'
                }, {
                    text: 'excel',
                    extend: "excel",
                    className: 'btn aqua btn-outline'
                }, {
                    text: 'pdf',
                    extend: "pdf",
                    className: 'btn yellow  btn-outline'
                }, {
                    text: 'print',
                    extend: "print",
                    className: 'btn purple  btn-outline'
                }],
                "pageLength": 20
            });



        });
    </script>
    </body>
</html>
