  <?php
    include("../data/DBConfig.php");
    include_once("../data/sessioncheck.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>View Delivery Status</title>
<!-- morris -->
<link href="<?php echo $host;?>assets/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="<?php echo $host;?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $host;?>assets/css/responsive.dataTables.min.css" rel="stylesheet">
<link href="<?php echo $host;?>assets/css/fixedHeader.dataTables.min.css" rel="stylesheet">
<!-- Bootstrap -->
<link href="<?php echo $host;?>assets/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $host;?>assets/css/jasny-bootstrap.min.css">
<!-- slimscroll -->
<link href="<?php echo $host;?>assets/css/jquery.slimscroll.css" rel="stylesheet">
<!-- Fontes -->
<link href="<?php echo $host;?>assets/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo $host;?>assets/css/simple-line-icons.css" rel="stylesheet">
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
    <div class="page-content">
      <div class="row wrapper border-bottom page-heading">
        <div class="col-lg-12">
          <h2>Track Way Bill Status</h2>
          <ol class="breadcrumb">
            <li> <a href="">Home</a> </li>
            <li> <a>Delivery Tracker</a> </li>
            <li class="active"> <strong>Manage Tracking</strong> </li>
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
                <!--<div class="tab-pane active" id="tab-1">
                  <div class="panel-body">-->

                                <div class="table-responsive">
                    <!--<table id="example7" style="font-size: 12px;"  class="display nowrap table  responsive nowrap table-bordered">-->
                        
                    <table id="example7" class="display  table  responsive  table-bordered" style="font-size: 12px; table-layout: fixed; word-wrap:break-word">
                      <thead>
                                            <tr>
                                                <th>OrderID</th>
                                                <th>Ticket#</th>
                                                <th>Departure Date</th>
                                                <!--<th>Store</th>
                                                <th>DoneBy</th>
                                                <th>Action</th>-->
                                                <th>Destination Address</th>
                                                <th>Delivery Status</th>
                                                <th>Arrival Date</th>
                                                <th>Dispatched Store</th>
                                                 <th>VIEW/UPDATE</th>
                                                          
                                            </tr>
                                        </thead>
                                       
                                        <tbody>
                                        <?php

                                        $myOrder = (array)$database->getAllGoodsLeft3();
                                            if($myOrder != null){

                                                foreach($myOrder as $mo){


                                     ?>
                                     <tr>

                                                <td><a href="<?php echo $host;?>goods-sold-ticket/<?php echo $mo['id'];?>" target="_blank"><?php echo str_pad($mo['id'],5,"0",STR_PAD_LEFT);?></a></td>
                                                <td><?php echo $mo['TicketNo'];?></td>
                                                <td><?php echo $mo['invoiceDate'];?></td>
                                                <!--<td><?php echo $mo['supplierID'];?></td>
                                                <td><?php echo $mo['invoiceNo'];?></td>-->
                                                <td><?php echo $mo['FileReference'];?></td>
                                                <td><?php echo $mo['deliveryStatus'];?></td>
                                                <!--<td><?php echo $mo['invoiceDate'];?></td>-->
                                                <td><?php echo " ";?></td>
                                                <td><?php echo $mo['storeName'];?></td>
                                                <td> <a href="<?php echo $host;?>update-way-bill/<?php echo $mo['id'];?>"><i class="fa fa-plus-o"></i> UPDATE WAY BILL  </a></td>
                                                <!--<td><?php echo $mo['transType'];?></td>-->

                                    </tr>

                                     <?php } ?>

                                     <?php }else{?>
                                          <tr>
                                       <td colspan="8">NO ORDER  YET</td>

                                    </tr>
                                     <?php } ?>

                                        </tbody>
                    </table>
                  </div>


                  <!--</div>
                </div>-->
               

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

                "pageLength": 20, 

                 "order": [[ 0, "desc" ]]
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
