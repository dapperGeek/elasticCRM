<?php
    include("../data/DBConfig.php");
    include_once("../data/sessioncheck.php");
    $yr_ = date("Y");
    $id = 0;

    if(!isset($_GET['id']) || $_GET['id'] == ""){
       $database->redirect_to($host."pm-view-account");
    }else{

        $id = $_GET['id'];
        $machineInfoPM  = (array)$database->getSingleMachineInformationPM($id);
        if($machineInfoPM[0] == false) {

           $machineInfo  = (array)$database->getSingleMachineInformationEmptyPM($id);

            }
        

        /*if($machineInfo == null){
            $database->redirect_to($host."view-machine");
        }*/
        
    }

if($myData['changePass'] == 0){
    //  $database->redirect_to($host."change-password");
}
?>
 <script type="text/javascript">
            var parent = <?php echo $database->getArrayAllAccounts();?>;
            var gchild = <?php echo $database->getArrayOfMachines();?>;

            function LoadChild() {
                var i = document.getElementById("parent").selectedIndex;
                var dp2 = document.getElementById("gchild");
                var count2 = gchild[i - 1].length;

                var html2 = "<option value=\"\" disabled selected hidden>- select -</option>";
                for (var k = 0; k < count2; k++) {
                    html2 += "<option value=\"" + gchild[i - 1][k][0] + "\">" + gchild[i - 1][k][1] + "</option>";
                }

                dp2.innerHTML = html2;
            }
        </script>
        <script type="text/javascript">
            function contractCheck() {
                var x_cost = document.getElementById("txtAmount");
                var x_machine = document.getElementById("gchild");
                var select_machine = x_machine.options[x_machine.selectedIndex].text;
                if (select_machine.indexOf("NC") + 1) {
                    x_cost.value = "10,000";
                    x_cost.disabled = false;
                } else {
                    x_cost.value = "0";
                    x_cost.disabled = true;
                }
                //x.disabled=(aList.selectedIndex == 0);
            }

            function init() {
                document.getElementById("txtMachine").selectedIndex = 1;
            }
        </script>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Update New Preventive Maintenance Call</title>
        <!-- Bootstrap -->
        <link href="<?php echo $host;?>assets/css/morris.css" rel="stylesheet">
        <!-- Bootstrap -->
        <link href="<?php echo $host;?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $host;?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" type="text/css" href="<?php echo $host;?>assets/css/select2.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $host;?>assets/css/bootstrap-select.min.css" />
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
        <link href="<?php echo $host;?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
            <!-- Ion Range Slider -->
    <link rel="stylesheet" href="<?php echo $host;?>assets/css/normalize.css" />
    <link rel="stylesheet" href="<?php echo $host;?>assets/css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="<?php echo $host;?>assets/css/ion.rangeSlider.skinFlat.css" />

    <link href="<?php echo $host;?>assets/css/skins/all.css" rel="stylesheet">


        <!-- slimscroll -->

        <!--[if lt IE 9]> <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
        <!--[if lt IE 9]> <script src="dist/html5shiv.js"></script> <![endif]-->
    </head>
    <?php include("../includes/header_.php");?>
        <?php
                            if(isset($_POST['btnRegisterCall'])){

                                $accountID = $database->test_input($_POST['txtAccount']);

                                $machineID = $database->test_input($_POST['txtMachine']);
                                

                            if(isset($_POST['txtPmId'])){
                                $pmID = $database->test_input($_POST['txtPmId']);
                            }else{
                                $pmID = false;
                            }

                                $MIF_id = $database->test_input($_POST['txtMIF_id']);

                                

                                
                               // var_dump($machineID);
                               // exit;
                               // $reportedBy = $database->test_input($_POST['txtReporter']);
                                $eng = $database->test_input($_POST['txtEngineer']);

                                $meterReadingMono = $database->test_input($_POST['txtMeterReadingMono']);

                                $meterReadingColor = $database->test_input($_POST['txtMeterReadingColor']);


                                $schDD = $database->test_input($_POST['txtSchDate']);
                                $schD = explode("/",$schDD);
                                $schDateString = explode(" ",$schD[0]);
                                //$birthday = '17 July 2019'; 
                                $nextSchDate = date("d-m-Y", strtotime($schD[0]. "+ 3 months"));
                                //var_dump($nextSchDate);  // "17-10-2019"
                                //exit;
                                $date=date_create($nextSchDate);
                                //$nextSchDateExploded = explode("-", $nextSchDate);
                                //$m = date("F", mktime(0, 0, 0, $nextSchDateExploded[1], 10));
                                //var_dump(date_format($date,"d F Y"));
                                $nextSchDateTxt = date_format($date,"d F Y");
                               // exit; 

                                // var_dump(date("n",strtotime($schDateString[1])));
                                

                                //$julianSchDateString = gregoriantojd(date("n",strtotime($schDateString[1])), $schDateString[0], $schDateString[2]);
                                //var_dump($julianSchDateString);
                                //exit;

                               // if($accountID != "" && $machineID != "" && $reportedBy != "" && $eng != "" && $paystatus != "" && $issues != "" && $schDD != ""){
                             if($eng != "" && $schDD != ""){
                                     $msg = $database->createPreventiveMaintenanceCall($MIF_id,$accountID,$machineID,$eng,$nextSchDateTxt,$schD[0],$schD[1],$pmID,$meterReadingMono,$meterReadingColor);
                                          
                                          //var_dump($database->createTicketNoNew());

                                          //exit;
                                     
                                     unset($_POST);

                                     /*$lastServiceCallEntry = (array)$database->getLastServiceCall();

                                      foreach($lastServiceCallEntry as $entry){

                                                     $lastServiceCallTicketId = $entry['ticketNo'];
                                                 }*/
                                                 //var_dump($lastServiceCallTicketId);
                                                 
                                     //header("location:Delivery_form.php?cnno=".$cnno."&copies=".$nocopy);
                                     // header("location:".$this->host."ticket-info/".$lastServiceCallTicketId);
                                     //            echo "<script type=\"text/javascript\">
                                      //   window.open('".$host."ticket-info/".$lastServiceCallTicketId."', '_blank')
                                      //     </script>";

                                           //header("location:".$host."view-service-call");

                                          // exit;


                                }else{
                                   $err = 'All fields are required to create a preventive maintenance call';
                                }

                                $database->redirect_to($host."pm-view-account-details/".$accountID);

                            }

                        ?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="row wrapper border-bottom page-heading">
                        <div class="col-lg-12">
                            <h2> Preventive Maintenance Call  </h2>
                            <ol class="breadcrumb">
                                <li> <a href="index-2.html">Home</a> </li>
                                <li> <a>Account</a> </li>
                                <li class="active"> <strong>Update New Preventive Maintenance Call </strong> </li>
                            </ol>
                        </div>
                    </div>
                    <div class="wrapper-content ">

                        <form method="post" class="form-horizontal">
                            <div class="row">
                             <div class="col-lg-9 top20 bottom20 col-sm-offset-1">
                                    <div class="widgets-container">
                                         <div class="panel panel-primary">
                      <div class="panel-heading">Update New Preventive Maintenance Call </div>
                      <div class="panel-body">
                              <?php 

                               

                              if(isset($err) && $err != ""){$database->showMsg('',$err,1);}?>
                                            <?php if(isset($msg) && $msg != ""){$database->showMsg('',$msg,2);}?>

                                       

                                             <?php  //var_dump($machineInfoPM);

                                                
                                            // if($machineInfo != null){
                                             if($machineInfoPM[0] != false) {
                                             
                                              foreach($machineInfoPM as $machInfo){

                                                
                                                ?>
                                     <div class="form-group">
                                            <label class="col-sm-2 control-label">ACCOUNT:</label>
                                            <div class="col-sm-10">
                                          
                                          <?php      echo $machInfo['Name']."/".$machInfo['account_id'];  ?>

                                    <input  class="form-control m-b" name="txtAccount" value="<?php echo $machInfo['account_id'];?>" type="hidden">
                                    <input  class="form-control m-b" name="txtPmId" value="<?php echo $machInfo['pm_id'];?>" type="hidden">
                                    <input  class="form-control m-b" name="txtMIF_id" value="<?php echo $machInfo['id'];?>" type="hidden">
                                        </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">MACHINE:</label>
                                            <div class="col-sm-10">

                                             <?php   echo $machInfo['productName'].' / '. $machInfo['machine_code'] ;  ?>
                                             <input class="form-control m-b" name="txtMachine" value="<?php echo $machInfo['machine_type'];?>" type="hidden" >
                                               </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">LAST SCHEDULED PREVENTIVE MAINTENANCE VISIT DATE:</label>
                                            <div class="col-sm-10">
                                               <?php   echo $machInfo['scheduleDate'];  ?>
                                                
                                               </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-sm-2 control-label">LAST ACTUAL VISIT DATE:</label>
                                            <div class="col-sm-10">
                                               </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">NEW SCHEDULED PREVENTIVE MAINTENANCE VISIT DATE:</label>
                                            <div class="col-sm-10">


                                              <?php  if(isset($machInfo['NextScheduledDateTime']) ){

                                                echo $machInfo['NextScheduledDateTime'];  

                                              } else{

                                                        echo " ";
                                                       }
                                                     ?>
                                               </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">LAST METER READING MONO</label>
                                            <div class="col-sm-10">


                                              <?php  if(isset($machInfo['meterReadingMono']) ){

                                                echo $machInfo['meterReadingMono'];  

                                              } else{

                                                        echo " ";
                                                       }
                                                     ?>
                                               </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">LAST METER READING COLOR</label>
                                            <div class="col-sm-10">


                                              <?php  if(isset($machInfo['meterReadingColour']) ){

                                                echo $machInfo['meterReadingColour'];  

                                              } else{

                                                        echo " ";
                                                       }
                                                     ?>
                                               </div>
                                        </div>

                                       

                                        
                                        <hr>
                                       

                                        

                                        

                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">ENGINEER:</label>
                                            <div class="col-lg-10">
                                                 <select class="form-control m-b" name="txtEngineer" required data-validation-required-message="engineer is required">
                                                            <option value="">- SELECT -</option>
                                                            <?php
                                                                                                        $engs = (array)$database->getAllEngineers();
                                                                                                            foreach($engs as $eng){

                                                                                                    ?>
                                                                <option value="<?php echo $eng['id'];?>" <?php if(isset($_POST['txtEngineer']) && $_POST['txtEngineer'] == $eng['id']){echo "selected";}?>><?php echo $eng['fullname']; ?></option>

                                                                <?php } ?>

                                                        </select>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">NEW METER READING MONO</label>
                                            <div class="col-sm-10">
                                             <input type="text" class="form-control m-b" name="txtMeterReadingMono" required data-validation-required-message="Mono Meter Reading is Required">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">NEW METER READING COLOR</label>
                                            <div class="col-sm-10">
                                             <input type="text" class="form-control m-b" name="txtMeterReadingColor" required data-validation-required-message="Color Meter Reading is Required">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">ACTUAL VISIT DATE:</label>
                                            <div class="input-group date form_datetime col-lg-9" data-date="<?php echo date('Y')?>-<?php echo date('m')?>-<?php echo date('d')?>T10:25:07Z" data-date-format="dd MM yyyy / HH:ii p" data-link-field="dtp_input1">
                                                <input class="form-control" name="txtSchDate" size="16" type="text" value="<?php if(isset($_POST['txtSchDate'])){echo $_POST['txtSchDate'];}?> " required="required" readonly>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                            </div>
                                            <input type="hidden" id="dtp_input1" value="" />

                                        </div>
                                        <?php    
                                               } } else if($machineInfo[0] != false) {
                                             // var_dump($machineInfo);
                                              //exit;
                                              foreach($machineInfo as $machInfo){

                                     ?>
                                     <div class="form-group">
                                            <label class="col-sm-2 control-label">ACCOUNT:</label>
                                            <div class="col-sm-10">
                                               
                                               <?php echo $machInfo['Name']."/".$machInfo['account_id'];  ?>


                                            
                                        
                                              <input  class="form-control m-b" name="txtAccount" value="<?php echo $machInfo['account_id'];?>" type="hidden">
                                    <!--<input  class="form-control m-b" name="txtPmId" value="<?php echo $machInfo['pm_id'];?>" type="hidden">-->
                                    <input  class="form-control m-b" name="txtMIF_id" value="<?php echo $machInfo['id'];?>" type="hidden">
                                        </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">MACHINE:</label>
                                            <div class="col-sm-10">

                                             <?php   echo $machInfo['productName'].' / '. $machInfo['machine_code'] ;  ?>
                                             <input class="form-control m-b" name="txtMachine" value="<?php echo $machInfo['machine_type'];?>" type="hidden" >
                                               </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">LAST SCHEDULED PREVENTIVE MAINTENANCE VISIT DATE:</label>
                                            <div class="col-sm-10">
                                               <?php   //echo $machInfo['scheduleDate'];  ?>
                                                
                                               </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">NEW SCHEDULED PREVENTIVE MAINTENANCE VISIT DATE:</label>
                                            <div class="col-sm-10">
                                               </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">LAST ACTUAL VISIT DATE:</label>
                                            <div class="col-sm-10">
                                               </div>
                                        </div>

                                        
                                        <!--<hr> -->
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">LAST METER READING MONO</label>
                                            <div class="col-sm-10">


                                              <?php  if(isset($machInfo['meterReadingMono']) ){

                                                echo $machInfo['meterReadingMono'];  

                                              } else{

                                                        echo " ";
                                                       }
                                                     ?>
                                               </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">LAST METER READING COLOR</label>
                                            <div class="col-sm-10">


                                              <?php  if(isset($machInfo['meterReadingColour']) ){

                                                echo $machInfo['meterReadingColour'];  

                                              } else{

                                                        echo " ";
                                                       }
                                                     ?>
                                               </div>
                                        </div>

                                       

                                        

                                        

                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">ENGINEER:</label>
                                            <div class="col-lg-10">
                                                 <select class="form-control m-b" name="txtEngineer" required data-validation-required-message="engineer is required">
                                                            <option value="">- SELECT -</option>
                                                            <?php
                                                                                                        $engs = (array)$database->getAllEngineers();
                                                                                                            foreach($engs as $eng){

                                                                                                    ?>
                                                                <option value="<?php echo $eng['id'];?>" <?php if(isset($_POST['txtEngineer']) && $_POST['txtEngineer'] == $eng['id']){echo "selected";}?>><?php echo $eng['fullname']; ?></option>

                                                                <?php } ?>

                                                        </select>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">NEW METER READING MONO</label>
                                            <div class="col-sm-10">
                                             <input type="text" class="form-control m-b" name="txtMeterReadingMono" required data-validation-required-message="Mono Meter Reading is Required">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">NEW METER READING COLOR</label>
                                            <div class="col-sm-10">
                                             <input type="text" class="form-control m-b" name="txtMeterReadingColor" required data-validation-required-message="Color Meter Reading is Required">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">ACTUAL VISIT DATE:</label>
                                            <div class="input-group date form_datetime col-lg-9" data-date="<?php echo date('Y')?>-<?php echo date('m')?>-<?php echo date('d')?>T10:25:07Z" data-date-format="dd MM yyyy / HH:ii p" data-link-field="dtp_input1">
                                                <input class="form-control" name="txtSchDate" size="16" type="text" value="<?php if(isset($_POST['txtSchDate'])){echo $_POST['txtSchDate'];}?> " required="required" readonly>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                            </div>
                                            <input type="hidden" id="dtp_input1" value="" />

                                        </div>



                                     <?php

                                             }  }

                                     ?>
                                        <hr>

                                        <div class="form-group">
                                            <div class="col-lg-12 col-sm-offset-2">

                                                <button class="btn aqua" name="btnRegisterCall" class="btn btn-success col-lg-12">PROCESS PREVENTIVE MAINTENANCE CALL</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                  </div>

                            </div>

                        </form>
                    </div>
                  
            </div>
            <!-- Go top -->
            <a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>
            <<a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>
                <!-- Go top -->
                <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
                <script src="<?php echo $host;?>assets/js/vendor/jquery.min.js"></script>
                <!-- bootstrap js -->
                <script src="<?php echo $host;?>assets/js/vendor/bootstrap.min.js"></script>
                <!-- slimscroll js -->
                <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jquery.slimscroll.js"></script>
                <script src="<?php echo $host;?>assets/js/vendor/select2.min.js"></script>
                <script src="<?php echo $host;?>assets/js/vendor/bootstrap-select.min.js"></script>
                <!-- pace js -->
                <script src="<?php echo $host;?>assets/js/vendor/pace/pace.min.js"></script>
                <!-- Sparkline -->
                <script src="<?php echo $host;?>assets/js/vendor/jquery.sparkline.min.js"></script>
                <!-- main js -->
                <script src="<?php echo $host;?>assets/js/main.js"></script>
                <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/bootstrap-datetimepicker.js" charset="UTF-8"></script>
                <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
                  <script src="<?php echo $host;?>assets/js/vendor/ion.rangeSlider.js"></script>
                  <script src="<?php echo $host;?>assets/js/vendor/icheck.js"></script>

                <script type="text/javascript">
                    $(function() {

                        $("#range").ionRangeSlider({
                                min: 0,
                                max: 100
                        });

                        $('._select').select2();
                        var data = [{
                            id: 0,
                            text: 'enhancement'
                        }, {
                            id: 1,
                            text: 'bug'
                        }, {
                            id: 2,
                            text: 'duplicate'
                        }, {
                            id: 3,
                            text: 'invalid'
                        }, {
                            id: 4,
                            text: 'wontfix'
                        }];

                        $(".js-example-data-array").select2({
                            data: data
                        })

                        $(".js-example-data-array-selected").select2({
                            data: data
                        })

                        $('.selectpicker').selectpicker({
                            style: 'defaultSelectDrop',
                            size: 4
                        });

                        $('.selectpickerprimary').selectpicker({
                            style: 'btn-primary',
                            size: 4
                        });
                        $('.selectpickerinfo').selectpicker({
                            style: 'btn-info',
                            size: 4
                        });
                        $('.selectpickersuccess').selectpicker({
                            style: 'btn-success',
                            size: 4
                        });
                        $('.selectpickerwarning').selectpicker({
                            style: 'btn-warning',
                            size: 4
                        });
                        $('.selectpickerdanger').selectpicker({
                            style: 'btn-danger',
                            size: 4
                        });

                    });
                </script>
                <script type="text/javascript">
                    $('.form_datetime').datetimepicker({
                        //language:  'fr',
                        weekStart: 1,
                        todayBtn: 1,
                        autoclose: 1,
                        todayHighlight: 1,
                        startView: 2,
                        forceParse: 0,
                        showMeridian: 1
                    });
                    $('.form_date').datetimepicker({
                        language: 'fr',
                        weekStart: 1,
                        todayBtn: 1,
                        autoclose: 1,
                        todayHighlight: 1,
                        startView: 2,
                        minView: 2,
                        forceParse: 0
                    });
                    $('.form_time').datetimepicker({
                        language: 'fr',
                        weekStart: 1,
                        todayBtn: 1,
                        autoclose: 1,
                        todayHighlight: 1,
                        startView: 1,
                        minView: 0,
                        maxView: 1,
                        forceParse: 0
                    });

                    $(function() {
                        $('#datetimepicker12').datetimepicker({
                            inline: true,
                            sideBySide: true
                        });

                        $('input[name="daterange"]').daterangepicker();

                        $('input[name="dateTimeRange"]').daterangepicker({
                            timePicker: true,
                            timePickerIncrement: 30,
                            locale: {
                                format: 'MM/DD/YYYY h:mm A'
                            }
                        });

                    });
                </script>

                </body>

    </html>