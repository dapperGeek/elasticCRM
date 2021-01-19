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
<title>Add Machine to WorkShop</title>
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


///////////////////////////////////////////////////////////


</script>



<?php
                             $msg = ""; $err = "";

                                    if(isset($_POST['btnAddMachine'])){

                                        $acc = $database->test_input($_POST['txtAccount']);
                                        $machineCode = $database->test_input($_POST['txtMachineCode']);
                                        $machineModel = $database->test_input($_POST['txtMachineType']);
                                        $machineSerialNo = $database->test_input($_POST['txtMachineSerialNo']);
                                        $meterReading = $database->test_input($_POST['txtMeterReading']);
                                        $category = $database->test_input($_POST['txtContractType']);
                                        //$fault = $database->test_input($_POST['txtWorkDone']);
                                        $engineer = $database->test_input($_POST['txtEngineer']);
                                         $reportedBy = $database->test_input($_POST['txtReporter']);

                                        $doi = $database->test_input($_POST['txtInD']);
                                       



                                    if($acc != "" && $machineCode != "" && $machineModel != ""  && $category != "" && $engineer !== "")
                                    {
                                        if($database->checkMachineAvailableInworkshop($machineCode)){
                                            $err = "This Machine code has been registered previously";
                                        }else{
                                            $database->createAWorkshopMachine($acc,$machineCode,$machineModel,$machineSerialNo,$category,$meterReading,$engineer,$doi,$reportedBy);
                                            unset($_POST);
                                            $msg= "MACHINE HAS BEEN SUCCESSFULLY ADDED TO WORKSHOP INVENTORY";

                                            //echo $database->showMsg("SUCCESS",$msg,2);
                                        }

                                    }else{
                                        if($acc == ""){$err .="<li>Please select an account</li>";}
                                        if($machineCode == ""){$err .="<li>Please enter machine code</li>";}
                                        if($machineModel == ""){$err .="<li>Please Select machine model</li>";}
                                        if($machineSerialNo == ""){$err .="<li>Please enter machine serial No.</li>";}
                                        if($Category == ""){$err .="<li>Please select Category </li>";}
                                        if($engineer == ""){$err.="<li>Please select engineer </li>";}
                                       
                                    

                                    }



                                    }


                            ?>

<div class="page-content-wrapper animated fadeInRight">
  <div class="page-content" >
    <div class="row wrapper border-bottom page-heading">
      <div class="col-lg-12">
        <h2> Workshop Inventory </h2>
        <ol class="breadcrumb">
          <li> <a href="index-2.html">Home</a> </li>
          <li> <a>Shop</a> </li>
          <li class="active"> <strong>Add Machine to workshop </strong> </li>
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
                 <div class="col-sm-6">
                   <?php if(isset($err) && $err != ""){$database->showMsg('',$err,1);}?>
                            <?php if(isset($msg) && $msg != ""){$database->showMsg('',$msg,2);}?>
                </div>

             </div>
         


                 <div class="form-group">
                <label class="col-sm-2 control-label">ACCOUNT NAME</label>
                <div class="col-sm-6">
                <select class="form-control" name="txtAccount">
                                                <option value="">--select--</option>
                                                <?php
                                                     $myMachines = (array)$database->getAllAcounts();
                                                     foreach ($myMachines as $machine) {

                                                ?>
                                                    <option value="<?php echo $machine['Name'];?>"
                                                    <?php if(isset($_POST['txtAccount']) && $_POST['txtAccount'] == $machine['Name']){echo "selected";}?>><?php echo strtoupper($machine['Name']);?></option>
                                                <?php }?>
                                                </select></div>
              </div>

              <hr>
              <div class="form-group">
                
                <label class="col-sm-2 control-label">MACHINE CODE</label>
                <div class="col-sm-6">
                   <input type="text" name="txtMachineCode"
                                                value="<?php if(isset($_POST['txtMachineCode'])){ echo $_POST['txtMachineCode'];}?>" class="form-control" required>

                  <span class="help-block bottom15-none">Enter the code of the machine you want to register</span> </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label">MACHINE MODEL</label>
                <div class="col-sm-6">
                  <select class="form-control" name="txtMachineType" >
                                                <option value="">--select--</option>
                                                <?php
                                                     $myMachines = (array)$database->getAllProducts();
                                                     foreach ($myMachines as $machine) {
                                                     if($machine['ProductType'] > 1){ break; }
                                                ?>
                                                    <option value="<?php echo $machine['productName'];?>"
                                                    <?php if(isset($_POST['txtMachineType']) && $_POST['txtMachineType'] == $machine['id']){echo "selected";}?>><?php echo $machine['productName'];?></option>
                                                <?php }?>
                                                </select>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label">MACHINE SERIAL NO</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="txtMachineSerialNo"
                                                value="<?php if(isset($_POST['txtMachineSerialNo'])){ echo $_POST['txtMachineSerialNo'];}?>" required>
                     </div>
              </div>
   <hr>

              <div class="form-group">
                <label class="col-sm-2 control-label">METER READING</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="txtMeterReading"
                                                value="<?php if(isset($_POST['txtMeterReading'])){ echo $_POST['txtMeterReading'];}?>" required>
                     </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label">CATEGORY</label>
                <div class="col-sm-6">
                  <select class="form-control" name="txtContractType">
                                                <option value="">--select--</option>
                                                <?php
                                                     $myMachines = (array)$database->getAllWorkshopCategories();
                                                     foreach ($myMachines as $machine) {
                                                ?>
                                                    <option value="<?php echo $machine['category_name'];?>"
                                                    <?php if(isset($_POST['txtContractType']) && $_POST['txtContractType'] == $machine['id']){echo "selected";}?>><?php echo $machine['category_name'];?></option>
                                                <?php }?>
                                                </select>
              </div>
              </div>
              
                
              

  <hr>
      <div class="form-group">
                                            <label class="col-sm-2 control-label">REPORTED BY</label>
                                            <div class="col-sm-6">
                                             <input type="text" class="form-control m-b" name="txtReporter" value="<?php if(isset($_POST['txtReporter'])){echo $_POST['txtReporter'];}?>" required data-validation-required-message="reporter name is required">
                                            </div>
                                        </div>

              <!-- <label class="col-sm-2 control-label">CONTRACT START</label> -->
            <!--     <div class="col-sm-2">
                  <div class="input-group date form_date col-md-12" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2"
														data-link-format="yyyy-mm-dd">
														<input class="form-control" type="text" name="txtCS" value="<?php //if(isset($_POST['txtCS'])){ echo $_POST['txtCS'];}?>" readonly>
														<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
													</div>
													<input type="hidden" id="dtp_input2" value="" />

              </div> -->
         <!--      <label class="col-sm-2 control-label">CONTRACT END</label>
                <div class="col-sm-2">
                  <div class="input-group date form_date col-md-12" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2"
														data-link-format="yyyy-mm-dd">
														<input class="form-control" type="text" name="txtCE" value="<?php //if(isset($_POST['txtCE'])){ echo $_POST['txtCE'];}?>" readonly>
														<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
													</div>
													<input type="hidden" id="dtp_input2" value="" />

              </div> -->
              
              <hr>

                <div class="form-group">
      <label class="col-md-2 control-label">DATE & TIME </label>
      <div class="input-group date form_datetime col-md-6" data-date="<?php echo date('Y-m-d'); ?>T<?php echo date('H:i:s'); ?>Z" data-date-format="dd MM yyyy - HH:ii p"
      data-link-field="dtp_input1">
      <input class="form-control" size="20" type="text" name="txtInD" value="<?php if(isset($_POST['txtInD'])){ echo $_POST['txtInD'];}?>" readonly>
      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
      </div>
      <input type="hidden" id="dtp_input1" value="" />
      <br/>
      </div>

           <hr/>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">ASSIGN ENGINEER</label>
                                            <div class="col-lg-6">
                                                <select class="form-control m-b" name="txtEngineer" required data-validation-required-message="engineer is required">
                                                    <option value="">- SELECT -</option>
                                                    <?php
                            $engs = (array)$database->getAllEngineers();
                                foreach($engs as $eng){
                        ?>
                                                        <option value="<?php echo $eng['fullname']; ?>" <?php if(isset($_POST[ 'txtEngineer']) && $_POST[ 'txtEngineer']==$eng[ 'id']){echo "selected";}?>>
                                                            <?php echo $eng['fullname']; ?>
                                                        </option>
                                                        <?php } ?>

                                                </select>
                                            </div>

                                        </div>
                                        <hr>


             <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">

                  <button class="btn aqua" type="submit" name="btnAddMachine" class="btn btn-success col-lg-12">Add Machine to Workshop</button>
                </div>
              </div>
              <hr>



             
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
