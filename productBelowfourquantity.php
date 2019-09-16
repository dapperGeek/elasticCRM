

 <div class="wrapper-content ">

      <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">

              <div class="ibox-content collapse in">
                <div class="widgets-container">
                    <?php include("settings/add-product.php");?>

                   <div class="table-responsive">
                    <table id="example7" style="font-size: 12px"  class="display nowrap table  responsive nowrap table-bordered">
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



<!-- Go top -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- <script src="<?php echo $host;?>assets/js/vendor/jquery.min.js"></script> -->
<!-- bootstrap js -->
<script src="<?php echo $host;?>assets/js/vendor/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jasny-bootstrap.min.js" charset="UTF-8"></script>
<!-- slimscroll js -->
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jquery.slimscroll.js"></script>
<!-- dataTables-->
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/dataTables.bootstrap.min.js"></script>
<!-- js for print and download -->
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/buttons.flash.min.js"></script>
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/buttons.print.min.js"></script>
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/dataTables.fixedHeader.min.js"></script>
<!-- pace js -->
<script src="<?php echo $host;?>assets/js/vendor/pace/pace.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $host;?>assets/js/vendor/jquery.sparkline.min.js"></script>
<!-- main js -->
<script src="<?php echo $host;?>assets/js/main.js"></script>
<script>

        $(document).ready(function() {
            // Flexible table

            $('#example').DataTable();

            // Scroll Horizontal example



            // Individual column searching

            // Setup - add a text input to each footer cell
            $('#example6 tfoot th').each(function() {
                var title = $(this).text();
                $(this).html('<input class="form-control dataSearch" type="text" placeholder="Search ' + title + '" />');
            });

            // DataTable
            var table = $('#example6').DataTable();

            // Apply the search
            table.columns().every(function() {
                var that = this;

                $('input', this.footer()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });


            // Advanced
            $('#example7').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                    text: 'copy',
                    extend: "copy",
                    className: 'btn dark btn-outline'
                }, {
                    text: 'csv',
                    extend: "csv",
                    className: 'btn aqua btn-outline'
                }, {
                    text: 'excel',
                    extend: "excel",
                    className: 'btn aqua btn-outline'
                }, {
                    text: 'pdf',
                    extend: "pdf",
                    className: 'btn yellow  btn-outline'
                }, {
                    text: 'print',
                    extend: "print",
                    className: 'btn purple  btn-outline'
                }],
                "pageLength": 50
            });



        });
    </script>