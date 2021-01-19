

 <div class="wrapper-content ">

      <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">

              <div class="ibox-content collapse in">
                <div class="widgets-container">
                    <?php include("settings/add-product.php");?>

                   <div class="table-responsive">
                    <table id="restocksTable" style="font-size: 12px"  class="display nowrap table  responsive nowrap table-bordered">
                          <div class="alert alert-danger alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    <strong></strong> LIST OF PRODUCT BELOW 4 QUANTITY
  </div>
                       <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Category</th>
                                                <th>Product Name</th>
                                                <th>Code</th>
                                                <th>Price</th>
                                                <th>Store 1</th>
                                                <th>Store 2</th>
                                                <th>Total</th>
                                                <th>Date Time</th>
                                                 <?php if($myData['superAdmin'] > 0){?>
                                                <th>Action</th>
                                                <?php }?>
                                            </tr>
                                            </thead>
                                        <tbody>
                                     <?php
                                        $products = (array)$database->getProductsBelowThreeQuantity(4);
                                        if($products != null){

                                        foreach($products as $prod){

                                    ?>
                                     <tr <?php if($prod['active'] == 0){"class='danger'";}?>>
                                         <td> <?php echo str_pad($prod['id'],5,"0",STR_PAD_LEFT);?></td>
                                                 <td><?php echo $prod['type'];?></td>
                                                 <td><?php echo $prod['productName'];?></td>
                                                <td><?php echo $prod['Code']?></td>
                                                <td><?php echo $database->convertToMoney($prod['price']);?></td>
                                                <td><?php echo $prod['store1']." ".$prod['unitName'];?></td>
                                                <td><?php echo $prod['store2']." ".$prod['unitName'];?></td>
                                                <td><?php echo ($prod['store1']+$prod['store2'])." ".$prod['unitName'] ;?></td>
                                                <td><?php echo date("d-M-Y h:i:s A");?></td>
                                                 <?php if($myData['superAdmin'] > 0){?>
                                                 <td>
                                                    <a class="badge badge-info col-lg-12" data-toggle="modal" data-target=".bs-example-modal-lg-2-<?php echo $prod['id'];?>">EDIT</a>

                                                </td>
                                              <?php include('settings/edit-product.php');}?>


                                     </tr>
                                     <?php }}else{?>
                                               <tr>
                                         <td colspan="12">NO DATA FOUND</td>
                                     </tr>
                                     <?php }?>


                                        </tbody>
                    </table>
                  </div>


                </div>


              </div>
            </div>
          </div>


                 </div>
              </div>