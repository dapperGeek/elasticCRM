<?php
    include 'headerJS.php';
    
    $getPmsSchedules = $database->pmsSchedules();
    $upcomingSchedules = isset($getPmsSchedules[UtilFunctions::$newSchedule])
        ? sizeof($getPmsSchedules[UtilFunctions::$newSchedule])
        : 0;
    $pendingSchedules =  isset($getPmsSchedules[UtilFunctions::$oldSchedule])
        ? sizeof($getPmsSchedules[UtilFunctions::$oldSchedule])
        : 0;
?>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elastic-25</title>
    <!-- Bootstrap -->


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
            <!--  TOP NAVIGATION MENU -->

            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-user">
                    <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="javascript:;"> <!-- <img src="assets/images/teem/a10.jpg" class="img-circle" alt=""> --> <span class="username username-hide-on-mobile"> <?php echo $myData['fullname'];?></span> <i class="fa fa-angle-down"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="#"> <i class="icon-lock"></i> Lock Screen </a>
                        </li>

                        <li>
                            <a href="<?php echo $host . 'change-password' ; ?>"> <i class="icon-lock"></i>Change Password</a>
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