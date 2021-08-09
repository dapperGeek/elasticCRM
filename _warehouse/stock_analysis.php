<?php
    $pageHeader = 'viewStockAnalysis';
    include("../includes/header_with_pageHeading.php");

    if(!isset($_GET['id']))
    {
        // $database->redirect_to($host);
    }
    else
    {
        $category_id = $database->test_input($_GET['id']);
    }
?>
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
                    foreach ($products as $dpt)
                    {
                        $value = "";
                        $ptype = $dpt['ProductType'];

                        if($vamp != $ptype)
                        {
                ?>
                            <optgroup label="<?php echo $dpt['type'];?>">
               <?php
                            $vamp = $ptype;
                        }
                ?>
                        <option value="<?php echo $dpt['id'];?>">
                          <?php echo $dpt['type'];?>
                        </option>
                <?php
                    }
                ?>
                        </optgroup>
                        </select>
                    </div>
                    <label class="col-lg-1 control-label">P.YEAR</label>
                    <div class="col-lg-4">
                        <select class="_select form-control" name="nYear" id="nYear">
                           <optgroup>
                               <option value="0">----SELECT THE YEAR YOU WANT TO PREVIEW----</option>
                <?php
                    for($i = 2017; $i <= date('Y'); $i++)
                    {
                        echo    "<option value=\"$i\">$i</option>" ;
                    }
                ?>
                        </optgroup>
                    </select>
                </div>
                   <!-- <label class="col-lg-1 control-label">STORE</label>
                    <div class="col-lg-4">
                          <select class="_select form-control m-b" name="txtStore" required data-validation-required-message="Supplier is required" >
                <?php
                    $mySuppliers = (array)$database->getAllStores();
                    foreach($mySuppliers as $ms)
                    {
                ?>
                    <option value="<?php echo $ms['id'];?>" <?php if(isset($_POST['txtStore']) && $_POST['txtStore'] == $ms['id']){echo "seleccted";}?>><?php echo $ms['storeName'];?></option>

                <?php
                    }
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
                if(isset($_POST['btnGetBim']))
                {
                    if($_POST['nProduct'] < 1 && $_POST['nYear'] < 1)
                    {
                        $database->showMsg("Error", "Please select product category and/or select analysis year",1);
                    }
                    else
                    {
                        $category_id = $database->test_input($_POST['nProduct']);
                        $year = $_POST['nYear'];
                        $products = (array)$database->getProductsByCategory($category_id);
            ?>
                <div class="table-responsive">
                   <style type="text/css">
                       th,td{
                           text-align: center;
                       }
                   </style>
                <table id="example7"  class="display nowrap table  responsive nowrap table-bordered">
                    <thead>
                        <tr>
                            <th> <i class="fa fa-number"></i> I.D </th>
                            <th> <i class="fa fa-briefcase"></i> CODE </th>
                            <th class="hidden-xs"> <i class="fa fa-user"></i> PRODUCT NAME </th>
                                  <!--     <th> <i class="fa fa-briefcase"></i> JAN </th> -->
                    <?php
                        $yr = date('Y');
                        for($i = 1; $i <= 12; $i++)
                        {
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
                    foreach($products as $prod)
                    {
                ?>
                        <tr>
                        <td><?php echo $prod['id'];?></td>
                        <td><?php echo $prod['Code'];?></td>
                        <td><?php echo $prod['productName'];?></td>
                <?php
                    //  $yr = date('Y');
                    $todaysDate = date("Y-m-d");
                    $yr = $year;
                    //var_dump($yr);
                    $totalMonthlySummary = 0;
                    $validMonthCount =0;
                    for($i = 1; $i <= 12; $i++)
                    {
                        //$jd=gregoriantojd($i,1,$yr);
                        // $monthly = jdmonthname($jd,0);
                        if($i < 10)
                        {
                            $dt = $yr.'-0'.$i.'-23';
                        }
                        else
                        {
                            $dt = $yr.'-'.$i.'-23';
                        }
                        echo "<td>";
                       //echo   $dt ;
                        $monthEndDate =  date('Y-m-t', strtotime($dt)) ;
                        //echo  date('Y-m-t', strtotime($dt)) ;
                        //    echo $monthEndDate;
                        $dateMonth = date("m",strtotime($monthEndDate));
                        $todaysMonth = date("m",strtotime($todaysDate));
                        //var_dump( $todaysMonth);
                        //  var_dump($monthEndDate);
                        $totalStock = (array)$database->stockMonthlySummary($prod['id'], $i, $yr);
                        //var_dump($totalStock);

                        foreach($totalStock as $stock)
                        {
                            $specificMonthTotalStock = $stock['totalsold'];
                            if($specificMonthTotalStock > 0 )
                            {
                                $totalMonthlySummary = $totalMonthlySummary + $specificMonthTotalStock;
                                $validMonthCount++;
                            }
                            if($specificMonthTotalStock == null)
                            {
                                $specificMonthTotalStock = 0;
                            }
                            if(  $dt >  $todaysDate && $dateMonth > $todaysMonth)
                            {
                                $specificMonthTotalStock = " ";
                                //echo "greater";
                            }
                            echo  $specificMonthTotalStock;
                        }
                        // echo  date('Y-m-01', strtotime($dt)) ;
                        echo "</td>";
                    }

                    if($validMonthCount != 0 || $validMonthCount != null)
                    {
                        $monthlyAverage = $totalMonthlySummary/$validMonthCount ;
                    }
                    else
                    {
                        $monthlyAverage =0;
                    }
                ?>
                <td>
                    <?php echo round($monthlyAverage, 0) ?>
                </td>
                <td>
                    <?php
                        $totalProductStock = $prod['store1'] + $prod['store2'] + $prod['store3'];
                        echo $totalProductStock
                    ?>
                </td>
                <td>
                    <?php
                        if($totalProductStock != 0 && $monthlyAverage != 0)
                        {
                            $rotationMonth = $totalProductStock/round($monthlyAverage, 0);
                            //var_dump($monthlyAverage);
                            echo round($rotationMonth, 0);
                        }
                        elseif ($totalProductStock == 0 && $monthlyAverage > 0)
                        {
                            $rotationMonth = "Out of stock";
                            echo $rotationMonth;
                        }
                        elseif ($totalProductStock > 0 && $monthlyAverage == 0)
                        {
                            $rotationMonth = "In stock";
                            echo $totalProductStock;
                        }
                        elseif ($totalProductStock == 0 && $monthlyAverage == 0)
                        {
                            $rotationMonth = "Out of stock";
                            $totalProductStock = 0;
                            echo $rotationMonth;
                        }
                    ?>
                </td>
                    <?php
                        }
                    ?>
                    </tr>
                    </tbody>
                </table>
            </div>
            <?php
                    }
                }
            ?>
                     </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
<?php include '../includes/footer.php';