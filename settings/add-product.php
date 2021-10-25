<script>
<<<<<<< HEAD
    function callAddAction(action,id) {

        var catID = $("#catID").val();
        var prodName = $("#prodName").val();
        var prodCode = $("#prodCode").val();
        var prodPrice = $("#prodPrice").val();
        var unitID = $("#unitID").val();

        var queryString = 'action=add&catID='+catID+'&prodName='+prodName+'&prodCode='+prodCode+'&prodPrice='+prodPrice+'&id='+id+'&unitID='+unitID;
        //alert("URL: "+queryString);
        if(catID!= "" && prodName != "" && prodCode != "" && prodPrice != ""){
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "<?php echo $host;?>/settings/product-action.php",
                data:queryString,
                type: "POST",
                success:function(data){

                    $("#responseFor").fadeIn(2000);
                    $("#responseFor").fadeOut(2000);
                    $("#loaderIcon").hide();
                    //location.href = <?php //echo $host ?>// + '/products/' + catID ;
                    window.location.href = "<?php echo $host ?>/view-products/" + catID;
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            });
        }else{
            // alert("Url"+queryString);
            $("#responseFor2").fadeIn(2000);
            $("#responseFor2").fadeOut(2000);
        }
    }
</script>
<div class="modal fade bs-example-modal-lg-2-add" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header success">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">ADD NEW PRODUCT </h4>
            </div>
            <!---- the beginning of the form-->

            <div class="modal-body">
                <div class="invoice">
                    <div class="row">
                        <label class="col-md-2">&nbsp;</label>
                        <label class="col-md-2">&nbsp;</label>
                        <div class="col-md-6" style="text-align: center">
                            <img src="<?php echo $host;?>img/LoaderIcon.gif" style="display:none" id="loaderIcon"  width="30" height="30" />
                            <label class="label label-success col-md-12" style="display:none" id="responseFor">YOU HAVE SUCCESSFULLY ADDED A NEW PRODUCT</label>
                            <label class="label label-danger col-md-12" style="display:none" id="responseFor2">Please all fields are required </label>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-md-2">&nbsp;</label>
                        <label class="col-md-2">CATEGORY</label>
                        <div class="col-md-6">
                            <select id="catID" name="catID" class="form-control margin-bottom-5">
                                <?php
                                $cat2 = (array)$database->getProductsCategory();
                                foreach($cat2 as $cat22){
                                    ?>
                                    <option value="<?php echo $cat22['id'];?>">
                                        <?php echo $cat22['type'];?>
                                    </option>
                                <?php }?>
                            </select>
                        </div>

                    </div>
                    <div class="row">
                        <label class="col-md-2">&nbsp;</label>
                        <label class="col-md-2">PRODUCT NAME:</label>
                        <div class="col-md-6">
                            <input class="form-control margin-bottom-5" id="prodName" name="prodName" value=""/>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-md-2">&nbsp;</label>
                        <label class="col-md-2">PRODUCT CODE:</label>
                        <div class="col-md-6">
                            <input class="form-control margin-bottom-5" id="prodCode" name="prodCode" value=""/>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-md-2">&nbsp;</label>
                        <label class="col-md-2">PRODUCT PRICE:</label>
                        <div class="col-md-6">
                            <input id="prodPrice" onkeyup = "javascript:this.value=Comma(this.value);" class="form-control margin-bottom-5" onKeyPress="return isNumberKey(event)" name="" value=""/>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-2">&nbsp;</label>
                        <label class="col-md-2">PRODUCT UNIT:</label>
                        <div class="col-md-6">
                            <select id="unitID" name="unitID" class="form-control margin-bottom-5">
                                <?php
                                $cat2 = (array)$database->getProductsUnits();
                                foreach($cat2 as $cat22){
                                    ?>
                                    <option value="<?php echo $cat22['id'];?>">
                                        <?php echo $cat22['unitName'];?>
                                    </option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-2">&nbsp;</label>
                        <label class="col-md-2">&nbsp;</label>
                        <div class="col-md-6">
                            <button class="btn btn-success col-md-12" onClick="callAddAction('add','')">ADD NEW PRODUCT INFO</button>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Dismiss</button>

                </div>

            </div>
        </div>
    </div>
=======
      function callAddAction(action,id) {

         var catID = $("#catID").val();
         var prodName = $("#prodName").val();
         var prodCode = $("#prodCode").val();
         var prodPrice = $("#prodPrice").val();
         var unitID = $("#unitID").val();

                  var queryString = 'action=add&catID='+catID+'&prodName='+prodName+'&prodCode='+prodCode+'&prodPrice='+prodPrice+'&id='+id+'&unitID='+unitID;
                  //alert("URL: "+queryString);
                  if(catID!= "" && prodName != "" && prodCode != "" && prodPrice != ""){
                  $("#loaderIcon").show();
                  jQuery.ajax({
                        url: "<?php echo $host;?>/settings/product-action.php",
                        data:queryString,
                        type: "POST",
                        success:function(data){

                          $("#responseFor").fadeIn(2000);
                          $("#responseFor").fadeOut(2000);
                          $("#loaderIcon").hide();
                           location.reload(true);
                        },
                       error: function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            alert(err.Message);
                          }
                      });
              }else{
                // alert("Url"+queryString);
                         $("#responseFor2").fadeIn(2000);
                          $("#responseFor2").fadeOut(2000);
              }
      }
    </script>
<div class="modal fade bs-example-modal-lg-2-add" tabindex="-1" role="dialog" >
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header success">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">ADD NEW PRODUCT </h4>
                                                            </div>
                                                         <!---- the beginning of the form-->

                                                          <div class="modal-body">
                                                               <div class="invoice">
                                                                   <div class="row">
                                                                       <label class="col-md-2">&nbsp;</label>
                                                                       <label class="col-md-2">&nbsp;</label>
                                                                       <div class="col-md-6" style="text-align: center">
                                                                              <img src="<?php echo $host;?>img/LoaderIcon.gif" style="display:none" id="loaderIcon"  width="30" height="30" />
                                                                              <label class="label label-success col-md-12" style="display:none" id="responseFor">YOU HAVE SUCCESSFULLY ADDED A NEW PRODUCT</label>
                                                                              <label class="label label-danger col-md-12" style="display:none" id="responseFor2">Please all fields are required </label>
                                                                      </div>
                                                                    </div>

                                                                   <div class="row">
                                                                       <label class="col-md-2">&nbsp;</label>
                                                                       <label class="col-md-2">CATEGORY</label>
                                                                         <div class="col-md-6">
                                                                             <select id="catID" name="catID" class="form-control">
                                                                                 <?php
                                                                                    $cat2 = (array)$database->getProductsCategory();
                                                                                    foreach($cat2 as $cat22){
                                                                                 ?>
                                                                                   <option value="<?php echo $cat22['id'];?>">
                                                                                       <?php echo $cat22['type'];?>
                                                                                   </option>
                                                                                   <?php }?>
                                                                         </select>
                                                                         </div>

                                                                   </div>
                                                                   <div class="row">
                                                                        <label class="col-md-2">&nbsp;</label>
                                                                       <label class="col-md-2">PRODUCT NAME:</label>
                                                                       <div class="col-md-6">
                                                                       <input class="form-control" id="prodName" name="prodName" value=""/>
                                                                         </div>
                                                                   </div>

                                                                   <div class="row">
                                                                        <label class="col-md-2">&nbsp;</label>
                                                                       <label class="col-md-2">PRODUCT CODE:</label>
                                                                       <div class="col-md-6">
                                                                       <input class="form-control" id="prodCode" name="prodCode" value=""/>
                                                                         </div>
                                                                   </div>

                                                                   <div class="row">
                                                                        <label class="col-md-2">&nbsp;</label>
                                                                       <label class="col-md-2">PRODUCT PRICE:</label>
                                                                       <div class="col-md-6">
                                                                       <input id="prodPrice" onkeyup = "javascript:this.value=Comma(this.value);" class="form-control" onKeyPress="return isNumberKey(event)" name="" value=""/>
                                                                         </div>
                                                                   </div>
                                                                   <div class="row">
                                                                        <label class="col-md-2">&nbsp;</label>
                                                                       <label class="col-md-2">PRODUCT UNIT:</label>
                                                                       <div class="col-md-6">
                                                                      <select id="unitID" name="unitID" class="form-control">
                                                                                 <?php
                                                                                    $cat2 = (array)$database->getProductsUnits();
                                                                                    foreach($cat2 as $cat22){
                                                                                 ?>
                                                                                   <option value="<?php echo $cat22['id'];?>">
                                                                                       <?php echo $cat22['unitName'];?>
                                                                                   </option>
                                                                                   <?php }?>
                                                                         </select>
                                                                         </div>
                                                                   </div>
                                                                   <div class="row">
                                                                        <label class="col-md-2">&nbsp;</label>
                                                                       <label class="col-md-2">&nbsp;</label>
                                                                       <div class="col-md-6">
                                                                       <button class="btn btn-success col-md-12" onClick="callAddAction('add','')">ADD NEW PRODUCT INFO</button>
                                                                         </div>
                                                                   </div>

                                                                </div>
                                                          <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Dismiss</button>

                                                            </div>

                                                        </div>
                                                    </div>
</div>
>>>>>>> 48136f1b63a2e7fb659fed72c5bf93f60ec79592

</div>