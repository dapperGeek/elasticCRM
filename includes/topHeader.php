<?php
    if (file_exists("data/DBConfig.php"))
    {
        include("data/DBConfig.php");
        include_once("data/sessioncheck.php");
        require_once ("Utils/UtilFunctions.php");
        include_once('includes/forms.php');
        include_once ('Utils/PageHeaders.php');
        include_once ('Utils/ViewLoader.php');
        include_once ('Utils/Constants.php');
    }
    else
    {
        include("../data/DBConfig.php");
        include_once("../data/sessioncheck.php");
        require_once ("../Utils/UtilFunctions.php");
        include_once('../includes/forms.php');
        include_once ('../Utils/PageHeaders.php');
        include_once ('../Utils/ViewLoader.php');
        include_once ('../Utils/Constants.php');
    }

    if($myData['changePass'] == 0){
    //      $database->redirect_to($host."change-password");
    }

//        Get MPS Accounts details
    $analytic = $database->mpsAnalytics();
    $data = json_encode($analytic);

    $getPmsSchedules = $database->pmsSchedules();
    $upcomingSchedules = isset($getPmsSchedules[UtilFunctions::$newSchedule])
                        ? sizeof($getPmsSchedules[UtilFunctions::$newSchedule])
                        : 0;
    $pendingSchedules =  isset($getPmsSchedules[UtilFunctions::$oldSchedule])
                        ? sizeof($getPmsSchedules[UtilFunctions::$oldSchedule])
                        : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1">-->
    <title><?php echo isset($title) ? $title : 'Elastic-25' ?></title>
    <!-- morris -->
    <link href="<?php echo $host;?>assets/css/morris.css" rel="stylesheet">
    <!-- Bootstrap -->
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
    <link href="<?php echo $host;?>assets/css/tables.css" rel="stylesheet">

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
    <!-- Range selectors -->
    <link rel="stylesheet" type="text/css" href="<?php echo $host;?>assets/css/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $host;?>assets/css/bootstrap-select.min.css" />
    <!-- icheck -->
    <link href="<?php echo $host;?>assets/css/skins/all.css" rel="stylesheet">
    <link href="<?php echo $host;?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <!-- aqua black theme css -->
    <link href="<?php echo $host;?>assets/css/aqua-black.css" rel="stylesheet">
    <!-- media css for responsive  -->
    <link href="<?php echo $host;?>assets/css/main.media.css" rel="stylesheet">

    <!-- AdminUI demo css-->
    <link href="<?php echo $host;?>assets/css/adminUIdemo.css" rel="stylesheet">
    <!-- Ion Range Slider -->
    <link rel="stylesheet" href="<?php echo $host;?>assets/css/normalize.css" />
    <link rel="stylesheet" href="<?php echo $host;?>assets/css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="<?php echo $host;?>assets/css/ion.rangeSlider.skinFlat.css" />

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <!-- Header JavaScripts -->
    <?php include('headerJS.php') ?>
    <style>
        #chartdiv {
            width: 100%;
            height: 500px;
        }

    </style>
    <script src="<?php echo $host . 'assets/js/tables.js' ?>"></script>
    <script src="<?php echo $host . 'assets/js/ajax.js' ?>"></script>


<!--    <script src="jquery-1.12.4.min.js"></script>-->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!--start acCharts JS-->
    <script src="https://amcharts.com/lib/4/core.js"></script>
    <script src="https://amcharts.com/lib/4/charts.js"></script>
    <script src="https://amcharts.com/lib/4/themes/animated.js"></script>
    <script src="https://amcharts.com/lib/4/themes/kelly.js"></script>
    <!--end amCharts JS-->

<!--    JQuery JS-->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>

<body class="page-header-fixed ">
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="<?php echo $host;?>"> <img class="logo-default" alt="logo" src="<?php echo $host;?>assets/images/logo.png"> </a>
        </div>
        <div class="library-menu"> <span class="one">-</span> <span class="two">-</span> <span class="three">-</span> </div><div class="top-nev-mobile-togal"><i class="glyphicon glyphicon-cog"></i></div>
        <!-- END LOGO -->
        <div class="top-menu">
            <!--  TOP NAVIGATION MENU -->

            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-user">
                    <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="javascript:;"> <!-- <img src="assets/images/teem/a10.jpg" class="img-circle" alt=""> --> <span class="username username-hide-on-mobile"> <?php echo $myData['fullname'];?></span> <i class="fa fa-angle-down"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="#"> <i class="icon-lock"></i> Lock Screen </a>
                        </li>

                        <li>
                            <a href="<?php echo $host . 'change-password' ; ?>">
                                <i class="icon-lock"></i>Change Password</a>
                        </li>
                        <li>
                            <a href="<?php echo $host;?>Logout"> <i class="icon-key"></i> Log Out </a>
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<div class="clearfix"> </div>
<div class="page-container">
    <!-- Start page sidebar wrapper -->
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar">
            <?php include 'sidebar-menu.php' ?>
        </div>
    </div>
    <!-- End page sidebar wrapper -->

    <!-- Start page content wrapper -->
    <div class="page-content-wrapper">

        <!-- start page content -->
        <div class="page-content">