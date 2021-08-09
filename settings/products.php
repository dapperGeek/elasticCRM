<?php
$pageHeader = 'viewStock';
include("../includes/header_with_pageHeading.php");
$stores = $database->getAllStores();

if(!isset($_GET['id'])){
    $database->redirect_to($host);
}else{
    $category_id = $database->test_input($_GET['id']);
}

?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">

            <div class="ibox-content collapse in">
                <div class="widgets-container">
                    <?php include("add-product.php");?>

                    <div class="row col-lg-12">
                    <?php
                        if($myData['superAdmin'] > 0 || ($_SESSION['dptID'] == 4 && $_SESSION['access'] >= 8))
                        {
                            if($myData['AccessLevel'] == 12)
                            {
                                echo '';
                            }
                            else
                            {
                                echo '<a class="btn btn-success pull-right" data-toggle="modal" data-target=".bs-example-modal-lg-2-add">ADD NEW PRODUCT</a>';
                            }
                        }
                    ?>

                    </div>

                    <div class="row col-lg-12">
                        <div class="row col-lg-12">
                            <!--             Filter stock search-->
                            <!--                  Advanced search functionality-->
                            <?php
                            if (isset($_POST['btnFilterStoreStock'])){
                                $store = $storeID == 0
                                    ? ' in All Stores '
                                    : ' in ' . $database->getStore($storeID)->storeName ;
                                $category = $categoryID == 0
                                    ? ' Products Stock '
                                    : $database->getCategoryById($categoryID)->type;
                                echo  "<div class='row col-lg-12 margin-bottom-10'>
                                      <h3><center>Showing $category $store</center></h3>
                                      </div>";
                            }
                            ?>

                        </div>

                        <form method="post">

                            <div class="col-lg-12">
                                <div class="col-lg-2 col-sm-12 margin-bottom-5">
                                    <h3>Filter Stock</h3>
                                </div>
                                <!--  Select category -->
                                <div class="col-lg-2 col-sm-12 margin-bottom-5">
                                    <select name="category" class="form-control">
                                        <option value="0">Select Category</option>
                                        <?php
                                        foreach ($cati as $cat){
                                            ?>
                                            <option value="<?php echo $cat['id'] ?>">
                                                <?php
                                                echo ucfirst($cat['type'])
                                                ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <!--   Select store   -->
                                <div class="col-lg-2 col-sm-12 margin-bottom-5">
                                    <select name="store" class="form-control">
                                        <option value="0">Select Store</option>
                                        <?php
                                        foreach ($stores as $str){
                                            ?>
                                            <option value="<?php echo $str['id'] ?>">
                                                <?php
                                                echo ucfirst($str['storeName'])
                                                ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- form submit button -->
                                <div class="col-lg-2 col-sm-12 margin-bottom-5">
                                    <button class="btn btn-primary col-lg-12" type="submit" name="btnFilterStoreStock">Search</button>
                                </div>
                                <div class="col-lg-2 col-sm-12 margin-bottom-5">
                                    <a class="btn btn-danger col-md-10" href="<?php echo $host . 'view-products/0' ?>">Reset List</a>
                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="row col-lg-12">

                        <hr>
                        <div class="table-responsive">
                            <table id="example7" style="font-size: 12px"  class="display nowrap table  responsive nowrap table-bordered">
                                <?php
                                    // If the stock filtering search is active
                                    if (isset($_POST['btnFilterStoreStock']) AND $storeID != 0)
                                    {
                                ?>
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category</th>
                                        <th>Product Name</th>
                                        <th>Code</th>
                                        <!--                                        <th>Price</th>-->
                                        <?php
                                            // show costs column for accounting department
                                            if ($myData['DepartmentID']== 5)
                                            {
                                        ?>
                                            <th>Cost</th>
                                        <?php } ?>
                                        <th>Quantity</th>
                                        <th>Date Time</th>
                                        <?php
                                            if($myData['superAdmin'] > 0)
                                            {?>
                                            <th>Action</th>
                                        <?php }?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        if($products != null)
                                        {
                                            foreach($products as $prod)
                                            {
                                    ?>
                                            <tr <?php if($prod['active'] == 0){"class='danger'";}?>>
                                                <td> <?php echo str_pad($prod['id'],5,"0",STR_PAD_LEFT);?></td>
                                                <td><?php echo $prod['type'];?></td>
                                                <td><?php echo $prod['productName'];?></td>
                                                <td><?php echo $prod['Code']?></td>
                                                <!--                                                <td>--><?php //echo $database->convertToMoney($prod['price']);?><!--</td>-->
                                                <?php if ($myData['DepartmentID']== 5) { ?>
                                                    <td><?php echo $database->convertToMoney($prod['cost'])?></td>
                                                <?php } ?>
                                                <td><?php echo $prod['quantity']." ".$prod['unitName'];?></td>
                                                <td><?php echo date("d-M-Y h:i:s A");?></td>
                                                <?php
                                                    if($myData['superAdmin'] > 0)
                                                    {
                                                        if($myData['AccessLevel'] == 12)
                                                        {
                                                            echo ' <td><a class="badge badge-info col-lg-12" data-toggle="modal" data-target=".bs-example-modal-lg-2-">EDIT</a> </td>';
                                                        }
                                                        else
                                                        {
                                                ?>
                                                        <td>
                                                            <a class="badge badge-info col-lg-12" data-toggle="modal" data-target=".bs-example-modal-lg-2-<?php echo $prod['id'];?>">EDIT</a> </td>
                                                 <?php
                                                    }
                                                    include('edit-product.php');
                                                }
                                                ?>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else{
                                        ?>
                                        <tr>
                                            <td colspan="12">NO DATA FOUND</td>
                                        </tr>
                                    <?php }?>


                                    </tbody>

                                    <?php
                                }
                                else
                                { // show all unfiltered products when filtering is not activated
                            ?>
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <?php
                                            if (!isset($category_id) OR $category_id == 0)
                                            {
                                        ?>
                                                <th>Category</th>
                                        <?php
                                            }
                                        ?>
                                        <th>Product Name</th>
                                        <th>Code</th>
                                        <!--                                        <th>Price</th>-->
                                        <?php
                                            if ($myData['DepartmentID']== 5)
                                            {
                                        ?>
                                            <th>Cost</th>
                                        <?php } ?>
                                        <th>Main Warehouse</th>
                                        <th>Showroom</th>
                                        <th>Abuja Store</th>
                                        <th>Used</th>
                                        <th>Total</th>
                                        <th>Date Time</th>
                                        <?php
                                            // Show the product details and stock edit action column for admin users with edit privileges
                                            if($myData['superAdmin'] > 0)
                                            {
                                        ?>
                                            <th>Action</th>
                                        <?php }?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
            // Set category id depending search is active or not
            $searchID = $categoryID ?? $category_id;
            $products = (array)$database->getProductsByCategory($searchID);
            if($products != null){

                foreach($products as $prod){

                    ?>
                    <tr <?php if($prod['active'] == 0){"class='danger'";}?>>
                        <td> <?php echo str_pad($prod['id'],5,"0",STR_PAD_LEFT);?></td>

                        <?php
                            if (!isset($category_id) OR $category_id == 0){
                                ?>
                                <td><?php echo $prod['type'];?></td>
                                <?php
                            }
                        ?>

                        <td><?php echo $prod['productName'];?></td>
                        <td><?php echo $prod['Code']?></td>
                                                <!--                                                <td>--><?php //echo $database->convertToMoney($prod['price']);?><!--</td>-->
                                                <?php if ($myData['DepartmentID']== 5) { ?>
                <td><?php echo $database->convertToMoney($prod['cost'])?></td>
                                                <?php } ?>
                <td><?php echo $prod['store1']." ".$prod['unitName'];?></td>
                <td><?php echo $prod['store2']." ".$prod['unitName'];?></td>
                <td><?php echo $prod['store3']." ".$prod['unitName'];?></td>
                <td><?php echo $prod['damaged']." ".$prod['unitName'];?></td>
                <td><?php echo ($prod['store1']+$prod['store2']+$prod['store3']+$prod['damaged'])." ".$prod['unitName'] ;?></td>
                <td><?php echo date("d-M-Y h:i:s A");?></td>
                        <?php if($myData['superAdmin'] > 0){
                            if($_SESSION['access'] <= 6){echo '';}
                            else{?>
                <td>

                    <table>
                        <tr>
                            <td>
                                <a title="Edit Details" style="cursor: pointer; text-decoration: none" class="pull-left fa fa-edit" data-toggle="modal" data-target=".bs-example-modal-lg-2-<?php echo $prod['id'];?>"></a>
                                <?php include('edit-product.php'); ?>
                            </td>

                            <td>

                                <a title="Edit Stock" style="cursor: pointer; text-decoration: none" class="pull-right fa fa-pie-chart" data-toggle="modal" data-target="#stock-modal-<?php echo $prod['id'];?>"></a>
                                <?php include ('edit-stock.php'); ?>

                            </td>
                        </tr>
                    </table>

                </td>

                                                    <?php }

                        }?>

                                            </tr>
                                        <?php }
            }
            else{
                ?>
                                        <tr>
                                            <td colspan="12">NO DATA FOUND</td>
                                        </tr>
                                    <?php }?>


                                    </tbody>

                                    <?php
                                }
                                ?>

                            </table>
                        </div>

                    </div>


                </div>


            </div>

        </div>
    </div>


</div>
</div>
</div>
</div>

<!-- start footer -->

</div>
</div>


<!-- Go top -->
<a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>
<!-- Go top -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo $host;?>assets/js/vendor/jquery.min.js"></script>
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
</body>
</html>
