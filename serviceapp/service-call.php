<?php
    $pageHeader = !isset($_GET['id']) ? 'createServiceCall' : 'editServiceCall';
    $callID = !isset($_GET['id']) ? 0 : $_GET['id'];
    include("../includes/header_with_pageHeading.php");
    $currentCall = isset($_GET['id']) ? $database->getServiceCall($_GET['id']) : array();
    $stores = $database->getAllStores();
     $yr_ = date("Y");
?>
<div class="row">
    <form method="post" class="form-horizontal">
        <div class="row">
            <div class="widgets-container">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <?php echo isset($_GET['id']) ? 'Update Service Call' : 'Make a Call' ?>
                    </div>
                    <div class="panel-body">
                        <?php if(isset($err) && $err != ""){$database->showMsg('',$err,1);}?>
                        <?php if(isset($msg) && $msg != ""){$database->showMsg('',$msg,2);}?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">ACCOUNT</label>
                            <div class="col-sm-10">
                                <select class="_select form-control m-b" name="txtAccount" id="parent" onChange="LoadChildAccounts();" required data-validation-required-message="Account is required">
                                    <optgroup>
                                        <option value="0">----SELECT ACCOUNT----</option>
                                    </optgroup>
                                    <script type="text/javascript">
                                        let callID = <?php echo $callID; ?>;
                                        let accountID = <?php echo $callID > 0 ? $currentCall->account_id : 0 ?> ;
                                        for (let i = 0; i < parentAccounts.length; i++)
                                        {
                                            // display selected account for call updates
                                            if (callID > 0 && accountID == parentAccounts[i][0])
                                            {
                                                document.write('<option selected value="' + parentAccounts[i][0] + '" >' + parentAccounts[i][1] + '</option>');
                                                // LoadChildMachines(i + 1);
                                            }
                                            else // display all accounts dropdown
                                            {
                                                document.write('<option value="' + parentAccounts[i][0] + '" >' + parentAccounts[i][1] + '</option>');
                                            }
                                        }
                                    </script>
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">MACHINE</label>
                            <div class="col-sm-10">
                                <select class="_select form-control m-b" name="txtMachine" required data-validation-required-message="Machine is required" id="gchild" onChange="contractCheck();">
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">REPORTED BY</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control m-b" name="txtReporter" value="<?php echo isset($callID) && $callID > 0 ? $currentCall->ReportedBy : $_POST['txtReporter'] ?? '' ?>" required data-validation-required-message="reporter name is required">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">COST</label>
                            <div class="col-sm-2">

                                <input type="text" class="form-control m-b" name="txtAmount" value="<?php echo isset($callID) && $callID > 0 ? $currentCall->cost : $_POST['txtAmount'] ?? '' ?>" id="txtAmount" required data-validation-required-message="Amount is required">

                            </div>
                            <label class="col-sm-3 control-label">PAYMENT STATUS</label>
                            <div class="col-sm-5">
                                <select class="form-control m-b" name="txtPayStatus" required data-validation-required-message="select payment status">
                                <?php
                                    $cases = (array)$database->getPaymentStatus();
                                    foreach($cases as $case)
                                    {
                                ?>
                                    <option <?php echo $callID > 0 && $currentCall->paymentStatus == $case['pstatus'] ? 'selected' : $_POST['txtAmount'] ?? '' ?>><?php echo $case['pstatus'];?></option>
                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">ISSUES</label>
                            <div class="col-lg-10">
                                <select class="_select js-states form-control" name="issues[]" multiple="multiple">
                                <?php
                                    $issues = (array)$database->getAllIssues();
                                    foreach($issues as $issue)
                                    {
                                        $issues = $callID > 0
                                            ? explode(",", $currentCall->issues)
                                            : array();
                                ?>
                                        <option <?php if(in_array($issue['id'], $issues)){echo 'selected';}?> value="<?php echo $issue['id']?>">
                                            <?php echo $issue['issues'];?>
                                        </option>
                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">CASE STATUS</label>
                            <div class="col-sm-10">
                                <select class="_select form-control m-b" name="txtCaseStatus" required data-validation-required-message="select payment status">
                                <?php
                                    $cases = (array)$database->getCaseStatus();
                                    foreach($cases as $case)
                                    {
                                        if($case['id'] > 7){break;}
                                ?>
                                        <option value="<?php echo $case['id'];?>" <?php echo $callID > 0 && $currentCall->CaseStatus == $case['id'] ? 'selected' : isset($_POST['txtCaseStatus']) &&($case['id'] == $_POST['txtCaseStatus']) ?? ''?>><?php echo $case['caseName'];?></option>
                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">ENGINEER</label>
                            <div class="col-lg-10">
                                <select class="_select form-control m-b" name="txtEngineer" required data-validation-required-message="engineer is required">
                                    <option value="">- SELECT -</option>
                        <?php
                            $engineers = (array)$database->getAllEngineers();
                            foreach($engineers as $eng)
                            {
                        ?>
                            <option value="<?php echo $eng['id'];?>" <?php echo $callID > 0 && $currentCall->engineer == $eng['id'] ? 'selected' : isset($_POST['txtEngineer']) && $_POST['txtEngineer'] == $eng['id'] ?? '' ?>><?php echo $eng['fullname']; ?></option>
                        <?php
                            }
                        ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">ScheduleDate</label>
                            <div class="input-group date form_datetime col-lg-4" data-date="<?php echo date('Y')?>-<?php echo date('m')?>-<?php echo date('d')?>T10:25:07Z" data-date-format="dd MM yyyy / HH:ii p" data-link-field="dtp_input1">
                                <input class="form-control" name="txtSchDate" size="16" type="text" value="<?php echo $callID > 0 ? $currentCall->schDate . '/' . $currentCall->schTime : $_POST['txtSchDate'] ?? '' ?> " required="required" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            </div>
                            <input type="hidden" id="dtp_input1" value="" />
                            <input type="hidden" name="callID" value="<?php echo $callID; ?>">
                            <input type="hidden" name="ticketNo" value="<?php echo $callID > 0 ? $currentCall->ticketNo : '' ; ?>">
                        </div>
                        <hr>

                        <div class="form-group">
                            <div class="col-lg-12 col-sm-offset-2">
                        <button class="btn aqua" name="btnRegisterCall" class="btn btn-success col-lg-12"><?php echo $callID > 0 ? 'UPDATE SERVICE CALL' : 'PROCESS SERVICE CALL' ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>
<?php
include '../includes/footer.php';