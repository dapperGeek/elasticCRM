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
                        : $quarter == ''
                            ? "For $yearInReview"
                            : " For $quarter, $yearInReview";
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
                        <table id="soldTicketsTable"  class="display nowrap table  responsive nowrap table-bordered">
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
<?php include '../includes/footer.php';