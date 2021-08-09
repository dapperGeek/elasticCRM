<?php
/**
 * Created by PhpStorm.
 * User: Uthman A. Bakar
 * Date: 26-Feb-20
 * Time: 10:10 AM
 */
    if (file_exists("includes/forms.php"))
    {
        include ("data/sessioncheck.php");
        include ("includes/forms.php");
    }
    else
    {
        include ("../data/sessioncheck.php");
        include ("../includes/forms.php");
    }
    
    $closedView = file_exists('serviceapp/followup/closed.php')
            ? 'serviceapp/followup/closed.php' : '../serviceapp/followup/closed.php';
?>

<div class="row">

<?php
    $loadFooterJS = 2;

    // get all engineers for dropdown
    $engineers = $database->getAllEngineers();

    if (isset($_POST['btnFilterCalls']))
    {
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
    
    //Show service call advanced filter for admin and customer support personnel
    if ($_SESSION['access'] >= 8 || $_SESSION['dptID'] == 3)
    {
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

                        for ($i = 2016; $i <= $curYear; $i++)
                        {
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
<?php    
    }
?>


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

            <table id="supportCalls" class="display  table  responsive  table-bordered" style="font-size: 12px; table-layout: fixed; word-wrap:break-word">
                <thead>
                    <tr>
                        <th style="display:none">ID</th>
                        <th>Ticket</th>
                        <th>Account</th>
                        <th>Machine</th>
                        <th>Lasted</th>
                        <th>Engineer</th>
                        <th>Reported</th>
                        <th>Open Date</th>
                        <!--<th style="width:25%">Work Done</th>-->
                        <th>Payment</th>
                    <?php
                        // Hide table column from non-Tenaui staff users
                            if ($myData['typeID'] == 0)
                            {
                                echo '<th>Status</th>';
                            }
                    ?>
                        <th>Case Status</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php
                        if($serviceCalls != null)
                        {
                            foreach($serviceCalls as $act)
                            {
                                $followUps = $database->getFollowUps($act['callID'], 1);
                                if ($act['closedBy'] == 0)
                                {
                                    $majTimeDif = $database->returnTimeDiff(time(),$act['openedTimeStamp']);
                    ?>
                        <tr 
                            <?php 
                                if($majTimeDif >432000 && $majTimeDif < 1036800)
                                {
                                    echo "class='warning'";
                                }
                                else if($majTimeDif >1036800)
                                {
                                    echo "class='danger'";
                                    
                                } 
                            ?>
                        >
                            <td style="display:none">
                                <?php echo $majTimeDif; ?>
                            </td>
                            <td>
                                <a href="<?php echo $host;?>ticket-info/<?php echo $act['ticketNo']?>" target="_blank"><?php echo strtoupper($act['ticketNo']); ?> </a>
                            </td>
                            <td>
                            <?php echo $act['AccountName'];?>
                                </td>
                                <td>
                                <a href="<?php if($myData['AccessLevel'] == 12)
                                {
                                }
                                else
                                {
                                    echo $host;?>machine-info/<?php echo $act['MachineID'];
                                }
                            ?>">
                                    <?php echo $act['machine_code'];?>
                                </a>
                            </td>
                            <td>
                                <div style="height: 10px;" class="progress progress-striped active">
                                    <div style="width: <?php echo $database->getPercentage($majTimeDif);?>" aria-valuemax="100" aria-valuemin="0" aria-valuenow="80" role="progressbar" class="progress-bar progress-bar-<?php echo $database->getSecondsColor( $majTimeDif);?>">
                                        <span class="sr-only"> 80% Complete (danger) </span> 
                                    </div>
                                </div>
                                <?php echo $database->secondsToTime( $majTimeDif);?>
                            </td>
                            <td>
                                <?php echo $database->getMyUserInformation($act['engineer'])['fullname'] ?>
                            </td>
                            <td>
                                <?php echo $act['ReportedBy'];?>
                            </td>
                            <td>
                                <?php echo $act['openedDateTime'];?>
                            </td>
                            <!--<td>-->
                                <?php 
//                                    if ($act['purchase']==1)
//                                    {
//                                        $ticketNo_ = $database->getServiceProductOrderCall($act['id'])[0]['ticketNo'];
//                                        echo "<a href='".$host."purchase-invoice/". $ticketNo_."' class='badge badge-info col-md-12'>". $ticketNo_."</a>";
//                                    }
//                                    echo $followUps[0]['work-done'];
                                ?>
                            <!--</td>-->
                            <td> 
                                <span class="badge badge-
                                    <?php 
                                        if($act['paymentStatus']=='PAID')
                                            {
                                            echo 'success';

                                            }
                                            else if($act['paymentStatus']=='UNPAID')
                                            {
                                                echo 'danger';
                                            }
                                            else
                                            {
                                                echo 'info';
                                            }
                                    ?> col-lg-12">
                                    <?php echo $act['paymentStatus'];?>
                                </span>
                            </td>

                                <?php
                                    if ($myData['typeID'] == 0)
                                    {
                                ?>
                            <td>
                                <?php 
                                    if($act['closedBy'] == 0)
                                    {
                                ?>
                                    <a class="badge badge-warning" href="<?php if($myData['AccessLevel'] == 12){
                                                        echo $host;?>view-service-call/<?php echo '#'; }else{ echo $host;?>follow-up/<?php echo $act['ticketNo'];}?>" target="_blank">FOLLOW-UP</a>


                                <?php 
                                    }
                                    else
                                    {
                                ?>
                                        <a class="badge badge-info col-lg-12" data-toggle="modal" data-target=".bs-example-modal-lg-2-<?php echo $act['ticketNo'];?>">CLOSED</a>
                                <?php 
                                        }
                                ?>
                            </td>
                                <?php
                                    }
                                ?>
                            <td>
                                <?php echo $act['caseName'];?>
                            </td>
                                <?php 
                                    include($closedView);
                                ?>
                        </tr>
                    <?php
                                }
                            }
                        }
                        else
                        {
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
    <div class="tab-pane" id="tab-2">
        <div class="panel-body">

            <div class="table-responsive">

                <!--<table id="example6" style="font-size: 12px;"  class="display nowrap table  responsive nowrap table-bordered">-->
                <table id="example6" class="display  table  responsive  table-bordered" style="font-size: 12px; table-layout: fixed; word-wrap:break-word">
                    <thead>
                    <tr>
                        <th style="display: none">ID</th>
                        <th>Ticket</th>
                        <th>Account</th>
                        <th>Machine</th>
                        <th>Engineer</th>
                        <th>Open Date</th>
                        <th>Issues</th>
                        <th>Contract Type</th>
                        <th>Cost</th>
                        <th>Closed By</th>
                        <th style="width:20%">Work Done</th>
                        <th>Closed Date</th>
                        <th>Closed By</th>
                    </tr>
                    </thead>
                    <tbody> 
                <?php
                    if($serviceCalls != null)
                    {
                        foreach($serviceCalls as $act)
                        {
                            $followUps = $database->getFollowUps($act['callID'], 1);
                            if ($act['closedBy'] > 0)
                            {
                ?>
                                <tr>
                                    <td style="display:none">
                                        <?php echo str_pad($act['id'],5,"0",STR_PAD_LEFT);?>
                                    </td>
                                    <td>
                                        <a href="<?php echo $host;?>ticket-info/<?php echo $act['ticketNo']?>" target="_blank"><?php echo strtoupper($act['ticketNo']);?>
                                        </a>
                                    </td>
                                    <td><?php echo $act['AccountName'];?></td>
                                    <td><a href="<?php echo $host;?>machine-info/<?php echo $act['MachineID']?>"><?php echo $act['machine_code'];?></a></td>
                                    <td>
                                        <?php 
                                            echo $database->getMyUserInformation($act['engineer'])['fullname'] ?>
                                    </td>
                                    <td><?php echo  date('d/m/Y', $act['openedTimeStamp']);?></td>
                                    <td>
                                        <?php 
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
                                    <td> 
                                        <span class="badge badge-<?php if($act['paymentStatus']=='PAID'){echo 'success';}else if($act['paymentStatus']=='UNPAID'){echo 'danger';}else{ echo 'info';}?> col-lg-12">
                                                 <?php echo $act['paymentStatus'];?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                            echo $cost = $act['cost'] == '0' || $act['cost'] == '000' ? '₦0' : $database->convertToMoney($act['cost']) ;
                                        ?>
                                    </td>
                                    <td>
                                        <?php if($act['closedBy'] == 0){?>
                                            <a class="badge badge-warning" href="<?php echo $host;?>follow-up/<?php echo $act['ticketNo'];?>" target="_blank">FOLLOW-UP</a>

                                        <?php 
                                            }
                                            else
                                            {
                                        ?>
                                            <a class="badge badge-info col-lg-12" data-toggle="modal" data-target=".bs-example-modal-lg-2-<?php echo $act['ticketNo'];?>">CLOSED</a>
                                        <?php }?>
                                    </td>
                                    <!--<td><?php echo $act['caseName'];?></td>-->
                                    <td>
                                        <?php echo UtilFunctions::textSummary($followUps[0]['work-done']);?>
                                    </td>
                                    <!--<?php echo $act['closedDateTime'];?></td>-->
                                    <td><?php echo  date('d/m/Y', $act['closedTimeStamp']);?></td>
                                    <!--<td><?php echo $database->time_space($act['closedTimeStamp'],$act['openedTimeStamp']);?></td>-->
                                    <td><?php echo $database->getMyUserInformation($act['closedBy'])['fullname'];?></td>

                                    <?php include($closedView);?>
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
<?php
//    $footerView = file_exists('includes/footer.php') ? 'includes/footer.php' : '../includes/footer.php';
//    include $footerView;