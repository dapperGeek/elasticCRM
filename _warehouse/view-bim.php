<?php
  include("../data/DBConfig.php");
  include_once("../data/sessioncheck.php");
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
    
    <link href="<?php echo $host;?>assets/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="<?php echo $host;?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $host;?>assets/css/responsive.dataTables.min.css" rel="stylesheet">
<link href="<?php echo $host;?>assets/css/fixedHeader.dataTables.min.css" rel="stylesheet">
    
    
    
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
<link href="<?php echo $host;?>assets/css/responsive.dataTables.min.css" rel="stylesheet">
<link href="<?php echo $host;?>assets/css/fixedHeader.dataTables.min.css" rel="stylesheet">
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

     <!-- <?php
                            if(isset($_POST['btnSubmitNewProduct'])){

                            }

      ?>  -->

        <h2 style="text-align: center">PREVIEW BIN CARD OF ITEMS IN THE STORE  <i class="fa fa-binoculars"></i></h2>
         <h4 style="text-align: center">GOODS BIN CARD PREVIEWED BY <?php echo strtoupper($myData['fullname']); ?></h4>

      </div>
    </div>
    <div class="wrapper-content ">
      <div class="row">

     <div class="col-lg-12 top20 bottom20">
          <div class="widgets-container">
         <form action="" method="post">
         <div class="form-group">
                    <label class="col-lg-1 control-label">ITEM</label>
                        <div class="col-lg-4">
                          <select class="_select form-control" name="nProduct" id="nProduct">
                                       <optgroup>
                                           <option value="0">----SELECT AN ITEM YOU WANT TO PREVIEW----</option>
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
                                             $vamp = $ptype; }
                                            ?>
                                        <option info="<?php echo $dpt['unitName'];?>" value="<?php echo $dpt['id'];?>"><?php echo $dpt['Code'].' ---- '.$dpt['productName'];?></option>
                                      <?php }?>

                                     </optgroup>
                             </select>

                        </div>
                   <!-- <label class="col-lg-1 control-label">STORE</label>
                    <div class="col-lg-4">
                          <select class="_select form-control m-b" name="txtStore" required data-validation-required-message="Supplier is required" >
                                      <?php
                                            $mySuppliers = (array)$database->getAllStores();

                                            foreach($mySuppliers as $ms){ ?>
                                               <option value="<?php echo $ms['id'];?>" <?php if(isset($_POST['txtStore']) && $_POST['txtStore'] == $ms['id']){echo "seleccted";}?>><?php echo $ms['storeName'];?></option>
                                           <?php }

                                      ?>

                          </select>
                    </div>-->
                    <div class="col-md-2">
                            <button class="btn  blue btn-block btn-outline" name="btnGetBim">GET BIN</button>
                    </div>

            </div>
         <hr>
       </form>

       <?php
            if(isset($_POST['btnGetBim'])){
              if($_POST['nProduct'] < 1){
                    $database->showMsg("Error", "Please select an Item and Store",1);
                }else{
                    $productID = $database->test_input($_POST['nProduct']);
                    $goodsLogs = (array)$database->getGoodsLog($productID);


       ?>
        <table id="example7"  class="display nowrap table  responsive nowrap table-bordered">

      

                      <thead>

                        <tr>
                              <th> <i class="fa fa-briefcase"></i> CODE </th>
                              <th class="hidden-xs"> <i class="fa fa-user"></i> PRODUCT NAME </th>
                              <th> <i class="fa fa-shopping-cart"></i> add</th>
                              <th> <i class="fa fa-shopping-cart"></i> tran. </th>
                              <th> <i class="fa fa-shopping-cart"></i>  sold </th>
                               <th> <i class="fa fa-hand-peace-o"></i> returned </th>
                              <th> <i class="fa fa-hand-peace-o"></i> remain </th>
                
                               <th> <i class="fa fa-shopping-cart"></i> INVOICE NO </th>
                              <th> <i class="fa fa-shopping-cart"></i> STORE </th>
                              
                              <th> <i class="fa fa-clock-o"></i>DATE</th>
                              <th>DONE BY </th>
                        </tr>
                      </thead>
                      <tbody>
                               <?php foreach($goodsLogs as $gl){  ?>
                               <tr>
                                 <td><?php echo $gl['Code'];?></td>
                                 <td><?php echo $gl['productName'];?></td>
                                 <td><?php echo $gl['added'];?></td>
                                 <td><?php echo $gl['transfered'];?></td>
                                 <td><?php echo $gl['sold'];?></td>
                                  <td><?php echo $gl['returned'];?></td>
                                 <td><?php echo $gl['remain'];?></td>

                                 
                                  <td><?php echo $gl['InvoiceNo'];?></td>
                                 <td><?php echo $gl['storeName'];?></td>
                                 
                                 <td><?php echo $gl['ocYear']."/".str_pad($gl['ocMonth'],2,"0",STR_PAD_LEFT)."/".str_pad($gl['ocDay'],2,"0",STR_PAD_LEFT);?></td>
                                  <td><?php echo $gl['fullname'];?></td>
                               </tr>
                               <?php }?>


                      </tbody>
                      </table>
                           <br/>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-5">

                            </div>
                            <div class="col-md-2">&nbsp;</div>
                             <div class="col-md-5">
                                 <button type="submit" class="btn btn-success col-lg-12" name="btnSubmitNewProduct"><i class="fa fa-file-pdf-o"></i> Convert to PDF!</button>
                            </div>
                        </div>

                      </div>

        <?php }}  ?>

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
    
    !-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<!-- bootstrap js -->

<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jasny-bootstrap.min.js" charset="UTF-8"></script>
<!-- slimscroll js -->

<!-- dataTables-->
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/dataTables.bootstrap.min.js"></script>


    <script src="<?php echo $host;?>assets/js/vendor/select2.min.js"></script>
    <script src="<?php echo $host;?>assets/js/vendor/bootstrap-select.min.js"></script
    
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

</body>
</html>
