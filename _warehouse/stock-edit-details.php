<?php
    $editID = $_GET['id'];
    $editStore = $_GET['store'];

    $yr_ = date("Y");
    include '../includes/header.php';

    if($myData['storeID']== 0){
        $database->redirect_to($host);
    }

?>
            <div class="col-lg-12">

                <?php

                    if(isset($_POST['btnApprove']))
                    {
                        $product = $storeQty = $updateQty = $difference = array();

                        if(isset($_POST['productID']))
                        {
                            $editID = $_POST['editID'];
                            $editStore = $_POST['editStore'];
                            $editorID = $_POST['editorID'];
                            $editTicket = $_POST['editTicket'];
                            $approvedID = $_POST['approvedID'];

                            $product = $_POST['productID'];
                            $storeQty = $_POST['storeQty'];
                            $updateQty = $_POST['updateQty'];
                            $difference = $_POST['difference'];
                        }
                        // var_dump($amount) ; echo '</br>';
                        // exit;

                        if(isset($_POST['productID']) && !empty($_POST['productID']))
                        {
                            $database->approveStockEdits($editID, $editStore, $editTicket, $editorID, $approvedID, $product, $storeQty, $updateQty, $difference);
                            unset($_POST);
                            $database->showMsg('', "STOCK HAS BEEN UPDATED SUCCESSFULLY", 2);

                            //Send email

                        }
                        else
                        {
                            $database->showMsg('', 'All fields are required to create a supply ticket', 1);
                        }
                    }

                    if (isset($_POST['btnCancel']))
                    {
                        $editID = $_POST['editID'];
                        if (isset($_POST['productID']) && !empty($_POST['productID']))
                        {
                            $database->cancelStockEdit($editID);
                            unset($_POST);
                            $database->showMsg('', "STOCK UPDATE NOT APPROVED, CANCELED SUCCESSFULLY", 2);
                            $database->redirect_to( $host . 'stock-edit');

                            //Send email

                        }
                    }

//                        Get update request details
                        $getEdits = $database->getStockEditDetails($editID, $editStore);
                        //                            print_r($getEdits)
                ?>

                <div class="row div-centered">
                    <h1 style="text-align: center"><span class="btn btn-warning">STOCK UPDATE FOR WARE HOUSE - <?php echo strtoupper($store[1]);?></span></h1>

                </div>

                <a href="<?php echo $host . 'stock-edit' ?>" class="btn btn-info pull-right" style="float: right !important;">Back To Lists</a>

               <div class="row div-centered">
                   <table style="width: 60%" class="table table-bordered">
                       <thead>
                       <tr>
                           <th colspan="2" style="text-align: center">
                               <?php echo 'Details for Stock Update Request <b>' . $getEdits[0]['edit_ticket'] . '</b>' ?>
                           </th>
                       </tr>
                       </thead>
                       <tbody>
                            <tr>
                                <td>Request ID</td>
                                <td><?php echo $getEdits[0]['edit_ticket']  ?></td>
                            </tr>
                            <tr>
                                <td>Request Raised By</td>
                                <td><?php echo  $getEdits[0]['fullname']  ?></td>
                            </tr>
                            <?php
                                if ($getEdits[0]['approval'] > 0)
                                {
                                    $approvedBy = $getEdits[0]['approval'] == 0 ? '' : $database->getSingleUserInformation($getEdits[0]['approval'])['fullname'];
                            ?>
                                <tr>
                                    <td>Approved By</td>
                                    <td><?php echo  $approvedBy;  ?></td>
                                </tr>
                            <?php
                                }
                            ?>
                            <tr>
                                <td>Date Raised</td>
                                <td><?php echo  date('d/m/Y', $getEdits[0]['created_at'])  ?></td>
                            </tr>
                            <tr>
                                <td>Warehouse/Store</td>
                                <td><?php echo $database->getStore($getEdits[0]['store_id'])->storeName  ?></td>
                            </tr>
                            <tr>
                                <td>Listed Products</td>
                                <td><?php echo $getEdits[0]['itemsQty']  ?></td>
                            </tr>
                       </tbody>

                   </table>
               </div>
            </div>
        <div class="wrapper-content ">
            <div class="row">

                <div class="col-lg-12">
                    <div class="widgets-container">

<!--                        Form for editable products approval or disapproval -->
                        <form method="post">
                            <input type="hidden" name="editID" value="<?php echo $editID; ?>">
                            <input type="hidden" name="editStore" value="<?php echo $editStore; ?>">
                            <input type="hidden" name="editorID" value="<?php echo $getEdits[0]['user_id']; ?>">
                            <input type="hidden" name="editTicket" value="<?php echo $getEdits[0]['edit_ticket']; ?>">
                            <input type="hidden" name="approvedID" value="<?php echo $user_id; ?>">
                            <div class="row">
                                <div class="col-lg-10">
                                    <div class="table-responsive">
                                        <table id="editStockTable"  class="display nowrap table  responsive nowrap table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Product</th>
                                                    <th>Type</th>
                                                    <th>Current Qty</th>
                                                    <th>Recorded Qty</th>
                                                    <th>Physical Qty</th>
                                                    <th>Difference</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>Code</th>
                                                <th>Product</th>
                                                <th>Type</th>
                                                <th>Current Qty</th>
                                                <th>Recorded Qty</th>
                                                <th>Physical Qty</th>
                                                <th>Difference</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            <?php
                                                if ($getEdits != null)
                                                {
                                                    foreach ($getEdits as $getEdit)
                                                    {
                                            ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $getEdit['Code']  ?>
                                                            <input type="hidden" name="productID[]" value="<?php echo $getEdit['product_id']  ?>">
                                                            <input type="hidden" name="storeQty[]" value="<?php echo $getEdit['store' . $editStore]  ?>">
                                                            <input type="hidden" name="updateQty[]" value="<?php echo $getEdit['update_quantity']  ?>">
                                                            <input type="hidden" name="difference[]" value="<?php echo $getEdit['difference']  ?>">
                                                        </td>
                                                        <td><?php echo $getEdit['productName']  ?></td>
                                                        <td><?php echo $getEdit['type']  ?></td>
                                                        <td><?php echo $getEdit['store' . $editStore]  ?></td>
                                                        <td><?php echo   $getEdit['current_quantity'] ?></td>
                                                        <td><?php echo $getEdit['update_quantity'] ?></td>
                                                        <td><?php echo $getEdit['difference'] ?></td>
                                                    </tr>
                                            <?php
                                                    }
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <?php
                                        if ($getEdits[0]['approval'] == 0)
                                        {
                                            if ($myData['AccessLevel'] > 9)
                                            {
                                    ?>
                                                <button class="btn btn-danger col-lg-12 top20 bottom20" name="btnCancel">
                                                    CANCEL EDIT
                                                </button>
                                                <button class="btn btn-info col-lg-12" name="btnApprove">
                                                    APPROVE
                                                </button>
                                    <?php
                                            }
                                            else {
                                    ?>
                                                <button class="btn btn-success col-lg-12" disabled>
                                                    PENDING APPROVAL
                                                </button>
                                    <?php
                                            }
                                        }
                                        else
                                        {
                                    ?>
                                            <button class="col-lg-12 top30 btn btn-primary" disabled>APPROVED</button>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--All form elements  End -->

<?php
    include '../includes/footer.php';