<?php
  include("../data/DBConfig.php");
  include_once("../data/sessioncheck.php");
   $id = 0;
    $msg = "";
    $err = "";

    if(!isset($_GET['id']) || $_GET['id'] == ""){
        $database->redirect_to($host."view-service-call");
    }else{
        $id = $_GET['id'];

        $ticket = $database->getServiceTicket($id);
        if($ticket == null){
            $database->redirect_to($host."view-service-call");
        }
    }

    if(isset($_POST['btncollectOrder'])){
         $oID = $database->test_input($_POST['txtOrderID']);
         $ocDay = $database->test_input($_POST['txtDay']);
         $ocMonth = $database->test_input($_POST['txtMonth']);
         $ocYear = $database->test_input($_POST['txtYear']);
         $vat = $database->test_input($_POST['txtVat']);
         $machineID = $database->test_input($_POST['txtMachineID']);
         $accID =  $database->test_input($_POST['txtAccountID']);
            $database->updateOrderCollected($oID,$ocDay,$ocMonth,$ocYear,$vat,$machineID,$accID);
        $msg = 'ORDER SUCCESSFULLY COLLECTED';
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Follow Up Call</title>
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

        if(isset($_POST['btnRegisterPurchase'])){
            $discount = $database->test_input($_POST['range']);
           $product=$qty=$amount=array();
                if(isset($_POST['txtProduct'])){
                    $product = $_POST['txtProduct'];
                    $qty = $_POST['txtProductQty'];
                    $amount = $_POST['txtProductAmount'];
                }

            if(isset($_POST['txtProduct']) && !empty($_POST['txtProduct'])){

                  $database->AddNewPurchase($product,$qty,$amount,$ticket['machine_id'],$ticket['account_id'], $ticket['id'],$discount);
                  unset($_POST);
                  $msg = "PURCHASE HAS BEEN MADE SUCCESSFULLY";

            }else{
                $err ='All fields are required to create a supply ticket';
            }
        }

        if(isset($_POST['btnFollowUp'])){
            $closeBy = 0;
            $closeDate = "";
            $closeTimeStamp = "";
            $issues = "";
            $engineer = $database->test_input($_POST['txtEngineer']);

             $schD = explode("/",$database->test_input($_POST['txtSchDate']));

             if(isset($_POST['issues'])){
                                    if(is_array($_POST['issues'])){
                                        foreach($_POST['issues'] as $an_issue){
                                            $issues = $issues.",".$database->test_input($an_issue);
                                        }
                                    }else{
                                        $issues = $database->test_input($_POST['issues']);
                                    }
                                }

                   $serviceID = $ticket['id'];
                   $paymentStatus = $database->test_input($_POST['txtPayStatus']);
                   $CaseStatus = $database->test_input($_POST['txtCaseStatus']);
                   if($CaseStatus == 8 || $CaseStatus == 9){$closeBy = $user_id; $closeDate = date("l jS \of F Y h:i:s A");$closeTimeStamp = time();}
                   $workDone = $database->test_input($_POST['txtWorkDone']);
                   $database->followUpCall($serviceID,$paymentStatus,$closeBy,$closeDate,$closeTimeStamp,$CaseStatus,$workDone,$ticket['machine_id'],$ticket['account_id'],$engineer,$issues,$schD[0],$schD[1]);
                   $msg = "This Ticket has been followed Up";

        }
        $ticket = $database->getServiceTicket($id);
        if($ticket == null){
            $database->redirect_to($host."view-service-call");
        }

?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="row wrapper border-bottom page-heading">
                        <div class="col-lg-12">
                            <h2> Follow Up Call for <?php echo $ticket['ticketNo'];?> | <span class="btn btn-primary"><?php echo $ticket['machine_code'];?></span> |
        <span class="btn btn-primary"><?php echo $ticket['AccountName'];?></span>  </h2>
                            <ol class="breadcrumb">
                                <li> <a href="index-2.html">Home</a> </li>
                                <li> <a>Account</a> </li>
                                <li class="active"> <strong>Follow Up Call </strong> </li>
                            </ol>
                        </div>
                    </div>
                    <div class="wrapper-content ">

                        <form method="post" class="form-horizontal">
                            <div class="row">


                                        <?php if(isset($err) && $err != ""){$database->showMsg('',$err,1);}?>
                                            <?php if(isset($msg) && $msg != ""){$database->showMsg('',$msg,2);}?>

                                <div class="col-lg-6 top20 bottom20">
                                    <div class="widgets-container">

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">ACCOUNT</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="<?php echo $ticket['AccountName'];?>" class="form-control" readonly="readonly">
                                            </div>
                                            <input type="hidden" name="serviceID" value="<?php echo $act['id'];?>" />
                                            <input type="hidden" name="ticketNo" value="<?php echo $act['ticketNo'];?>" />
                                            <input type="hidden" name="machineID" value="<?php echo $act['MachineID'];?>" />
                                            <input type="hidden" name="AccountID" value="<?php echo $act['accountID'];?>" />
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">MACHINE</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="<?php echo $ticket['machine_code'];?>" class="form-control" readonly="readonly"> </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">COST</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control m-b" value="<?php echo $database->convertToMoney($ticket['cost']);?>" readonly="readonly">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">PAYMENT</label>
                                            <div class="col-sm-5">

                                                 <select class="form-control m-b" name="txtPayStatus" required data-validation-required-message="select payment status">
                                                                  <?php
                                                                        $cases = (array)$database->getPaymentStatus();
                                                                        foreach($cases as $case){
                                                                     ?>

                                                         <option <?php if($case['pstatus'] == $ticket['paymentStatus']){echo "selected";}?>><?php echo $case['pstatus'];?></option>
                                                         <?php }?>
                                                        </select>

                                            </div>
                                            <div class="col-sm-5">
                                                <select class="form-control m-b" name="txtCaseStatus" required data-validation-required-message="select payment status">
                                                    <?php
                        $cases = (array)$database->getCaseStatus();
                        foreach($cases as $case){
                     ?>

                                                        <option value="<?php echo $case['id'];?>" <?php if($case['id']==$ticket['CaseStatus']){echo "selected";}?>>
                                                            <?php echo $case['caseName'];?>
                                                        </option>
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
                                            <label class="col-lg-2 control-label">ENGINEER</label>
                                            <div class="col-lg-10">
                                                <select class="form-control m-b" name="txtEngineer" required data-validation-required-message="engineer is required">
                                                    <option value="">- SELECT -</option>
                                                    <?php
                            $engs = (array)$database->getAllEngineers();
                                foreach($engs as $eng){
                        ?>
                                                        <option value="<?php echo $eng['id'];?>" <?php if(isset($_POST[ 'txtEngineer']) && $_POST[ 'txtEngineer']==$eng[ 'id']){echo "selected";}else if($ticket[ 'engineer']==$eng[ 'id']){echo 'selected';}?>>
                                                            <?php echo $eng['fullname']; ?>
                                                        </option>
                                                        <?php } ?>

                                                </select>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">ScheduleDate</label>
                                            <div class="input-group date form_datetime col-lg-9" data-date="<?php echo date('Y')?>-<?php echo date('m')?>-<?php echo date('d')?>T10:25:07Z" data-date-format="dd MM yyyy / HH:ii p" data-link-field="dtp_input1">
                                                <input class="form-control" name="txtSchDate" size="16" type="text" value="<?php if($ticket['schDate']!=" "){echo $ticket['schDate'].' / '.$ticket['schTime'];}?> " readonly>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                            </div>
                                            <input type="hidden" id="dtp_input1" value="" />

                                        </div>

                                        <hr>
                                         <div class="form-group">
                                            <label class="col-sm-2 control-label">WORK DONE DESCRIPTION</label>
                                            <div class="col-sm-10">
                                                    <textarea name="txtWorkDone" class="form-control" id="" rows="10" placeholder="ENTER WORK DONE BY THE ENGINEER"><?php echo $ticket['workDone']; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-12 col-sm-offset-2">

                                                <button class="btn aqua" name="btnFollowUp" class="btn btn-success col-lg-12">PROCESS FOLLOW UP</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!--All form elements  End -->
                                <script>
                                    function addRow() {
                                        var productID = document.getElementById('nProduct');
                                        var id = productID.value;
                                        var nID = '<input type="hidden" name="txtProduct[]" value="' + id + '" /> ';
                                        var selectText = productID.options[productID.selectedIndex].text;
                                        var productname = selectText.substr(selectText.indexOf("---- ") + 4, selectText.length);

                                        var productcode = selectText.substr(0, selectText.indexOf("----"));
                                        var nQty = '<input type="text" placeholder="QTY." required  onkeyup = "javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)"  name="txtProductQty[]" class="form-control required" value="' + document.getElementById('nQty').value + '" />';
                                        var nPrice = '<input type="text" placeholder="PRICE."  onkeyup = "javascript:this.value=Comma(this.value);" required onKeyPress="return isNumberKey(event)"  name="txtProductAmount[]" class="form-control required" value="' + document.getElementById('nPrice').value + '" />';
                                        var Action = "<input type='button' class='btn btn-outline btn-round dark btn-sm black' onclick='removeRow();' value='Remove Row'/>";
                                        var table = document.getElementById('table');
                                        var newRow = table.insertRow(1);

                                        var cel1 = newRow.insertCell(0);
                                        var cel2 = newRow.insertCell(1);
                                        var cel3 = newRow.insertCell(2);
                                        var cel4 = newRow.insertCell(3);
                                        var cel5 = newRow.insertCell(4);

                                        cel1.innerHTML = productcode + nID;
                                        cel2.innerHTML = productname;
                                        cel3.innerHTML = nPrice;
                                        cel4.innerHTML = nQty;
                                        cel5.innerHTML = Action;
                                    }

                                    function removeRow() {
                                        var index, table = document.getElementById('table');
                                        for (var i = 1; i < table.rows.length; i++) {
                                            table.rows[i].cells[4].onclick = function() {
                                                var c = confirm("do you want to delete this row ?");
                                                if (c === true) {
                                                    index = this.parentElement.rowIndex;
                                                    table.deleteRow(index);
                                                }
                                            };
                                        }
                                    }
                                </script>

                                <div class="col-lg-6 top20 bottom20">

                                    <div class="form-group" style="font-size: x-small">

                                        <div class="col-lg-6">
                                            <select class="_select form-control" name="nProduct" id="nProduct">
                                                <?php

                                                        $products = (array)$database->getAllProductsForDropDown();
                                                        $vamp = 1;
                                                        foreach ($products as $dpt) {
                                                            $value = "";
                                                            $ptype = $dpt['ProductType'];
                                                                if($vamp != $ptype){?>
                                                                            </optgroup>
                                                                            <optgroup label="<?php echo $dpt['type'];?>">
                                                                                <?php $vamp = $ptype; }
                                                             ?>

                                                            <option value="<?php echo $dpt['id'];?>">
                                                                <?php echo $dpt['Code'].' ---- '.$dpt['productName'];?>
                                                            </option>

                                                            <?php  }?>
                                                    </optgroup>
                                            </select>

                                        </div>
                                        <div class="col-md-2">

                                            <input type="text" name="nPrice" value="" placeHolder="AMOUNT" id="nPrice" onkeyup="javascript:this.value=Comma(this.value);" class="form-control" onKeyPress="return isNumberKey(event)" value="1"/>

                                        </div>
                                        <div class="col-md-2">

                                            <input type="text" name="nQty" value="" class="form-control" id="nQty" placeHolder="QTY"  onKeyPress="return isNumberKey(event)" value="1"/>

                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn  blue btn-block btn-outline " onclick="addRow();">Add Item</button>
                                        </div>

                                    </div>

                                    <div class="widgets-container">
                                        <div class="borderedTable">
                                            <div class="table-scrollable">
                                                <table id="table" style="font-size: 12px" class="table table-striped table-bordered table-advance table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th> <i class="fa fa-briefcase"></i> Code </th>
                                                            <th class="hidden-xs"> <i class="fa fa-user"></i> Product Name </th>
                                                            <th> <i class="fa fa-shopping-cart"></i> Price </th>
                                                            <th> <i class="fa fa-shopping-cart"></i> Qty </th>

                                                            <th> </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                                 <table id="tbt"class="table table-striped table-bordered table-advance table-hover">
                                 <tr>
                                     <td>

                                            <div class="input-group col-md-12">
                                                <input type="text" id="range" value="<?php if(isset($_POST['range'])){echo $_POST['range'];}else{echo 0;}?>" name="range" />
                                            </div>
                                     </td>
                                 </tr>
                                 </table>
                                                <button type="submit" class="btn btn-success col-md-12" name="btnRegisterPurchase">
                                                    <i class="fa fa-plus-o"></i> PROCESS PURCHASE
                                                </button>

                                                           <?php
                     $amounted2 = 0;
                     $amount_ = 0;
                            if($ticket['purchase'] == 1){
                            $n = 1;
                                $machineDemands = (array)$database->getPurchaseTicketForServiceCall($ticket['id']);
                                foreach($machineDemands as $demand){
                            ?>

                                 <table style="font-size: 12px" class="table table-striped table-bordered table-advance table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2">
                                                                  <h3><?php echo $demand['ticketNo'];?></h3>
                                                            </th>
                                                            <th colspan="3">

                                                                    <?php if($demand['orderCollect']== 0){?>
                                                                   <div class="btn-group">
                                                                     <button data-toggle="dropdown" class="btn btn-info dropdown-toggle" type="button">ACTIONS &nbsp;<i class="fa fa-angle-down"></i> </button>
                                                                        <ul role="menu" class="dropdown dropdown-menu">
                                                                            <li> <a href="<?php echo $host;?>purchase-invoice/<?php echo $demand['ticketNo'];?>?vat=1">PFI - VAT</a></li>
                                                                            <li> <a href="<?php echo $host;?>purchase-invoice/<?php echo $demand['ticketNo'];?>?vat=0">PFI - NO VAT</a></li>
                                                                            <li class="divider"> </li>

                                                                            <li><a href="<?php echo $host;?>edit-purchase/<?php echo $demand['ticketNo'];?>">EDIT PURCHASE</a></li>
                                                                        </ul>
                                                                    </div>

                                                                    <div class="btn-group">
                                                                     <button  class="btn btn-warning dropdown-toggle" type="button" data-toggle="modal" data-target=".bs-example-modal-lg-<?php echo $demand['ticketNo'];?>">COLLECT ORDER &nbsp;<i class="fa fa-check-square"></i> </button>
                                                                    </div>
                                                                    <!-- Large modal -->

                                                                      <?php

                                                                            $accName =  $ticket['AccountName'];
                                                                            $m_code = $ticket['machine_code'];
                                                                            $m_machineID = $ticket['machine_id'];
                                                                            $m_accountID = $ticket['account_id'];

                                                                      include("followup/collect-purchase-order.php");?>
                                                                    <?php   }else{;?>
                                                                     <div class="btn-group">
                                                                         <a href="<?php echo $host;?>purchase-invoice/<?php echo $demand['ticketNo'];?>" class="btn btn-success"><i class="fa fa-cube"></i>&nbsp;VIEW SOF</a>
                                                                     </div>
                                                                     <?php }?>

                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th> <i class="fa fa-briefcase"></i> Code </th>
                                                            <th class="hidden-xs"> <i class="fa fa-user"></i> Product Name </th>
                                                            <th> <i class="fa fa-shopping-cart"></i> Price </th>
                                                            <th> <i class="fa fa-shopping-cart"></i> Qty </th>

                                                            <th> <i class="fa fa-shopping-cart"></i> Amount  </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                            <?php
                             $amounted = 0;
                             $vatN = 0;
                             $vatv_ = "NO VAT";
                             $salesorder = (array)$database->getPurchaseProductOrderCall($demand['id']);
                            foreach ($salesorder as $order) {
                                        ?>
                                                        <tr>
                                                        <td><?php echo $order['productName'];?><?php if($order['ProductType']>1){echo " - ".$order['color'];}?></td>
                                                        <td><?php echo $order['Code'];?></td>
                                                        <td> <?php echo $database->convertToMoney($order['Amount']);?></td>
                                                        <td><?php echo $order['qty'];?></td>
                                                        <td><?php
                                                                                $amount_ = $order['qty'] * $order['Amount'];
                                                                        echo $database->convertToMoney($amount_);?></td>
                                                        </tr>


                                         <?php $n++;$amounted += $amount_; $amounted2 += $amount_;}?>
                                         <tr>
                                             <td colspan="4"><p style="text-align: right">AMOUNT</p></td>
                                             <td><?php echo $database->convertToMoney($amounted);?></td>
                                         </tr>
                                         <tr> <?php if($order['vat'] == 1){$vatv_ = "5% VAT";$vatN = 0.05 *$amounted;};?>
                                             <td colspan="4"><p style="text-align: right"><?php echo $vatv_;?></p></td>
                                             <td><?php echo $database->convertToMoney($vatN);?></td>
                                             <?php $added = $amounted + $vatN;?>
                                         </tr>
                                         <tr>
                                             <td colspan="4"><p style="text-align: right">DISCOUNT <?php echo $demand['discount'];?>%</p></td>
                                             <td><?php
                                                            $disc = (($demand['discount']/100) *  $added);
                                                            echo $database->convertToMoney($disc);

                                             ?></td>
                                         </tr>
                                         <tr>
                                             <td colspan="4"><p style="text-align: right">TOTAL</p></td>
                                             <td><?php
                                                            $dis = $added - $disc;
                                                            echo $database->convertToMoney($dis);

                                             ?></td>
                                         </tr>
                                            </tbody>
                                         </table><br/>
                    <?php }}?>

                                                       <br/>



                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!--All form elements  End -->

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