<?php
/**
 * Created by PhpStorm.
 * User: Uthman A. Bakar
 * Date: 18-Aug-20
 * Time: 1:20 PM
 */

    $contractDetails = $database->selectAcctContractInfo($_GET['id']);
?>

<style type="text/css">
    body {
        margin:0;
        padding:0;
        background:#ccc;
    }

    .symbols {
        font-size: 25px;
        font-weight: bold;
        vertical-align: bottom;
    }
    .center {
        position:absolute;
        left:50%;
        top:50%;
        transform:translate(-50%, -50%);
    }

    input[type="checkbox"] {
        margin: 10px;
        position: relative;
        width: 40px;
        height: 11px;
        -webkit-appearance: none;
        background: linear-gradient(0deg, #ede7e7, rgba(0, 0, 0, 0.37));
        outline: none;
        border-radius: 20px !important;
        box-shadow: 0 0 0 4px #d5cece, 0 0 0 5px #d0cccc, inset 0 0 10px rgba(0, 0, 0, 0.43);
    }

    input:checked[type="checkbox"]:nth-of-type(1) {
        background: linear-gradient(0deg, #e63713, #f33e1f);
        box-shadow: 0 0 0 4px #353535, 0 0 0 5px #3e3e3e, inset 0 0 10px rgba(0, 0, 0, 0.25);
    }

    input:checked[type="checkbox"]:nth-of-type(2) {
        background: linear-gradient(0deg, #70a1ff, #1e90ff);
        box-shadow: 0 0 0 4px #353535, 0 0 0 5px #3e3e3e, inset 0 0 10px rgba(0,0,0,1);
    }

    input[type="checkbox"]:before {
        content:'';
        position:absolute;
        top:0;
        left:0;
        width:20px;
        height:10px;
        background: linear-gradient(0deg, #000, #6b6b6b);
        border-radius: 20px;
        box-shadow: 0 0 0 1px #232323;
        transform: scale(.98,.96);
        transition:.5s;
    }

    input:checked[type="checkbox"]:before {
        left:20px;
    }

    input[type="checkbox"]:after {
        content: '';
        position: absolute;
        top: calc(50% - 2px);
        left: 10px;
        width: 2px;
        height: 4px;
        background: linear-gradient(0deg, #6b6b6b, #000);
        border-radius: 50%;
        transition: .5s;
    }

    input:checked[type="checkbox"]:after {
        left:35px;
    }

    h1 {
        margin:0;
        padding:0;
        font-family: sans-serif;
        text-align:center;
        color:#fff;
        font-size:16px;
        padding:15px 0;
        text-transform: uppercase;
        letter-spacing:4px;
    }
</style>

<script>

    function editContract(id) {

        let contractType = $("#txtContractType").val();
        let cumulative = $("#cumulative").val();
        let rentalCharge = $('input[name="txtRentalCharge"]').val();
        let volMono = $('input[name="txtVolMono"]').val();
        let costMono = $('input[name="txtCostMono"]').val();
        let exVolMono = $('input[name="txtExVolMono"]').val();
        let exCostMono = $('input[name="txtExCostMono"]').val();
        let volColor = $('input[name="txtVolColor"]').val();
        let costColor = $('input[name="txtCostColor"]').val();
        let exVolColor = $('input[name="txtExVolColor"]').val();
        let exCostColor = $('input[name="txtExCostColor"]').val();
        let conStart = $('input[name="txtCS"]').val();
        let contractDuration = $("#txtContractDuration").val();
        let billingType = $("#txtBillingType").val();

        if(confirm("Are you sure you want to edit this contract?")){

            $.ajax({
                type: 'POST',
                url: "<?php echo $host;?>/includes/edit_contract.php",
                data: {
                    'edit_contract': 1,
                    'accountID': id,
                    'contractType': contractType,
                    'cumulative': cumulative,
                    'rentalCharge': rentalCharge,
                    'volMono': volMono,
                    'costMono': costMono,
                    'exVolMono': exVolMono,
                    'exCostMono': exCostMono,
                    'volColor': volColor,
                    'costColor': costColor,
                    'exVolColor': exVolColor,
                    'exCostColor': exCostColor,
                    'conStart': conStart,
                    'contractDuration': contractDuration,
                    'billingType': billingType},
                success: function(response){

                    // $('.loading-gif').hide();
                    let success = response['success'];
                    let msg = response['msg'];

                    // if(success){// if server side update succeeds
                    //
                    //     statusMsg = msg;
                    //     msg_class = 'sxs-msg';
                    // }
                    // else{// if server side error occurs
                    //
                    //     statusMsg = msg;
                    //     msg_class = 'err-msg';
                    // }
                    //console.log(response);
                    $('#modal-msg').html(statusMsg).addClass(msg_class).show();
                }
            });
        }
    }
</script>

<div class="modal fade contract-modal" id="contract-modal" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">EDIT CONTRACT</h4>
            </div>
            <!---- the beginning of the form-->

            <div class="modal-body">
                <div class="invoice">
                    <div class="row">
                        <label class="col-md-2">&nbsp;</label>
                        <label class="col-md-2">&nbsp;</label>
                        <div class="col-md-6" style="text-align: center">
                            <img src="<?php echo $host;?>img/LoaderIcon.gif" style="display:none" id="loaderIcon"  width="30" height="30" />
                            <label class="label label-success col-md-12" style="display:none" id="responseFor-">You have successfully edited this product</label>
                            <label class="label label-danger col-md-12" style="display:none" id="responseFor2-">Please all fields are required </label>
                        </div>
                    </div>

                    <form method="post" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">&nbsp;</label>
                            <div class="col-sm-10">
                                <?php if(isset($err) && $err != ""){$database->showMsg('',$err,1);}?>
                                <?php if(isset($msg) && $msg != ""){$database->showMsg('',$msg,2);}?>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">CONTRACT TYPE</label>
                            <div class="col-sm-2">
                                <select class="form-control" id="txtContractType" name="txtContractType">
                                    <option value="">--select--</option>
                                    <?php
                                    $allContracts = (array)$database->getAllContracts();
                                    foreach ($allContracts as $contract) {
                                        ?>
                                        <option value="<?php echo $contract['id'];?>"
                                            <?php if(isset($contractDetails['contractName']) && $contractDetails['contractName'] == $contract['contractName']){
                                                echo "selected";}?>><?php echo $contract['c_name'];?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <label class="col-sm-2 control-label">TYPE 2</label>
                            <div class="col-sm-2">
                                <select class="form-control" id="cumulative" name="cumulative">
                                    <?php
                                    foreach ($billingTypes as $key => $bTypes) {
                                        ?>
                                        <option value="<?php echo $key;?>"
                                            <?php if(isset($contractDetails['cummulative']) && $contractDetails['cummulative'] == $key){echo "selected";}?>><?php echo $bTypes;?></option>
                                    <?php
                                            }
                                    ?>
                                </select>
                            </div>
                            <label class="col-sm-2 control-label">RENTAL CHARGE</label>
                            <div class="col-sm-2">

                                <input type="text" placeholder="AMOUNT" onKeyPress="return isNumberKey(event)" value="<?php echo isset($contractDetails['RentalCharge']) ? $contractDetails['RentalCharge'] : 0.00 ?>" name="txtRentalCharge" class="form-control" onkeyup = "javascript:this.value=Comma

(this.value);" required />
                            </div>
                        </div> <hr/>

                        <div class="form-group">

                            <label class="col-sm-2 control-label">MIN-VOL-MONO</label>
                            <div class="col-sm-2">
                                <input type="text" placeholder="volume" onKeyPress="return isNumberKey(event)" name="txtVolMono" value="<?php echo isset($contractDetails['min_vol_mono']) ? $contractDetails['min_vol_mono'] : 0.00 ?>" class="form-control" required />

                            </div>
                            <label class="col-sm-2 control-label">COST-MONO</label>
                            <div class="col-sm-2">
                                <input type="text" placeholder="AMOUNT" onkeypress="return fun_AllowOnlyAmountAndDot(this.id);" value="<?php echo isset($contractDetails['cost_mono']) ? $contractDetails['cost_mono'] : 0.00 ?>" name="txtCostMono" class="form-control" onkeyup = "javascript:this.value=Comma(this.value);" required />

                            </div>

                            <label class="col-sm-1 control-label">TOTAL:</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="total" readonly="readonly" class="form-control" />


                            </div>
                        </div>

                        <div class="form-group">

                            <label class="col-sm-2 control-label">EXCESS-VOL-MONO</label>
                            <div class="col-sm-2">
                                <input type="text" placeholder="volume" onKeyPress="return isNumberKey(event)" name="txtExVolMono" value="<?php echo isset($contractDetails['excess_mono']) ? $contractDetails['excess_mono'] : 0.00 ?>" class="form-control" required />

                            </div>
                            <label class="col-sm-2 control-label">EXCESS-COST-MONO</label>
                            <div class="col-sm-2">
                                <input type="text" placeholder="AMOUNT" onkeypress="return fun_AllowOnlyAmountAndDot(this.id);" value="<?php echo isset($contractDetails['excess_cost_mono']) ? $contractDetails['excess_cost_mono'] : 0.00 ?>" name="txtExCostMono" class="form-control" onkeyup = "javascript:this.value=Comma(this.value);" required />

                            </div>

                            <label class="col-sm-1 control-label"></label>
                            <div class="col-sm-3">

                            </div>
                        </div>

                        <hr/>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">MIN-VOL-COLOR</label>
                            <div class="col-sm-2">
                                <input type="text" placeholder="volume" value="<?php echo isset($contractDetails['min_vol_color']) ? $contractDetails['min_vol_color'] : 0.00 ?>" onKeyPress="return isNumberKey(event)" name="txtVolColor" class="form-control" required />


                            </div>
                            <label class="col-sm-2 control-label">COST-COLOR</label>
                            <div class="col-sm-2">
                                <input type="text" placeholder="AMOUNT" value="<?php echo isset($contractDetails['cost_color']) ? $contractDetails['cost_color'] : 0.00 ?>" onkeypress="return fun_AllowOnlyAmountAndDot(this.id);" name="txtCostColor" class="form-control" onkeyup = "javascript:this.value=Comma(this.value);" required />

                            </div>
                            <label class="col-sm-1 control-label">TOTAL:</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="total" readonly="readonly" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">EXCESS-VOL-COLOR</label>
                            <div class="col-sm-2">
                                <input type="text" placeholder="volume" value="<?php echo isset($contractDetails['excess_color']) ? $contractDetails['excess_color'] : 0.00 ?>" onKeyPress="return isNumberKey(event)" name="txtExVolColor" class="form-control" required />


                            </div>
                            <label class="col-sm-2 control-label">EXCESS-COST-COLOR</label>
                            <div class="col-sm-2">
                                <input type="text" placeholder="AMOUNT" value="<?php echo isset($contractDetails['excess_cost_color']) ? $contractDetails['excess_cost_color'] : 0.00 ?>" onkeypress="return fun_AllowOnlyAmountAndDot(this.id);" name="txtExCostColor" class="form-control" onkeyup = "javascript:this.value=Comma(this.value);" required />

                            </div>
                        </div>
                        <hr/>

                        <div class="form-group row">
                            <label class="col-sm-2 control-label">CONTRACT START</label>
                            <div class="col-sm-6">
                                <div class="input-group date form_date col-md-12" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2"
                                     data-link-format="yyyy-mm-dd">
                                    <input class="form-control" type="text" name="txtCS" value="<?php echo isset($contractDetails['conStart']) ? $contractDetails['conStart'] : '' ; ?>" required="required" readonly>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                                <input type="hidden" id="dtp_input2" value="" />

                            </div>

<!--                            <label class="col-sm-2 control-label">CONTRACT END</label>-->
<!--                            <div class="col-sm-4">-->
<!--                                <div class="input-group date form_date col-md-12" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2"-->
<!--                                     data-link-format="yyyy-mm-dd">-->
<!--                                    <input class="form-control" type="text" name="txtCEnds" value="--><?php //if(isset($_POST['txtCEnds'])){ echo $_POST['txtCEnds'];}?><!--" required="required" readonly>-->
<!--                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>-->
<!--                                </div>-->
<!--                                <input type="hidden" id="dtp_input2" value="" />-->
<!---->
<!--                            </div>-->

                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 control-label">CONTRACT DURATION</label>
                            <div class="col-sm-4">
                                <select class="form-control m-b" id="txtContractDuration" name="txtContractDuration">
                                    <?php for($i = 1;$i <12;$i++){?>
                                        <option value="<?php echo $i;?>" <?php if(isset($contractDetails['contract_duration']) && $contractDetails['contract_duration'] == $i)
                                        {
                                            echo "selected";
                                        } ?>>
                                            <?php echo $i ;?> YEARS</option>
                                        <?php
                                    }
                                    ?>
                                </select>

                            </div>
                            <label class="col-sm-2 control-label">BILLING TYPE</label>
                            <div class="col-sm-4">
                                <select id="txtBillingType" class="form-control m-b" name="txtBillingType">

                                    <?php
                                    $bt = (array)$database->getBillingType();
                                    foreach ($bt as $bts) {
                                        ?>

                                        <option value="<?php echo $bts['value'];?>" <?php if(isset($contractDetails['billingType']) && $contractDetails['billingType'] == $bts['value']){echo "selected";} ?>><?php echo $bts['BillingType'];?></option>

                                    <?php }?>
                                </select>

                            </div>
                        </div>

                        <hr>


                        <div class="form-group">
                            <div class="col-lg-3"></div>
                            <div class="col-sm-6">
                                <button onclick="editContract(<?php echo $_GET['id'] ?>)" name="btnEditContract" class="btn btn-primary col-lg-12" type="submit">
                                    <i class="fa fa-edit"></i>&nbsp;Edit Contract</button>

                            </div>
                            <div class="col-lg-3"></div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Dismiss</button>


                </div>

            </div>
        </div>
    </div>

</div>
