<?php
    include("data/DBConfig.php");
    include_once("data/sessioncheck.php");

if($myData['changePass'] == 0){

    //  $database->redirect_to($host."change-password");
}
?>
<html lang="en">
        <link href="<?php echo $host;?>assets/css/bootstrap.min.css" rel="stylesheet">
        <!-- slimscroll -->
        <link href="<?php echo $host;?>assets/css/jquery.slimscroll.css" rel="stylesheet">
        <!-- project -->
        <link href="<?php echo $host;?>assets/css/project.css" rel="stylesheet">

        <!-- flotCart css -->
        <link href="<?php echo $host;?>assets/css/flotCart.css" rel="stylesheet">

 <!-- jvectormap -->
        <link href="<?php echo $host;?>assets/css/jqvmap.css" rel="stylesheet">

        <!-- dataTables -->
        <link href="<?php echo $host;?>assets/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="<?php echo $host;?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $host;?>assets/css/responsive.dataTables.min.css" rel="stylesheet">
        <link href="<?php echo $host;?>assets/css/fixedHeader.dataTables.min.css" rel="stylesheet">

        <!-- Fontes -->
        <link href="<?php echo $host;?>assets/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo $host;?>assets/css/simple-line-icons.css" rel="stylesheet">
        <link href="<?php echo $host;?>assets/css/ameffectsanimation.css" rel="stylesheet">
        <link href="<?php echo $host;?>assets/css/buttons.css" rel="stylesheet">
        <!-- animate css -->
        <link href="<?php echo $host;?>assets/css/animate.css" rel="stylesheet">
        <!-- top nev css -->
        <link href="<?php echo $host;?>assets/css/page-header.css" rel="stylesheet">
        <!-- adminui main css -->
        <link href="<?php echo $host;?>assets/css/main.css" rel="stylesheet">

        <!-- morris -->
        <link href="<?php echo $host;?>assets/css/morris.css" rel="stylesheet">

        <!-- aqua black theme css -->
        <link href="<?php echo $host;?>assets/css/aqua-black.css" rel="stylesheet">
        <!-- media css for responsive  -->
        <link href="<?php echo $host;?>assets/css/main.media.css" rel="stylesheet">

                <!-- AdminUI demo css-->
        <link href="<?php echo $host;?>assets/css/adminUIdemo.css" rel="stylesheet">
<?php include("includes/header_.php");?>
        <div class="page-content-wrapper">
              <?php include("includes/make-purchase.php");?>
            <div class="page-content">
                   <div class="row">
     
      <div  class="col-lg-12">
        <h2> Change Password </h2>
        <ol class="breadcrumb">
          <li> <a href="index.php">Home</a> </li>
          <li> <a>Profile</a> </li>
          <li class="active"> <strong> Change Password  </strong> </li>
        </ol>
      </div>


                   




          <div style="height: 1000px; background-color: white" class="col-lg-12">

  

          <!-- Basic Form start -->
        <div style="margin-left: 300px;margin-right: 300px;" class="col-lg-6">
          <div class="ibox float-e-margins">
            <div class="widgets-container">
              <h5>Change Password </h5>
              <hr>
              <?php  

               $user_currentPass = $myData['password'];

              $username = $myData['username'];

              if (isset($_POST['change_password_button'])) {
                 
                    
                     $old_pass =  $_POST['old_pass'];
                       $new_pass = $_POST['new_pass'];
                      $confirm_pass = $_POST['confirm_pass'];


                      $database->changeUserPass($user_currentPass,$old_pass,$new_pass,$confirm_pass,$username);







              }

                    

               ?>
              <form action="" method="POST">
                <div class="form-group">
                  <label for="exampleInputEmail1">Current Password</label>
                  <input class="form-control m-t-xxs" id="exampleInputEmail1" name="old_pass" placeholder="Enter Current Password" type="password" required="">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">New Password</label>
                  <input  class="password form-control m-t-xxs" name="new_pass" id="exampleInputPassword1" placeholder=" Enter New Password" type="password" required="">
                </div>

                  <div class="form-group">
                  <label for="exampleInputPassword1">Confirm Password</label>
                  <input  class="password form-control m-t-xxs" name="confirm_pass" id="exampleInputPassword1" placeholder=" Enter Confirm Password" type="password" required="">
                </div>

               
                <button type="submit" name="change_password_button" class="btn aqua m-t-xs bottom15-xs">Submit</button>
              </form>
            </div>
          </div>
        </div>
        <!-- Basic Form End -->
         
<!-- <center><h1>WELCOME TO </h1></center> -->
                    




</div>


                    

       




<!-- Column Chart
                        <div class="col-lg-6 top15">
                            <div class="ibox float-e-margins ">

                                <div class="ibox-content top10" id="demo2">
                                    <div class="demo-container">
                                        <div>
                                            <canvas id="barChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  -->

</div>


<br><br> <br><br>




        









                <!-- start footer -->
                <div class="footer">
                    <div class="pull-right">
                        <ul class="list-inline">
                            <li><a title="" href="index-2.html">Dashboard</a></li>
                            <li><a title="" href="mailbox.html"> Inbox </a></li>
                            <li><a title="" href="blog.html">Blog</a></li>
                            <li><a title="" href="contacts.html">Contacts</a></li>
                        </ul>
                    </div>
                    <div> <strong>Copyright</strong> Elastic 25  &copy; <?php echo ("Y");?> </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Go top -->
    <a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>
    <!-- Flot -->
    <script src="<?php echo $host;?>assets/js/vendor/flotCart/jquery.flot.js"></script>
    <script src="<?php echo $host;?>assets/js/vendor/flotCart/jquery.flot.tooltip.min.js"></script>
    <script src="<?php echo $host;?>assets/js/vendor/flotCart/jquery.flot.resize.js"></script>

    <!-- Go top -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo $host;?>assets/js/vendor/jquery.min.js"></script>
    <!-- bootstrap js -->
    <script src="<?php echo $host;?>assets/js/vendor/bootstrap.min.js"></script>
    <!--  morris Charts  -->




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
    <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/dataTables.fixedHeader.min.js"></script>

    <script src="<?php echo $host;?>assets/js/vendor/chartJs/Chart.bundle.js"></script>
    <script src="<?php echo $host;?>assets/js/dashboard1.js"></script>
    <!-- slimscroll js -->
    <script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jquery.slimscroll.js"></script>
    <!-- pace js -->
    <script src="<?php echo $host;?>assets/js/vendor/pace/pace.min.js"></script>
    <!-- Sparkline -->
<script src="<?php echo $host;?>assets/js/vendor/jquery.sparkline.min.js"></script>
<!-- main js -->
<script src="<?php echo $host;?>assets/js/main.js"></script>
<!-- AdminUI demo js-->
<script src="<?php echo $host;?>assets/js/adminUIdemo.js"></script>
<script>
$(document).ready(function(){
 var data2 = [
                { label: "Data 1", data: d1, color: '#19a0a1'}
            ];
            $.plot($("#flot-chart2"), data2, {
                xaxis: {
                    tickDecimals: 0
                },
                series: {
                    lines: {
                        show: true,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 1
                            }, {
                                opacity: 1
                            }]
                        }
                    },
                    points: {
                        width: 0.1,
                        show: false
                    }
                },
                grid: {
                    show: false,
                    borderWidth: 0
                },
                legend: {
                    show: false
                }
            });

            var data3 = [
                { label: "Data 1", data: d1, color: '#fbbe7b'},
                { label: "Data 2", data: d2, color: '#f8ac59' }
            ];
            $.plot($("#flot-chart3"), data3, {
                xaxis: {
                    tickDecimals: 0
                },
                series: {
                    lines: {
                        show: true,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 1
                            }, {
                                opacity: 1
                            }]
                        }
                    },
                    points: {
                        width: 0.1,
                        show: false
                    }
                },
                grid: {
                    show: false,
                    borderWidth: 0
                },
                legend: {
                    show: false
                }
            });


        });

</script>
<!-- start theme config -->
<div class="theme-config">
    <div class="theme-config-box">
        <div class="spin-icon"> <i class="fa fa-cogs fa-spin"></i> </div>
        <div class="skin-setttings">
            <div class="title">Configuration</div>
            <div class="setings-item"> <span> Collapse menu </span>
                <div class="switch">
                    <div class="onoffswitch">
                        <input name="collapsemenu" class="onoffswitch-checkbox" id="collapsemenu" type="checkbox">
                        <label class="onoffswitch-label" for="collapsemenu">
            <span class="onoffswitch-inner"></span>
            <span class="onoffswitch-switch"></span>
            </label>
                    </div>
                </div>
            </div>
            <div class="setings-item"> <span> Fixed sidebar </span>
                <div class="switch">
                    <div class="onoffswitch">
                        <input name="fixedsidebar" class="onoffswitch-checkbox" id="fixedsidebar" type="checkbox">
                        <label class="onoffswitch-label" for="fixedsidebar">
            <span class="onoffswitch-inner"></span>
            <span class="onoffswitch-switch"></span>
            </label>
                    </div>
                </div>
            </div>
            <div class="setings-item"> <span> Header Fixed </span>
                <div class="switch">
                    <div class="onoffswitch">
                        <input name="headerfixed" class="onoffswitch-checkbox" id="headerfixed" type="checkbox" checked>
                        <label class="onoffswitch-label" for="headerfixed">
            <span class="onoffswitch-inner"></span>
            <span class="onoffswitch-switch"></span>
            </label>
                    </div>
                </div>
            </div>
            <div class="setings-item"> <span> Boxed layout </span>
                <div class="switch">
                    <div class="onoffswitch">
                        <input name="boxedlayout" class="onoffswitch-checkbox" id="boxedlayout" type="checkbox">
                        <label class="onoffswitch-label" for="boxedlayout">
            <span class="onoffswitch-inner"></span>
            <span class="onoffswitch-switch"></span>
            </label>
                    </div>
                </div>
            </div>
            <div class="setings-item"> <span> Fixed footer </span>
                <div class="switch">
                    <div class="onoffswitch">
                        <input name="fixedfooter" class="onoffswitch-checkbox" id="fixedfooter" type="checkbox">
                        <label class="onoffswitch-label" for="fixedfooter">
            <span class="onoffswitch-inner"></span>
            <span class="onoffswitch-switch"></span>
            </label>
                    </div>
                </div>
            </div>
            <!--<div class="setings-item viewAllThemes"> <span class="skin-name"> <a href="#"> View All Themes </a> </span> </div>
            <div class="setings-item gohome "> <span class="skin-name"> <a href="http://adminui-v1.3.bittyfox.com/"> Go to Lending Page </a> </span> </div>-->
        </div>
    </div>
</div>
<!-- end theme config -->


</body>

</html>