<?php
    $id = 0;
    $msg = "";
    $err = "";

    $pageHeader = 'followUpCall';
    $title = 'Follow Up Call';
    include("../includes/header_with_pageHeading.php");

    if(!isset($_GET['id']) || $_GET['id'] == "")
    {
        $database->redirect_to($host."view-service-call");
    }
    else
    {
        $id = $_GET['id'];

        $ticket = $database->getServiceTicket($id);
        if($ticket == null)
        {
            $database->redirect_to($host."view-service-call");
        }
    }

    if(isset($_POST['btncollectOrder']))
    {
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

    if(isset($_POST['btnRegisterPurchase']))
    {
        $discount = $database->test_input($_POST['range']);
        $product=$qty=$amount=array();
        if(isset($_POST['txtProduct'])){
            $product = $_POST['txtProduct'];
            $qty = $_POST['txtProductQty'];
            $amount = $_POST['txtProductAmount'];
        }

        if(isset($_POST['txtProduct']) && !empty($_POST['txtProduct'])){

            $salesType = 1;
            $database->AddNewPurchase($product,$qty,$amount,$ticket['machine_id'],$ticket['account_id'], $ticket['id'],$discount,  $salesType);
            unset($_POST);
            $msg = "PURCHASE HAS BEEN MADE SUCCESSFULLY";

        }else{
            $err ='All fields are required to create a supply ticket';
        }
    }

    if(isset($_POST['btnRegisterPurchaseSpare']))
    {
        $discount = $database->test_input($_POST['range']);
        $product=$qty=$amount=array();
        if(isset($_POST['txtProductnSparePart'])){
            $product = $_POST['txtProductnSparePart'];
            $qty = $_POST['txtProductQtynSparePart'];
            $amount = $_POST['txtProductAmountnSparePart'];
        }

        if(isset($_POST['txtProductnSparePart']) && !empty($_POST['txtProductQtynSparePart'])){

            $salesType = 2;

            $database->AddNewPurchase($product,$qty,$amount,$ticket['machine_id'],$ticket['account_id'], $ticket['id'],$discount,$salesType);
            unset($_POST);
            $msg = "PURCHASE HAS BEEN MADE SUCCESSFULLY";

        }else{
            $err ='All fields are required to create a supply ticket';
        }
    }

    if(isset($_POST['btnFollowUp']))
    {
        $closeBy = 0;
        $closeDate = "";
        $closeTimeStamp = "";
        $issues = "";
        $engineer = $database->test_input($_POST['txtEngineer']);

        $schD = explode("/",$database->test_input($_POST['txtSchDate']));

        // Check if meter reading is valid
        $meterReading = $database->RemoveComma($database->test_input($_POST['meterReading']));
        $colour = $database->RemoveComma($database->test_input($_POST['txtColour']));
        $Mono = $database->RemoveComma($database->test_input($_POST['txtMono']));

        if (empty($meterReading) || empty($colour) || empty($Mono))
        {
            $err = 'The fields Meter Reading, Color and Mono values are required';
        }
        else
        {
            if(isset($_POST['issues']))
            {
                if(is_array($_POST['issues']))
                {
                    foreach($_POST['issues'] as $an_issue)
                    {
                        $issues = $issues.",".$database->test_input($an_issue);
                    }
                }
                else
                {
                    $issues = $database->test_input($_POST['issues']);
                }
            }

            $serviceID = $ticket['id'];
            $paymentStatus = $database->test_input($_POST['txtPayStatus']);
            $CaseStatus = $database->test_input($_POST['txtCaseStatus']);
            if($CaseStatus == 8 || $CaseStatus == 9)
            {
                $closeBy = $user_id;
                $closeDate = date("l jS \of F Y h:i:s A");
                $closeTimeStamp = time();
            }
            
            $st = $database->test_input($_POST['txtST']);
            $et = $database->test_input($_POST['txtET']);

            $colour = $database->RemoveComma($database->test_input($_POST['txtColour']));
            $Mono = $database->RemoveComma($database->test_input($_POST['txtMono']));
            $meterReading = $database->RemoveComma($database->test_input($_POST['meterReading']));


            $wd = "<b>Scheduled Date/Time :</b> ".$ticket['schDate']." / ".$ticket['schTime']." \n <b>START TIME:</b> ".$st." / <b>FINISH TIME:</b> ".$et." \n";
            $workDone = $database->test_input($_POST['txtWorkDone']);
//            if($wd2 != "")
//            {
//                $workDone = $_POST['txtWrkDone2'].$wd.$wd2."\n\n";
//            }
//            else
//            {
//                $workDone = $_POST['txtWrkDone2'];
//            }
            //var_dump($workDone);
            //exit;

            $database->followUpCall($serviceID,$paymentStatus,$closeBy,$closeDate,$closeTimeStamp,$CaseStatus,$workDone,$ticket['machine_id'],$ticket['account_id'],$engineer,$issues,$schD[0],$schD[1],$meterReading,$colour,$Mono, $st, $et);
            $msg = "This Ticket has been followed Up";

        }
    }

    $ticket = $database->getServiceTicket($id);
    if($ticket == null)
    {
        $database->redirect_to($host."view-service-call");
    }

    if(isset($_POST['btnCloseCall']))
    {
        // Check if meter reading is valid
        $meterReading = $database->RemoveComma($database->test_input($_POST['meterReading']));
        $colour = $database->RemoveComma($database->test_input($_POST['txtColour']));
        $Mono = $database->RemoveComma($database->test_input($_POST['txtMono']));

        if (empty($meterReading) || empty($colour) || empty($Mono))
        {
            $err = 'The fields Meter Reading, Color and Mono values are required';
        }
        else
        {
            $closeBy = 0;
            $closeDate = "";
            $closeTimeStamp = "";
            $issues = "";
            $engineer = $database->test_input($_POST['txtEngineer']);

            $schD = explode("/",$database->test_input($_POST['txtSchDate']));

            if(isset($_POST['issues']))
            {
                if(is_array($_POST['issues']))
                {
                    foreach($_POST['issues'] as $an_issue)
                    {
                        $issues = $issues.",".$database->test_input($an_issue);
                    }
                }
                else
                {
                    $issues = $database->test_input($_POST['issues']);
                }
            }

            $serviceID = $ticket['id'];
            $paymentStatus = $database->test_input($_POST['txtPayStatus']);
            $CaseStatus = $database->test_input($_POST['txtCaseStatus']);
            if($CaseStatus == 8 || $CaseStatus == 9)
            {
                $closeBy = $user_id; 
                $closeDate = date("l jS \of F Y h:i:s A");
                $closeTimeStamp = time();
            }
            $st = $database->test_input($_POST['txtST']);
            $et = $database->test_input($_POST['txtET']);
            $meterReading = $database->test_input($_POST['meterReading']);

            $wd = "<b>Scheduled Date/Time :</b> ".$ticket['schDate']." / ".$ticket['schTime']." \n <b>START TIME:</b> ".$st." / <b>FINISH TIME:</b> ".$et." \n";
            $workDone = $database->test_input($_POST['txtWorkDone']);
//            if($wd2 != "")
//            {
//                $workDone = $_POST['txtWrkDone2'].$wd.$wd2."\n\n";
//            }
//            else
//            {
//                $workDone = $_POST['txtWrkDone2'];
//            }

            $database->closeCall($serviceID,$paymentStatus,$closeBy,$closeDate,$closeTimeStamp,$CaseStatus,$workDone,$ticket['machine_id'],$ticket['account_id'],$engineer,$issues,$schD[0],$schD[1],$meterReading,$colour,$Mono);
            $msg = "This Ticket has been followed Up";
        }
    }
    
    $followUps = $database->getFollowUps($ticket['callID']);
?>
        <div class="row wrapper border-bottom page-heading">
            <div class="col-lg-12">
                <h2> Follow Up Call for <?php echo $ticket['ticketNo'];?> | <span class="btn btn-primary"><?php echo $ticket['machine_code'];?></span> |
                    <span class="btn btn-primary"><?php echo $ticket['AccountName'];?></span>  </h2>
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
                                <label class="col-lg-2 control-label">ISSUES REPORTED</label>
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


                            <hr>
                            <div class="form-group">
                                <h4 style="text-align: center">ENGINEER'S FEED BACK</h4>

                            </div>
                            <div class="form-group">
                                <label for="dtp_input3" class="col-lg-2 control-label">START-TIME</label>
                                <div class="col-lg-4">
                                    <div class="input-group date form_time" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
                                        <input class="form-control" name="txtST" size="16" type="text" value="" readonly>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                    </div>
                                </div>
                                <label for="dtp_input3" class="col-lg-2 control-label">END-TIME</label>
                                <div class="col-lg-4">
                                    <div class="input-group date form_time" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
                                        <input class="form-control" name="txtET" size="16" type="text" value="" readonly>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                    </div>
                                </div>

                                <br>
                                <br>

                                <input type="hidden" id="dtp_input3" value="" />

                            </div>



                            <hr>
                            <div class="form-group">
                                <h4 style="text-align: center">CURRENT METER READING</h4>

                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">METER READING</label>
                                <div class="col-sm-10">
                                    <input  type="text" name="meterReading" value="<?php echo $ticket['meterReading'];?>" class="form-control" onkeyup="javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)"> </div>
                            </div>
                            <div class="form-group">
                                <label for="dtp_input3" class="col-lg-2 control-label">COLOUR</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input class="form-control" name="txtColour" size="19" type="text"  value="<?php echo $ticket['colour']; ?>" onkeyup="javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)">

                                    </div>
                                </div>
                                <label for="dtp_input4" class="col-lg-2 control-label">MONO</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input class="form-control" name="txtMono" size="19" value="<?php echo $ticket['Mono']; ?>" type="text" onkeyup="javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)" >

                                    </div>
                                </div>

                                <br>
                                <br>

                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">WORK DONE DESCRIPTION</label>
                                <div class="col-sm-10">
                                    <textarea name="txtWorkDone" class="form-control" id="" rows="10" placeholder="ENTER WORK DONE BY THE ENGINEER"> </textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">&nbsp;</label>
                                <div class="col-sm-10">
<!--                                <input type="hidden" name="txtWrkDone2" value="<?php echo $ticket['workDone'];?>" />-->

                    <?php 
//                        echo nl2br($ticket['workDone']); 
                        if($followUps != false)
                        {
                            foreach ($followUps as $followUp)
                            {
                                echo nl2br($followUp['work-done']) . '<hr>';
                            }
                        }
                    ?>
                                </div>
                            </div>
                            <hr/>
                            <br>
                            <br>
                            <div><p><b>&nbsp;&nbsp;&nbsp;Spare Part Require for Machine </b></p></div>
                            <div class="col-lg-6">

                                <select class="_select form-control" name="nSparePart" id="nSparePart">
                                    <?php

                                    $products = (array)$database->getAllProductsForDropDownSparePart();
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

                                <input type="text" name="nPriceSparePart" value="" placeHolder="AMOUNT" id="nPriceSparePart" onkeyup="javascript:this.value=Comma(this.value);" class="form-control" onKeyPress="return isNumberKey(event)" value="1"/>

                            </div>
                            <div class="col-md-2">

                                <input type="text" name="nQtySparePart" value="" class="form-control" id="nQtySparePart" placeHolder="QTY"  onKeyPress="return isNumberKey(event)" value="1"/>

                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn  blue btn-block btn-outline " onclick="addRowSpare();">Add Item</button>
                            </div>

                            <table id="table_spare" style="font-size: 12px" class="table table-striped table-bordered table-advance table-hover">
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

                            <button type="submit" class="btn btn-success col-md-12" name="btnRegisterPurchaseSpare">
                                <i class="fa fa-plus-o"></i> PROCESS PURCHASE
                            </button>

                            <!--All form elements  End -->

                            <?php
                            $amounted2 = 0;
                            $amount_ = 0;
                            if($ticket['purchase'] == 1){
                                $n = 1;
                                $machineDemands = (array)$database->getPurchaseTicketForServiceCall($ticket['id']);
                                foreach($machineDemands as $demand){
                                    if($demand['sales_type_id'] == 2) {
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
                                                            <a href="<?php echo $host;?>purchase-invoice/<?php echo $demand['ticketNo'];?>" class="btn btn-success"><i class="fa fa-cube"></i>&nbsp;VIEW SUPPLY TICKET</a>
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
                                    <?php }}}?>

                            <br/>

                            <script>
                                function addRowSpare() {
                                    var productID = document.getElementById('nSparePart');
                                    var id = productID.value;
                                    var nID = '<input type="hidden" name="txtProductnSparePart[]" value="' + id + '" /> ';
                                    var selectText = productID.options[productID.selectedIndex].text;
                                    var productname = selectText.substr(selectText.indexOf("---- ") + 4, selectText.length);

                                    var productcode = selectText.substr(0, selectText.indexOf("----"));
                                    var nQty = '<input type="text" placeholder="QTY." required  onkeyup = "javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)"  name="txtProductQtynSparePart[]" class="form-control required" value="' + document.getElementById('nQtySparePart').value + '" />';
                                    var nPrice = '<input type="text" placeholder="PRICE."  onkeyup = "javascript:this.value=Comma(this.value);" required onKeyPress="return isNumberKey(event)"  name="txtProductAmountnSparePart[]" class="form-control required" value="' + document.getElementById('nPriceSparePart').value + '" />';
                                    var Action = "<input type='button' class='btn btn-outline btn-round dark btn-sm black' onclick='removeRowSpare();' value='Remove Row'/>";
                                    var table = document.getElementById('table_spare');
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

                                function removeRowSpare() {
                                    var index, table = document.getElementById('table_spare');
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


                            <hr/>
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
                                <label class="col-lg-2 control-label">SCHEDULE</label>
                                <div class="col-lg-9">
                                    <div class="input-group date form_datetime" data-date="<?php echo date('Y')?>-<?php echo date('m')?>-<?php echo date('d')?>T10:25:07Z" data-date-format="dd MM yyyy / HH:ii p" data-link-field="dtp_input1">
                                        <input class="form-control" name="txtSchDate" size="16" type="text" value="<?php if($ticket['schDate']!=" "){echo $ticket['schDate'].' / '.$ticket['schTime'];}?> " readonly>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                    </div>
                                </div>

                                <input type="hidden" id="dtp_input1" value="" />

                            </div>

                            <div class="form-group">
                                <div class="col-lg-12 col-sm-offset-2">
                                    <?php if(in_array($myData['DepartmentID'], array(1,2,3,6))){?>
                                        <button class="btn aqua" name="btnFollowUp" class="btn btn-success col-lg-9">PROCESS FOLLOW UP</button><?php } ?>
                                    <?php if(in_array($myData['DepartmentID'], array(1,2,3))){?>
                                        <button style="margin-left:70px; " class="btn aqua" name="btnCloseCall" class="btn btn-success col-lg-3">Close Call</button><?php } ?>
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
                                    if($ticket['purchase'] == 1)
                                    {
                                        $n = 1;
                                        $machineDemands = (array)$database->getPurchaseTicketForServiceCall($ticket['id']);
                                        foreach($machineDemands as $demand)
                                        {
                                            if($demand['sales_type_id'] == 1)
                                            {
                                                ?>

                                                <table style="font-size: 12px" class="table table-striped table-bordered table-advance table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th colspan="2">
                                                            <h3><?php echo $demand['ticketNo'];?></h3>
                                                        </th>
                                                        <th colspan="3">

                                                        <?php 
                                                            if($demand['orderCollect']== 0)
                                                            {
                                                        ?>
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

                                                                include("followup/collect-purchase-order.php");
                                                            }
                                                            else
                                                            {
                                                        ?>
                                                                <div class="btn-group">
                                                                    <a href="<?php echo $host;?>purchase-invoice/<?php echo $demand['ticketNo'];?>" class="btn btn-success"><i class="fa fa-cube"></i>&nbsp;VIEW SUPPLY TICKET</a>
                                                                </div>
                                                        <?php 
                                                            }
                                                        ?>
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
                                                    foreach ($salesorder as $order)
                                                    {
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
                                                <?php 
                                                    $n++;$amounted += $amount_; $amounted2 += $amount_;}
                                                ?>
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
                                                        <td colspan="4"><p style="text-align: right">
                                                            DISCOUNT <?php echo $demand['discount'];?>%</p></td>
                                                        <td>
                                                            <?php
                                                            $disc = (($demand['discount']/100) *  $added);
                                                            echo $database->convertToMoney($disc);
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4"><p style="text-align: right">TOTAL</p></td>
                                                        <td>
                                                    <?php
                                                            $dis = $added - $disc;
                                                            echo $database->convertToMoney($dis);
                                                    ?>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table><br/>
                                            <?php 
                                                        }
                                                    }
                                                }
                                            ?>
                                    <br/>
            </form>
        </div>
        <br/>

        <h1  class="text-primary" style="text-align:center;">
            Backdate Call for <?php  echo $supplyTicket = $ticket['ticketNo'];
            $getSupplyTicket = $database->getServiceCallTickectNo($supplyTicket);
            foreach ($getSupplyTicket as $getSupplyTicketID)
            {
                $openedDateTime = $getSupplyTicketID['openedDateTime'];
                $closedDateTime = $getSupplyTicketID['closedDateTime'];
            }
        ?>
        </h1>

        <?php
            if (isset($_POST['closeCall'])) 
            {
                $supplyTicket = $_POST['supplyTicket'];
                $openedDateTime = $_POST['openedDateTime'];
                $closedDateTime = $_POST['closedDateTime'];
                $database->updateBackdatedCall($supplyTicket,$openedDateTime,$closedDateTime);
                $msg = "This Ticket has been backdated";
            }
        ?>

        <form action="" method="POST">
            <div class="form-group">
                <label class="col-sm-2 control-label">Ticket No</label>
                <div class="col-sm-10">
                    <input type="text" name="supplyTicket" value="<?php echo $ticket['ticketNo'];?>" class="form-control" readonly="readonly">
            </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Open Date</label>
                <div class="col-sm-10">
                    <input type="text" name="openedDateTime" value="<?php echo $openedDateTime;?>" class="form-control">
            </div>
            </div>


            <div class="form-group">
                <label class="col-lg-2 control-label">Close DateTime</label>
                <div class="col-lg-9">
                    <div class="input-group date form_date" data-date="<?php echo date('Y')?>-<?php echo date('m')?>-<?php echo date('d')?>T10:25:07Z" data-date-format="dd MM yyyy" data-link-field="dtp_input1">
                        <input class="form-control" name="closedDateTime" size="16" type="text" value="<?php echo $closedDateTime;?>" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                    </div>
                </div>

                <input type="hidden" id="dtp_input1" value="" />

            </div>
            <input type="submit" id="closeCall" class="btn btn-primary btn-block" name="closeCall" value="Backdate!">

        </form>
    </div>
</div>
</div>

<!--All form elements  End -->
</div>
</div>
</div>
</div>
<!-- Go top -->
<a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>
<a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>
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
</body>
</html>