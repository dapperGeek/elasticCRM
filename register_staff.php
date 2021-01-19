<?php


 include("data/MySQLDatabase.php");
    include("data/DBConfig.php");

    include_once("data/sessioncheck.php");

if($myData['changePass'] == 0){

    //  $database->redirect_to($host."change-password");
}
?>
    <script src="<?php echo $host;?>amcharts/amcharts.js" type="text/javascript"></script>
        <script src="<?php echo $host;?>amcharts/serial.js" type="text/javascript"></script>
<script>
            var chart;
            var chartData = [];
            var chartCursor;



            AmCharts.ready(function () {
                // generate some data first
                var chartData= [
                <?php
                    $yr = date('Y');

                    for($i = 1; $i < 13; $i++){
                        $j = cal_days_in_month(CAL_GREGORIAN, $i, $yr);
                        $j = $j + 1;
                            for($k = 1; $k < $j; $k++){
                               $r = $database->getDailySales($k,$i,$yr);
                        ?>
                        {
                            <?php $myDate =  $myDate = $yr."-".$i."-".$k;  ?>
                            "date": "<?php echo $myDate; ?>",
                            "value": <?php if($r['Amount'] ==''){echo 0;}else{echo $r['Amount'];}?>
                        },

                    <?php }
                    }

                ?>
                ];

               /* var chartData= [
                {
                    "date": "2009-10-02",
                    "value": 5
                },
                {
                    "date": "2009-10-03",
                    "value": 15
                },
                {
                    "date": "2009-10-05",
                    "value": 17
                },
                {
                    "date": "2009-10-06",
                    "value": 15
                },
                {
                    "date": "2009-10-09",
                    "value": 19
                },

            ]; */



                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();

                chart.dataProvider = chartData;
                chart.categoryField = "date";
                chart.balloon.bulletSize = 5;

                // listen for "dataUpdated" event (fired when chart is rendered) and call zoomChart method when it happens
                chart.addListener("dataUpdated", zoomChart);

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
                categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
                categoryAxis.dashLength = 1;
                categoryAxis.minorGridEnabled = true;
                categoryAxis.twoLineMode = true;
                categoryAxis.dateFormats = [{
                    period: 'fff',
                    format: 'JJ:NN:SS'
                }, {
                    period: 'ss',
                    format: 'JJ:NN:SS'
                }, {
                    period: 'mm',
                    format: 'JJ:NN'
                }, {
                    period: 'hh',
                    format: 'JJ:NN'
                }, {
                    period: 'DD',
                    format: 'DD'
                }, {
                    period: 'WW',
                    format: 'DD'
                }, {
                    period: 'MM',
                    format: 'MMM'
                }, {
                    period: 'YYYY',
                    format: 'YYYY'
                }];

                categoryAxis.axisColor = "#DADADA";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.dashLength = 1;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.title = "red line";
                graph.valueField = "value";
                graph.bullet = "round";
                graph.bulletBorderColor = "#FFFFFF";
                graph.bulletBorderThickness = 2;
                graph.bulletBorderAlpha = 1;
                graph.lineThickness = 2;
                graph.lineColor = "#5fb503";
                graph.negativeLineColor = "#ff0000";
                graph.hideBulletsCount = 50; // this makes the chart to hide bullets when there are more than 50 series in selection
                chart.addGraph(graph);

                // CURSOR
                chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorPosition = "mouse";
                chartCursor.pan = true; // set it to fals if you want the cursor to work in "select" mode
                chart.addChartCursor(chartCursor);

                // SCROLLBAR
                var chartScrollbar = new AmCharts.ChartScrollbar();
                chart.addChartScrollbar(chartScrollbar);

                chart.creditsPosition = "bottom-right";

                // WRITE
                chart.write("chartdiv");
            });

            // this method is called when chart is first inited as we listen for "dataUpdated" event
            function zoomChart() {
                // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
                chart.zoomToIndexes(chartData.length - 40, chartData.length - 1);
            }

            // changes cursor mode from pan to select
            function setPanSelect() {
                if (document.getElementById("rb1").checked) {
                    chartCursor.pan = false;
                    chartCursor.zoomable = true;
                } else {
                    chartCursor.pan = true;
                }
                chart.validateNow();
            }

        </script>
<html lang="en">
<!-- fullcalendar -->
<link href='<?php echo $host;?>assets/css/fullcalendar.css' rel='stylesheet' />
<link href='<?php echo $host;?>assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<link href="<?php echo $host;?>assets/css/morris.css" rel="stylesheet">
	<!-- Bootstrap -->
	<link href="<?php echo $host;?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $host;?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" type="text/css" href="<?php echo $host;?>assets/css/daterangepicker.css" />
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


    <!-- morris -->
    <link href="assets/css/morris.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-select.min.css" />
    <!-- slimscroll -->
    <link href="assets/css/jquery.slimscroll.css" rel="stylesheet">
    <!-- Fontes -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/simple-line-icons.css" rel="stylesheet">
    <!-- all buttons css -->
    <link href="assets/css/buttons.css" rel="stylesheet">
    <!-- animate css -->
<link href="assets/css/animate.css" rel="stylesheet">
<!-- top nev css -->
<link href="assets/css/page-header.css" rel="stylesheet">
<!-- adminui main css -->
    <link href="assets/css/main.css" rel="stylesheet">
    <!-- aqua black theme css -->
    <link href="assets/css/aqua-black.css" rel="stylesheet">
    <!-- media css for responsive  -->
    <link href="assets/css/main.media.css" rel="stylesheet">

    <link href="assets/css/morris.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/jasny-bootstrap.min.css">
    <!-- slimscroll -->
    <link href="assets/css/jquery.slimscroll.css" rel="stylesheet">
    <!-- Fontes -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/simple-line-icons.css" rel="stylesheet">
    <!-- all buttons css -->
    <link href="assets/css/buttons.css" rel="stylesheet">
    <!-- animate css -->
<link href="assets/css/animate.css" rel="stylesheet">
<!-- top nev css -->
<link href="assets/css/page-header.css" rel="stylesheet">
<!-- adminui main css -->
    <link href="assets/css/main.css" rel="stylesheet">
    <!-- aqua black theme css -->
    <link href="assets/css/aqua-black.css" rel="stylesheet">
    <!-- media css for responsive  -->
    <link href="assets/css/main.media.css" rel="stylesheet">

<?php include("includes/header_.php");?>
        <div class="page-content-wrapper">
              <?php include("includes/make-purchase.php");?>
            <div class="page-content">
       

















  <div id="main" role="main">
          <div class="block">
   		  <div class="clearfix"></div>

             <!--page title-->
<div class="wrapper-content ">
                   <div class="row">
        <!-- Basic Form start -->
        
        <div class="col-lg-12">
                 <div class="col-lg-6">
          <div class="ibox float-e-margins">
            <div class="widgets-container">
              <h2>Register Members of Staff</h2>


              <hr>

              <?php


                  
                  if (isset($_POST['registerButton'])) {
                    
                                $fullname = $database->test_input($_POST['fullname']);
                                $number = $database->test_input($_POST['number']);
                                $email = $database->test_input($_POST['email']);
                                $department = $database->test_input($_POST['department']);

                                $designation = $database->test_input($_POST['designation']);
                                $username = $database->test_input($_POST['username']);
                                $password = $_POST['password'];

                                $imageUploadUser = $_FILES['file']['name'];

                                $imageUploadUser_tmp = $_FILES['file']['tmp_name'];
                               

                               if (empty($fullname) || empty($number) OR empty($email) || empty($department) || empty($designation) || empty($username) || empty($password)) {
                                     
                                     $database->showMsg('', 'All fields are required to register staff', 1);


                   }else{


               move_uploaded_file($imageUploadUser_tmp, "userprofile/$imageUploadUser");


 $select = $con->query("INSERT INTO staff (fullname,phoneNo,email,DepartmentID,AccessLevel,designationID,warehouse,storeID,serviceCall,Administrative,purchases,Billing,DashBoards,superAdmin,engineer,username,password,avartar,service,crm,login,active,changePass,ipAddress,LastLoginTime,Token,dob,resumeDate) VALUES('$fullname','$number','$email','$department','1','$designation','0','0','0','0','0','0','0','0','0','$username','$password','$imageUploadUser','0','0','1','1','1','','','','','')");

 if ($select) {
    $database->showMsg('', "REGISTRATION HAS BEEN MADE SUCCESSFULLY", 2);
 }

                   }





                  }



              ?>
              <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="exampleInputEmail1">FULLNAME</label>
                  <input class="form-control m-t-xxs" si id="exampleInputEmail1" name="fullname" placeholder="Enter Fullname" type="text">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">PHONE NO</label>
                  <input  class="password form-control m-t-xxs" id="exampleInputPassword1" name="number" placeholder="Phone Number" type="number">
                </div>
                 <div class="form-group">
                  <label for="exampleInputEmail1">EMAIL</label>
                  <input class="form-control m-t-xxs" id="exampleInputEmail1" name="email" placeholder="Enter Fullname" type="email">
                </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">DEPARTMENT</label>
                 <select class=" _select js-states form-control" name="department" required="">


                    <option value="">Select Department</option>
                          <?php 

 // includes('data/MySQLDatabase.php');

     // $post = new MySQLDatabase($con);
      $stateArray = $database->getStaffDepartment();

      echo '<optgroup label="Department">';

      foreach ($stateArray as $states) {?>
         <option value="<?php echo $states['id'];?>" ><?php echo $states['Department'];?></option>

        </optgroup>

     <?php }




?>

                        </optgroup>
                      
                        
                      </select>
                                
                </div>


              <div class="form-group">
                  <label for="exampleInputEmail1">DESIGNATION 

 


                  </label>

                 <select class=" _select js-states form-control" name="designation" required="">
  <option value="">Select Designation</option>
 
                        <?php 

 // includes('data/MySQLDatabase.php');

     // $post = new MySQLDatabase($con);
      $designationArray = $database->getStaffDesignation();

      echo '<optgroup label="Designation">';

      foreach ($designationArray as $designation) {?>
         <option value="<?php echo $designation['id'];?>" ><?php echo $designation['designation'];?></option>


        </optgroup>

     <?php }




?>

                       
                       
                    
                        
                      
                        
                      </select>
                                
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">USERNAME</label>
                  <input class="form-control m-t-xxs" id="exampleInputEmail1" name="username" placeholder="Enter Username" type="text">
                </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">PASSWORD</label>
                  <input class="form-control m-t-xxs" id="exampleInputEmail1" name="password" placeholder="Enter Password" type="password">
                </div>
 <div class="form-group">

                                            <label class="col-md-2 control-label">Image upload</label>
                                          
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                                                    <div> <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                        <input type="file" name="file">
                                                        </span> <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> </div>
                                                </div>
                                            </div>
                                    

            
                <button style="" type="submit" name="registerButton" class="btn aqua m-t-xs bottom15-xs btn-block">Submit</button>
              </form>
            </div>
          </div>
        </div>
        </div>


				<hr>




             </div>


             <!--page title end-->
                          </div>


                 </div>





         












            </div>
        </div>
    </div>
    </div>
    <!-- Go top -->
    <a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>

    <script src="assets/js/vendor/jquery.min.js"></script>
    <!-- bootstrap js -->
    <script src="assets/js/vendor/bootstrap.min.js"></script>
    <!-- slimscroll js -->
    <script type="text/javascript" src="assets/js/vendor/jquery.slimscroll.js"></script>
    <script src="assets/js/vendor/select2.min.js"></script>
    <script src="assets/js/vendor/bootstrap-select.min.js"></script>
    <!-- pace js -->
<script src="assets/js/vendor/pace/pace.min.js"></script>
<!-- Sparkline -->
<script src="assets/js/vendor/jquery.sparkline.min.js"></script>
<!-- main js -->
    <script src="assets/js/main.js"></script>
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


    <script src="assets/js/vendor/jquery.min.js"></script>
    <!-- bootstrap js -->
    <script src="assets/js/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/vendor/jasny-bootstrap.min.js" charset="UTF-8"></script>
    <!-- slimscroll js -->
    <script type="text/javascript" src="assets/js/vendor/jquery.slimscroll.js"></script>
    <!-- pace js -->
<script src="assets/js/vendor/pace/pace.min.js"></script>
<!-- Sparkline -->
<script src="assets/js/vendor/jquery.sparkline.min.js"></script>
<!-- main js -->
    <script src="assets/js/main.js"></script>





