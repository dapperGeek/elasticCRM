
<script>
            function isNumberKey(evt) {
                var charCode = (evt.which) ? evt.which : event.keyCode
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }
</script>
<script type="text/javascript">

function Comma(Num) { //function to add commas to textboxes
        Num += '';
        Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
        Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
        x = Num.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        return x1 + x2;
    }

</script>


<script>
function validateNumber_Dot(s) {
    var rgx = /^[0-9]*\.?[0-9]*$/;
    return s.match(rgx);
}

function fun_AllowOnlyAmountAndDot(txt)
        {
            if(event.keyCode > 47 && event.keyCode < 58 || event.keyCode == 46)
            {
               var txtbx=document.getElementById(txt);
               var amount = document.getElementById(txt).value;
               var present=0;
               var count=0;

               if(amount.indexOf(".",present)||amount.indexOf(".",present+1));
               {
              // alert('0');
               }

              /*if(amount.length==2)
              {
                if(event.keyCode != 46)
                return false;
              }*/
               do
               {
               present=amount.indexOf(".",present);
               if(present!=-1)
                {
                 count++;
                 present++;
                 }
               }
               while(present!=-1);
               if(present==-1 && amount.length==0 && event.keyCode == 46)
               {
                    event.keyCode=0;
                    //alert("Wrong position of decimal point not  allowed !!");
                    return false;
               }

               if(count>=1 && event.keyCode == 46)
               {

                    event.keyCode=0;
                    //alert("Only one decimal point is allowed !!");
                    return false;
               }
               if(count==1)
               {
                var lastdigits=amount.substring(amount.indexOf(".")+1,amount.length);
                if(lastdigits.length>=2)
                            {
                              //alert("Two decimal places only allowed");
                              event.keyCode=0;
                              return false;
                              }
               }
                    return true;
            }
            else
            {
                    event.keyCode=0;
                    //alert("Only Numbers with dot allowed !!");
                    return false;
            }

        }

    </script>


<head>
        <meta charset="utf-8">
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
        
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-1470918389379477",
    enable_page_level_ads: true
  });
</script>

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
                              <!--  <div class="hor-menu  hor-menu-light hidden-sm hidden-xs">
                                        <ul class="nav navbar-nav">
                                                DOC: Remove data-hover="megamenu-dropdown" and data-close-others="true" attributes below to disable the horizontal opening on mouse hover --
                                                <li class="classic-menu-dropdown active"> <a href="index-2.html"><i class="icon-user fa-fw"></i></a> </li>


                                                <li class="mega-menu-dropdown mega-menu-full hover-initialized"> <a class="dropdown-toggle hover-initialized" href="javascript:;">Mega <i class="fa fa-angle-down"></i> </a>
                                                        <ul class="dropdown-menu">
                                                                <li>
                                                                        <!-- Content container to add padding --
                                                                        <div class="mega-menu-content ">
                                                                                <div class="row">
                                                                                        <div class="col-md-3">
                                                                                                <h4>Pages <span class="label label-warning">14</span></h4>
                                                                                                <div class="row">
                                                                                                        <div class="col-md-6">
                                                                                                                <ul class="mega-menu-submenu">
                                                                                                                        <li><a href="profile.html">Profile</a></li>
                                                                                                                        <li><a href="profile_2.html">Profile-2</a></li>
                                                                                                                        <li><a href="contacts.html">Contacts</a></li>
                                                                                                                        <li><a href="contacts_2.html">Contacts-2</a></li>
                                                                                                                        <li><a href="search_results.html">Search results</a></li>
                                                                                                                        <li></li>
                                                                                                                        <li></li>
                                                                                                                </ul>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                                <ul class="mega-menu-submenu">

                                                                                                                        <li><a href="login.html">Login</a></li>
                                                                                                                        <li><a href="login_v2.html">Login 2</a></li>
                                                                                                                        <li><a href="forgot_password.html">Forget password</a></li>
                                                                                                                        <li><a href="register.html">Register</a></li>
                                                                                                                        <li><a href="register_v2.html">Register 2</a></li>
                                                                                                                        <li></li>
                                                                                                                        <li></li>
                                                                                                                </ul>
                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>

                                                                                        <div class="col-md-2 b-l b-r b-light">
                                                                                                <h4>Apps <span class="label label-info">08</span></h4>
                                                                                                <div class="row">
                                                                                                        <div class="col-md-12">
                                                                                                                <ul class="mega-menu-submenu">
                                                                                                                        <li><a href="projects.html">Projects</a></li>
                                                                                                                        <li></li>
                                                                                                                        <li><a href="issue_tracker.html">Issue tracker</a></li>
                                                                                                                        <li><a href="blog.html">Blog</a></li>
                                                                                                                        <li><a href="article.html">Article</a></li>
                                                                                                                        <li><a href="timeline.html">Timeline</a></li>
                                                                                                                        <li></li>
                                                                                                                </ul>
                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>

                                                                                        <div class="col-md-3">
                                                                                                <h3>UI Features <span class="label label-primary">13</span></h3>
                                                                                                <div class="row">
                                                                                                        <div class="col-md-6">
                                                                                                                <ul class="mega-menu-submenu">
                                                                                                                        <li><a href="ui_colors.html"> Color Library </a></li>
                                                                                                                        <li><a href="ui_buttons.html"> Buttons </a></li>
                                                                                                                        <li><a href="ui_icons.html"> Font Icons </a></li>
                                                                                                                        <li><a href="ui_tabs.html"> Tabs </a></li>
                                                                                                                        <li></li>
                                                                                                                        <li><a href="timeline_horizontal.html"> Timeline Horizontal </a></li>
                                                                                                                        <li></li>
                                                                                                                </ul>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                                <ul class="mega-menu-submenu">
                                                                                                                        <li><a href="ui_grids.html"> Grids </a></li>
                                                                                                                        <li><a href="ui_panels.html"> Panels UI </a></li>
                                                                                                                        <li><a href="ui_typography.html"> Typography </a></li>
                                                                                                                        <li><a href="alerts_Modal_Tooltip.html"> Alerts &amp; Modal </a></li>

                                                                                                                        <li><a href="MediaObjects_Thumbnails.html"> Media Objects </a></li>
                                                                                                                </ul>
                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>


                                                                                        <div class="col-md-4">
                                                                                                <h4>Analysis</h4>
                                                                                                <span id="sparkNev"></span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                </li>
                                                        </ul>
                                                </li>
                                                <li class="classic-menu-dropdown"> <a data-close-others="true" data-hover="megamenu-dropdown" href="javascript:;" class="hover-initialized"> Classic <i class="fa fa-angle-down"></i> </a>
                                                        <ul class="dropdown-menu pull-left">
                                                                <li>
                                                                        <a href="javascript:;"> <i class="fa fa-bookmark-o"></i> Section 1 </a>
                                                                </li>
                                                                <li>
                                                                        <a href="javascript:;"> <i class="fa fa-user"></i> Section 2 </a>
                                                                </li>
                                                                <li>
                                                                        <a href="javascript:;"> <i class="fa fa-puzzle-piece"></i> Section 3 </a>
                                                                </li>
                                                                <li>
                                                                        <a href="javascript:;"> <i class="fa fa-gift"></i> Section 4 </a>
                                                                </li>
                                                                <li>
                                                                        <a href="javascript:;"> <i class="fa fa-table"></i> Section 5 </a>
                                                                </li>
                                                                <li class="dropdown-submenu">
                                                                        <a href="javascript:;"> <i class="fa fa-envelope-o"></i> More options </a>
                                                                        <ul class="dropdown-menu">
                                                                                <li> <a href="javascript:;"> Second level link </a> </li>

                                                                                <li> <a href="index-2.html"> Second level link </a> </li>
                                                                                <li> <a href="index-2.html"> Second level link </a> </li>
                                                                                <li> <a href="index-2.html"> Second level link </a> </li>
                                                                        </ul>
                                                                </li>
                                                        </ul>
                                                </li>
                                        </ul>

                                        <form method="GET" action="http://adminui-v1.0.bittyfox.com/default/aqua-black/search_results.html" class="search-form search-form-expanded">
                                        <div class="input-group">
                                                <input name="query" placeholder="Search..." class="form-control" type="text">
                                                <span class="input-group-btn"> <a class="btn submit" href="javascript:;"> <i class="icon-magnifier"></i> </a> </span>						</div>
                                </form>
                                </div>-->
                                <!--  TOP NAVIGATION MENU -->

                                <ul class="nav navbar-nav pull-right">
                                       <!-- <li class="dropdown">
                                                <a href="#" data-toggle="dropdown" class="dropdown-toggle count-info"> <i class="fa fa-envelope"></i> <span class="badge badge-info">6</span> </a>
                                                <ul class="dropdown-menu dropdown-messages menuBig">
                                                        <li>
                                                                <div class="dropdown-messages-box">
                                                                        <a class="pull-left" href="profile.html"> <img src="assets/images/teem/a7.jpg" class="img-circle" alt="image"> </a>
                                                                        <div class="media-body"> <small class="pull-right">46h ago</small> <strong>Mike Loreipsum</strong> started following <strong>Olivia Wenscombe</strong>. <br>
                                                                                <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small> </div>
                                                                </div>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                                <div class="dropdown-messages-box">
                                                                        <a class="pull-left" href="profile.html"> <img src="assets/images/teem/a4.jpg" class="img-circle" alt="image"> </a>
                                                                        <div class="media-body "> <small class="pull-right text-navy">5h ago</small> <strong> Alex Smith </strong> started following <strong>Olivia Wenscombe</strong>. <br>
                                                                                <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small> </div>
                                                                </div>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                                <div class="dropdown-messages-box">
                                                                        <a class="pull-left" href="profile.html"> <img src="assets/images/teem/a3.jpg" class="img-circle" alt="image"> </a>
                                                                        <div class="media-body "> <small class="pull-right">23h ago</small> <strong>Olivia Wenscombe</strong> love <strong>Sophie </strong>. <br>
                                                                                <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small> </div>
                                                                </div>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                                <div class="text-center link-block">
                                                                        <a href="mailbox.html"> <i class="fa fa-envelope"></i> <strong>Read All Messages</strong> </a>
                                                                </div>
                                                        </li>
                                                </ul>
                                        </li>
                                        <li class="dropdown">
                                                <a href="#" data-toggle="dropdown" class="dropdown-toggle count-info"> <i class="fa fa-bell"></i> <span class="badge badge-primary">8</span> </a>
                                                <ul class="dropdown-menu dropdown-alerts menuBig">
                                                        <li>
                                                                <a href="mailbox.html">
                                                                        <div> <i class="fa fa-envelope fa-fw"></i> You have 16 messages <span class="pull-right text-muted small">4 minutes ago</span> </div>
                                                                </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                                <a href="profile.html">
                                                                        <div> <i class="fa fa-twitter fa-fw"></i> 3 New Followers <span class="pull-right text-muted small">12 minutes ago</span> </div>
                                                                </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                                <a href="grid_options.html">
                                                                        <div> <i class="fa fa-upload fa-fw"></i> Server Rebooted <span class="pull-right text-muted small">4 minutes ago</span> </div>
                                                                </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                                <div class="text-center link-block">
                                                                        <a href="mailbox.html"> <strong>See All Alerts</strong> <i class="fa fa-angle-right"></i> </a>
                                                                </div>
                                                        </li>
                                                </ul>
                                        </li>
                                        <!-- START USER LOGIN DROPDOWN -->
                                        <li class="dropdown dropdown-user">
                                                <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="javascript:;"> <!-- <img src="assets/images/teem/a10.jpg" class="img-circle" alt=""> --> <span class="username username-hide-on-mobile"> <?php echo $myData['fullname'];?></span> <i class="fa fa-angle-down"></i> </a>
                                                <ul class="dropdown-menu dropdown-menu-default">
                                                        <!--<li>
                                                                <a href="profile.html"> <i class="icon-user"></i> My Profile </a>

                                                        </li>
                                                        <li>
                                                                <a href="profile_2.html"> <i class="icon-user"></i> Profile-2 </a>
                                                        </li>
                                                        <li>
                                                                <a href="calendar.html"> <i class="icon-calendar"></i> My Calendar </a>
                                                        </li>
                                                        <li>
                                                                <a href="mailbox.html"> <i class="icon-envelope-open"></i> My Inbox <span class="badge badge-danger"> 3 </span> </a>
                                                        </li>
                                                        <li>
                                                                <a href="dashboard2.html"> <i class="icon-rocket"></i> My Tasks <span class="badge badge-success"> 7 </span> </a>
                                                        </li>
                                                        <li class="divider"> </li> -->
                                                        <li>
                                                                <a href="#"> <i class="icon-lock"></i> Lock Screen </a>
                                                        </li>

                                                         <li>
                                                                <a href="change_password.php"> <i class="icon-lock"></i>Change Password</a>
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
                                <ul class="page-sidebar-menu  page-header-fixed ">
                                        <li class="sidebar-search-wrapper">
                                                <!-- START RESPONSIVE SEARCH FORM
                                                <form class="sidebar-search  " action="http://adminui-v1.0.bittyfox.com/default/aqua-black/search_results.html" method="POST">
                                                        <a href="javascript:;" class="remove"> <i class="icon-close"></i> </a>
                                                        <div class="input-group">
                                                                <input type="text" class="form-control" placeholder="Search...">
                                                                <span class="input-group-btn"> <a href="javascript:;" class="btn submit"> <i class="icon-magnifier"></i> </a> </span> </div>
                                                </form>
                                                <!-- END RESPONSIVE SEARCH FORM -->
                                        </li>
                                        <li class="nav-item ">
                                                <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-th-large"></i><span class="title">Dashboard</span> <span class="arrow"></span> </a>
                                                <ul class="sub-menu">
                                                        <li class="nav-item active">
                                                                <a class="nav-link" href="<?php echo $host;?>"> <span class="title">Dashboard</span> </a>
                                                        </li>
                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>reports"> <span class="title">Reports</span> </a>
                                                        </li>


                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>view-stock-analysis"> <span class="title">Stock Analysis</span> </a>
                                                        </li>
                                                </ul>
                                        </li>
                                        <?php if($myData['superAdmin'] > 0){?>
                                         <li class="nav-item ">

                                                <li class="nav-item"> <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-wrench"></i><span class="title">Settings</span> <span class="arrow"></span> </a>
                                                    <ul class="sub-menu">
                                                        <li class="nav-item"> <a class="nav-link" href="javascript:;"> PRODUCTS <span class="arrow nav-toggle"></span> </a>
                                                            <ul class="sub-menu">
                                                                <?php
                                                                        $cati = (array)$database->getProductsCategory();
                                                                        foreach($cati as $catii){
                                                                ?>
                                                                <li class="nav-item"> <a class="nav-link" href="<?php echo $host;?>view-products/<?php echo $catii['id'];?>"><?php echo ucfirst($catii['type']);?></a> </li>
                                                                 <?php }?>
                                                            </ul>
                                                        </li>

                                                    </ul>
                                                </li>

                                        </li>
                                        <?php }?>

                                        <?php if($myData['engineer'] > 0){?>

                                        <li class="heading">
                                                <h3 class="uppercase">Service Call</h3>
                                        </li>

                                                          <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>engineer-view-service-call"> <span class="title">View Call</span> </a>
                                                        </li>


                                                    <?php } ?>

                                                         <li class="heading">
                                                             <h3 class="uppercase">Workshop Inventory</h3>
                                                <h3 class="uppercase"></h3>
                                        </li>


                                         

                                                 <?php if($myData['serviceCall'] > 0 OR $myData['engineer'] > 0 ){?>

                                                          <li class="nav-item ">

                                                <li class="nav-item"> <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-cube"></i><span class="title">Workshop</span> <span class="arrow"></span> </a>
                                                    <ul class="sub-menu">
                                                       
                                                                
                                                                    <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>add-machine-to-workshop"> <span class="title">Add Machine to Workshop</span> </a>
                                                        </li>


                                                                    <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>view-workshop-machine"> <span class="title">View Workshop</span> </a>
                                                        </li>

                                                       
                                                        

                                                       

                                                    </ul>
                                                </li>

                                        </li>

                                                        <?php  } ?>



                                         <?php if($myData['serviceCall'] > 0){?>
                                        <li class="heading">
                                                <h3 class="uppercase">Service Call</h3>
                                        </li>
                                        <li class="nav-item">
                                                <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-diamond"></i> <span class="title">Admin Call</span> <span class="arrow"></span> </a>
                                                <ul class="sub-menu">
                                                            <?php  if($myData['AccessLevel'] == 12){ ?>
                                                        <li class="nav-item">
                                                                <a class="nav-link" href="#"> <span class="title">Make a Call</span> </a>
                                                        </li>
                                                        <?php }?>


                                                            <?php  if($myData['AccessLevel'] < 12){ ?>
                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>service-call"> <span class="title">Make a Call</span> </a>
                                                        </li>
                                                        <?php }?>

                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>view-service-call"> <span class="title">View Call</span> </a>
                                                        </li>


                                                         
                                                        
                                                        <li class="nav-item">
                                                                <a class="nav-link" href="#"> <span class="title">Follow Up</span> </a>
                                                        </li>
                                                        <li class="nav-item">
                                                                <a class="nav-link" href="#"> <span class="title">PM Call</span> </a>
                                                        </li>

                                                </ul>
                                        </li>
                                        <li class="nav-item">
                                                <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-envelope-open"></i> <span class="title">Customers</span> <span class="arrow"></span> </a>
                                                <ul class="sub-menu">
                                                        <li class="nav-item">
                                                                <a class="nav-link" href="#"> <span class="title">Machine Issues</span> <span class="badge badge-danger">0</span> </a>
                                                        </li>
                                                        <li class="nav-item">
                                                                <a class="nav-link" href="#"> <span class="title">Feedback</span><span class="badge badge-warning">0</span> </a>
                                                        </li>
                                                        <li class="nav-item">
                                                                <a class="nav-link" href="#"> <span class="title">Request</span><span class="badge badge-success">0</span> </a>
                                                        </li>
                                                        <li class="nav-item">
                                                                <a class="nav-link" href="#"> <span class="title">Suggestions</span><span class="badge badge-info">0</span> </a>
                                                        </li>

                                                </ul>
                                        </li>
                                             <li class="heading">
                                                <h3 class="uppercase"></h3>
                                            </li>
                                        <?php }?>
                                        <?php if($myData['Administrative'] > 0){?>

                                        <li class="heading">
                                                <h3 class="uppercase">Administrative</h3>
                                        </li>
                                        <li class="nav-item">
                                                <a class="nav-link nav-toggle" href="javascript:;"> <i class="icon-layers"></i> <span class="title">Accounts</span> <span class="arrow"></span> </a>
                                                <ul class="sub-menu">
                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php if($myData['AccessLevel'] == 12){echo '#';}else{echo $host;}?>add-account"> <span class="title">Add Account</span> </a>
                                                        </li>
                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>view-account"> <span class="title">View Accounts</span> </a>
                                                        </li>

                                                </ul>
                                        </li>
                                        <li class="nav-item">
                                                <a class="nav-link nav-toggle" href="javascript:;"> <i class="icon-paper-plane"></i> <span class="title">Machines</span> <span class="arrow"></span> </a>
                                                <ul class="sub-menu">
                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php if($myData['AccessLevel'] == 12){echo '#';}else{echo $host;}?>add-machine"> <span class="title">Add Machine </span> </a>
                                                        </li>
                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>view-machine"> <span class="title">View Machines</span> </a>
                                                        </li>
                                                </ul>
                                        </li>

                                        <?php }?>
                                         <?php if($myData['purchases'] > 0){?>
                                        <li class="heading">
                                                <h3 class="uppercase">Purchase</h3>
                                        </li>
                                        <li class="nav-item">
                                                <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-money"></i> <span class="title">Purchase Info</span> <span class="arrow"></span> </a>
                                                <ul class="sub-menu">
                                                    <li class="nav-item">



                                                        </li>
                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>purchase-collected"> <span class="title">Collected</span> </a>
                                                        </li>
                                                       <?php if($myData['DepartmentID'] == 5){

                                                         echo "";


                                                       }else{



                                                       ?>

                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>purchase-uncollected"> <span class="title">Uncollected</span> </a>
                                                        </li>

                                                        <?php } ?>

                                                </ul>
                                        </li>
                                        <li class="heading">
                                                <h3 class="uppercase"></h3>
                                        </li>
                                        <?php }?>
                                         <?php if($myData['Billing'] > 0){?>
                                        <li class="heading">
                                                <h3 class="uppercase">Billing</h3>
                                        </li>
                                        <li class="nav-item">
                                                <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-bank"></i> <span class="title">Contract Info</span> <span class="arrow"></span> </a>
                                                <ul class="sub-menu">

                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php if($myData['AccessLevel'] == 12){echo '#';}else{echo $host;}?>add-contract"> <span class="title">Create Contract</span> </a>
                                                        </li>
                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>view-contract"> <span class="title">View Contract</span> </a>
                                                        </li>
                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>view-contract-billing"> <span class="title">Contract Billing</span> </a>
                                                        </li>

                                                </ul>
                                        </li>
                                        <li class="heading">
                                                <h3 class="uppercase"></h3>
                                        </li>
                                         <?php }?>
                                          <?php if($myData['warehouse'] > 0){?>


                                         
                                        <li class="heading">
                                                <h3 class="uppercase">WareHouse</h3>
                                        </li>
                                        <?php
                                                $store = $database->getStoreIDInfo($myData['storeID']);

                                        ?>
                                        <li class="heading">
                                                <h3 class="uppercase"><?php echo $store['1'];?></h3>
                                        </li>
                                         <?php if($myData['DepartmentID'] == 5){?>

                                                          

                                                               
                                                               <?php }else{?>

                                                          <li class="nav-item">
                                             <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-cart-arrow-down"></i> <span class="title">Supplier</span> <span class="arrow"></span> </a>
                                                <ul class="sub-menu">

                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php if($myData['AccessLevel'] == 12){echo '#';}else{echo $host;}?>add-contract"> <span class="title">View</span> </a>
                                                        </li>

                                                </ul>
                                        </li>
                                                           <?php }?>

                                       



                                             <li class="nav-item">
                                                <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-cubes"></i> <span class="title">Goods Transactions</span> <span class="arrow"></span> </a>
                                                <ul class="sub-menu">

                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>view-sold-ticket"> <span class="title">Electronic Waybill</span> </a>
                                                        </li>




                                                         <?php if($myData['DepartmentID'] == 5){?>

                                                           <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>return-ticket-view"> <span class="title">Credit Note</span> </a>
                                                        </li>

                                                               
                                                               <?php }else{?>

                                                         <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>return-ticket"> <span class="title">Credit Note</span> </a>
                                                        
                                                        </li>
                                                           <?php }?>

                                                          
                                                         
                                                         
                                                         <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>view-goods-recieve-ticket"> <span class="title">Recieve</span> </a>
                                                        </li>
                                                        

                                                         <?php if($myData['DepartmentID'] == 5){?>

                                                            <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>transfer-goods-account"> <span class="title">Transfer</span> </a>
                                                        </li>

                                                         <?php }else{?>
                                                           
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>transfer-goods"> <span class="title">Transfer</span> </a>
                                                        </li>

                                                       <?php }?>



                                                      


                                                         
                                                         <!--<li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>view-goods-recieve-ticket"> <span class="title">Returned</span> </a>
                                                        </li>-->
                                                         <!--<li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>add-product-stock"> <span class="title">Add</span> </a>
                                                        </li> -->


                                                </ul>

                                        </li>

                                    

                                        <li class="nav-item">
                                                <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-calendar-o"></i> <span class="title">E-BIN Card</span> <span class="arrow"></span> </a>
                                                <ul class="sub-menu">

                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>view-bim"> <span class="title">View BIN</span> </a>
                                                        </li>
                                                </ul>

                                        </li>
                                         <li class="nav-item ">

                                                <li class="nav-item"> <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-cube"></i><span class="title">Stocks</span> <span class="arrow"></span> </a>
                                                    <ul class="sub-menu">
                                                        <li class="nav-item"> <a class="nav-link" href="javascript:;"> View All <span class="arrow nav-toggle"></span> </a>
                                                     
                                                            <ul class="sub-menu">
                                                                <?php
                                                                        $cati = (array)$database->getProductsCategory();
                                                                        foreach($cati as $catii){
                                                                ?>
                                                                <li class="nav-item"> <a class="nav-link" href="<?php echo $host;?>view-products/<?php echo $catii['id'];?>"><?php echo ucfirst($catii['type']);?></a> </li>


                                                                 <?php }?>


                                                            </ul>
                                                        </li>

                                                        <?php if ($myData['DepartmentID']== 5) { ?>
                                                             <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>add-product-cost"> <span class="title">Add Cost</span> </a>
                                                        </li>


                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>add-product-price"> <span class="title">Add Price</span> </a>
                                                        </li>
                                                         <?php } ?>

                                                    </ul>
                                                </li>

                                        </li>

                                        <?php }?>
                                        
                                        <?php if ($myData['DepartmentID']== 5) { ?>
                                                            <li class="nav-item">
                                                <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-calendar-o"></i> <span class="title">E-BIN Card</span> <span class="arrow"></span> </a>
                                                <ul class="sub-menu">

                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>view-bim"> <span class="title">View BIN</span> </a>
                                                        </li>
                                                </ul>

                                        </li>
                                                         <?php } ?>





                                        <?php if($myData['AccessLevel'] == 3 OR $myData['username'] == 'adeyinka' OR $myData['changePass'] == 2){?>
     <li class="nav-item ">

                                                <li class="nav-item"> <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-cube"></i><span class="title">Stocks</span> <span class="arrow"></span> </a>
                                                    <ul class="sub-menu">
                                                        <li class="nav-item"> <a class="nav-link" href="javascript:;"> View All <span class="arrow nav-toggle"></span> </a>
                                                            <ul class="sub-menu">
                                                                <?php
                                                                        $cati = (array)$database->getProductsCategory();
                                                                        foreach($cati as $catii){
                                                                ?>
                                                                <li class="nav-item"> <a class="nav-link" href="<?php echo $host;?>view-products/<?php echo $catii['id'];?>"><?php echo ucfirst($catii['type']);?></a> </li>
                                                                 <?php }?>
                                                            </ul>
                                                        </li>

                                                    </ul>
                                                </li>

                                        </li>

                                                         <?php }else{?>
                                                           
                                                            

                                                       <?php }?>

                                </ul>
                        </div>
                </div>
                <!-- End page sidebar wrapper -->
                <!-- Start page content wrapper -->