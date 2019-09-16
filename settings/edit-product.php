<script>
      function callEditAction<?php echo $prod['id'];?>(action,id) {

         var catID = $("#catID<?php echo $prod['id'];?>").val();
         var prodName = $("#prodName<?php echo $prod['id'];?>").val();
         var prodCode = $("#prodCode<?php echo $prod['id'];?>").val();
         var prodPrice = $("#prodPrice<?php echo $prod['id'];?>").val();
          var unitID = $("#unitID<?php echo $prod['id'];?>").val();
                  var queryString = 'action=edit&catID='+catID+'&prodName='+prodName+'&prodCode='+prodCode+'&prodPrice='+prodPrice+'&id='+id+'&unitID='+unitID;
                //  alert(queryString);
                  if(catID!= "" && prodName != "" && prodCode != "" && prodPrice != "" && id != "" ){
                   if(confirm("Are you sure you want to edit this?")) {
                  $("#loaderIcon<?php echo $prod['id'];?>").show();
                  jQuery.ajax({
                        url: "<?php echo $host;?>/settings/product-action.php",
                        data:queryString,
                        type: "POST",
                        success:function(data){

                          $("#responseFor-<?php echo $prod['id'];?>").fadeIn(2000);
                          $("#responseFor-<?php echo $prod['id'];?>").fadeOut(2000);
                          $("#loaderIcon<?php echo $prod['id'];?>").hide();
                           location.reload(true);
                        },
                       error: function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            alert(err.Message);
                          }
                      });
                  }
              }else{
                // alert("Url"+queryString);
                         $("#responseFor2-<?php echo $prod['id'];?>").fadeIn(2000);
                          $("#responseFor2-<?php echo $prod['id'];?>").fadeOut(2000);
              }
      }
    </script>
<div class="modal fade bs-example-modal-lg-2-<?php echo $prod['id'];?>" tabindex="-1" role="dialog" >
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">EDIT <?php echo strtoupper($prod['productName']);?> </h4>
                                                            </div>
                                                         <!---- the beginning of the form-->

                                                          <div class="modal-body">
                                                               <div class="invoice">
                                                                   <div class="row">
                                                                       <label class="col-md-2">&nbsp;</label>
                                                                       <label class="col-md-2">&nbsp;</label>
                                                                       <div class="col-md-6" style="text-align: center">
                                                                              <img src="<?php echo $host;?>img/LoaderIcon.gif" style="display:none" id="loaderIcon<?php echo $prod['id'];?>"  width="30" height="30" />
                                                                              <label class="label label-success col-md-12" style="display:none" id="responseFor-<?php echo $prod['id'];?>">You have successfully editted this product</label>
                                                                              <label class="label label-danger col-md-12" style="display:none" id="responseFor2-<?php echo $prod['id'];?>">Please all fields are required </label>
                                                                      </div>
                                                                    </div>

                                                                   <div class="row">
                                                                       <label class="col-md-2">&nbsp;</label>
                                                                       <label class="col-md-2">CATEGORY</label>
                                                                         <div class="col-md-6">
                                                                             <select id="catID<?php echo $prod['id'];?>" name="catID<?php echo $prod['id'];?>" class="form-control">
                                                                                 <?php
                                                                                    $cat2 = (array)$database->getProductsCategory();
                                                                                    foreach($cat2 as $cat22){
                                                                                 ?>
                                                                                   <option value="<?php echo $cat22['id'];?>" <?php if($cat22['id'] == $prod['ProductType']){echo "selected";}?>>
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
                                                                       <input class="form-control" id="prodName<?php echo $prod['id'];?>" name="prodName<?php echo $prod['id'];?>" value="<?php echo $prod['productName'];?>"/>
                                                                         </div>
                                                                   </div>

                                                                   <div class="row">
                                                                        <label class="col-md-2">&nbsp;</label>
                                                                       <label class="col-md-2">PRODUCT CODE:</label>
                                                                       <div class="col-md-6">
                                                                       <input class="form-control" id="prodCode<?php echo $prod['id'];?>" name="prodCode<?php echo $prod['id'];?>" value="<?php echo $prod['Code'];?>"/>
                                                                         </div>
                                                                   </div>
                                                                     <div class="row">
                                                                       <label class="col-md-2">&nbsp;</label>
                                                                       <label class="col-md-2">PRODUCT UNIT</label>
                                                                         <div class="col-md-6">
                                                                             <select id="unitID<?php echo $prod['id'];?>" name="unitID<?php echo $prod['id'];?>" class="form-control">
                                                                                 <?php
                                                                                    $cat2 = (array)$database->getProductsUnits();
                                                                                    foreach($cat2 as $cat22){
                                                                                 ?>
                                                                                   <option value="<?php echo $cat22['id'];?>" <?php if($cat22['id'] == $prod['unitID']){echo "selected";}?>>
                                                                                       <?php echo $cat22['unitName'];?>
                                                                                   </option>
                                                                                   <?php }?>
                                                                         </select>
                                                                         </div>

                                                                   </div>

                                                                   <div class="row">
                                                                        <label class="col-md-2">&nbsp;</label>
                                                                       <label class="col-md-2">PRODUCT PRICE:</label>
                                                                       <div class="col-md-6">
                                                                       <input id="prodPrice<?php echo $prod['id'];?>" onkeypress="return fun_AllowOnlyAmountAndDot(this.id);" class="form-control" onKeyPress="return isNumberKey(event)" name="" value="<?php echo $prod['price'];?>"/>
                                                                         </div>
                                                                   </div>
                                                                   <div class="row">
                                                                        <label class="col-md-2">&nbsp;</label>
                                                                       <label class="col-md-2">&nbsp;</label>
                                                                       <div class="col-md-6">
                                                                       <button class="btn btn-warning col-md-12" onClick="callEditAction<?php echo $prod['id'];?>('edit','<?php echo $prod['id'] ?>')">EDIT PRODUCT INFO</button>
                                                                         </div>
                                                                   </div>

                                                                </div>
                                                          <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Dismiss</button>


                                                            </div>

                                                        </div>
                                                    </div>
</div>

