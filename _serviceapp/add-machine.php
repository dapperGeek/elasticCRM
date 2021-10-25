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
<title>Add Machine</title>
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
<!--[if lt IE 9]> <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
<!--[if lt IE 9]> <script src="dist/html5shiv.js"></script> <![endif]-->
</head>
<?php include("../includes/header_.php");?>
<script type="text/javascript">
var parent = <?php echo $database->getArrayStates();?>;
var child = <?php echo $database->getLGAofStates();?>;
var gchild = <?php echo $database->getAreasofLGA();?>;
    function LoadChild(){
        var i = document.getElementById("parent").selectedIndex ;
       // var dp = document.getElementById("child");
        var dp2 = document.getElementById("gchild");
      //  var count = child[i-1].length;
        var count2 = gchild[i-1].length;

        //var html = "<option value=\"\" disabled selected hidden>- select -</option>";
       // for(var k = 0 ; k < count ; k ++){
       //     html += "<option value=\""+child[i-1][k][0]+"\">"+child[i-1][k][1]+"</option>";
       // }

        var html2 = "<option value=\"\" disabled selected hidden>- select -</option>";
        for(var k = 0 ; k < count2 ; k ++){
            html2 += "<option value=\""+gchild[i-1][k][0]+"\">"+gchild[i-1][k][1]+"</option>";
        }

       // dp.innerHTML = html;
        dp2.innerHTML = html2;
    }

</script>
<?php
                             $msg = ""; $err = "";

                                    if(isset($_POST['btnAddMachine'])){

                                        $acc = $database->test_input($_POST['txtAccount']);
                                        $machineCode = $database->test_input($_POST['txtMachineCode']);
                                        $machineModel = $database->test_input($_POST['txtMachineType']);
                                        $machineSerialNo = $database->test_input($_POST['txtMachineSerialNo']);
                                        $contractType = $database->test_input($_POST['txtContractType']);


                                        $address = $database->test_input($_POST['txtAddress']);
                                        $state = $database->test_input($_POST['txtState']);
                                        $area = $database->test_input($_POST['txtAreaID']);
                                        $dpt = $database->test_input($_POST['txtDpt']);

                                        $contactN1 = $database->test_input($_POST['txtContactName1']);
                                        $contactP1 = $database->test_input($_POST['txtPhone1']);
                                        $contactE1 = $database->test_input($_POST['txtEmail1']);
                                        $contactD1 = $database->test_input($_POST['txtDesig1']);

                                        $contactN2 = $database->test_input($_POST['txtContactName2']);
                                        $contactP2 = $database->test_input($_POST['txtPhone2']);
                                        $contactE2 = $database->test_input($_POST['txtEmail2']);
                                        $contactD2 = $database->test_input($_POST['txtDesig2']);

                                        $contactN3 = $database->test_input($_POST['txtContactName3']);
                                        $contactP3 = $database->test_input($_POST['txtPhone3']);
                                        $contactE3 = $database->test_input($_POST['txtEmail3']);
                                        $contactD3 = $database->test_input($_POST['txtDesig3']);




                                        $doi = $database->test_input($_POST['txtInD']);
                                        $cstart = $database->test_input($_POST['txtCS']);
                                        $cend = $database->test_input($_POST['txtCE']);




                                    if($acc != "" && $machineCode != "" && $machineModel != ""  && $contractType != "")
                                    {
                                        if($database->checkMachineAvailable($machineCode)){
                                            $err = "This Machine code has been registered previously";
                                        }else{
                                            $database->createAMachine($acc,$machineCode,$machineModel,$machineSerialNo,$contractType,$doi,$cstart,$cend,$address,$area,$contactN1,$contactP1,$contactE1,$contactD1,$contactN2,$contactP2,$contactE2,$contactD2,$contactN3,$contactP3,$contactE3,$contactD3,$dpt);
                                            unset($_POST);
                                            $msg= "MACHINE HAS BEEN SUCCESSFULLY ADDED";

                                            //echo $database->showMsg("SUCCESS",$msg,2);
                                        }

                                    }else{
                                        if($acc == ""){$err .="<li>Please select an account</li>";}
                                        if($machineCode == ""){$err .="<li>Please enter machine code</li>";}
                                        if($machineModel == ""){$err .="<li>Please Select machine model</li>";}
                                        if($machineSerialNo == ""){$err .="<li>Please enter machine serial No.</li>";}
                                        if($contractType == ""){$err .="<li>Please select contract Type</li>";}
                                        if($address == ""){$err.="<li>Please enter machine address</li>";}
                                        if($state == ""){$err .="<li>Please select machine state</li>";}
                                        if($area == ""){$err .="<li>Please select area of the machine</li>";}
                                        if($inD == ""){$err .="<li>Please select Installation day</li>";}
                                        if($inM == ""){$err .="<li>Please select Installation month</li>";}
                                        if($inY == ""){$err .="<li>Please select Installation year</li>";}
                                        if($contactN1 == ""){$err .="<li>Please enter first contact person name</li>";}
                                        if($contactP1 == ""){$err .="<li>Please enter first contact person phone no.</li>";}
                                        if($contactE1 == ""){$err .="<li>Please enter first contact person email</li>";}
                                        if($contactD1 == ""){$err .="<li>Please enter first contact person designation</li>";}


                                    }



                                    }


                            ?>

<div class="page-content-wrapper animated fadeInRight">
  <div class="page-content" >
    <div class="row wrapper border-bottom page-heading">
      <div class="col-lg-12">
        <h2> Add Machine Information </h2>
        <ol class="breadcrumb">
          <li> <a href="index-2.html">Home</a> </li>
          <li> <a>Account</a> </li>
          <li class="active"> <strong>Add Machine </strong> </li>
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
                   <?php if(isset($err) && $err != ""){$database->showMsg('',$err,1);}?>
                            <?php if(isset($msg) && $msg != ""){$database->showMsg('',$msg,2);}?>
                </div>

             </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">ACCOUNT NAME</label>
                <div class="col-sm-10">
                <select class="form-control" name="txtAccount">
                                                <option value="">--select--</option>
                                                <?php
                                                     $myMachines = (array)$database->getAllAcounts();
                                                     foreach ($myMachines as $machine) {

                                                ?>
                                                    <option value="<?php echo $machine['id'];?>"
                                                    <?php if(isset($_POST['txtAccount']) && $_POST['txtAccount'] == $machine['id']){echo "selected";}?>><?php echo strtoupper($machine['Name']);?></option>
                                                <?php }?>
                                                </select></div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label">MACHINE CODE</label>
                <div class="col-sm-10">
                   <input type="text" name="txtMachineCode"
                                                value="<?php if(isset($_POST['txtMachineCode'])){ echo $_POST['txtMachineCode'];}?>" class="form-control" required>

                  <span class="help-block bottom15-none">Enter the code of the machine you want to register</span> </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label">MACHINE MODEL</label>
                <div class="col-sm-10">
                  <select class="form-control" name="txtMachineType">
                                                <option value="">--select--</option>
                                                <?php
                                                     $myMachines = (array)$database->getAllProducts();
                                                     foreach ($myMachines as $machine) {
                                                     if($machine['ProductType'] > 1){ break; }
                                                ?>
                                                    <option value="<?php echo $machine['id'];?>"
                                                    <?php if(isset($_POST['txtMachineType']) && $_POST['txtMachineType'] == $machine['id']){echo "selected";}?>><?php echo $machine['productName'];?></option>
                                                <?php }?>
                                                </select>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label">MACHINE SERIAL NO</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="txtMachineSerialNo"
                                                value="<?php if(isset($_POST['txtMachineSerialNo'])){ echo $_POST['txtMachineSerialNo'];}?>" required>
                     </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label">CONTRACT TYPE</label>
                <div class="col-sm-10">
                  <select class="form-control" name="txtContractType">
                                                <option value="">--select--</option>
                                                <?php
                                                     $myMachines = (array)$database->getAllContracts();
                                                     foreach ($myMachines as $machine) {
                                                ?>
                                                    <option value="<?php echo $machine['id'];?>"
                                                    <?php if(isset($_POST['txtContractType']) && $_POST['txtContractType'] == $machine['id']){echo "selected";}?>><?php echo $machine['contractName'];?></option>
                                                <?php }?>
                                                </select>
              </div>
              </div>
               <div class="form-group">
                <label class="col-sm-2 control-label">INTSALLATION DATE</label>
                <div class="col-sm-2">
                  <div class="input-group date form_date col-md-12" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2"
														data-link-format="yyyy-mm-dd">
														<input class="form-control" type="text" name="txtInD" value="<?php if(isset($_POST['txtInD'])){ echo $_POST['txtInD'];}?>" readonly>
														<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
													</div>
													<input type="hidden" id="dtp_input2" value="" />

              </div>
              <label class="col-sm-2 control-label">CONTRACT START</label>
                <div class="col-sm-2">
                  <div class="input-group date form_date col-md-12" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2"
														data-link-format="yyyy-mm-dd">
														<input class="form-control" type="text" name="txtCS" value="<?php if(isset($_POST['txtCS'])){ echo $_POST['txtCS'];}?>" readonly>
														<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
													</div>
													<input type="hidden" id="dtp_input2" value="" />

              </div>
              <label class="col-sm-2 control-label">CONTRACT END</label>
                <div class="col-sm-2">
                  <div class="input-group date form_date col-md-12" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2"
														data-link-format="yyyy-mm-dd">
														<input class="form-control" type="text" name="txtCE" value="<?php if(isset($_POST['txtCE'])){ echo $_POST['txtCE'];}?>" readonly>
														<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
													</div>
													<input type="hidden" id="dtp_input2" value="" />

              </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label">ADDRESS & DEPARTMENT</label>
                <div class="col-sm-5">
                 <input type="text" class="form-control" name="txtAddress" placeholder="ADDRESS"
                                                value="<?php if(isset($_POST['txtAddress'])){ echo $_POST['txtAddress'];}?>" required>
                </div>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="txtDpt" placeholder="DEPARTMENT"
                                                value="<?php if(isset($_POST['txtDpt'])){ echo $_POST['txtDpt'];}?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">STATE & L.G.A</label>
                <div class="col-sm-5">
                   <select class="form-control m-b" id="parent" name="txtState" onChange="LoadChild();" required data-validation-required-message="State is required">
                                        <option value="" disabled selected hidden>- select -</option>
                                        <script type="text/javascript">
                                            for(var i = 0 ; i < parent.length ; i ++){
                                                document.write('<option value="'+parent[i][0]+'">'+parent[i][1]+'</option>');
                                            }
                                        </script>

                                    </select>
                </div>
                <div class="col-sm-5">
                    <select class="form-control m-b" name="txtAreaID" required data-validation-required-message="area is required" id="gchild" onChange="LoadGChild();">


                                    </select>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-lg-2 control-label">CONTACT 1</label>
                <div class="col-lg-3">
                  <input type="text" name="txtContactName1"
                                                value="<?php if(isset($_POST['txtContactName1'])){ echo $_POST['txtContactName1'];}?>" class="form-control" placeHolder="Contact Name" required>

                </div>
                <div class="col-md-2">

                                                <input type="text" name="txtPhone1"
                                                value="<?php if(isset($_POST['txtPhone1'])){ echo $_POST['txtPhone1'];}?>" placeHolder="Contact Phone Number" class="form-control" required>

                                        </div>
                                         <div class="col-md-3">

                                                <input type="text" name="txtEmail1"
                                                value="<?php if(isset($_POST['txtEmail1'])){ echo $_POST['txtEmail1'];}?>" class="form-control" placeHolder="Contact Email" required>

                                        </div>
                                        <div class="col-md-2">

                                                <input type="text" name="txtDesig1"
                                                value="<?php if(isset($_POST['txtDesig1'])){ echo $_POST['txtDesig1'];}?>" placeholder="Designation" class="form-control" required>

                                        </div>
              </div>
               <div class="form-group">
                <label class="col-lg-2 control-label">CONTACT 2</label>
                <div class="col-lg-3">
                  <input type="text" name="txtContactName2"
                                                value="<?php if(isset($_POST['txtContactName2'])){ echo $_POST['txtContactName2'];}?>" class="form-control" placeHolder="Contact Name" />

                </div>
                <div class="col-md-2">

                                                <input type="text" name="txtPhone2"
                                                value="<?php if(isset($_POST['txtPhone2'])){ echo $_POST['txtPhone2'];}?>" placeHolder="Contact Phone Number" class="form-control" />

                                        </div>
                                         <div class="col-md-3">

                                                <input type="text" name="txtEmail2"
                                                value="<?php if(isset($_POST['txtEmail2'])){ echo $_POST['txtEmail2'];}?>" class="form-control" placeHolder="Contact Email" />

                                        </div>
                                        <div class="col-md-2">

                                                <input type="text" name="txtDesig2"
                                                value="<?php if(isset($_POST['txtDesig2'])){ echo $_POST['txtDesig2'];}?>" placeholder="Designation" class="form-control" />

                                        </div>
              </div>
               <div class="form-group">
                <label class="col-lg-2 control-label">CONTACT 3</label>
                <div class="col-lg-3">
                  <input type="text" name="txtContactName3"
                                                value="<?php if(isset($_POST['txtContactName3'])){ echo $_POST['txtContactName3'];}?>" class="form-control" placeHolder="Contact Name" />

                </div>
                <div class="col-md-2">

                                                <input type="text" name="txtPhone3"
                                                value="<?php if(isset($_POST['txtPhone3'])){ echo $_POST['txtPhone3'];}?>" placeHolder="Contact Phone Number" class="form-control" />

                                        </div>
                                         <div class="col-md-3">

                                                <input type="text" name="txtEmail3"
                                                value="<?php if(isset($_POST['txtEmail3'])){ echo $_POST['txtEmail3'];}?>" class="form-control" placeHolder="Contact Email" />

                                        </div>
                                        <div class="col-md-2">

                                                <input type="text" name="txtDesig3"
                                                value="<?php if(isset($_POST['txtDesig3'])){ echo $_POST['txtDesig3'];}?>" placeholder="Designation" class="form-control" />

                                        </div>
              </div>
              <hr>

              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">

                  <button class="btn aqua" type="submit" name="btnAddMachine" class="btn btn-success col-lg-12">Save changes</button>
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
<!-- slimscroll js -->
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jquery.slimscroll.js"></script>
<!-- pace js -->
<script src="<?php echo $host;?>assets/js/vendor/pace/pace.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $host;?>assets/js/vendor/jquery.sparkline.min.js"></script>
<!-- main js -->
<script src="<?php echo $host;?>assets/js/main.js"></script>
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
