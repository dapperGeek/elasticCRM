
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
            <ul class="page-sidebar-menu  page-header-fixed ">
                <li class="sidebar-search-wrapper">

                </li>
                <li class="nav-item ">
                <a class="nav-link nav-toggle" href="javascript:;">
                    <i class="fa fa-th-large"></i><span class="title">Dashboard</span> <span class="arrow"></span>
                </a>
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
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $host;?>stock-to-order"> <span class="title">Stock To Order</span> </a>
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
                                                                <a class="nav-link" href="<?php echo $host;?>pm-view-account"> <span class="title">PM Call</span> </a>
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
                                        <li class="nav-item">
                                                <a class="nav-link nav-toggle" href="javascript:;"> <i class="icon-print"></i> <span class="title">POC-Proof Of Concept</span> <span class="arrow"></span> </a>
                                                <ul class="sub-menu">
                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php if($myData['AccessLevel'] == 12){echo '#';}else{echo $host;}?>add-poc"> <span class="title">Add New POC </span> </a>
                                                        </li>
                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>view-poc"> <span class="title">View POC</span> </a>
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
                                                                <a class="nav-link" href="<?php //echo $host;?>view-goods-recieve-ticket"> <span class="title">Returned</span> </a>
                                                        </li>-->
                                                         <!--<li class="nav-item">
                                                                <a class="nav-link" href="<?php //echo $host;?>add-product-stock"> <span class="title">Add</span> </a>
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
                                        <li class="nav-item">
                                                <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-calendar-o"></i> <span class="title">DELIVERY TRACKER</span> <span class="arrow"></span> </a>
                                                <ul class="sub-menu">

                                                        <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>track-a-delivery"> <span class="title">MANAGE TRACKING</span> </a>
                                                        </li>
                                                        <!-- <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host;?>view-bim"> <span class="title">VIEW DELEIVERY STATUS</span> </a>
                                                        </li>-->
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
                                                           
                                                            

<?php
                }

                // IT/Software Developer Section

//                if ($myData['designation'] == 'IT/Software Developer'){
?>
                    <li class="heading">
                        <h3 class="uppercase">
                            <?php echo $myData['designation']; ?>
                        </h3>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $host;?>users">
                        <span class="title">Users</span> </a></li>
<?php
//                }

?>

                                </ul>
        </div>
    </div>
                <!-- End page sidebar wrapper -->
                <!-- Start page content wrapper -->