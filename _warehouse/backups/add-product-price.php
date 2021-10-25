<?php
  include("../data/DBConfig.php");
  include_once("../data/sessioncheck.php");
   $yr_ = date("Y");
    
    //  if($myData['storeID'] == 0){
    //     $database->redirect_to($host);
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Recieve Goods Ticket</title>
<!-- Bootstrap -->
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
                            if(isset($_POST['btnSubmitNewProduct'])){
                               
                                // $supplier = $database->test_input($_POST['txtSupplier']);
                                // $invoiceNo = $database->test_input($_POST['txtInvoiceNo']);
                                // $fileRef = $database->test_input($_POST['txtFileReference']);
                                // $storeID = $database->test_input($_POST['txtStore']);
                                // $save = 1;
                                // $invoiceDate = str_pad($_POST['txtDay'],2,"0",STR_PAD_LEFT)."/".str_pad($_POST['txtMonth'],2,"0",STR_PAD_LEFT)."/".$_POST['txtYear'];
                                   $product=$qty=$amount=array();
                                        if(isset($_POST['txtProduct'])){
                                            $product = $_POST['txtProduct'];
                                            $cost = $_POST['txtProductQty'];
                                   }

                                  if(isset($_POST['txtProduct']) && !empty($_POST['txtProduct'])){
                                       
                                        $myValue = $database->UpdateProductPrice($product, $cost);

                                        unset($_POST);
                                        $database->showMsg('', "PRODUCT PRICE HAS BEEN MADE SUCCESSFULLY", 2);
                                 
                                  }else{

                                        $database->showMsg('', 'All fields are required', 1);
                                    }



                            }

                        ?>

        <h1 style="text-align: center"><span class="btn btn-warning">ADD PRODUCT PRICE </span></h1>
         <h4 style="text-align: center">PRODUCT PRICE ADDED BY <?php echo strtoupper($myData['fullname']); ?></h4>

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
              var nQty = '<input type="text" placeholder="Price." required  onkeyup = "javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)"  name="txtProductQty[]" class="form-control required" value="'+qty_+'" />';
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
                           <option value="0">----SELECT AN ITEM YOU WANT TO RECIEVE----</option>
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
                       <optgroup label="<?php echo $dpt['type'];?>">
                           <?php
                           $storeID = 1;
                                $vamp = $ptype; }
                                $qty = $database->getProductStoreQty($dpt['id'],$storeID);

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
                        value="" class="form-control" id="nQty" placeHolder="Price" required onKeyPress="return isNumberKey(event)" value="1">

                </div>
                <div class="col-md-2">
                             <button class="btn  blue btn-block btn-outline " onclick="addRow();">Add Item</button>
                </div>



        </div>
     <hr>        <form action="" method="post">
                 <div class="borderedTable">
                


                    <table id="table" class="table table-striped table-bordered table-advance table-hover">

                      <thead>

                        <tr>
                         
                           <th> <i class="fa fa-briefcase"></i> CODE </th>
                          <th class="hidden-xs"> <i class="fa fa-user"></i> PRODUCT NAME </th>
                         <!-- <th> <i class="fa fa-shopping-cart"></i> Price </th>-->
                          <th> <i class="fa fa-hand-peace-o"></i> PRICE </th>
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
                                 <button type="submit" class="btn btn-success col-lg-12" name="btnSubmitNewProduct"><i class="fa fa-plus-o"></i>ADD PRICE!</button>
                            </div>
                        </div>

                      </div>
                      </form>
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

</body>
</html>
