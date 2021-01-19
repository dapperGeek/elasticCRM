  <?php
    include("../data/DBConfig.php");
    include_once("../data/sessioncheck.php");
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
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>View Preventive Maintenance Schedule for Machines</title>
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
          <h2>View Preventive Maintenance Schedule for <?php echo $machineInfo['Name'];?> Machines </h2>
          <ol class="breadcrumb">
            <li> <a href="index-2.html">Home</a> </li>
            <li> <a>View Account</a> </li>
            <li> <a>Accounts</a> </li>
            <li class="active"> <strong>View Machine Preventive Maintenance Status</strong> </li>
          </ol>
        </div>
        <div class="col-lg-12"> </div>
      </div>
      <div class="wrapper-content ">

      <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">

              <div class="ibox-content collapse in">
                <div class="widgets-container">  <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-1" data-toggle="tab" > PREVENTIVE MAINTENANCE SCHEDULE &nbsp;&nbsp;</a></li>
                
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab-1">
                  <div class="panel-body">

                                <div class="table-responsive">
                    <!--<table id="example7" style="font-size: 12px;"  class="display nowrap table  responsive nowrap table-bordered">-->
                        
                    <table id="example7" class="display  table  responsive  table-bordered" style="font-size: 12px;">
                       <thead>
                                            <tr>
                                                <th>Machine Code</th>
                                                <th>Address</th>
                                                
                                                <th>Serial Number</th>
                                                <th>DOI</th>
                                                <th>PM Last Visit Date </th>
                                                <th>PM Next Schedule Date</th>
                                                <!--<th>PM Actual Date </th>-->
                                                <th>Last Meter Reading Mono</th>
                                                <th>Last Meter Reading Color</th>
                                                <th>Days Delayed</th>
                                                <th>&nbsp;</th>
                                                
                                                

                                                
                                            </tr>
                                            </thead>
                                        <tbody>


                                              <?php
                                              //$machineInfo;
                                              //var_dump($machineInfo);
                                              
                                              $accMachine = (array)$database->getAllMachineForAccount($machineInfo['id']);
                                              //$accMachinePM = (array)$database->getAllMachineForAccountPM($machineInfo['id']);
                                              if($accMachine[0] != false) {

                                               $j = 0;
                                              //var_dump($accMachine);
                                              //exit;
                                              foreach($accMachine as $acm){
                                               // j++;
                                              $entryValue = $database->verifyPreventiveMaintenanceEntryForMachine($acm['id']);
                                             // var_dump($entryValue);
                                             // exit;
                                              if($entryValue === 1) {

                                              $acmPm = (array)$database->getAllMachineForAccountPM($machineInfo['id'], $acm['id']);
                                             //var_dump($acmPm);
                                              foreach($acmPm as $acmPmDetails){
                                                ?>

                                              <tr> 
                                                
                                              <td><?php  echo $acmPmDetails['machine_code']; ?></td>

                                            
                                              <td><?php  echo $acmPmDetails['Address']; ?></td>

                                              <td><?php  echo $acmPmDetails['serialNo'];?></td>

                                              <td><?php  echo $acmPmDetails['doi'];?></td>

                                              <td><?php  echo $acmPmDetails['scheduleDate']; ?></td>

                                              <td><?php 

                                                    if(isset($acmPmDetails['NextScheduledDateTime']) ){

                                                     echo $acmPmDetails['NextScheduledDateTime'];  
                                                
                                                        } else{

                                                        echo " ";
                                                       }

                                                     ?>
                                                      
                                              </td>

                                              <td><?php  echo $acmPmDetails['meterReadingMono'];?></td>

                                               <td><?php  echo $acmPmDetails['meterReadingColour'];?></td>

                                              <td><?php  echo "";?></td>

                                              <td><a class="badge badge-warning" href="<?php 
                                                     
                                                    echo $host;?>update-new-pm-visit/<?php echo $acmPmDetails['machine_in_field_id'];?>">Update New PM Visit</a></td>


                                    


                                     </tr>
                                     <?php    
                                            }  }  else {
                                            // var_dump($accMachinePM);
                                             //exit;
                                            //  foreach($accMachinePM as $acm){
                                                ?>

                                            <tr> <td><?php  echo $acm['machine_code']; ?></td>

                                            
                                              <td><?php  echo $acm['Address']; ?></td>

                                              <td><?php  echo $acm['serialNo'];?></td>

                                              <td><?php  echo $acm['doi'];?></td>

                                              <td><?php  echo ""; ?></td>

                                              <td><?php  echo " ";?></td>

                                              <td><?php  echo "";?></td>

                                               <td><?php  echo "";?></td>

                                              <!--<td><?php  echo $acm['meterReading'];?></td>-->

                                              <td><?php  echo " ";?></td>

                                              <td><a class="badge badge-warning" href="<?php 
                                                     
                                             echo $host;?>update-new-pm-visit/<?php echo $acm['id'];?>">Update New PM Visit</a></td>


                                    


                                             </tr>


                                        
                                     
                                              
                                         <?php
                                        }
                                        
                                        $j++;

                                         } 
                                               } else{
                                      ?>
                                       <tr>
                                         <td colspan="12">NO DATA FOUND</td>
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
                                        <tbody>
                                     <?php ?>
                                               <tr>
                                         <td colspan="12">NO DATA FOUND</td>
                                     </tr>
                                     <?php    ?>


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
