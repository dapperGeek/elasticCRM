<<<<<<< HEAD
<div class="modal fade bs-example-modal-lg-<?php echo $demand['ticketNo'];?>" tabindex="-1" role="dialog" >
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header" style="text-align: center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" ><?php echo $demand['ticketNo'];?></h4>
            <small class="font-bold"><?php echo $ticket['AccountName'];?></small>
            <small class="font-bold"><?php echo $ticket['machine_code'];?></small>
        </div>

             <form method="post">
              <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h4><b>SELECT ORDER CLOSE DATE :</b><input type="hidden" name="txtOrderID" value="<?php echo $demand['id'];?>" /></h4>
                                        </div>
                                        <div class="col-lg-2">
                                            <select name="txtDay" class="form-control">
                                                <?php for($i=1;$i < 32;$i++){ ?>
                                                <option <?php if($i == date('d')){echo "selected";}?>>
                                                    <?php echo $i;?>
                                                </option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <select class="form-control" name="txtMonth">
                                                <?php for($i=1;$i < 13;$i++){ ?>
                                                <option value="<?php echo $i;?>" <?php if($i == date('m')){echo "selected";}?>>
                                                    <?php echo date('F', mktime(0, 0, 0, $i, 10))?>
                                                </option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <select name="txtYear" class="form-control">
                                                <option>
                                                    <?php echo date('Y');?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-lg-4">
                                            <h4><b>VAT SELECT :</b></h4>
                                        </div>
                                        <div class="col-lg-6">
                                             <label class="mt-radio">
                                            <input type="radio" class="iCheck" checked="" value="1" id="optionsRadios22" name="txtVat">
                                            VAT</label>
                                            <label class="mt-radio">
                                            <input type="radio" class="iCheck" checked="" value="0" id="optionsRadios23" name="txtVat">
                                            NO VAT</label>
                                        </div>
                                    </div>




           <small class="font-bold">
                                        <b>
                                            <input type="checkbox" name="check<?php echo $demand['id'];?>" onchange="document.getElementById('btncollectOrder[<?php echo $demand['id'];?>]').disabled = !this.checked;"> I agree and accept that this order was successfully collected on the specified date I provided to this system
                                        </b>
                                    </small>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input type="submit" name="btncollectOrder" disabled="" id="btncollectOrder[<?php echo $demand['id'];?>]" class="btn btn-primary" value="Collect Order"/>
        </div>
        </form>
    </div>
</div>
=======
<div class="modal fade bs-example-modal-lg-<?php echo $demand['ticketNo'];?>" tabindex="-1" role="dialog" >
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header" style="text-align: center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" ><?php echo $demand['ticketNo'];?></h4>
            <small class="font-bold"><?php echo $ticket['AccountName'];?></small>
            <small class="font-bold"><?php echo $ticket['machine_code'];?></small>
        </div>

             <form method="post">
              <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h4><b>SELECT ORDER CLOSE DATE :</b><input type="hidden" name="txtOrderID" value="<?php echo $demand['id'];?>" /></h4>
                                        </div>
                                        <div class="col-lg-2">
                                            <select name="txtDay" class="form-control">
                                                <?php for($i=1;$i < 32;$i++){ ?>
                                                <option <?php if($i == date('d')){echo "selected";}?>>
                                                    <?php echo $i;?>
                                                </option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <select class="form-control" name="txtMonth">
                                                <?php for($i=1;$i < 13;$i++){ ?>
                                                <option value="<?php echo $i;?>" <?php if($i == date('m')){echo "selected";}?>>
                                                    <?php echo date('F', mktime(0, 0, 0, $i, 10))?>
                                                </option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <select name="txtYear" class="form-control">
                                                <option>
                                                    <?php echo date('Y');?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-lg-4">
                                            <h4><b>VAT SELECT :</b></h4>
                                        </div>
                                        <div class="col-lg-6">
                                             <label class="mt-radio">
                                            <input type="radio" class="iCheck" checked="" value="1" id="optionsRadios22" name="txtVat">
                                            VAT</label>
                                            <label class="mt-radio">
                                            <input type="radio" class="iCheck" checked="" value="0" id="optionsRadios23" name="txtVat">
                                            NO VAT</label>
                                        </div>
                                    </div>




           <small class="font-bold">
                                        <b>
                                            <input type="checkbox" name="check<?php echo $demand['id'];?>" onchange="document.getElementById('btncollectOrder[<?php echo $demand['id'];?>]').disabled = !this.checked;"> I agree and accept that this order was successfully collected on the specified date I provided to this system
                                        </b>
                                    </small>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input type="submit" name="btncollectOrder" disabled="" id="btncollectOrder[<?php echo $demand['id'];?>]" class="btn btn-primary" value="Collect Order"/>
        </div>
        </form>
    </div>
</div>
>>>>>>> 48136f1b63a2e7fb659fed72c5bf93f60ec79592
</div>