<?php
$pageHeader = 'viewServiceCall';
include("../includes/header_with_pageHeading.php");
$engineers = $database->getAllEngineers();
?>
<div class="row">

    <?php
    if (isset($_POST['btnFilterCalls'])){
        $quarterTxt = '';
        $noYear = array('Last month', 'This month');
        $engineer = $engID == 0
            ? ''
            : ' Assigned To Engineer '
            . $database->getAdmin($engID)->fullname ;

        // $quarterTxt = $quarter == 'Last month'
        //     ? "For $quarter"
        //     : $quarter == ''
        //         ? "For $yearInReview"
        //         : " For $quarter, $yearInReview";

        if (in_array($quarter, $noYear)){
            $quarterTxt = "For $quarter";
        }
        elseif ($quarter == '')
        {
            $quarterTxt = "For $yearInReview";
        }
        else
        {
            $quarterTxt =  " For $quarter, $yearInReview";
        }


        echo  "<h3><center>Showing results $quarterTxt $engineer</center></h3><p></p>";
    }
    ?>
    <form method="post">

        <div class="col-lg-12">
            <div class="col-lg-2 col-sm-12 margin-bottom-5">
                <h3>Advanced Filter</h3>
            </div>
            <!--                       Select engineer assigned to call-->
            <div class="col-lg-2 col-sm-12 margin-bottom-5">
                <select name="engineer" class="form-control">
                    <option value="0">Select Engineer</option>
                    <?php
                    foreach ($engineers as $eng){
                        ?>
                        <option value="<?php echo $eng['id'] ?>">
                            <?php
                            echo ucfirst($eng['fullname'])
                            ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <!--                       Select period-->
            <div class="col-lg-2 col-sm-12 margin-bottom-5">
                <select name="period" class="form-control">
                    <option value="0">Select period</option>
                    <option value="1">1st Quarter</option>
                    <option value="2">2nd Quarter</option>
                    <option value="3">3rd Quarter</option>
                    <option value="4">4th Quarter</option>
                    <option value="5">Last Month</option>
                    <option value="6">This Month</option>
                </select>
            </div>
            <!--                       Select year in review-->
            <div class="col-lg-2 col-sm-12 margin-bottom-5">
                <select name="year" class="form-control">
                    <option value="0">Year</option>
                    <?php
                    $curYear = date('Y');

                    for ($i = 2016; $i <= $curYear; $i++){
                        ?>
                        <option value="<?php echo $i ?>">
                            <?php echo $i; ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <!--                       form submit button-->
            <div class="col-lg-2 col-sm-12 margin-bottom-5">
                <button class="btn btn-primary col-lg-12" type="submit" name="btnFilterCalls">Search</button>
            </div>
            <!--                Reset List-->
            <div class="col-lg-2 col-sm-12 margin-bottom-5">
                <a class="btn btn-danger col-md-10" href="<?php echo $host . 'view-service-call' ?>">Reset List</a>
            </div>

        </div>
    </form>

</div>
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab-1" data-toggle="tab" > OPENED CALLS &nbsp;&nbsp; <span class="label label-warning">NEW</span></a></li>
    <li ><a href="#tab-2" data-toggle="tab" >CLOSED CALLS &nbsp;&nbsp; <span class="label label-success">OLD</span> </a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="tab-1">
        <div class="panel-body">

            <div class="table-responsive">
                <!--<table id="example7" style="font-size: 12px;"  class="display nowrap table  responsive nowrap table-bordered">-->

                <table id="example7" class="display  table  responsive  table-bordered" style="font-size: 12px; table-layout: fixed; word-wrap:break-word">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ticket</th>
                        <th>Account</th>
                        <th>Machine</th>
                        <th>Lasted</th>
                        <th>Engineer</th>
                        <th>Reported</th>
                        <th>Open Date</th>
                        <th>Purchase</th>
                        <th>Payment</th>
                    <?php
                        // Hide table column from non-Tenaui staff users
                            if ($myData['typeID'] == 0){
                                echo '<th>Status</th>';
                            }
                    ?>


                        <th>Case Status</th>


                    </tr>
                    </thead>
                    <tbody> <?php

                    //$serviceCalls = (array)$database->getAllServiceCallForFollowUp(0);
                    if($serviceCalls != null)
                    {
                        foreach($serviceCalls as $act)
                        {
                            if ($act['closedBy'] == 0)
                            {
                                $majTimeDif = $database->returnTimeDiff(time(),$act['openedTimeStamp']);
                                // var_dump($majTimeDif)
                ?>
                        <tr <?php if($majTimeDif >432000 && $majTimeDif < 1036800){echo "class='warning'";}else if($majTimeDif >1036800){echo "class='danger'";} ?>>
                                    <td> <?php echo  $majTimeDif;?></td>
                                    <td><a href="<?php echo $host;?>ticket-info/<?php echo $act['ticketNo']?>" target="_blank"><?php echo strtoupper($act['ticketNo']); ?> </a></td>
                                    <td><?php echo $act['AccountName'];?></td>
                                    <td><a href="<?php if($myData['AccessLevel'] == 12){ }else{echo $host;?>machine-info/<?php echo $act['MachineID'];}?>"><?php echo $act['machine_code'];?></a></td>
                                    <td>
                                        <div style="height: 10px;" class="progress progress-striped active">
                                            <div style="width: <?php echo $database->getPercentage($majTimeDif);?>" aria-valuemax="100" aria-valuemin="0" aria-valuenow="80" role="progressbar" class="progress-bar progress-bar-<?php echo $database->getSecondsColor( $majTimeDif);?>"> <span class="sr-only"> 80% Complete (danger) </span> </div>
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

                                    <?php
                                        if ($myData['typeID'] == 0){
                                    ?>
                                            <td>
                                                <?php if($act['closedBy'] == 0){?>
                                                    <a class="badge badge-warning" href="<?php
                                                    if($myData['AccessLevel'] == 12){
                                                        echo $host;?>view-service-call/<?php echo '#'; }else{ echo $host;?>follow-up/<?php echo $act['ticketNo'];}?>" target="_blank">FOLLOW-UP</a>


                                                <?php }else{?>
                                                    <a class="badge badge-info col-lg-12" data-toggle="modal" data-target=".bs-example-modal-lg-2-<?php echo $act['ticketNo'];?>">CLOSED</a>
                                                <?php }?>
                                            </td>
                                    <?php
                                        }
                                    ?>

                                    <td><?php echo $act['caseName'];?></td>



                                    <?php include('followup/closed.php');?>


                                </tr>
                                <?php
                            }
                        }}else{?>
                        <tr>
                            <td colspan="12">
                                <center><strong>NO DATA FOUND</strong></center>
                            </td>
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

                <!--<table id="example6" style="font-size: 12px;"  class="display nowrap table  responsive nowrap table-bordered">-->
                <table id="example6" class="display  table  responsive  table-bordered" style="font-size: 12px; table-layout: fixed; word-wrap:break-word">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ticket</th>
                        <th>Account</th>
                        <th>Machine</th>
                        <!--<th>Reported</th>-->
                        <th>Engineer</th>
                        <th>Open Date</th>
                        <th>Issues</th>
                        <th>Contract Type</th>
                        <th>Closed By</th>
                        <th>Work Done</th>
                        <th>Closed Date</th>
                        <th>Closed By</th>
                    </tr>
                    </thead>
                    <tbody>
                <?php
                    if($serviceCalls != null)
                    {
                        foreach($serviceCalls as $act){
                            if ($act['closedBy'] > 0){

                                ?>
                                <tr>
                                    <td><?php echo str_pad($act['id'],5,"0",STR_PAD_LEFT);?></td>
                                    <td><a href="<?php echo $host;?>ticket-info/<?php echo $act['ticketNo']?>" target="_blank"><?php echo strtoupper($act['ticketNo']);?></a></td>
                                    <td><?php echo $act['AccountName'];?></td>
                                    <td><a href="<?php echo $host;?>machine-info/<?php echo $act['MachineID']?>"><?php echo $act['machine_code'];?></a></td>
                                    <!--<td><?php echo $act['ReportedBy'];?></td>-->
                                    <td><?php echo $database->getMyUserInformation($act['engineer'])['fullname'] ?></td>
                                    <!--<td><?php echo $act['openedDateTime'];?></td>-->
                                    <td><?php echo  date('d/m/Y', $act['openedTimeStamp']);?></td>
                                    <!--<td><?php if ($act['purchase']==1){
                                        $ticketNo_ = $database->getServiceProductOrderCall($act['id'])[0]['ticketNo']; ?>

                                                 <?php echo "<a href='".$host."purchase-invoice/". $ticketNo_."' class='badge badge-info col-md-12'>". $ticketNo_."</a>";}?>

                                                 </td>--->
                                    <td>
                                        <?php
//                                            echo $act['issues'];
                                            $issues = explode(",",$act['issues']);
                                            $i = 0;
                                            foreach($issues as $iss)
                                            {
                                                if($iss == "")
                                                {
                                                    continue;
                                                }
                                                else
                                                {
                                                    echo $i == count($issues) - 1
                                                        ? $database->getIssueWithId($iss)['issues']
                                                        : $database->getIssueWithId($iss)['issues'] . ',';
                                                }
                                                $i++;
                                            }
                                        ?>
                                    </td>

                                    <td> <span class="badge badge-<?php if($act['paymentStatus']=='PAID'){echo 'success';}else if($act['paymentStatus']=='UNPAID'){echo 'danger';}else{ echo 'info';}?> col-lg-12">
                                                 <?php echo $act['paymentStatus'];?></span></td>
                                    <td>
                                        <?php if($act['closedBy'] == 0){?>
                                            <a class="badge badge-warning" href="<?php echo $host;?>follow-up/<?php echo $act['ticketNo'];?>" target="_blank">FOLLOW-UP</a>

                                        <?php }else{?>
                                            <a class="badge badge-info col-lg-12" data-toggle="modal" data-target=".bs-example-modal-lg-2-<?php echo $act['ticketNo'];?>">CLOSED</a>
                                        <?php }?>
                                    </td>
                                    <!--<td><?php echo $act['caseName'];?></td>-->
                                    <td><?php echo UtilFunctions::textSummary($act['workDone']);?></td>
                                    <!--<?php echo $act['closedDateTime'];?></td>-->
                                    <td><?php echo  date('d/m/Y', $act['closedTimeStamp']);?></td>
                                    <!--<td><?php echo $database->time_space($act['closedTimeStamp'],$act['openedTimeStamp']);?></td>-->
                                    <td><?php echo $database->getMyUserInformation($act['closedBy'])['fullname'];?></td>

                                    <?php include('followup/closed.php');?>


                                </tr>
                                <?php
                            }
                        }
                    }
                    else{
                        ?>
                        <tr>
                            <td colspan="12">
                                <center><strong>NO DATA FOUND</strong></center>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>


                    </tbody>
                </table>
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
        // Flexible table

        $('#example').DataTable();

        // Scroll Horizontal example



        // Individual column searching

        // Setup - add a text input to each footer cell


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
            "pageLength": 20,

            "columnDefs": [
                { "width": "5px", "targets": 0 },
                { "width": "5px", "targets": 1 },
                { "width": "5px", "targets": 2 },
                { "width": "5px", "targets": 3 },
                { "width": "5px", "targets": 4 },
                { "width": "5px", "targets": 5 }
            ],
        });

    });
</script>
</body>

<!-- Mirrored from adminui-v1.0.bittyfox.com/default/aqua-black/alerts_Modal_Tooltip.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Jul 2017 15:58:53 GMT -->
</html>
