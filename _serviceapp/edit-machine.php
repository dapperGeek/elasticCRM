<?php
  include("../data/DBConfig.php");
  include_once("../data/sessioncheck.php");
  $yr_ = date("Y");

if($myData['changePass'] == 0){
  //  $database->redirect_to($host."change-password");
}
 $machineInfo = $database->getSingleMachineInformation($_GET['id']);
        if($machineInfo == null){
            $database->redirect_to($host."view-machine");
        }
?>
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
 <link href="<?php echo $host;?>css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo $host;?>css/main.css" rel="stylesheet" media="screen">
    <link href="<?php echo $host;?>fonts/icomoon/icomoon.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/heatmap/cal-heatmap.css" rel="stylesheet">
    <link href="<?php echo $host;?>css/c3/c3.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $host;?>css/datepicker.css">

<?php include("../includes/header.php");?>

            <div class="main-container">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-light">
                            <div class="panel-heading">
                                <h4>Edit Machine | <?php echo $machineInfo['machine_code']." FOR ".$machineInfo['Name'];?></h4></div>
                            <div class="panel-body">

                            <?php
                             $msg = ""; $err = "";

                                    if(isset($_POST['btnAddMachine'])){

                                        $acc = $database->test_input($_POST['txtAccount']);
                                        $machineCode = $database->test_input($_POST['txtMachineCode']);
                                        $machineModel = $database->test_input($_POST['txtMachineType']);
                                        $machineSerialNo = $database->test_input($_POST['txtMachineSerialNo']);
                                        $contractType = $database->test_input($_POST['txtContractType']);

                                        $inD = $database->test_input($_POST['txtDayI']);
                                        $inM = $database->test_input($_POST['txtMonthI']);
                                        $inY = $database->test_input($_POST['txtYrI']);
                                        $csD = $database->test_input($_POST['txtDayCS']);
                                        $csM = $database->test_input($_POST['txtMonthCS']);
                                        $csY = $database->test_input($_POST['txtYrCS']);
                                        $ceD = $database->test_input($_POST['txtDayCE']);
                                        $ceM = $database->test_input($_POST['txtMonthCE']);
                                        $ceY = $database->test_input($_POST['txtYrCE']);

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




                                        $doi = $inD."-".$inM."-".$inY;
                                        $cstart = $csD."-".$csM."-".$csY;
                                        $cend = $ceD."-".$ceM."-".$ceY;




                                    if($acc != "" && $machineCode != "" && $machineModel != "" && $machineSerialNo != ""
                                        && $contractType != "" && $address != "" && $state != "" && $area != "" && $inD !=""
                                        && $inM != "" && $inY != "" && $contactN1 != "" && $contactP1 != "" && $contactE1 != ""
                                        && $contactD1 != "")
                                    {
                                        if($database->checkMachineAvailableCompare($machineCode,$machineInfo['id'])){
                                            $err = "This Machine code has been registered previously";
                                        }else{
                                            $database->EditAMachine($acc,$machineCode,$machineModel,$machineSerialNo,$contractType,$doi,$cstart,$cend,$address,$area,$contactN1,$contactP1,$contactE1,$contactD1,$contactN2,$contactP2,$contactE2,$contactD2,$contactN3,$contactP3,$contactE3,$contactD3,$dpt,$machineInfo['id']);
                                            $msg= "MACHINE HAS BEEN SUCCESSFULLY EDITTED";
                                            unset($_POST);
                                            echo $database->showMsg("SUCCESS",$msg,2);
                                        }

                                    }else{
                                        if($acc == ""){$err ="<li>Please select an account</li>";}
                                        if($machineCode == ""){$err ="<li>Please enter machine code</li>";}
                                        if($machineModel == ""){$err ="<li>Please Select machine model</li>";}
                                        if($machineSerialNo == ""){$err ="<li>Please enter machine serial No.</li>";}
                                        if($contractType == ""){$err ="<li>Please select contract Type</li>";}
                                        if($address == ""){$err ="<li>Please enter machine address</li>";}
                                        if($state == ""){$err ="<li>Please select machine state</li>";}
                                        if($area == ""){$err ="<li>Please select area of the machine</li>";}
                                        if($inD == ""){$err ="<li>Please select Installation day</li>";}
                                        if($inM == ""){$err ="<li>Please select Installation month</li>";}
                                        if($inY == ""){$err ="<li>Please select Installation year</li>";}
                                        if($contactN1 == ""){$err ="<li>Please enter first contact person name</li>";}
                                        if($contactP1 == ""){$err ="<li>Please enter first contact person phone no.</li>";}
                                        if($contactE1 == ""){$err ="<li>Please enter first contact person email</li>";}
                                        if($contactD1 == ""){$err ="<li>Please enter first contact person designation</li>";}









                                        echo $database->showMsg("",$err,1);
                                    }



                                    }
                                        $machineInfo = $database->getSingleMachineInformation($_GET['id']);

                            ?>
                                <form id="movieForm" method="post">
                                <div class="form-group">
                                        <div class="row gutter">
                                            <div class="col-md-6">
                                                <label class="control-label">ACCOUNT</label>
                                                <select class="form-control" name="txtAccount">
                                                <option value="">--select--</option>
                                                <?php
                                                     $myMachines = (array)$database->getAllAcounts();
                                                     foreach ($myMachines as $machine) {

                                                ?>
                                                    <option value="<?php echo $machine['id'];?>"
                                                    <?php if($machineInfo['account_id'] == $machine['id']){echo "selected";}?>><?php echo strtoupper($machine['Name']);?></option>
                                                <?php }?>
                                                </select>
                                            </div>
                                            <div class="col-md-6 selectContainer">
                                             <label class="control-label">MACHINE CODE</label>
                                                <input type="text" name="txtMachineCode"
                                                value="<?php echo $machineInfo['machine_code'];?>" class="form-control" required>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row gutter">
                                            <div class="col-md-4">
                                             <label class="control-label">MACHINE MODEL</label>
                                                <select class="form-control" name="txtMachineType">
                                                <option value="">--select--</option>
                                                <?php
                                                     $myMachines = (array)$database->getAllProducts();
                                                     foreach ($myMachines as $machine) {
                                                     if($machine['ProductType'] > 1){ break; }
                                                ?>
                                                    <option value="<?php echo $machine['id'];?>"
                                                    <?php if($machineInfo['machine_type'] == $machine['id']){echo "selected";}?>><?php echo $machine['productName'];?></option>
                                                <?php }?>
                                                </select>

                                            </div>
                                            <div class="col-md-4 ">
                                               <label class="control-label">MACHINE SERIAL NO.</label>
                                                <input type="text" class="form-control" name="txtMachineSerialNo"
                                                value="<?php echo $machineInfo['serialNo'];?>" required>
                                            </div>
                                             <div class="col-md-4 ">
                                               <label class="control-label">CONTRACT TYPE</label>
                                                <select class="form-control" name="txtContractType">
                                                <option value="">--select--</option>
                                                <?php
                                                     $myMachines = (array)$database->getAllContracts();
                                                     foreach ($myMachines as $machine) {
                                                ?>
                                                    <option value="<?php echo $machine['id'];?>"
                                                    <?php if($machineInfo['contractID'] == $machine['id']){echo "selected";}?>><?php echo $machine['contractName'];?></option>
                                                <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row gutter">
                                            <div class="col-md-4">
                                             <label class="control-label">DATE OF INSTALLATION</label>
                                             <div class="row">
                                                <div class="col-md-4">
                                                    <?php
                                                            $doi = explode("-", $machineInfo['doi']);
                                                              $doid = $doi[0];
                                                              $doim = $doi[1];
                                                              $doiy = $doi[2];

                                                    ?>
                                                    <select class="form-control" name="txtDayI">
                                                        <option value="">-day-</option>
                                                        <?php

                                                            for($i = 1; $i < 32; $i++){
                                                        ?>
                                                         <option value="<?php echo $i;?>"
                                                            <?php if($doid == $i){echo "selected";}?>><?php echo $i;?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                 <div class="col-md-4">
                                                   <select class="form-control" name="txtMonthI">
                                                    <option value="">-month-</option>
                                                    <?php

                                                        for($i = 1; $i < 13; $i++){
                                                    ?>
                                                     <option value="<?php echo $i;?>"
                                                        <?php if($doim == $i){echo "selected";}?>><?php echo date('F', mktime(0, 0, 0, $i, 10));?></option>
                                                    <?php }?>
                                                </select>
                                                </div>
                                                 <div class="col-md-4">
                                                    <select class="form-control" name="txtYrI">
                                                <option value="">-year-</option>
                                                <?php


                                                    for($i = $yr_+1; $i > $yr_-2; $i--){
                                                ?>
                                                    <option value="<?php echo $i;?>"
                                                    <?php if($doiy == $i){echo "selected";}?>><?php echo $i;?></option>
                                                <?php }?>
                                                </select>
                                                </div>
                                                </div>

                                            </div>

                                             <div class="col-md-4">
                                             <label class="control-label">CONTRACT-START</label>
                                             <div class="row">
                                                <div class="col-md-4">
                                                      <?php
                                                            $cs = explode("-", $machineInfo['contractStart']);
                                                              $csd = $cs[0];
                                                              $csm = $cs[1];
                                                              $csy = $cs[2];

                                                    ?>
                                                    <select class="form-control" name="txtDayCS">
                                                        <option value="">-day-</option>
                                                        <?php

                                                            for($i = 1; $i < 32; $i++){
                                                        ?>
                                                         <option value="<?php echo $i;?>"
                                                            <?php if($csd == $i){echo "selected";}?>><?php echo $i;?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                 <div class="col-md-4">
                                                   <select class="form-control" name="txtMonthCS">
                                                    <option value="">-month-</option>
                                                    <?php

                                                        for($i = 1; $i < 13; $i++){
                                                    ?>
                                                     <option value="<?php echo $i;?>"
                                                        <?php if($csm == $i){echo "selected";}?>><?php echo date('F', mktime(0, 0, 0, $i, 10));?></option>
                                                    <?php }?>
                                                </select>
                                                </div>
                                                 <div class="col-md-4">
                                                    <select class="form-control" name="txtYrCS">
                                                <option value="">-year-</option>
                                                <?php
                                                    for($i = $yr_+1; $i > $yr_-2; $i--){
                                                ?>
                                                    <option value="<?php echo $i;?>"
                                                    <?php if($csy == $i){echo "selected";}?>><?php echo $i;?></option>
                                                <?php }?>
                                                </select>
                                                </div>
                                                </div>

                                            </div>

                                             <div class="col-md-4">
                                             <label class="control-label">CONTRACT-END</label>
                                             <div class="row">
                                                <div class="col-md-4">
                                                    <?php
                                                            $ce = explode("-", $machineInfo['contractEnds']);
                                                              $ced = $ce[0];
                                                              $cem = $ce[1];
                                                              $cey = $ce[2];

                                                    ?>
                                                    <select class="form-control" name="txtDayCE">
                                                        <option value="">-day-</option>
                                                        <?php

                                                            for($i = 1; $i < 32; $i++){
                                                        ?>
                                                         <option value="<?php echo $i;?>"
                                                            <?php if($ced == $i){echo "selected";}?>><?php echo $i;?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                 <div class="col-md-4">
                                                   <select class="form-control" name="txtMonthCE">
                                                    <option value="">-month-</option>
                                                    <?php

                                                        for($i = 1; $i < 13; $i++){
                                                    ?>
                                                     <option value="<?php echo $i;?>"
                                                        <?php if($cem == $i){echo "selected";}?>><?php echo date('F', mktime(0, 0, 0, $i, 10));?></option>
                                                    <?php }?>
                                                </select>
                                                </div>
                                                 <div class="col-md-4">
                                                    <select class="form-control" name="txtYrCE">
                                                <option value="">-year-</option>
                                                <?php
                                                    for($i = $yr_; $i< $yr_+8; $i++){
                                                ?>
                                                    <option value="<?php echo $i;?>"
                                                    <?php if($cey == $i){echo "selected";}?>><?php echo $i;?></option>
                                                <?php }?>
                                                </select>
                                                </div>
                                                </div>

                                            </div>



                                        </div>
                                    </div>
                                    <div class="form-group">
                                    <div class="row gutter">
                                        <div class="col-md-3">
                                        <label class="control-label">CONTACT NAME 1</label>
                                                <input type="text" name="txtContactName1"
                                                value="<?php echo $machineInfo['contactName1'];?>" class="form-control" required>

                                        </div>
                                         <div class="col-md-3">
                                         <label class="control-label">CONTACT PHONE 1</label>
                                                <input type="text" name="txtPhone1"
                                                value="<?php echo $machineInfo['contactPhone1'];?>" class="form-control" required>

                                        </div>
                                         <div class="col-md-3">
                                         <label class="control-label">CONTACT EMAIL 1</label>
                                                <input type="text" name="txtEmail1"
                                                value="<?php echo $machineInfo['contactEmail1'];?>" class="form-control" required>

                                        </div>
                                         <div class="col-md-3">
                                         <label class="control-label">CONTACT DESIGNATION 1</label>
                                                <input type="text" name="txtDesig1"
                                                value="<?php echo $machineInfo['contactDesig1'];?>" class="form-control" required>

                                        </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                    <div class="row gutter">
                                        <div class="col-md-3">
                                        <label class="control-label">CONTACT NAME 2</label>
                                                <input type="text" name="txtContactName2"
                                                value="<?php echo $machineInfo['contactName2'];?>" class="form-control">

                                        </div>
                                         <div class="col-md-3">
                                         <label class="control-label">CONTACT PHONE 2</label>
                                                <input type="text" name="txtPhone2"
                                                value="<?php echo $machineInfo['contactPhone2'];?>" class="form-control">

                                        </div>
                                         <div class="col-md-3">
                                         <label class="control-label">CONTACT EMAIL 2</label>
                                                <input type="text" name="txtEmail2"
                                                value="<?php echo $machineInfo['contactEmail2'];?>" class="form-control">

                                        </div>
                                         <div class="col-md-3">
                                         <label class="control-label">CONTACT DESIGNATION 2</label>
                                                <input type="text" name="txtDesig2"
                                                value="<?php echo $machineInfo['contactDesig2'];?>" class="form-control">

                                        </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                    <div class="row gutter">
                                        <div class="col-md-3">
                                        <label class="control-label">CONTACT NAME 3</label>
                                                <input type="text" name="txtContactName3"
                                                value="<?php echo $machineInfo['contactName3'];?>" class="form-control">

                                        </div>
                                         <div class="col-md-3">
                                         <label class="control-label">CONTACT PHONE 3</label>
                                                <input type="text" name="txtPhone3"
                                                value="<?php echo $machineInfo['contactPhone3'];?>" class="form-control">

                                        </div>
                                         <div class="col-md-3">
                                         <label class="control-label">CONTACT EMAIL 3</label>
                                                <input type="text" name="txtEmail3"
                                                value="<?php echo $machineInfo['contactEmail3'];?>" class="form-control">

                                        </div>
                                         <div class="col-md-3">
                                         <label class="control-label">CONTACT DESIGNATION 3</label>
                                                <input type="text" name="txtDesig3"
                                                value="<?php echo $machineInfo['contactDesig3'];?>" class="form-control">

                                        </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="row gutter">
                                         <div class="col-md-2">
                                                <label class="control-label">STATE</label>
                                               <select class="form-control m-b" id="parent" name="txtState" onChange="LoadChild();" required data-validation-required-message="State is required">
                                        <option value="" disabled selected hidden>- select -</option>
                                        <script type="text/javascript">
                                            for(var i = 0 ; i < parent.length ; i ++){
                                                document.write('<option value="'+parent[i][0]+'">'+parent[i][1]+'</option>');
                                            }
                                        </script>

                                    </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="control-label">AREA</label>
                                                 <select class="form-control m-b" name="txtAreaID" required data-validation-required-message="area is required" id="gchild" onChange="LoadGChild();">


                                    </select>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="control-label">ADDRESS</label>
                                                <input type="text" class="form-control" name="txtAddress"
                                                value="<?php  echo $machineInfo['Address'];?>" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label">DEPARTMENT</label>
                                                <input type="text" class="form-control" name="txtDpt"
                                                value="<?php echo $machineInfo['department'];?>" required>
                                            </div>


                                        </div>
                                    </div>
                                    <button type="submit" name="btnAddMachine" class="btn btn-success col-lg-12">
                                    <i class="fa fa-plus"></i> Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gutter">

                </div>
                <div class="row gutter">
                 </div>
                <div class="row gutter">

                </div>
                <div class="row gutter">
                </div>
            </div>
          <!--  <footer class="footer">Copyright Nexton Admin App <span>2017</span>.</footer>-->
        </div>
        <div class="right-sidebar">
            <div class="panel panel-blue">
                <div class="panel-heading">
                    <h5>Sales</h5></div>
                <div class="panel-body">
                    <div id="cal-heatmap" class="auto-margin"></div>
                </div>
            </div>
            <div class="panel">
                <div class="info-stats green-two">
                    <div class="icon-type pull-left"><i class="icon-announcement"></i></div>
                    <div class="sale-num">
                        <h4>732</h4>
                        <p>Notifications</p>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="info-stats green-one">
                    <div class="icon-type pull-left"><i class="icon-drafts"></i></div>
                    <div class="sale-num">
                        <h4>529</h4>
                        <p>Messages</p>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="info-stats pink">
                    <div class="icon-type pull-left"><i class="icon-chat2"></i></div>
                    <div class="sale-num">
                        <h4>218</h4>
                        <p>Comments</p>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="info-stats yellow">
                    <div class="icon-type pull-left"><i class="icon-assignment_turned_in"></i></div>
                    <div class="sale-num">
                        <h4>147</h4>
                        <p>Tasks</p>
                    </div>
                </div>
            </div>
            <div class="panel">
                <ul class="views">
                    <li>
                        <p class="detail-info"><i class="icon-vinyl blue"></i> Signups</p>
                    </li>
                    <li>
                        <p class="detail-info"><i class="icon-vinyl green"></i> Users Online</p>
                    </li>
                    <li>
                        <p class="detail-info"><i class="icon-vinyl red"></i>Uploads</p>
                    </li>
                </ul>
            </div>
            <div class="panel">
                <div class="tags clearfix"><a href="#">Dashboard</a> <a href="#">News</a> <a href="#">Admin</a> <a href="#">Profile</a> <a href="#">Invoice</a> <a href="#">Sass</a></div>
            </div>
        </div>
    </div>
    <script src="<?php echo $host;?>js/jquery.js"></script>
    <script src="<?php echo $host;?>js/bootstrap.min.js"></script>
    <script src="<?php echo $host;?>js/sparkline/retina.js"></script>
    <script src="<?php echo $host;?>js/scrollup.min.js"></script>
    <script src="<?php echo $host;?>js/d3.min.js"></script>
    <script src="<?php echo $host;?>js/heatmap/cal-heatmap.min.js"></script>
    <script src="<?php echo $host;?>js/heatmap/cal-heatmap.custom.js"></script>
    <script src="<?php echo $host;?>js/common.js"></script>
</body>
<!-- Mirrored from bootstrap.gallery/nexton/form-inputs.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 26 Apr 2017 13:57:05 GMT -->

</html>