<?php
  include("../data/DBConfig.php");
  include_once("../data/sessioncheck.php");
   $yr_ = date("Y");
    $id = $database->test_input($_GET['id']);
    $ticket = $database->getPurchaseTicket($id);
    if($ticket == null){
        $database->redirect_to($host);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Make Purchase</title>
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
        <script src="<?php echo $host;?>assets/js/jquery.min.js"></script>

<!--[if lt IE 9]> <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
<!--[if lt IE 9]> <script src="dist/html5shiv.js"></script> <![endif]-->
</head>
<?php include("../includes/header_.php");?>


<div class="page-content-wrapper animated fadeInRight">
  <div class="page-content" >
    <div class="row wrapper border-bottom page-heading">
      <div class="col-lg-12">
        <h2> EDIT Purchase for <?php echo $ticket['machine_code'];?> | <?php echo $ticket['ticketNo'];?></h2>
         <h4><?php echo $ticket['machineBrand'];?></h4>
                                    <h4><?php echo $ticket['AccountName'];?></h4>
                                    <p>
                                        <?php echo $ticket['Address'].", ".$ticket['areaname'].", ".$ticket["lga"]." L.G.A, ".$ticket['state'];?><br/>
                                    </p>
        <ol class="breadcrumb">
          <li> <a href="index-2.html">Home</a> </li>
          <li> <a>PurchaSE</a> </li>
          <li class="active"> <strong>Edit Purchase </strong> </li>
        </ol>
      </div>
    </div>
    <div class="wrapper-content ">
      <div class="row">
          <?php
                            if(isset($_POST['btnRegisterCall'])){

                               
                            }

                        ?>
   <script>
      function addRow(){
          var productID =  document.getElementById('nProduct');
          var id = productID.value;
          var nID = '<input type="hidden" name="txtProduct[]" value="'+id+'" /><input type="hidden" name="recVal[]" value="0"/> ';
          var selectText =  productID.options[productID.selectedIndex].text;
          var productname =  selectText.substr(selectText.indexOf("---- ")+4,selectText.length);

          var productcode = selectText.substr(0,selectText.indexOf("----"));
          var nQty = '<input type="text" placeholder="QTY." required  onkeyup = "javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)"  name="txtProductQty[]" class="form-control required" value="'+document.getElementById('nQty').value+'" />';
          var nPrice = '<input type="text" placeholder="PRICE."  onkeyup = "javascript:this.value=Comma(this.value);" required onKeyPress="return isNumberKey(event)"  name="txtProductAmount[]" class="form-control required" value="'+document.getElementById('nPrice').value+'" />';
           var Action = "<input type='button' class='btn btn-outline btn-round dark btn-sm black' onclick='removeRow();' value='Remove Row'/>";
          var table = document.getElementById('table');
          var newRow = table.insertRow(1);

          var cel1 = newRow.insertCell(0);
          var cel2 = newRow.insertCell(1);
          var cel3 = newRow.insertCell(2);
          var cel4 = newRow.insertCell(3);
          var cel5 = newRow.insertCell(4);

          cel1.innerHTML = productcode+nID;
          cel2.innerHTML = productname;
          cel3.innerHTML = nPrice;
          cel4.innerHTML = nQty;
          cel5.innerHTML = Action;
      }

        function removeRow() {
            var index, table = document.getElementById('table');
    for(var i = 1; i < table.rows.length; i++)
    {
       table.rows[i].cells[4].onclick = function()
       {
           var c = confirm("do you want to delete this row ?");
           if(c=== true){
                   index = this.parentElement.rowIndex;
                   table.deleteRow(index);
             }
       };
    }
       }



</script>

        <div class="col-lg-12 top20 bottom20">
          <div class="widgets-container">

                    <div class="form-group">
                         <label class="col-lg-3 control-label">CONSUMABLE & SPARE PARTS</label>
                <div class="col-lg-4">
                  <select class="_select form-control" name="nProduct" id="nProduct">
          <?php

                    $products = (array)$database->getAllProductsForDropDown();
                    $vamp = 1;
                    foreach ($products as $dpt) {
                        $value = "";
                        $ptype = $dpt['ProductType'];
                            if($vamp != $ptype){?>
                                 </optgroup>
                                <optgroup label="<?php echo $dpt['type'];?>">
                           <?php $vamp = $ptype; }
                         ?>

                          <option value="<?php echo $dpt['id'];?>"><?php echo $dpt['Code'].' ---- '.$dpt['productName'];?></option>

                      <?php  }?>
                       </optgroup>
            </select>

                </div>
                <div class="col-md-2">

                                                <input type="text" name="nPrice"
                                                value="" placeHolder="AMOUNT" id="nPrice"  onkeyup = "javascript:this.value=Comma(this.value);" class="form-control" onKeyPress="return isNumberKey(event)" value="1">

                                        </div>
                                         <div class="col-md-1">

                                                <input type="text" name="nQty"
                                                value="" class="form-control" id="nQty" placeHolder="QTY" required onKeyPress="return isNumberKey(event)" value="1">

                                        </div>
                                        <div class="col-md-2">
                                                     <button class="btn  blue btn-block btn-outline " onclick="addRow();">Add Item</button>
                                        </div>



        </div>
     <hr>
                 <div class="borderedTable">
                  <div class="table-scrollable">
                  <form action="" method="post">
                    <table id="table" class="table table-striped table-bordered table-advance table-hover">
                      <thead>
                        <tr>
                          <th> <i class="fa fa-briefcase"></i> Code </th>
                          <th class="hidden-xs"> <i class="fa fa-user"></i> Product Name </th>
                          <th> <i class="fa fa-shopping-cart"></i> Price </th>
                          <th> <i class="fa fa-shopping-cart"></i> Qty </th>

                          <th> </th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                           $salesorder = (array)$database->getPurchaseProductOrderCall($ticket['id']);
                            foreach ($salesorder as $order) { ?>

                            <tr>

                                    <td><?php echo $order['Code'];?><input type="hidden" name="recVal[]" value="<?php echo $order['id']; ?>"/></td>
                                    <td><?php echo $order['productName'];?></td>
                                     <td><input type="text" placeholder="PRICE."  onkeyup = "javascript:this.value=Comma(this.value);" required onKeyPress="return isNumberKey(event)"  name="txtProductAmount[]" class="form-control required" value="<?php echo $order['Amount'];?>"/></td>
                                    <td><input type="text" placeholder="QTY." required  onkeyup = "javascript:this.value=Comma(this.value);" onKeyPress="return isNumberKey(event)"  name="txtProductQty[]" class="form-control required" value="<?php echo $order['qty'];?>"/></td>
                                    <td><button name="btnDelete" value="<?php echo $order['id']; ?>">Delete</button></td>
                            </tr>
                    <?php }?>



                      </tbody>
                      </table>
                         <button type="submit" class="btn btn-success col-md-12" name="btnRegisterCall" disabled="">
                             <i class="fa fa-plus-o"></i>
                                    Submit
                         </button>
                      </form>
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
    <script src="<?php echo $host;?>assets/js/main.js"></script>
    <script type="text/javascript">
        $(function() {
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
