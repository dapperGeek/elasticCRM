<?php
$yr_ = date("Y");
include '../includes/header.php';

if($myData['storeID']== 0){
    $database->redirect_to($host);
}

?>
        <div class="row wrapper border-bottom page-heading">
            <div class="col-lg-12">

                <?php

                    if(isset($_POST['btnUpdateStock']))
                    {
                        $storeID = $database->test_input($_POST['txtStoreID']);

                        $save = 1;
                        $product = $updateQty = $currentQty = array();

                        if(isset($_POST['txtProduct']))
                        {
                            $product = $_POST['txtProduct'];
                            $updateQty = $_POST['txtProductQty'];
                            $currentQty = $_POST['txtProductPcs'];
                        }
    //                    var_dump($amount) ; echo '</br>';
                        // exit;

                        if(isset($_POST['txtProduct']) && !empty($_POST['txtProduct']))
                        {
                            $requestID = $database->makeStockUpdateRequest($storeID, $_SESSION['user_id'], $product, $currentQty, $updateQty);
                            unset($_POST);
                            $database->showMsg('', "UPDATE REQUEST & LOGS CREATED SUCCESSFULLY, PENDING APPROVAL", 2);

                            //Send email
                            $getEdits = $database->getStockEditDetails($requestID, $storeID);

                            $email = "tastore@tenaui.com";
                            $subject = "Products Stock Update Pending Approval";

                            $html ="<p name='mydata'> good \n";
                            //$html.= htmlspecialchars($data)."\n";
                            $html.= "</p>";

                            $link = '<a href="' . $host . 'stock-edit-details/' . $requestID . '/' . $storeID . '">' . 'View Update Request' . '</a>';
                            $body = "<p xmlns=\"http://www.w3.org/1999/html\">Dear Admin,</p><p>A stock update request has been raised and needs your approval to implement the update. to view update, use the link </br><span>$link</span></br> to Approve or Cancel request</p><p>Products in the request raised are listed below.</p>";

                            $table = "<table width='80%' align='center'  border=0>
    <tr>
        <th colspan='2'>";
                            $table.= "<h2>Approve Stock Updates</h2>";
                            $table  .= "</th>
                                 </tr>
                                  <tr>
                                    <td>
                                        <b>Update ID:</b>" . $getEdits[0]['edit_ticket'] . "<br/>
                                        <b>Done By:</b>" . $getEdits[0]['fullname'] . "<br/>
                                        <b>Store:</b>" . $getEdits[0]['storeName'] . "<br/>
                                    </td>
                                    <td align='right'><img src='https://elastic250.com/img/tenaui-logo.jpg' width='100' height='100'></td>
                                  </tr>
                                </table>";

                            $table .= '<table id="editStockTable"  class="display nowrap table  responsive nowrap table-bordered">
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
                                            </thead><tbody>';

                                if ($getEdits != null)
                                {
                                    foreach ($getEdits as $getEdit)
                                    {
                                        $table .= "<tr>
                                            <td>" . $getEdit['Code'] . "</td>
                                            <td>" .$getEdit['productName'] . "</td>
                                            <td>" .$getEdit['type'] . "</td>
                                            <td>" .$getEdit['store' . $storeID] . "</td>
                                            <td>" .$getEdit['current_quantity'] . "</td>
                                            <td>" .$getEdit['update_quantity'] . "</td>
                                            <td>" .$getEdit['difference'] . "</td>
                                        </tr>";
                                    }
                                }

                                $table .= "</tbody>
                                        </table>";

                            // use actual sendgrid username and password in this section
                            $url = SendGrid::$url;
                            $user = SendGrid::$username; // place SG username here
                            $pass = SendGrid::$password; // place SG password here
                            $userId = $_SESSION['user_id'];
                            $copyEmails = array('talal@tenaui.com','uthman@tenaui.com');
                            $myUserDetails = $database->getSingleUserInformation($userId);

                            $devEmail = 'uthmanb@outlook.com';
                            $ccEmail = "talal@tenaui.com";

                            //exit;
                            // note the above parameters now referenced in the 'subject', 'html', and 'text' sections
                            // make the to email be your own address or where ever you would like the contact form info sent

                            $json_string = array(
                                'to' => $copyEmails,
                                'category' => 'test_category'
                            );

                            $params = array(
                                'api_user'  => "$user",
                                'api_key'   => "$pass",
                                'x-smtpapi' => json_encode($json_string),
                                'to'        => "$ccEmail",
                                'replyto'   => "$email",
                                'cc'        => $ccEmail,
                                'subject'   => "$subject", // Either give a subject for each submission, or set to $subject
                                'html'      => "<html lang='en'><head><meta http-equiv=\"Content-Type\" content=\"text/html\"; charset=\"utf-8\"><title>$subject</title></head><body>$body
$table </body></html>", // Set HTML here.  Will still need to make sure to reference post data names
                                'text'      => "$table",
                                'from'      => $email, // set from address here, it can really be anything
                            );

                            $request =  $url.'api/mail.send.json';
                            // Generate curl request
                            $session = curl_init($request);
                            // set the curl SSL version
                            curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
                            // Tell curl to use HTTP POST
                            curl_setopt ($session, CURLOPT_POST, true);
                            // Tell curl that this is the body of the POST
                            curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
                            // Tell curl not to return headers, but do return the response
                            curl_setopt($session, CURLOPT_HEADER, false);
                            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
                            // obtain response
                            curl_exec($session);
                            curl_close($session);

                        }
                        else
                        {
                            $database->showMsg('', 'All fields are required to create a supply ticket', 1);
                        }
                    }
                ?>

                <h1 style="text-align: center"><span class="btn btn-warning">STOCK UPDATE FOR WARE HOUSE - <?php echo strtoupper($store[1]);?></span></h1>
                <h4 style="text-align: center">STOCK UPDATE REQUEST RAISED BY <?php echo strtoupper($myData['fullname']); ?></h4>

            </div>
        </div>
        <div class="wrapper-content ">
            <div class="row">

                <script>
                    let displaySubTotal = 0;
                    let DiscountVal = 0;
                    let totalProductPrice = 0;
                    let count = 0;

                    function addRow(){

                        let productID =  document.getElementById('nProduct');
                        let storeID =  document.getElementById('txtStoreID').value;
                        let id = productID.value;

                        if (id > 0)
                        {
                            let nID = '<input type="hidden" name="txtProduct[]" value="'+id+'" /> ';
                            let selectText =  productID.options[productID.selectedIndex].text;
                            let productname =  selectText.substr(selectText.indexOf("---- ")+4,selectText.length);
                            let qty_ = document.getElementById('updateQty').value;
                            let unitName = document.getElementById('currentQty').value;
                            let productcode = selectText.substr(0,selectText.indexOf("----"));
                            let updateQty = '<input type="text" placeholder="QTY." required  onkeyup = "javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)"  name="txtProductQty[]" class="form-control required" value="'+qty_+'" />';
                            let currentQty = '<input type="hidden" placeholder="UNITS" name="txtProductPcs[]" class="form-control required" value="'+unitName+'" />';
                            let cal =   unitName;
                            let Action = "<input type='button' class='btn btn-outline btn-round dark btn-sm black' onclick='removeRow("+20+");' value='Remove Row'/>";
                            let table = document.getElementById('table');
                            //let table = document.getElementById('tableDeliveryData');
                            let newRow = table.insertRow(1);
                            let cel1 = newRow.insertCell(0);
                            let cel2 = newRow.insertCell(1);
                            let cel3 = newRow.insertCell(2);
                            let cel4 = newRow.insertCell(3);
                            let cel5 = newRow.insertCell(4);

                            cel1.innerHTML = productcode+nID;
                            cel2.innerHTML = productname;
                            cel3.innerHTML = updateQty;
                            cel4.innerHTML = cal + currentQty;
                            cel5.innerHTML = Action;

                            document.getElementById('currentQty').value = "";
                            document.getElementById('updateQty').value = "";
                            document.getElementById('nProduct').value = 0;
                        }
                        else
                        {
                            alert("PLEASE SELECT A PRODUCT");
                        }
                    }

                    function removeRow(id)
                    {
                        let storeID =  parseInt(document.getElementById('txtStoreID').value);
                        let col = storeID === 3 ? 6 : 4;
                        let index, table = document.getElementById('table');

                        for(let i = 1; i < table.rows.length; i++)
                        {
                            table.rows[i].cells[col].onclick = function()
                            {
                                let c = confirm("do you want to delete this row ?");

                                if(c === true)
                                {
                                    totalProductPrice -= id;
                                    index = this.parentElement.rowIndex;;
                                    table.deleteRow(index);
                                    document.getElementById('txtTotalPrice').value = addComma(totalProductPrice);
                                }
                            };
                        }
                    }

                    function selectionChange(info){
                        let np =  document.getElementById('currentQty');
                        if(info > 0){np.readOnly = true;}else{np.readOnly = false;}
                        info = info.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        np.value = info;
                        // alert(info);
                    }

                    function addComma(x){
                        // let part = x.toString().split(".");
                        // part[0] = part[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        // return part.join(".");
                        return x.toLocaleString();
                    }

                    let currentValue = 0;
                </script>

                <div class="col-lg-12 top20 bottom20">
                    <div class="widgets-container">

                        <div class="form-group row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4">
                                <?php  //var_dump($myData['storeID']); ?>
                                <select class="_select form-control" name="nProduct" id="nProduct" onchange="selectionChange(this.options.item(this.selectedIndex).getAttribute('info'))">
                                    <optgroup>
                                        <option value="0">----SELECT AN ITEM TO EDIT STOCK----</option>
                                    </optgroup>
                                    <?php
                                        $products = (array)$database->getAllProductsForDropDownWareHouse();
                                        $vamp = 0;
                                        foreach ($products as $dpt)
                                        {
                                            $value = "";
                                            $ptype = $dpt['ProductType'];
                                            if($vamp != $ptype)
                                            {
                                    ?>
                                    </optgroup>
                                    <optgroup label="<?php echo $dpt['type'];?>">
                                        <?php
                                                $vamp = $ptype;
                                            }
                                            $updateQty = $database->getProductStoreQty($dpt['id'],$myData['storeID']);
                                        ?>
                                        <option info="<?php echo $updateQty." ".$dpt['unitName'];?>" value="<?php echo $dpt['id'];?>"><?php echo $dpt['Code'].' ---- '.$dpt['productName'];?></option>
                                    <?php
                                        }
                                    ?>
                                    </optgroup>
                                </select>

                            </div>
                            <div class="col-md-1">
                                <input type="text" name="currentQty" disabled="disabled" value="" placeHolder="Recorded" id="currentQty" class="form-control" value="1">

                                <input  class="form-control m-b" name="txtStoreID" id="txtStoreID" value="<?php echo $myData['storeID'];?>" type="hidden">
                            </div>

                            <div class="col-md-1">

                                <input type="text" name="updateQty" value="" class="form-control" id="updateQty" placeHolder="Physical" required onKeyPress="return isNumberKey(event)" value="1">

                            </div>
                            <?php
                                if($myData['storeID'] == 3 )
                                {
                            ?>
                                <div class="col-md-1">
                                    <input type="text" name="nProductPrice"
                                           value="" class="form-control" id="nProductPrice" placeHolder="Unit Price" onkeyup = "javascript:this.value=Comma(this.value);" required onKeyPress="return isNumberKey(event)" value="1">
                                </div>
                            <?php
                                }
                            ?>
                            <div class="col-md-2">
                                <button class="btn  blue btn-block btn-outline" onclick="addRow();">Add Item</button>
                            </div>

                        </div>

                        <div class="row"></div>

                        <form action="" method="post">
                            <input type="hidden" name="txtStoreID" value="<?php echo $myData['storeID']; ?>">
                            <table id="table" class="table table-striped table-bordered table-advance table-hover">
<!--                                <thead>-->
                                    <tr style="background-color: #49b6d6">
                                        <th> CODE </th>
                                        <th class="hidden-xs"> PRODUCT </th>
                                        <th> Physical Qty </th>
                                        <th> Recorded Qty </th>
                                        <th> </th>
                                    </tr>
<!--                                </thead>-->
                                <tbody>

                                    <!-- Selected products are populated here -->

                                </tbody>
                            </table>
                            <br/>
                            <div class="clearfix"></div>
                            <div class="row" style="display: flex; justify-content: center; align-items: center;">

                                <button <?php if($myData['warehouse'] > 0 AND $myData['AccessLevel'] < 7){ echo 'disabled'; } ?> type="submit" class="btn btn-success col-lg-4" name="btnUpdateStock"><i class="fa fa-plus-o"></i>REQUEST STOCK UPDATE</button>
                            </div>

                    </div>
                    </form>
                </div>

                <div class="col-lg-12">
                    <div class="widgets-container">
                            <center><h2 class="bottom35">STOCK UPDATE REQUESTS</h2></center>
                       <br>
                        <div class="table-responsive">
                            <table id="editStockTable"  class="display nowrap table  responsive nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th>Ticket#</th>
                                        <th>Items Quantity</th>
                                        <th>Approval Status</th>
                                        <th>Raised By</th>
<!--                                        <th>Approved By</th>-->
                                        <th>Date Raised / Approved</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Ticket#</th>
                                        <th>Items Quantity</th>
                                        <th>Approval Status</th>
                                        <th>Raised By</th>
<!--                                        <th>Approved By</th>-->
                                        <th>Date Raised / Approved</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                        $getEdits = $database->getStockEdits();

                                        if ($getEdits != null)
                                        {
                                            foreach ($getEdits as $getEdit)
                                            {
                                                $approval = $getEdit['approval'] > 0 ? 'APPROVED' : 'PENDING';
                                                $approvedBy = $getEdit['approval'] == 0 ? '' : $database->getSingleUserInformation($getEdit['approval'])['fullname'];
                                                $link = '<a href="' . $host . 'stock-edit-details/' . $getEdit['id'] . '/' . $getEdit['store_id'] . '">' . $getEdit['edit_ticket'] . '</a>';
                                        ?>
                                               <tr>
                                                   <td>
                                                      <?php echo $link ?>
                                                   </td>
                                                   <td><?php echo $getEdit['itemsQty']  ?></td>
                                                   <td><?php echo  $approval ?></td>
                                                   <td><?php echo $getEdit['fullname'] ?></td>
<!--                                                   <td>--><?php //echo $approvedBy ?><!--</td>-->
                                                   <td>
                                                       <?php
                                                            echo date('Y-m-d', $getEdit['created_at']) ;

                                                            echo $getEdit['approval'] != 0
                                                           ? ' / ' . date('Y-m-d', $getEdit['updated_at'])
                                                           : ' / Pending';
                                                       ?>
                                                   </td>
                                               </tr>
                                        <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--All form elements  End -->

<?php
    include '../includes/footer.php';