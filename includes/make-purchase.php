<?php if(isset($_POST['btnPurchase'])){
    $machineID = $database->test_input($_POST['txtMachine']);
    $accID = $database->test_input($_POST['txtAccount']);
    $database->redirect_to($host."purchase-item/".$machineID."?acID=".$accID);
}
?>
<script type="text/javascript">
            var parent = <?php echo $database->getArrayAllAccounts();?>;
            var gchild = <?php echo $database->getArrayOfMachines();?>;

            function LoadChild() {
                var i = document.getElementById("parent").selectedIndex;
                var dp2 = document.getElementById("gchild");
                var count2 = gchild[i - 1].length;

                var html2 = "<option value=\"\" disabled selected hidden>- select -</option><option value='0'>- NO MACHINE -</option>";
                for (var k = 0; k < count2; k++) {
                    html2 += "<option value=\"" + gchild[i - 1][k][0] + "\">" + gchild[i - 1][k][1] + "</option>";
                }

                dp2.innerHTML = html2;
            }
        </script>
<div class="modal fade bs-example-modal-lg-make-purchase" tabindex="-1" role="dialog" >
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header" style="text-align: center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" >MAKE QUICK PURCHASE</h4>

        </div>

             <form method="POST">
              <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <h4><b>SELECT ACCOUNT :</b></h4>
                                        </div>
                                        <div class="col-lg-4">
                                            <select class="form-control m-b" id="parent" name="txtAccount" onChange="LoadChild();" required data-validation-required-message="Account is required">
                                                            <option value="" disabled selected hidden>- select -</option>
                                                            <script type="text/javascript">
                                                                // document.writeln('Parent Lenght: '+parent.lenght);
                                                                for (var i = 0; i < parent.length; i++) {
                                                                    document.write('<option value="' + parent[i][0] + '">' + parent[i][1] + '</option>');
                                                                }
                                                            </script>

                                                        </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <h4><b>SELECT MACHINE :</b></h4>

                                        </div>
                                        <div class="col-lg-4">
                                           <select class="form-control m-b" name="txtMachine" required data-validation-required-message="Machine is required" id="gchild" onChange="contractCheck();">

                                                        </select>
                                        </div>
                                    </div>





           <small class="font-bold">
                                        <b>
                                            <input type="checkbox" name="check" onchange="document.getElementById('btnPurchase').disabled = !this.checked;"> I agree and accept that this order was successfully collected on the specified date I provided to this system
                                        </b>
                                    </small>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input type="submit" name="btnPurchase" disabled="" id="btnPurchase" class="btn btn-primary" value="Start Purchase"/>
        </div>
        </form>
    </div>
</div>
</div>