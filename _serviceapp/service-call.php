<?php
    include("../data/DBConfig.php");
    include_once("../data/sessioncheck.php");
    $yr_ = date("Y");

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
        <title>Make A Call</title>
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
                                $reportedBy = $database->test_input($_POST['txtReporter']);
                                $eng = $database->test_input($_POST['txtEngineer']);
                                if(isset($_POST['txtAmount'])){$cost = $database->test_input(str_replace(',','',$_POST['txtAmount']));}else{
                                   $cost = 0;
                                }
                                $CaseStatus = $database->test_input($_POST['txtCaseStatus']);

                                $paystatus = $database->test_input($_POST['txtPayStatus']);
                                $issues = "";
                                $createdBy = $user_id;

                                if(isset($_POST['issues'])){
                                    if(is_array($_POST['issues'])){
                                        foreach($_POST['issues'] as $an_issue){
                                            $issues = $issues.",".$database->test_input($an_issue);
                                        }
                                    }else{
                                        $issues = $database->test_input($_POST['issues']);
                                    }
                                }
                                $schDD = $database->test_input($_POST['txtSchDate']);
                                $schD = explode("/",$schDD);

                                if($accountID != "" && $machineID != "" && $reportedBy != "" && $eng != "" && $paystatus != "" && $issues != "" && $schDD != ""){
                                     $msg = $database->createServiceCall($accountID,$machineID,$reportedBy,$eng,$cost,$paystatus,$issues,$user_id,$CaseStatus,$schD[0],$schD[1]);
                                     unset($_POST);

                                }else{
                                   $err = 'All fields are required to create a case';
                                }

                            }

                        ?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="row wrapper border-bottom page-heading">
                        <div class="col-lg-12">
                            <h2> Service 121 Call  </h2>
                            <ol class="breadcrumb">
                                <li> <a href="index-2.html">Home</a> </li>
                                <li> <a>Account</a> </li>
                                <li class="active"> <strong>Service Call </strong> </li>
                            </ol>
                        </div>
                    </div>
                    <div class="wrapper-content ">

                        <form method="post" class="form-horizontal">
                            <div class="row">
                             <div class="col-lg-9 top20 bottom20 col-sm-offset-1">
                                    <div class="widgets-container">
                                         <div class="panel panel-primary">
                      <div class="panel-heading">Make a Call </div>
                      <div class="panel-body">
                              <?php if(isset($err) && $err != ""){$database->showMsg('',$err,1);}?>
                                            <?php if(isset($msg) && $msg != ""){$database->showMsg('',$msg,2);}?>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">ACCOUNT</label>
                                            <div class="col-sm-10">
                                               <select class="form-control m-b" id="parent" name="txtAccount" onChange="LoadChild();" required data-validation-required-message="Account is required">
                                                            <option value="" disabled selected hidden>- select -</option>
                                                            <script type="text/javascript">
                                                                // document.writeln('Parent Lenght: '+parent.lenght);
                                                                for (var i = 0; i < parent.length; i++) {
                                                                    document.write('<option value="' + parent[i][0] + '">' + parent[i][1] + '</option>');
                                                                }
                                                            </script>

                                                        </select>
                                        </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">MACHINE</label>
                                            <div class="col-sm-10">
                                               <select class="form-control m-b" name="txtMachine" required data-validation-required-message="Machine is required" id="gchild" onChange="contractCheck();">

                                                        </select></div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">REPORTED BY</label>
                                            <div class="col-sm-10">
                                             <input type="text" class="form-control m-b" name="txtReporter" value="<?php if(isset($_POST['txtReporter'])){echo $_POST['txtReporter'];}?>" required data-validation-required-message="reporter name is required">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">COST</label>
                                            <div class="col-sm-2">

                                                 <input type="text" class="form-control m-b" name="txtAmount" value="<?php if(isset($_POST['txtAmount'])){echo $_POST['txtAmount'];}?>" id="txtAmount" required data-validation-required-message="Amount is required">

                                            </div>
                                            <label class="col-sm-3 control-label">PAYMENT STATUS</label>
                                            <div class="col-sm-5">
                                                <select class="form-control m-b" name="txtPayStatus" required data-validation-required-message="select payment status">
                                                                  <?php
                                                                        $cases = (array)$database->getPaymentStatus();
                                                                        foreach($cases as $case){
                                                                     ?>

                                                         <option <?php if(isset($_POST['txtPayStatus']) &&($case['id']== $_POST['txtPayStatus'])){echo "selected";}?>><?php echo $case['pstatus'];?></option>
                                                         <?php }?>
                                                        </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">ISSUES</label>
                                            <div class="col-lg-10">
                                                <select class=" _select js-states form-control" name="issues[]" multiple="multiple">
                                                    <?php
                                                     $issues = (array)$database->getAllIssues();
                                                            foreach($issues as $issue){
                                                             $issues = explode(",",$ticket['issues']);

                                                        ?>

                                                        <option <?php if(in_array($issue['id'], $issues)){echo 'selected';}?> value="
                                                            <?php echo $issue['id']?>">
                                                                <?php echo $issue['issues'];?>
                                                        </option>

                                                        <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                             <label class="col-sm-2 control-label">CASE STATUS</label>
                                            <div class="col-sm-10">
                                                <select class="form-control m-b" name="txtCaseStatus" required data-validation-required-message="select payment status">
                                                         <?php
                                                            $cases = (array)$database->getCaseStatus();
                                                            foreach($cases as $case){
                                                                if($case['id'] > 7){break;}
                                                         ?>

                                                         <option value="<?php echo $case['id'];?>" <?php if(isset($_POST['txtCaseStatus']) &&($case['id']== $_POST['txtCaseStatus'])){echo "selected";}?>><?php echo $case['caseName'];?></option>
                                                         <?php }?>
                                                        </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">ENGINEER</label>
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
                                            <label class="col-lg-2 control-label">ScheduleDate</label>
                                            <div class="input-group date form_datetime col-lg-9" data-date="<?php echo date('Y')?>-<?php echo date('m')?>-<?php echo date('d')?>T10:25:07Z" data-date-format="dd MM yyyy / HH:ii p" data-link-field="dtp_input1">
                                                <input class="form-control" name="txtSchDate" size="16" type="text" value="<?php if(isset($_POST['txtSchDate'])){echo $_POST['txtSchDate'];}?> " required readonly>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                            </div>
                                            <input type="hidden" id="dtp_input1" value="" />

                                        </div>
                                        <hr>

                                        <div class="form-group">
                                            <div class="col-lg-12 col-sm-offset-2">

                                                <button class="btn aqua" name="btnRegisterCall" class="btn btn-success col-lg-12">PROCESS SERVICE CALL</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                  </div>

                            </div>

                        </form>
                    </div>

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