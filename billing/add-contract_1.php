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
<title>Add Contracts</title>
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
<!-- icheck -->
<link href="<?php echo $host;?>assets/css/skins/all.css" rel="stylesheet">
    <link href="<?php echo $host;?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    	<link rel="stylesheet" type="text/css" href="<?php echo $host;?>assets/css/select2.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $host;?>assets/css/bootstrap-select.min.css" />


<!--[if lt IE 9]> <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
<!--[if lt IE 9]> <script src="dist/html5shiv.js"></script> <![endif]-->
</head>
<?php include("../includes/header_.php");?>
<script type="text/javascript">
            var parent = <?php echo $database->getArrayAllAccounts();?>;
            var gchild = <?php echo $database->getArrayOfMachines();?>;

            function LoadChild() {
                var i = document.getElementById("parent").selectedIndex;
                var dp2 = document.getElementById("gchild");
                var count2 = gchild[i - 1].length;

                var html2 = "";
                for (var k = 0; k < count2; k++) {
                    html2 += "<option value=\"" + gchild[i - 1][k][0] + "\">" + gchild[i - 1][k][1] + "</option>";
                }

                dp2.innerHTML = html2;
            }
        </script>
<?php
                             $msg = ""; $err = "";

    if(isset($_POST['btnCreateContract']))
    {
                                        $accID = $database->test_input($_POST['txtAccount']);
                                        $machineID = $_POST['txtMachine'];
                                        $rentalCharge = $database->test_input($_POST['txtRentalCharge']);
                                        $contractType = $database->test_input($_POST['txtContractType']);
                                        $cummul = $database->test_input($_POST['txtContractType2']);
                                        $volmono = $database->test_input($_POST['txtVolMono']);
                                        $costmono = $database->test_input($_POST['txtCostMono']);
                                        $excostmono = $database->test_input($_POST['txtExCostMono']);
                                        $exvolmono = $database->test_input($_POST['txtExVolMono']);
                                        $volcolor = $database->test_input($_POST['txtVolColor']);
                                        $costcolor = $database->test_input($_POST['txtCostColor']);
                                        $excostcolor = $database->test_input($_POST['txtExCostColor']);
                                        $exvolcolor = $database->test_input($_POST['txtExVolColor']);

                                        $duration = $database->test_input($_POST['txtContractDuration']);
                                        $cs = $database->test_input($_POST['txtCS']);
                                        $billingType = $database->test_input($_POST['txtBillingType']);

                                        if($accID!= "" && $machineID != "" && $rentalCharge != "" && $contractType != "" && $volmono!= "" && $costmono != "" && $excostmono != "" && $exvolmono != ""
                                            && $volcolor != "" && $costcolor != "" && $excostcolor != "" && $exvolcolor != "" && $duration != "" && $cs != "" && $billingType!=""
        )
        {
                                            $valID = 0;
                                            $machineNames = "";
            if(isset($_POST['txtMachine']))
            {
                if (is_array($_POST['txtMachine'])) 
                {
                    foreach($_POST['txtMachine'] as $value)
                    {
                                                                $validate = $database->validateExistingMachineContract($value);
                        if($validate == 1)
                        {
                                                                    $machine_ = $database->getSingleMachineInformation($value)['machine_code'];
                                                                    $machineNames = $machineNames.", ".$machine_;
                                                                }
                                                                $valID = $valID + $validate;
                                                            }
                }
                else
                {
                                                             $validate = $database->validateExistingMachineContract($_POST['txtMachine']);
                    if($validate == 1)
                    {
                                                                    $machine_ = $database->getSingleMachineInformation($_POST['txtMachine'])['machine_code'];
                                                                    $machineNames = $machineNames.", ".$machine_;
                                                                }
                                                             $valID = $valID + $validate;
                                                          }
                                                    }

            if($valID > 0)
            {
                                                        $err = $machineNames." has already been registered for a contract previously";
            }
            else
            {
                                                        $countValue = count($_POST['txtMachine']);
                                                        $c_volmono = $countValue * $volmono;
                                                        $c_volcolor = $countValue * $volcolor;
                                                        $c_exvolmono = $countValue * $exvolmono;
                                                        $c_exvolcolor = $countValue * $exvolcolor;
                                                        $contractID = $database->createContractTicket($accID,$contractType,$costmono,$c_volmono,$costcolor,$c_volcolor,$c_exvolmono,$excostmono,$c_exvolcolor,$excostcolor,$duration,$billingType,$cs,$cummul);

                if (is_array($_POST['txtMachine']))
                {
                    foreach($_POST['txtMachine'] as $value)
                    {
                                                                    $database->inputMachineContract($contractID,$accID,$value,$rentalCharge,$costmono,$volmono,$costcolor,$volcolor,$exvolmono,$excostmono,$exvolcolor,$excostcolor,$duration,$billingType);
                                                                }
                }
                else
                {
                                                                    $database->inputMachineContract($contractID,$accID,$_POST['txtMachine'],$rentalCharge,$costmono,$volmono,$costcolor,$volcolor,$exvolmono,$excostmono,$exvolcolor,$excostcolor,$duration,$billingType);
                                                          }
                                                          $msg= "CONTRACT SUCCESSFULLY CREATED";
                                                          unset($_POST);
                                                    }
        }
        else
        {
                                            $err = "ALL FIELDS ARE REQUIRED";
                                        }
                                       }
                            ?>

<div class="page-content-wrapper animated fadeInRight">
  <div class="page-content" >
    <div class="row wrapper border-bottom page-heading">
      <div class="col-lg-12">
        <h2>Create Contract </h2>
        <ol class="breadcrumb">
          <li> <a href="index-2.html">Home</a> </li>
          <li> <a>Billing</a> </li>
          <li class="active"> <strong>Add New Contract </strong> </li>
        </ol>
      </div>
    </div>
    <div class="wrapper-content ">
      <div class="row">
        <div class="col-lg-12 top20 bottom20">
          <div class="widgets-container">
            <form method="post" class="form-horizontal">
             <div class="form-group">
                  <label class="col-sm-2 control-label">&nbsp;</label>
                 <div class="col-sm-10">
                <?php 
                    if(isset($err) && $err != ""){$database->showMsg('',$err,1);}
                    if(isset($msg) && $msg != ""){$database->showMsg('',$msg,2);}
                ?>
                </div>
             </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">ACCOUNT NAME</label>
                <div class="col-sm-10">
                                       <select class="form-control m-b" id="parent" name="txtAccount" onChange="LoadChild();" required data-validation-required-message="Account is required">
                                                            <option value="" disabled selected hidden>- select -</option>
                                                            <script type="text/javascript">
                                                                // document.writeln('Parent Lenght: '+parent.lenght);
            for (var i = 0; i < parent.length; i++)
            {
                                                                    document.write('<option value="' + parent[i][0] + '">' + parent[i][1] + '</option>');
                                                                }
                                                            </script>
                                                        </select>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label">MACHINES</label>
                <div class="col-sm-10">
                    <select class=" _select js-states form-control" required multiple="multiple" name="txtMachine[]" required data-validation-required-message="Machine is required" id="gchild" onChange="contractCheck();">


                                                        </select>
                  <span class="help-block bottom15-none">Enter the code of the machine you want to register</span> </div>
              </div>
              <hr>

              <div class="form-group">
                <label class="col-sm-2 control-label">CONTRACT TYPE</label>
                <div class="col-sm-2">
                  <select class="form-control" name="txtContractType">
                                                <option value="">--select--</option>
                                                <?php
                                                     $myMachines = (array)$database->getAllContracts();
                                 foreach ($myMachines as $machine)
                                 {
                                                ?>
                                                    <option value="<?php echo $machine['id'];?>"
                                <?php if(isset($_POST['txtContractType']) && $_POST['txtContractType'] == $machine['id']){echo "selected";}?>>
                                    <?php echo $machine['c_name'];?>
                        </option>
                                                <?php }?>
                                                </select>
              </div>
              <label class="col-sm-2 control-label">TYPE 2</label>
                <div class="col-sm-2">
                  <select class="form-control" name="txtContractType2">
                                                <option value="0">INDIVIDUAL BILLING</option>
                                                <option value="1">CUMMULATIVE BILLING</option>
                                                </select>
              </div>
               <label class="col-sm-2 control-label">RENTAL CHARGE</label>
                                   <div class="col-sm-2">

                                       <input type="text" placeholder="AMOUNT" onKeyPress="return isNumberKey(event)" value="<?php if(isset($_POST['txtRentalCharge'])){echo $_POST['txtRentalCharge'];}else{echo "0.00";} ?>" name="txtRentalCharge" class="form-control" onkeyup = "javascript:this.value=Comma

(this.value);" required />
                                       </div>
              </div> <hr/>
              <div class="form-group">

                                     <label class="col-sm-2 control-label">MIN-VOL-MONO</label>
                                   <div class="col-sm-2">
                                   <input type="text" placeholder="volume" onKeyPress="return isNumberKey(event)" name="txtVolMono" value="<?php if(isset($_POST['txtVolMono'])){echo $_POST['txtVolMono'];}else{echo "0";} ?>" class="form-control" required />


                                    </div>
                                    <label class="col-sm-2 control-label">COST-MONO</label>
                                   <div class="col-sm-2">
                                    <input type="text" placeholder="AMOUNT" onkeypress="return fun_AllowOnlyAmountAndDot(this.id);" value="<?php if(isset($_POST['txtCostMono'])){echo $_POST['txtCostMono'];}else{echo "0.00";} ?>" name="txtCostMono" class="form-control" onkeyup = "javascript:this.value=Comma(this.value);" required />

                                    </div>

                                    <label class="col-sm-1 control-label">TOTAL:</label>
                                     <div class="col-sm-3">
                                           <input type="text" placeholder="total" readonly="readonly" class="form-control" />


                                    </div>
                                </div>
                                <div class="form-group">

                                     <label class="col-sm-2 control-label">EXCESS-VOL-MONO</label>
                                   <div class="col-sm-2">
                                   <input type="text" placeholder="volume" onKeyPress="return isNumberKey(event)" name="txtExVolMono" value="<?php if(isset($_POST['txtExVolMono'])){echo $_POST['txtExVolMono'];}else{echo "0";} ?>" class="form-control" required />


                                    </div>
                                    <label class="col-sm-2 control-label">EXCESS-COST-MONO</label>
                                   <div class="col-sm-2">
                                    <input type="text" placeholder="AMOUNT" onkeypress="return fun_AllowOnlyAmountAndDot(this.id);" value="<?php if(isset($_POST['txtExCostMono'])){echo $_POST['txtExCostMono'];}else{echo "0.00";} ?>" name="txtExCostMono" class="form-control" onkeyup = "javascript:this.value=Comma(this.value);" required />

                                    </div>

                                    <label class="col-sm-1 control-label"></label>
                                     <div class="col-sm-3">

                                    </div>
                                </div>
                                <hr/>
                        <div class="form-group">
                             <label class="col-sm-2 control-label">MIN-VOL-COLOR</label>
                                   <div class="col-sm-2">
                                   <input type="text" placeholder="volume" value="<?php if(isset($_POST['txtVolColor'])){echo $_POST['txtVolColor'];}else{echo "0";} ?>" onKeyPress="return isNumberKey(event)" name="txtVolColor" class="form-control" required />


                                    </div>
                                <label class="col-sm-2 control-label">COST-COLOR</label>
                                   <div class="col-sm-2">
                                    <input type="text" placeholder="AMOUNT" value="<?php if(isset($_POST['txtCostColor'])){echo $_POST['txtCostColor'];}else{echo "0.00";} ?>" onkeypress="return fun_AllowOnlyAmountAndDot(this.id);" name="txtCostColor" class="form-control" onkeyup = "javascript:this.value=Comma(this.value);" required />

                                    </div>
                                    <label class="col-sm-1 control-label">TOTAL:</label>
                                     <div class="col-sm-3">
                                        <input type="text" placeholder="total" readonly="readonly" class="form-control" />
                                    </div>
                                </div>
                                  <div class="form-group">
                             <label class="col-sm-2 control-label">EXCESS-VOL-COLOR</label>
                                   <div class="col-sm-2">
                                   <input type="text" placeholder="volume" value="<?php if(isset($_POST['txtExVolColor'])){echo $_POST['txtExVolColor'];}else{echo "0";} ?>" onKeyPress="return isNumberKey(event)" name="txtExVolColor" class="form-control" required />


                                    </div>
                                <label class="col-sm-2 control-label">EXCESS-COST-COLOR</label>
                                   <div class="col-sm-2">
                                    <input type="text" placeholder="AMOUNT" value="<?php if(isset($_POST['txtExCostColor'])){echo $_POST['txtExCostColor'];}else{echo "0.00";} ?>" onkeypress="return fun_AllowOnlyAmountAndDot(this.id);" name="txtExCostColor" class="form-control" onkeyup = "javascript:this.value=Comma(this.value);" required />

                                    </div>
                                    <label class="col-sm-1 control-label">TOTAL:</label>
                                     <div class="col-sm-3">


                                    </div>
                                </div>
                                <hr/>

               <div class="form-group">
                <label class="col-sm-2 control-label">CONTRACT DURATION</label>
                <div class="col-sm-2">
                  <select class="form-control m-b" name="txtContractDuration">
                                         <?php for($i = 1;$i <12;$i++){?>
                                         <option value="<?php echo $i;?>" <?php if(isset($_POST['txtContractDuration']) && $_POST['txtContractDuration']==$i){echo "selected";} ?>><?php echo strtoupper($database->convert_number_to_words($i));?> YEARS</option>
                                         <?php }?>
                                         </select>

              </div>
              <label class="col-sm-2 control-label">CONTRACT START</label>
                <div class="col-sm-2">
                  <div class="input-group date form_date col-md-12" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2"
                                                        data-link-format="yyyy-mm-dd">
                                                        <input class="form-control" type="text" name="txtCS" value="<?php if(isset($_POST['txtCS'])){ echo $_POST['txtCS'];}?>" required="required" readonly>
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                    </div>
                                                    <input type="hidden" id="dtp_input2" value="" />

              </div>
              <label class="col-sm-2 control-label">BILLING TYPE</label>
                <div class="col-sm-2">
                  <select class="form-control m-b" name="txtBillingType">

                                       <?php
                                            $bt = (array)$database->getBillingType();
                                            foreach ($bt as $bts) {
                                               ?>

                                         <option value="<?php echo $bts['value'];?>" <?php if(isset($_POST['txtBillingType']) && $_POST['txtBillingType']==$i){echo "selected";} ?>><?php echo $bts['BillingType'];?></option>

                                         <?php }?>
                                         </select>

              </div>
              </div>

              <hr>


             <div class="form-group">
                                <label class="col-sm-2 control-label">&nbsp;</label>
                                    <div class="col-sm-10">
                                    	 <button name="btnCreateContract" class="btn btn-primary col-lg-12" type="submit">
                                         <i class="fa fa-user"></i>&nbsp;Create Contract</button>

                                    </div>
                                </div>
            </form>
          </div>
        </div>
        <!--All form elements  End -->
      </div>
    </div>

  </div>
</div>
<!-- Go top -->
<a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>
<!-- Go top -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<script src="<?php echo $host;?>assets/js/vendor/jquery.min.js"></script>
<script src="<?php echo $host;?>assets/js/vendor/validator.js"></script>
<!-- icheck -->
<script src="<?php echo $host;?>assets/js/vendor/icheck.js"></script>
<!-- bootstrap js -->
<script src="<?php echo $host;?>assets/js/vendor/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jquery.slimscroll.js"></script>
	<script src="<?php echo $host;?>assets/js/vendor/select2.min.js"></script>
	<script src="<?php echo $host;?>assets/js/vendor/bootstrap-select.min.js"></script>

<!-- pace js -->
<script src="<?php echo $host;?>assets/js/vendor/pace/pace.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $host;?>assets/js/vendor/jquery.sparkline.min.js"></script>
<!-- main js -->
<script src="<?php echo $host;?>assets/js/main.js"></script>
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
<script src="<?php echo $host;?>assets/js/vendor/ion.rangeSlider.js"></script>

	<script src="<?php echo $host;?>assets/js/main.js"></script>
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
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/bootstrap-datetimepicker.js" charset="UTF-8"></script>
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
                       // language: 'fr',
                        weekStart: 1,
                        todayBtn: 1,
                        autoclose: 1,
                        todayHighlight: 1,
                        startView: 2,
                        minView: 2,
                        forceParse: 0
                    });
                    $('.form_time').datetimepicker({
                       // language: 'fr',
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
                <script type="text/javascript">
        $(function() {
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

<script>
 $(function () {
  $('#myForm').validator();
});

  $(document).ready(function(){
            var callbacks_list = $('.demo-callbacks ul');
            $('input.iCheck').on('ifCreated ifClicked ifChanged ifChecked ifUnchecked ifDisabled ifEnabled ifDestroyed', function(event){
              callbacks_list.prepend('<li><span>#' + this.id + '</span> is ' + event.type.replace('if', '').toLowerCase() + '</li>');
            }).iCheck({
               checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
              increaseArea: '20%'
            });
          });

</script>
</body>
</html>
