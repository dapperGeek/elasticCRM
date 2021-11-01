<?php
$pageHeader = 'viewSoldTickets';
include("../includes/header_with_pageHeading.php");
$stores = $database->getAllStores();

if (!isset($_POST['btnFilterStoreSales'])){
    $myOrder = (array)$database->getAllGoodsLeft();
}
?>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">

                    <div class="row col-lg-12">
                        <h5>
                            All Ticket Sold/Transferred for WareHouse
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php if($myData['DepartmentID'] == 5){?>

                            <?php }else{?>
                                <a href="<?php echo $host;?>sell-goods" class="btn btn-success">SELL GOODS</a>

                            <?php } ?>

                        </h5>
                    </div>

                <!--                  Advanced search functionality-->
                <?php
                if (isset($_POST['btnFilterStoreSales'])){
                    $store = $storeID == 0
                        ? ''
                        : ' Sales from '
                        . $database->getStore($storeID)->storeName ;
                    $quarterTxt = $quarter == 'Last month'
                        ? "For $quarter"
                        :(
                        $quarter == ''
                            ? "For $yearInReview"
                            : " For $quarter, $yearInReview"
                        );
                    echo  "<div class='row col-lg-12 margin-bottom-10'>
<h3><center>Showing results $quarterTxt $store</center></h3>
</div>";
                    }
                    ?>
                    <form method="post">

                        <div class="col-lg-12">
                            <div class="col-lg-2 col-sm-12 margin-bottom-5">
                                <h3>Advanced Filter</h3>
                            </div>
                            <!--   Select selling store   -->
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
                            <!--                       Select period-->
                            <div class="col-lg-2 col-sm-12 margin-bottom-5">
                                <select name="period" class="form-control">
                                    <option value="0">Select period</option>
                                    <option value="1">1st Quarter</option>
                                    <option value="2">2nd Quarter</option>
                                    <option value="3">3rd Quarter</option>
                                    <option value="4">4th Quarter</option>
                                    <option value="5">Last Month</option>
                                    <option value="6">January</option>
                                    <option value="7">February</option>
                                    <option value="8">March</option>
                                    <option value="9">April</option>
                                    <option value="10">May</option>
                                    <option value="11">June</option>
                                    <option value="12">July</option>
                                    <option value="13">August</option>
                                    <option value="14">September</option>
                                    <option value="15">October</option>
                                    <option value="16">November</option>
                                    <option value="17">December</option>
                                </select>
                            </div>
                            <!--                       Select year in review-->
                            <div class="col-lg-2 col-sm-12 margin-bottom-5">
                                <select name="year" class="form-control">
                                    <option value="0">Year</option>
                                    <?php
                                    $curYear = date('Y');

                                    for ($i = 2016; $i <= $curYear; $i++){
                                        ?>
                                        <option value="<?php echo $i ?>">
                                            <?php echo $i; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- form submit button -->
                            <div class="col-lg-2 col-sm-12 margin-bottom-5">
                                <button class="btn btn-primary col-lg-12" type="submit" name="btnFilterStoreSales">Search</button>
                            </div>
                            <div class="col-lg-2 col-sm-12 margin-bottom-5">
                                <a class="btn btn-danger col-md-10" href="<?php echo $host . 'view-sold-ticket' ?>">Reset List</a>
                            </div>
                        </div>
                    </form>

            </div>
            <div class="ibox-content collapse in">
                <div class="widgets-container">
                    <div class="table-responsive">
                        <table id="soldTicketsTable" class="display  table  responsive  table-bordered" style="font-size: 12px; table-layout: fixed; word-wrap:break-word">
                            <thead>
                            <tr>
                                <th>OrderID</th>
                                <th>Ticket#</th>
                                <th>Customer</th>
                        <?php
                                if (isset($_POST['btnFilterStoreSales'])){
                                    echo '<th>Serial No.</th>' ;
                                }
                                else{
                                    echo '<th>Invoice No.</th>';
                                }
                        ?>
                                <th>Invoice Date</th>
                                <th>Address</th>
                                <th>Store</th>
                                <th>DoneBy</th>
                                <th>Action</th>


                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>OrderID</th>
                                <th>Ticket#</th>
                                <th>Customer</th>
                                <th>InvoiceNo</th>
                                <th>Invoice Date</th>
                                <th>Address</th>
                                <th>Store</th>
                                <th>DoneBy</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php

                                if($myOrder != null){

                                    foreach($myOrder as $mo){


                                        ?>
                                        <tr>

                                            <td><a href="<?php echo $host;?>goods-sold-ticket/<?php echo $mo['id'];?>" target="_blank"><?php echo str_pad($mo['id'],5,"0",STR_PAD_LEFT);?></a></td>
                                            <td><?php echo $mo['TicketNo'];?></td>
                                            <td><?php echo $mo['supplierID'];?></td>
                                            <!--                                        <td>--><?php //echo $mo['invoiceNo'];?><!--</td>-->
                                            <td><?php
                                                if (isset($_POST['btnFilterStoreSales'])){
                                                    echo $mo['serialNumber'] ;
                                                }
                                                else{
                                                    echo $mo['invoiceNo'];
                                                }
                                                ?></td>
                                            <td><?php echo $mo['invoiceDate'];?></td>
                                            <td><?php echo $mo['FileReference'];?></td>
                                            <td><?php echo $mo['storeName'];?></td>
                                            <td><?php echo $mo['fullname'];?></td>
                                            <td><?php echo $mo['transType'];?></td>

                                        </tr>

                                    <?php } ?>

                                <?php }else{?>
                                    <tr>
                                        <td colspan="8">NO ORDER  YET</td>

                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- start footer -->
</div>
</div>


</div>
</div>
<!-- Go top -->
<a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>
<!-- Go top -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo $host;?>assets/js/vendor/jquery.min.js"></script>
<!-- bootstrap js -->
<script src="<?php echo $host;?>assets/js/vendor/bootstrap.min.js"></script>
<!-- slimscroll js -->
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jquery.slimscroll.js"></script>
<script src="<?php echo $host;?>assets/js/vendor/select2.min.js"></script>
<script src="<?php echo $host;?>assets/js/vendor/bootstrap-select.min.js"></script>
<!-- pace js -->
<script src="<?php echo $host;?>assets/js/vendor/pace/pace.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $host;?>assets/js/vendor/jquery.sparkline.min.js"></script>
<!-- main js -->
<script src="<?php echo $host;?>assets/js/vendor/ion.rangeSlider.js"></script>

<script src="<?php echo $host;?>assets/js/main.js"></script>
<script type="text/javascript">

    $(function() {

        $("#range").ionRangeSlider({
            min: 0,
            max: 100
        });

        $('._select').select2();
        var data = [{
            id: 0,
            text: 'enhancement'
        }, {
            id: 1,
            text: 'bug'
        }, {
            id: 2,
            text: 'duplicate'
        }, {
            id: 3,
            text: 'invalid'
        }, {
            id: 4,
            text: 'wontfix'
        }];

        $(".js-example-data-array").select2({
            data: data
        })

        $(".js-example-data-array-selected").select2({
            data: data
        })

        $('.selectpicker').selectpicker({
            style: 'defaultSelectDrop',
            size: 4
        });

        $('.selectpickerprimary').selectpicker({
            style: 'btn-primary',
            size: 4
        });
        $('.selectpickerinfo').selectpicker({
            style: 'btn-info',
            size: 4
        });
        $('.selectpickersuccess').selectpicker({
            style: 'btn-success',
            size: 4
        });
        $('.selectpickerwarning').selectpicker({
            style: 'btn-warning',
            size: 4
        });
        $('.selectpickerdanger').selectpicker({
            style: 'btn-danger',
            size: 4
        });

    });
</script>


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
        $('#soldTicketsTable').DataTable({
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
            }]


        });
    });
</script>
</body>
</html>
