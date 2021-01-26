<?php
    $callID = addslashes($_GET['id']);
    $pageHeader = isset(filter_input($_GET['id'])) ? 'editServiceCall' : 'createServiceCall';
    include("../includes/header_with_pageHeading.php");
    $stores = $database->getAllStores();

    $yr_ = date("Y");
//    if($myData['changePass'] == 0)
//    {
//        //  $database->redirect_to($host."change-password");
//    }
?>

    <div class="row">

    <form method="post" class="form-horizontal">
        <div class="row">
            <div class="widgets-container">
                <div class="panel panel-primary">
                    <div class="panel-heading">Make a Call </div>
                    <div class="panel-body">
                        <?php if(isset($err) && $err != ""){$database->showMsg('',$err,1);}?>
                        <?php if(isset($msg) && $msg != ""){$database->showMsg('',$msg,2);}?>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">ACCOUNT</label>
                            <div class="col-sm-10">
                                <select class="form-control m-b" id="parent" name="txtAccount" onChange="LoadChildAccounts();" required data-validation-required-message="Account is required">
                                    <option value="" disabled selected hidden>- select -</option>
                                    <script type="text/javascript">
                                        // document.writeln('Parent Lenght: '+parent.lenght);
                                        for (var i = 0; i < parentAccounts.length; i++) {
                                            document.write('<option value="' + parentAccounts[i][0] + '">' + parentAccounts[i][1] + '</option>');
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
                                        $issues = isset($ticket)
                                            ? explode(",",$ticket['issues'])
                                            : array();
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
                                <input class="form-control" name="txtSchDate" size="16" type="text" value="<?php if(isset($_POST['txtSchDate'])){echo $_POST['txtSchDate'];}?> " required="required" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            </div>
                            <input type="hidden" id="dtp_input1" value="" />

                        </div>
                        <hr>

                        <div class="form-group">
                            <div class="col-lg-12 col-sm-offset-2">
                                
                    <?php
                            if(isset($callID))
                            {
                    ?>
                                <button class="btn aqua" name="btnUpdateCall" class="btn btn-success col-lg-12">UPDATE SERVICE CALL</button>
                    <?php
                            }
                            else
                            {
                    ?>
                                <button class="btn aqua" name="btnRegisterCall" class="btn btn-success col-lg-12">PROCESS SERVICE CALL</button>
                    <?php
                            }
                    ?>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

    </form>

<?php
include '../includes/footer.php';