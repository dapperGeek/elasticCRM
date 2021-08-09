<?php
//    require_once("data/DBConfig.php");
?>
<script>
    function callDeleteTicket<?php echo $act['callID'] ?>(id) {
        let callID = $("#callID<?php echo $act['callID']; ?>").val();
        $("#loaderIcon<?php echo $act['callID']; ?>").show();
        let deleteUri = 'http://localhost/elastic25.com/settings/delete-call-action.php';
        // console.log(deleteUri);

        $.ajax({
            type: 'POST',
            url: deleteUri
            data: {
                'callID': callID,
                'action': 'delete'
            },
            success: function(response)
            {
                //$("#loaderIcon<?php //echo $act['callID']; ?>//").hide();
                $("#responseFor-<?php echo $act['id'];?>").fadeIn(2000);
                $("#responseFor-<?php echo $act['id'];?>").fadeOut(2000);
                location.reload(true);
            }

            error: function(xhr, status, error) {
                let err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
            }
        });

    }
</script>
<div class="modal fade delete-ticket-modal-<?php echo $act['callID'];?>" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete <?php echo strtoupper($act['ticketNo']);?> </h4>
            </div>
            <!---- the beginning of the form-->

            <div class="modal-body">
                <div class="invoice">
                    <div class="row">
                        <label class="col-md-2">&nbsp;</label>
                        <label class="col-md-2">&nbsp;</label>
                        <div class="col-md-6" style="text-align: center">
                            <img src="<?php echo $host;?>img/LoaderIcon.gif" style="display:none" id="loaderIcon<?php echo $act['callID'];?>"  width="30" height="30" />
                            <label class="label label-success col-md-12" style="display:none" id="responseFor-<?php echo $act['callID'];?>">You have successfully deleted this service call</label>
                        </div>
                    </div>

                    <div class="row" style="text-align: left">
                        <div class="col-lg-3">&nbsp;</div>
                        <div class="col-lg-6 margin-right-10">
                            <center><h4>SERVICE CALL INFO</h4></center>
                            <p><b>Ticket No.:</b> <?php echo $act['ticketNo'] ?></p>
                            <p><b>Account:</b> <?php echo $act['AccountName'] ?></p>
                            <p><b>Machine:</b> <?php echo $act['machine_code'] ?></p>
                            <input type="hidden" id="callID<?php echo $act['callID']; ?>" value="<?php echo $act['callID']; ?>" />
                        </div>
                    </div>

                    <div class="row">

                    </div>
                    <div class="row">
                        <label class="col-md-3">&nbsp;</label>
                        <div class="col-md-6">
                            <button class="btn btn-warning col-md-12" onClick="callDeleteTicket<?php echo $act['callID'];?>(<?php echo $act['callID'] ?>)">CONFIRM DELETE</button>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Dismiss</button>


                </div>

            </div>
        </div>
    </div>

