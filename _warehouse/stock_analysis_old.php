  <?php
    include("../data/DBConfig.php");
    include_once("../data/sessioncheck.php");
      


    if(!isset($_GET['id'])){
        // $database->redirect_to($host);
    }else{
        $category_id = $database->test_input($_GET['id']);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>View Stock Analysis</title>
<!-- morris -->
<link href="<?php echo $host;?>assets/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="<?php echo $host;?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $host;?>assets/css/responsive.dataTables.min.css" rel="stylesheet">
<link href="<?php echo $host;?>assets/css/fixedHeader.dataTables.min.css" rel="stylesheet">
<!-- Bootstrap -->
<link href="<?php echo $host;?>assets/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $host;?>assets/css/jasny-bootstrap.min.css">
<!-- slimscroll -->
<link href="<?php echo $host;?>assets/css/jquery.slimscroll.css" rel="stylesheet">
<!-- Fontes -->
<link href="<?php echo $host;?>assets/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo $host;?>assets/css/simple-line-icons.css" rel="stylesheet">
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
<script src="<?php echo $host;?>assets/js/vendor/jquery-2.1.1.min.js" type="text/javascript"></script>
<!--[if lt IE 9]> <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
<!--[if lt IE 9]> <script src="dist/html5shiv.js"></script> <![endif]-->
<?php include("../includes/header_.php");?>

    <!-- End page sidebar wrapper -->
    <!-- Start page content wrapper -->
     <div class="page-content-wrapper">
    <div class="page-content">
      <div class="row wrapper border-bottom page-heading">
        <div class="col-lg-12">
          <h2>View Stock Analysis </h2>
          <ol class="breadcrumb">
            <li> <a href="index-2.html">Home</a> </li>
            <li> <a>Settings</a> </li>
            <li> <a>Products</a> </li>
            <li class="active"> <strong>Stock Analysis</strong> </li>
       
          </ol>
        </div>





        
      </div>

    <div class="col-lg-12 top20 bottom20">
          <div class="widgets-container">
         <form action="" method="post">
         <div class="form-group">
                    <label class="col-lg-1 control-label">P.CATEGORY</label>
                        <div class="col-lg-4">
                        <select class="_select form-control" name="nProduct" id="nProduct">
                                       <optgroup>
                                           <option value="0">----SELECT AN ITEM YOU WANT TO PREVIEW----</option>
                                       </optgroup>
                                      <?php

                                            $products = (array)$database->getProductsCategory();
                                            $vamp = 0;
                                            foreach ($products as $dpt) {
                                                $value = "";
                                                $ptype = $dpt['ProductType'];

                                                if($vamp != $ptype){
                                      ?>
                                      
                                      <optgroup label="<?php echo $dpt['type'];?>">
                                           <?php
                                             $vamp = $ptype; }
                                            ?>
                                        <option value="<?php echo $dpt['id'];?>">
                                          <?php echo $dpt['type'];?>
                                        </option>
                                      <?php }?>

                                     </optgroup>
                             </select>


                        </div>

                        <label class="col-lg-1 control-label">P.YEAR</label>
                        <div class="col-lg-4">
                        <select class="_select form-control" name="nYear" id="nYear">
                                       <optgroup>
                                           <option value="0">----SELECT THE YEAR YOU WANT TO PREVIEW----</option>
                                       </optgroup>
                                      
                                        <option value="2016">
                                         2016
                                        </option>
                                        <option value="2017">
                                         2017
                                        </option>
                                        <option value="2018">
                                         2018
                                        </option>
                                        <option value="2019">
                                         2019
                                        </option>
                                      

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
                            <button class="btn  blue btn-block btn-outline" name="btnGetBim">GET ANALYSIS</button>
                    </div>

            </div>
         <hr>
       </form>
     </div>
   </div>
      <div class="wrapper-content ">



      <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">

              <div class="ibox-content collapse in">
                <div class="widgets-container">



                    

                  
                    <?php
            if(isset($_POST['btnGetBim'])){
              if($_POST['nProduct'] < 1 && $_POST['nYear'] < 1){
                    $database->showMsg("Error", "Please select product category and/or select analysis year",1);
                }else{
                    $category_id = $database->test_input($_POST['nProduct']);
                    $year = $_POST['nYear'];
                    $products = (array)$database->getProductsByCategory($category_id);

                   
            

       ?>
                    
                 
                   <div class="table-responsive">
                       <table id="example7"  class="display nowrap table  responsive nowrap table-bordered">

      

                      <thead>
                        <style type="text/css">
                          th,td{

                            text-align: center;
                          }
                        </style>

                        <tr>  
                              <th> <i class="fa fa-number"></i> I.D </th>
                              <th> <i class="fa fa-briefcase"></i> CODE </th>
                              <th class="hidden-xs"> <i class="fa fa-user"></i> PRODUCT NAME </th>
                          <!--     <th> <i class="fa fa-briefcase"></i> JAN </th> -->
                              <?php
                    $yr = date('Y');

                   for($i = 1; $i <= 12; $i++){

                        $jd=gregoriantojd($i,1,$yr);
                         $monthly = jdmonthname($jd,0);
                         echo "<th>";

                         echo  $monthly ;
                         echo "</th>";

                       }
                              ?>
                              <th>AVG PER MONTH</th>

                              <th>CURRENT STOCK</th>

                               <th>ROTATION MONTHS</th>

                              
                        </tr>
                      </thead>
                      <tbody>
                        <?php 

                        $yr = date('y');
                             

                                        foreach($products as $prod){

                               
                                        ?>

                               <tr>
                                <td><?php echo $prod['id'];?></td>
                                 <td><?php echo $prod['Code'];?></td>
                                 <td><?php echo $prod['productName'];?></td>
                                 <?php
                                  //  $yr = date('Y');
                                   //  $yr = date('2018');
                                     $yr = $year;
                                     //var_dump($yr);
                                      $totalMonthlySummary = 0;
                                      $validMonthCount =0;
                                     for($i = 1; $i <= 12; $i++){

                                         //$jd=gregoriantojd($i,1,$yr);

                                        // $monthly = jdmonthname($jd,0);
                                           
                                          $dt = $yr.'-0'.$i.'-23';
                                                  echo "<td>";
                                                 //echo   $dt ;
                                                  $monthEndDate =  date('Y-m-t', strtotime($dt)) ;
                                              //echo  date('Y-m-t', strtotime($dt)) ;
                                              //    echo $monthEndDate;

                                                $dateMonth = date("m",strtotime($monthEndDate));
                                                 //var_dump($dateMonth);
                                                $totalStock = (array)$database->stockMonthlySummary($prod['id'], $i, $yr);
                                                 //var_dump($totalStock);
                                               

                                                 foreach($totalStock as $stock){

                                                     $specificMonthTotalStock = $stock['totalsold'];

                                                     if($specificMonthTotalStock > 0 ){

                                                     $totalMonthlySummary = $totalMonthlySummary + $specificMonthTotalStock;
                                                      $validMonthCount++;
                                                     }
                                                     
                                                     if($specificMonthTotalStock == null){

                                                        $specificMonthTotalStock = 0;

                                                        }

                                                    echo  $specificMonthTotalStock;
                                                 }
                                                 

                                                 // echo  date('Y-m-01', strtotime($dt)) ;

                                                  echo "</td>";

                                                  }
                                                  if($validMonthCount != 0 || $validMonthCount != null){

                                                    $monthlyAverage = $totalMonthlySummary/$validMonthCount ;
                                                  }else {
                                                    $monthlyAverage =0;
                                                  }
                                                      ?>

                                                 <td><?php echo round($monthlyAverage, 0) ?></td>
                                                 <td><?php $totalProductStock = $prod['store1'] + $prod['store2'];
                                                 echo $totalProductStock ?></td>
                                                 <td><?php if($totalProductStock != 0 && $monthlyAverage != 0){

                                                       $rotationMonth = $totalProductStock/round($monthlyAverage, 0);
                                                       echo round($rotationMonth, 0);

                                                 } elseif ($totalProductStock == 0 && $monthlyAverage > 0) {

                                                   $rotationMonth = "Out of stock";
                                                   echo $rotationMonth;

                                                 }elseif ($totalProductStock > 0 && $monthlyAverage == 0) {

                                                   $rotationMonth = "In stock";
                                                   echo $totalProductStock;

                                                 }elseif ($totalProductStock == 0 && $monthlyAverage == 0) {

                                                   $rotationMonth = "Out of stock";
                                                   $totalProductStock = 0;
                                                    echo $rotationMonth;

                                                 }

                                                  ?></td>
                                 <?php }  ?>
                                     
                                 
                               </tr>

                               


                      </tbody>
                      </table>
                </div>
                  <?php }  
                   }
                    ?>
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
