<?php
/**
 * Created by PhpStorm.
 * User: Uthman A. Bakar
 * Date: 09-Jul-20
 * Time: 10:47 AM
 */
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

    function callEditStock<?php echo $prod['id'];?>(id) {

        let mainStore =$('input[name="main_store<?php echo $prod['id'];?>"]').val();
        let mainSwitch = document.getElementById("main_switch" + id).checked;
        let mainEdit =$('input[name="main_update<?php echo $prod['id'];?>"]').val();

        let officeStore =$('input[name="office_store<?php echo $prod['id'];?>"]').val();
        let officeSwitch = document.getElementById("office_switch" + id).checked;
        let officeEdit =$('input[name="office_update<?php echo $prod['id'];?>"]').val();

        let abjStore =$('input[name="abj_store<?php echo $prod['id'];?>"]').val();
        let abjSwitch = document.getElementById("abj_switch" + id).checked;
        let abjEdit =$('input[name="abj_update<?php echo $prod['id'];?>"]').val();

        let dmgStore =$('input[name="dmg_store<?php echo $prod['id'];?>"]').val();
        let dmgSwitch = document.getElementById("dmg_switch" + id).checked;
        let dmgEdit =$('input[name="dmg_update<?php echo $prod['id'];?>"]').val();

        let remarks =$('input[name="remarks<?php echo $prod['id'];?>"]').val();

        if(confirm("Are you sure you want to edit this?")){
            // send to controller if no error occurs
            // $('.savepass').hide();
            //show loading animation
            // $('.loading-gif').show();

            let newMain = upOrDown(mainStore, mainEdit, mainSwitch);
            let newAbj = upOrDown(abjStore, abjEdit, abjSwitch);
            let newOffice = upOrDown(officeStore, officeEdit, officeSwitch);
            let newDamaged = upOrDown(dmgStore, dmgEdit, dmgSwitch);

            $.ajax({
                type: 'POST',
                url: "<?php echo $host;?>/settings/stock-edit-action.php",
                data: {
                    'productID': id,
                    'newMain': newMain,
                    'newAbj': newAbj,
                    'newOffice': newOffice,
                    'newDamaged': newDamaged,
                    'mainEdit': mainEdit,
                    'officeEdit': officeEdit,
                    'abjEdit': abjEdit,
                    'dmgEdit': dmgEdit,
                    'mainSwitch': mainSwitch,
                    'officeSwitch': officeSwitch,
                    'abjSwitch': abjSwitch,
                    'dmgSwitch': dmgSwitch,
                    'remarks': remarks},
                success: function(response){

                    // $('.loading-gif').hide();
                    var success = response['success'];
                    var msg = response['msg'];

                    if(success){// if server side update succeeds

                        statusMsg = 'Product stock info updated successfully';
                        msg_class = 'sxs-msg';

                        $('#modal-msg').html(statusMsg).addClass(msg_class).show();
                    }
                    else{// if server side error occurs

                        statusMsg = msg;
                        msg_class = 'err-msg';
                        // $('.savepass').show();
                    }
                    //console.log(response);
                }
            });
        }
    }

    function upOrDown(store, update, sign) {
        let result = 0;
        switch (sign) {
            case true :
                result = parseInt(store) + parseInt(update);
                break;

            case false :
                result = parseInt(store) - parseInt(update);
                break;

            default:
                result = parseInt(store);
                break;
        }
        return result;
    }
</script>

<div class="modal fade stock-modal-<?php echo $prod['id'];?>" id="stock-modal-<?php echo $prod['id'];?>" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">EDIT <?php echo strtoupper($prod['productName']);?> STOCK</h4>
            </div>
            <!---- the beginning of the form-->

            <div class="modal-body">
                <div class="invoice">
                    <div class="row">
                        <label class="col-md-2">&nbsp;</label>
                        <label class="col-md-2">&nbsp;</label>
                        <div class="col-md-6" style="text-align: center">
                            <img src="<?php echo $host;?>img/LoaderIcon.gif" style="display:none" id="loaderIcon<?php echo $prod['id'];?>"  width="30" height="30" />
                            <label class="label label-success col-md-12" style="display:none" id="responseFor-<?php echo $prod['id'];?>">You have successfully edited this product</label>
                            <label class="label label-danger col-md-12" style="display:none" id="responseFor2-<?php echo $prod['id'];?>">Please all fields are required </label>
                        </div>
                    </div>

                    <form method="post">
                        <div class="row bottom10">
                            <label class="col-md-1">&nbsp;</label>
                            <label class="col-md-2">STORES</label>
                            <div class="col-md-3">

                                <b>CURRENT QTY.</b>

                            </div>
                            <div class="col-md-1">

                            </div>
                            <div class="col-md-2">
                                UPDATE AMOUNT
                            </div>

                        </div>

                        <div class="row bottom10">
                            <label class="col-md-1">&nbsp;</label>
                            <label class="col-md-2">Main Warehouse</label>
                            <div class="col-md-3">

                                <input class="form-control margin-bottom-5 " type="text" readonly name="main_store<?php echo $prod['id'];?>" value="<?php echo $prod['store1'] ; ?>">
                            </div>

                            <div class="col-md-2">

                                <span class="symbols">-</span>
                                <input type="checkbox" name="main_switch<?php echo $prod['id'];?>" id="main_switch<?php echo $prod['id'];?>">
                                <span class="symbols">+</span>
                            </div>

                            <div class="col-lg-2">
                                <input class="form-control margin-bottom-5" type="number"  name="main_update<?php echo $prod['id'];?>" value="0">
                            </div>

                        </div>

                        <div class="row bottom10">
                            <label class="col-md-1">&nbsp;</label>
                            <label class="col-md-2">Office Store</label>
                            <div class="col-md-3">

                                <input class="form-control margin-bottom-5" type="text" readonly name="office_store<?php echo $prod['id'];?>" value="<?php echo $prod['store2'] ; ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="switch">
                                    <span class="symbols">-</span>
                                    <input type="checkbox" name="office_switch<?php echo $prod['id'];?>" id="office_switch<?php echo $prod['id'];?>">
                                    <span class="symbols">+</span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control margin-bottom-5" type="number"  name="office_update<?php echo $prod['id'];?>" value="0">
                            </div>

                        </div>

                        <div class="row bottom10">
                            <label class="col-md-1">&nbsp;</label>
                            <label class="col-md-2">Abuja Store</label>
                            <div class="col-md-3">

                                <input class="form-control margin-bottom-5" type="text" readonly name="abj_store<?php echo $prod['id'];?>" value="<?php echo $prod['store3'] ; ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="switch">
                                    <span class="symbols">-</span>
                                    <input type="checkbox" name="abj_switch<?php echo $prod['id'];?>" id="abj_switch<?php echo $prod['id'];?>">
                                    <span class="symbols">+</span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control margin-bottom-5" type="number"  name="abj_update<?php echo $prod['id'];?>" value="0">
                            </div>

                        </div>

                        <div class="row bottom10">
                            <label class="col-md-1">&nbsp;</label>
                            <label class="col-md-2">Damaged</label>
                            <div class="col-md-3">

                                <input class="form-control margin-bottom-5" type="text" readonly name="dmg_store<?php echo $prod['id'];?>" value="<?php echo $prod['damaged'] ; ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="switch">
                                    <span class="symbols">-</span>
                                    <input type="checkbox" name="dmg_switch<?php echo $prod['id'];?>" id="dmg_switch<?php echo $prod['id'];?>">
                                    <span class="symbols">+</span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control margin-bottom-5" type="number"  name="dmg_update<?php echo $prod['id'];?>" value="0">
                            </div>

                        </div>

                        <div class="row bottom10">
                            <label class="col-md-1">&nbsp;</label>
                            <label class="col-md-2">Remarks</label>
                            <div class="col-md-6">

                                <textarea style="width: 100%; height: 80px; margin: auto; border-radius: 5px" name="remarks<?php echo $prod['id'];?>" class="form-control margin-bottom-5"></textarea>

                            </div>

                        </div>


                        <div class="row">
                            <label class="col-md-2">&nbsp;</label>
                            <label class="col-md-2">&nbsp;</label>
                            <div class="col-md-6">
                                <button class="btn btn-warning col-md-12" onclick="callEditStock<?php echo $prod['id'];?>('<?php echo $prod['id'] ?>')" >EDIT STOCK INFO</button>
                            </div>
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Dismiss</button>


                </div>

            </div>
        </div>
    </div>