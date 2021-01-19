<?php
/**
 * Created by PhpStorm.
 * User: Uthman A. Bakar
 * Date: 26-Feb-20
 * Time: 10:10 AM
 */
    if (file_exists("includes/forms.php")){
        include ("includes/forms.php");
    }
    else{
        include ("../includes/forms.php");
    }
?>

<div class="row">

<?php
    $loadFooterJS = 2;

    // get all engineers for dropdown
    $engineers = $database->getAllEngineers();

    if (isset($_POST['btnFilterCalls'])){
        $quarterTxt = '';
        $noYear = array('Last month', 'This month');
        $engineer = $engID == 0
            ? ''
            : ' Assigned To Engineer '
            . $database->getAdmin($engID)->fullname ;

        if (in_array($quarter, $noYear)){
            $quarterTxt = "For quarter $quarter";
        }
        elseif ($quarter == ''){
            $quarterTxt = "For $yearInReview";
        }
        else{
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
                        <th>OpenDate</th>
                        <th>Purchase</th>
                        <th>Payment</th>
                        <th>Status</th>

                        <th>CaseStatus</th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $serviceCallsRows = $serviceCalls != null
                        ? sizeof($serviceCalls)
                        : 0;
                    if($serviceCallsRows != null){

                        foreach($serviceCalls as $act){
                            if ($act['closedBy'] == 0){

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

                                    <td>
                                        <?php if($act['closedBy'] == 0){?>
                                            <a class="badge badge-warning" href="<?php
                                            if($myData['AccessLevel'] == 12){
                                                echo $host;?>view-service-call/<?php echo '#'; }else{ echo $host;?>follow-up/<?php echo $act['ticketNo'];}?>" target="_blank">FOLLOW-UP</a>


                                        <?php }else{?>
                                            <a class="badge badge-info col-lg-12" data-toggle="modal" data-target=".bs-example-modal-lg-2-<?php echo $act['ticketNo'];?>">CLOSED</a>
                                        <?php }?>
                                    </td>

                                    <td><?php echo $act['caseName'];?></td>



<?php
    if (file_exists('../serviceapp/followup/closed.php')){
        include('../serviceapp/followup/closed.php');
    }
    else{
        include('serviceapp/followup/closed.php');
    }
?>


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
                        <th>OpenDate</th>
                        <th>Schedule Date</th>
                        <th>Contract Type</th>
                        <th>Closed By</th>
                        <th>Work Done</th>
                        <th>CloseDate</th>
                        <th>Closed By</th>
                    </tr>
                    </thead>
                    <tbody> <?php
                    if($serviceCallsRows != null){
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
                                    <td><?php echo $act['schDate'];?></td>

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

<?php
    if (file_exists('../serviceapp/followup/closed.php')){
    include('../serviceapp/followup/closed.php');
    }
    else{
    include('serviceapp/followup/closed.php');
    }
?>

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

