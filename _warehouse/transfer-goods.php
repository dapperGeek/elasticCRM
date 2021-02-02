<?php
include("../data/DBConfig.php");
include_once("../data/sessioncheck.php");

$yr_ = date("Y");

if($myData['storeID']== 0){
    $database->redirect_to($host);
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transfer Goods To Other Warehouse</title>
    <!-- Bootstrap -->

    <link href="<?php echo $host;?>assets/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo $host;?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $host;?>assets/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo $host;?>assets/css/fixedHeader.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo $host;?>assets/css/morris.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="<?php echo $host;?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $host;?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="<?php echo $host;?>assets/css/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $host;?>assets/css/bootstrap-select.min.css" />
    <!-- slimscroll -->
    <link href="<?php echo $host;?>assets/css/jquery.slimscroll.css" rel="stylesheet">
    <!-- Fontes -->
    <link href="<?php echo $host;?>assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $host;?>assets/css/simple-line-icons.css" rel="stylesheet">
    <!-- all buttons css -->
    <link href="<?php echo $host;?>assets/css/buttons.css" rel="stylesheet">
    <!-- animate css -->
    <link href="<?php echo $host;?>assets/css/animate.css" rel="stylesheet">
    <!-- top nev css -->
    <link href="<?php echo $host;?>assets/css/page-header.css" rel="stylesheet">
    <!-- adminui main css -->
    <link href="<?php echo $host;?>assets/css/main.css" rel="stylesheet">
    <!-- aqua black theme css -->
    <link href="<?php echo $host;?>assets/css/aqua-black.css" rel="stylesheet">
    <!-- media css for responsive  -->
    <link href="<?php echo $host;?>assets/css/main.media.css" rel="stylesheet">

    <!-- Ion Range Slider -->
    <link rel="stylesheet" href="<?php echo $host;?>assets/css/normalize.css" />
    <link rel="stylesheet" href="<?php echo $host;?>assets/css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="<?php echo $host;?>assets/css/ion.rangeSlider.skinFlat.css" />

    <!--[if lt IE 9]> <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
    <!--[if lt IE 9]> <script src="dist/html5shiv.js"></script> <![endif]-->
</head>
<?php include("../includes/header_.php");?>


<div class="page-content-wrapper animated fadeInRight">
    <div class="page-content" >
        <div class="row wrapper border-bottom page-heading">
            <div class="col-lg-12">

<?php
    $i = 0;
    
    if(isset($_POST['btnSubmitNewProduct']))
    {
        $supplier = $database->test_input($_POST['txtSupplier']);
        $receivingStoreId = $database->getWarehouseIdfromName($supplier);
        //var_dump($receivingStoreId);
        //exit;
       
        $invoiceNo = $database->test_input($_POST['txtInvoiceNo']);
        $fileRef = $database->test_input($_POST['txtFileReference']);
        $storeID = $database->test_input($_POST['txtStore']);
        //var_dump($storeID);
        // exit;
        
        $save = 1;
        $invoiceDate = str_pad($_POST['txtDay'], 2, "0", STR_PAD_LEFT)."/".str_pad($_POST['txtMonth'], 2, "0",STR_PAD_LEFT). "/" .$_POST['txtYear'];

        $product = $qty = $amount = array();

        if(isset($_POST['txtProduct']))
        {
            $product = $_POST['txtProduct'];
            $qty = $_POST['txtProductQty'];
        }

        if(isset($_POST['txtProduct']) && !empty($_POST['txtProduct']))
        {
            if($i == 0)
            {
                $myValue = $database->SellProductStock($supplier, $invoiceNo, $fileRef, $storeID, $product, $qty, $save, $invoiceDate, 2, $receivingStoreId);
                unset($_POST);
                $database->showMsg('', "TRANSFER HAS BEEN MADE SUCCESSFULLY", 2);
            }
            else
            {
                $database->showMsg('', "YOU HAVE ADDED THIS PREVIOUSLY", 1);
            }
        }
        else
        {
            $database->showMsg('', 'All fields are required to create a supply ticket', 1);
        }

        $i++;
    }
?>

                <h1 style="text-align: center">
                    <span class="btn btn-danger">
                        TRANSFER GOODS TICKET FOR WARE HOUSE   -   <?php echo strtoupper($store[1]);?>
                    </span>
                </h1>
                <h4 style="text-align: center">
                    GOODS BEEN TRANSFERRED BY <?php echo strtoupper($myData['fullname']); ?>
                </h4>

            </div>
        </div>
        <div class="wrapper-content ">
            <div class="row">

                <script>
                    var displaySubTotal = 0;
                    var DiscountVal = 0;

                    function addRow(){
                        var productID =  document.getElementById('nProduct');
                        var id = productID.value;
                        if(id > 0){
                            var nID = '<input type="hidden" name="txtProduct[]" value="'+id+'" /> ';
                            var selectText =  productID.options[productID.selectedIndex].text;
                            var productname =  selectText.substr(selectText.indexOf("---- ")+4,selectText.length);
                            var qty_ = document.getElementById('nQty').value;
                            var unitName = document.getElementById('nPrice').value;
                            var productcode = selectText.substr(0,selectText.indexOf("----"));
                            var nQty = '<input type="text" placeholder="QTY." required  onkeyup = "javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)"  name="txtProductQty[]" class="form-control required" value="'+qty_+'" />';
                            var nPrice = '<input type="text" placeholder="UNITS" name="txtProductPcs[]" class="form-control required" value="'+unitName+'" />';
                            var cal =   unitName;
                            var Action = "<input type='button' class='btn btn-outline btn-round dark btn-sm black' onclick='removeRow("+20+");' value='Remove Row'/>";
                            var table = document.getElementById('table');
                            var newRow = table.insertRow(1);
                            var cel1 = newRow.insertCell(0);
                            var cel2 = newRow.insertCell(1);
                            var cel3 = newRow.insertCell(2);
                            var cel4 = newRow.insertCell(3);
                            var cel5 = newRow.insertCell(4);


                            cel1.innerHTML = productcode+nID;
                            cel2.innerHTML = productname;

                            cel3.innerHTML = nQty;
                            cel4.innerHTML = cal;
                            cel5.innerHTML = Action;
                            document.getElementById('nPrice').value = "";
                            document.getElementById('nQty').value = "";
                            document.getElementById('nProduct').value = 0;
                        }else{
                            alert("PLEASE SELECT A PRODUCT");
                        }

                    }

                    function removeRow(id) {
                        var index, table = document.getElementById('table');
                        for(var i = 1; i < table.rows.length; i++)
                        {
                            table.rows[i].cells[4].onclick = function()
                            {
                                var c = confirm("do you want to delete this row ?");
                                if(c=== true){

                                    //alert("we are removing "+id);
                                    displaySubTotal = displaySubTotal - id;
                                    index = this.parentElement.rowIndex;
                                    table.deleteRow(index);
                                    document.getElementById('subtotalAmount').value = addComma(displaySubTotal);
                                    displayDiscount();
                                }
                            };
                        }
                    }

                    function updateDiscount(val){
                        DiscountVal = val;
                        displayDiscount();
                    }

                    function amountedTotal(disval){
                        var amounted__ = displaySubTotal - disval;
                        document.getElementById("amountedTotal").value = addComma(amounted__);
                    }

                    function displayDiscount(){
                        var disVal = (DiscountVal/100)*displaySubTotal;
                        document.getElementById('discountView').value = addComma(disVal);
                        amountedTotal(disVal);
                    }

                    function selectionChange(info){
                        var np =  document.getElementById('nPrice');
                        if(info > 0){np.readOnly = true;}else{np.readOnly = false;}
                        info = info.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        np.value = info;
                        // alert(info);
                    }

                    function addComma(x){
                        // var part = x.toString().split(".");
                        // part[0] = part[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        // return part.join(".");
                        return x.toLocaleString();
                    }

                </script>

                <div class="col-lg-12 top20 bottom20">
                    <div class="widgets-container">

                        <div class="form-group">
                            <label class="col-lg-2 control-label">CONSUMABLE & SPARE PARTS</label>
                            <div class="col-lg-4">
                                <select class="_select form-control" name="nProduct" id="nProduct" onchange="selectionChange(this.options.item(this.selectedIndex).getAttribute('info'))">
                                    <optgroup>
                                        <option value="0">----SELECT AN ITEM YOU WANT TO TRANSFER----</option>
                                    </optgroup>
                                    <?php

                                    $products = (array)$database->getAllProductsForDropDownWareHouse();
                                    $vamp = 0;
                                    foreach ($products as $dpt) {
                                    $value = "";
                                    $ptype = $dpt['ProductType'];
                                    if($vamp != $ptype){
                                    ?>
                                    </optgroup>
                                    <optgroup label="<?ph0000000000000ap echo $dpt['type'];?>">
                                        <?php
                                        $vamp = $ptype; }
                                        $qty = $database->getProductStoreQty($dpt['id'],$myData['storeID']);

                                        ?>
                                        <option info="<?php echo $qty." ".$dpt['unitName'];?>" value="<?php echo $dpt['id'];?>"><?php echo $dpt['Code'].' ---- '.$dpt['productName'];?></option>
                                        <?php  }?>
                                    </optgroup>
                                </select>

                            </div>
                            <div class="col-md-3">
                                <input type="text" name="nPrice" disabled="disabled" value="" placeHolder="CURRENT QUANTITY" id="nPrice" class="form-control" value="1">
                            </div>

                            <div class="col-md-1">

                                <input type="text" name="nQty"
                                       value="" class="form-control" id="nQty" placeHolder="QTY" required onKeyPress="return isNumberKey(event)" value="1">

                            </div>
                            <div class="col-md-2">
                                <button class="btn  blue btn-block btn-outline " onclick="addRow();">Add Item</button>
                            </div>
                        </div>
                        <hr>        <form action="" method="post">
                            <div class="borderedTable">
                                <div class="table-scrollable">

                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">TRANSFER TO STORE:</label>
                                                <div class="col-sm-9">
                                                    <!--  <input type="text" class="form-control m-b"  value="" required data-validation-required-message="Customer Name is required"> -->

                                                    <select required class="form-control m-b" name="txtSupplier">
                                                <?php    //$Stores = $database->getStoreName();
                                                    $Stores = $database->getStoreNameTransferOption($store[0]);
                                                    foreach ($Stores as $Store)
                                                    {
                                                ?>
                                                        <option value="<?php echo $Store['storeName'];?>">
                                                            <?php echo $Store['storeName'];?>
                                                        </option>
                                                <?php    
                                                    } 
                                                ?>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">TRANSFER DATE</label>
                                                <div class="col-sm-9">
                                                    <div class="col-md-4">
                                                        <select name="txtDay" class="form-control">
                                                            <?php for($i=1;$i < 32;$i++){ ?>
                                                                <option <?php if($i == date('d')){echo "selected";}?>>
                                                                    <?php echo $i;?>
                                                                </option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="txtMonth">
                                                            <?php for($i=1;$i < 13;$i++){ ?>
                                                                <option value="<?php echo $i;?>" <?php if($i == date('m')){echo "selected";}?>>
                                                                    <?php echo date('F', mktime(0, 0, 0, $i, 10))?>
                                                                </option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select name="txtYear" class="form-control">
                                                            <option>
                                                                <?php echo date('Y');?>
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" class="form-control m-b" name="txtInvoiceNo" value="TRANSFER" required data-validation-required-message="Invoice No is required">
                                                </div>

                                                <input type="hidden" name="txtFileReference"/>
                                                <!-- </div>
                                             </div> -->

                                            </div>

                                            <div class="form-group row">

                                                <label class="col-sm-3 control-label">TRANSFERING FROM STORE</label>
                                                <div class="col-sm-9">
                                                    <select class="_select form-control m-b" name="txtStore" required data-validation-required-message="Supplier is required" onChange="contractCheck();">
                                                        <?php
                                                        // $mySuppliers = (array)$database->getAllStores();

                                                        //   foreach($mySuppliers as $ms){ ?>
                                                        <?php //if(isset($_POST['txtStore']) && $_POST['txtStore'] == $ms['id']){echo "seleccted";} ?>
                                                        <option value="<?php echo $store[0];?>"><?php echo $store[1]." - ".strtoupper($store['2']);?></option>
                                                        <?php //} ?>

                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <table id="table" class="table table-striped table-bordered table-advance table-hover">

                                    <thead>

                                    <tr>
                                        <th> <i class="fa fa-briefcase"></i> CODE </th>
                                        <th class="hidden-xs"> <i class="fa fa-user"></i> PRODUCT NAME </th>
                                        <!-- <th> <i class="fa fa-shopping-cart"></i> Price </th>-->
                                        <th> <i class="fa fa-hand-peace-o"></i> QTY </th>
                                        <th> <i class="fa fa-shopping-cart"></i> UNIT </th>

                                        <th> </th>
                                    </tr>
                                    </thead>
                                    <tbody>



                                    </tbody>
                                </table>
                                <br/>
                                <div class="clearfix"></div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <!--<button type="submit" class="btn btn-warning col-lg-12" name="btnSaveNCont"><i class="fa fa-plus-o"></i>Save and Continue Later</button>-->
                                    </div>
                                    <div class="col-md-2">&nbsp;</div>
                                    <div class="col-md-5">
                                        <button type="submit" class="btn btn-success col-lg-12" name="btnSubmitNewProduct"><i class="fa fa-plus-o"></i>TRANSFER!</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>





            <div class="wrapper-content ">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">

                                <h5>
                                    Transfered for WareHouse
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <!--  <a href="<?php //echo $host;?>sell-goods" class="btn btn-success">SELL GOODS</a> -->
                                </h5>
                            </div>
                            <div class="ibox-content collapse in">
                                <div class="widgets-container">
                                    <div class="table-responsive">
                                        <table id="example7"  class="display nowrap table  responsive nowrap table-bordered">
                                            <thead>
                                            <tr>
                                                <th>OrderID</th>
                                                <th>Ticket#</th>
                                                <th>Receiving Store</th>
                                                <!-- <th>InvoiceNo</th>
                                                <th>Invoice Date</th> -->
                                                <!-- <th>Address</th> -->
                                                <th>Sending Store</th>
                                                <th>DoneBy</th>
                                                <th>Action</th>
                                                <th>Transfer Date</th>


                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>OrderID</th>
                                                <th>Ticket#</th>
                                                <th>Receiving Store</th>
                                                <!-- <th>InvoiceNo</th>
                                                <th> Date</th> -->
                                                <!-- <th>Address</th> -->
                                                <th>Sending Store</th>
                                                <th>DoneBy</th>
                                                <th>Action</th>
                                                <th>Transfer Date</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            <?php

                                            $myOrder = (array)$database->getAllGoodsTranfer();
                                            if($myOrder != null){

                                                foreach($myOrder as $mo){


                                                    ?>
                                                    <tr>

                                                        <td><a href="_warehouse/transter-ticket.php?id=<?php echo $mo['id'];?>" target="_blank"><?php echo str_pad($mo['id'],5,"0",STR_PAD_LEFT);?></a></td>
                                                        <td><?php echo $mo['TicketNo'];?></td>
                                                        <td><?php echo $mo['supplierID'];?></td>
                                                        <!-- <td><?php //echo $mo['invoiceNo'];?></td>
                                                <td>mmmm</td> -->
                                                        <!--   <td><?php //echo $mo['FileReference'];?></td> -->
                                                        <td><?php echo $mo['storeName'];?></td>
                                                        <td><?php echo $mo['fullname'];?></td>
                                                        <td><?php echo $mo['invoiceNo'];?></td>
                                                        <td><?php echo date('F j, Y', strtotime(str_ireplace('/', '-', $mo['invoiceDate'])));?></td>

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
            </div>

            <!--All form elements  End -->
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

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

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
            }]
        });



    });
</script>

</body>
</html>
