  <?php
    include("../data/DBConfig.php");
    include_once("../data/sessioncheck.php");

?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from adminui-v1.0.bittyfox.com/default/aqua-black/alerts_Modal_Tooltip.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Jul 2017 15:58:53 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>View Service Call</title>
<!-- morris -->
<link href="<?php echo $host;?>assets/css/morris.css" rel="stylesheet">
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
<?php include("../includes/header_.php");?>

    <!-- End page sidebar wrapper -->
    <!-- Start page content wrapper -->
    <div class="page-content-wrapper">
        <div class="page-content" >
            <div class="row wrapper border-bottom page-heading">
                <div class="col-lg-12">
                        <h2>View Service Call1 23 </h2>
                        <ol class="breadcrumb">
                            <li> <a href="index-2.html">Home</a> </li>
                            <li> <a> Administrative</a> </li>
                            <li class="active"> <strong>Service Call</strong> </li>
                        </ol>
                    </div>
            </div>
            <div class="wrapper-content ">
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
                                        $activities = (array)$database->getAllServiceCall();
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

<!-- start footer -->
        <div class="footer">

                <div> <strong>Copyright</strong> Elastic 25 &copy; <?php echo date('Y');?> </div>
            </div>
        </div>
    </div>
</div>
<!-- Go top -->
<a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>
<!-- Go top -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="assets/js/vendor/jquery.min.js"></script>
<!-- bootstrap js -->
<script src="assets/js/vendor/bootstrap.min.js"></script>
<!-- slimscroll js -->
<script type="text/javascript" src="assets/js/vendor/jquery.slimscroll.js"></script>
<!-- pace js -->
<script src="assets/js/vendor/pace/pace.min.js"></script>
<!-- Sparkline -->
<script src="assets/js/vendor/jquery.sparkline.min.js"></script>
<!-- main js -->
<script src="assets/js/main.js"></script>
</body>

<!-- Mirrored from adminui-v1.0.bittyfox.com/default/aqua-black/alerts_Modal_Tooltip.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Jul 2017 15:58:53 GMT -->
</html>
