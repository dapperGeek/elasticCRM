<?php
/**
 * Created by PhpStorm.
 * User: Bakar U.A.
 * Date: 27-Nov-19
 * Time: 9:47 AM
 */
?>

<ul class="page-sidebar-menu  page-header-fixed ">
    <li class="sidebar-search-wrapper">
        <!-- START RESPONSIVE SEARCH FORM
        <form class="sidebar-search  " action="http://adminui-v1.0.bittyfox.com/default/aqua-black/search_results.html" method="POST">
                <a href="javascript:;" class="remove"> <i class="icon-close"></i> </a>
                <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn"> <a href="javascript:;" class="btn submit"> <i class="icon-magnifier"></i> </a> </span> </div>
        </form>
        END RESPONSIVE SEARCH FORM -->

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

    <?php }?>

    <?php if($myData['engineer'] > 0){?>

        <li class="heading">
            <h3 class="uppercase">Service Call</h3>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?php echo $host;?>engineer-view-service-call"> <span class="title">View Call</span> </a>
        </li>


<?php
    }

//    Show workshop menus for engineers and customer care personnel
    if(($myData['serviceCall'] > 0 OR $myData['engineer'] > 0) AND $myData['typeID'] == 0){
?>
        <li class="heading">
            <h3 class="uppercase">Workshop Inventory</h3>
        </li>

        <li class="nav-item">
            <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-cube"></i><span class="title">Workshop</span> <span class="arrow"></span> </a>
            <ul class="sub-menu">


                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $host;?>add-machine-to-workshop"> <span class="title">Add Machine to Workshop</span> </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $host;?>view-workshop-machine"> <span class="title">View Workshop</span> </a>
                </li>

            </ul>
        </li>

        <li class="heading">
            <h3 class="uppercase">Showroom Inventory</h3>
        </li>

        <li class="nav-item">
            <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-cubes"></i><span class="title">Showroom</span> <span class="arrow"></span> </a>
            <ul class="sub-menu">

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $host;?>add-machine-to-showroom"> <span class="title">Add Machine to Showroom</span> </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $host;?>view-showroom-machine"> <span class="title">View Showroom</span> </a>
                </li>

            </ul>
        </li>

<?php
    }
?>

    <?php if($myData['serviceCall'] > 0){?>
        <li class="heading">
            <h3 class="uppercase">Service Call</h3>
        </li>
        <li class="nav-item">
            <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-diamond"></i> <span class="title">Admin Call
<?php
                if ($upcomingSchedules > 0){

?>
                    <span style="margin-right: 20px" class="label badge-info pull-right">
                <?php echo  $upcomingSchedules ?>
            </span>
<?php
}
?>
                </span> <span class="arrow"></span> </a>
            <ul class="sub-menu">
                <?php  if($myData['AccessLevel'] == 12){ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#"> <span class="title">Make a Call</span> </a>
                    </li>
                <?php }?>


                <?php  if($myData['AccessLevel'] < 12 AND $myData['typeID'] == 0){ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $host;?>service-call"> <span class="title">Make a Call</span> </a>
                    </li>
                <?php }?>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $host;?>view-service-call"> <span class="title">View Call</span> </a>
                </li>

                <?php
                    if ($myData['typeID'] == 0){
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#"> <span class="title">Follow Up</span> </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $host;?>pm-view-account"> <span class="title">PM Call
<?php
if ($upcomingSchedules > 0){

?>
<span class="label badge-info pull-right">
                    <?php echo  $upcomingSchedules ?>
                </span>
<?php
}
?>                    </span> </a>
                    </li>
                <?php
                    }
                ?>

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
            <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-suitcase"></i> <span class="title">Contract Info</span> <span class="arrow"></span> </a>
            <ul class="sub-menu">

                <li class="nav-item">
                    <a class="nav-link" href="<?php if($myData['AccessLevel'] == 12){echo '#';}else{echo $host;}?>add-contract"> <span class="title">Create Contract</span> </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php if($myData['AccessLevel'] == 12){echo '#';}else{echo $host . 'contracts/mps' ;}?>"> <span class="title">MPS Contract</span> </a>
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
        <?php
            if ($myData['typeID'] == 0) {
        ?>
                <!--Suppliers Links-->
                <li class="nav-item">
                    <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-cart-arrow-down"></i> <span class="title">Supplier</span> <span class="arrow"></span> </a>
                    <ul class="sub-menu">

                        <li class="nav-item">
                            <a class="nav-link" href="<?php if($myData['AccessLevel'] == 12){echo '#';}else{echo $host;}?>add-contract"> <span class="title">View</span> </a>
                        </li>

                    </ul>
                </li>

                <!-- Goods Transactions Link-->
                <li class="nav-item">
                    <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-cubes"></i> <span class="title">Goods Transactions</span>
                        <span class="arrow"></span> </a>
                    <ul class="sub-menu">

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $host; ?>view-sold-ticket"> <span class="title">Electronic Waybill</span>
                            </a>
                        </li>

                        <?php if ($myData['DepartmentID'] == 5) { ?>

                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $host; ?>return-ticket-view"> <span class="title">Credit Note</span>
                                </a>
                            </li>

                        <?php
                                }
                                else{
                        ?>

                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $host; ?>return-ticket"> <span class="title">Credit Note</span>
                                </a>

                            </li>
                        <?php } ?>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $host; ?>view-goods-recieve-ticket"> <span
                                        class="title">Receive</span> </a>
                        </li>


                        <?php if ($myData['DepartmentID'] == 5) { ?>

                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $host; ?>transfer-goods-account"> <span
                                            class="title">Transfer</span> </a>
                            </li>

                        <?php } else { ?>

                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $host; ?>transfer-goods"> <span class="title">Transfer</span>
                                </a>
                            </li>

                        <?php } ?>

                        <!--<li class="nav-item">
                                                                <a class="nav-link" href="<?php //echo $host;
                        ?>view-goods-recieve-ticket"> <span class="title">Returned</span> </a>
                                                        </li>-->
                        <!--<li class="nav-item">
                                                                <a class="nav-link" href="<?php //echo $host;
                        ?>add-product-stock"> <span class="title">Add</span> </a>
                                                        </li> -->


                    </ul>

                </li>

                <!-- E-Bin Card Link-->
                <li class="nav-item">
                    <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-calendar-o"></i> <span
                                class="title">E-BIN Card</span> <span class="arrow"></span> </a>
                    <ul class="sub-menu">

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $host; ?>view-bim"> <span class="title">View BIN</span>
                            </a>
                        </li>
                    </ul>

                </li>

                <!--Delivery Tracker-->
                <li class="nav-item">
                    <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-calendar-o"></i> <span
                                class="title">DELIVERY TRACKER</span> <span class="arrow"></span> </a>
                    <ul class="sub-menu">

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $host; ?>track-a-delivery"> <span class="title">MANAGE TRACKING</span>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                                                                <a class="nav-link" href="<?php echo $host; ?>view-bim"> <span class="title">VIEW DELEIVERY STATUS</span> </a>
                                                        </li>-->
                    </ul>

                </li>

        <?php
                }

        ?>
        <li class="nav-item"> <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-warehouse"></i><span class="title">Stocks</span> <span class="arrow"></span> </a>
            <ul class="sub-menu">
                <?php
                    // Show links for staff users
                    if($myData['typeID'] == 0){
                ?>
                <!-- Link to display all products-->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $host.'view-products/0' ?>">
                                View All</a>
                        </li>

                <!--      Link to list products by categories -->
                        <li class="nav-item"> <a class="nav-link" href="javascript:;"> View By Categories <span class="arrow nav-toggle"></span> </a>

                            <ul class="sub-menu">
                                <?php
                                $cati = (array)$database->getProductsCategory();
                                foreach($cati as $catii){
                                    ?>
                                    <li class="nav-item"> <a class="nav-link" href="<?php echo $host;?>view-products/<?php echo $catii['id'];?>"><?php echo ucfirst($catii['type']);?></a> </li>
                                <?php }?>

                            </ul>
                        </li>

                <?php
                    }

                    // show links for users representing clients
                    else {
                        $catInfo = (array)$database->getCategoryById($myData['typeID'])
                ?>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo $host;?>view-products/<?php echo $catInfo['id'];?>"><?php echo ucfirst($catInfo['type']);?></a> </li>
                <?php
                        }
                ?>

                <?php
                    // Display links for adding product costs for account dept users
                    if ($myData['DepartmentID']== 5) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $host;?>add-product-cost"> <span class="title">Add Cost</span> </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $host;?>add-product-price"> <span class="title">Add Price</span> </a>
                    </li>
                <?php } ?>

            </ul>
        </li>

    <?php }?>



    <?php if($myData['AccessLevel'] == 3){?>
        <li class="nav-item ">

        <li class="nav-item"> <a class="nav-link nav-toggle" href="javascript:;"> <i class="fa fa-cube"></i><span class="title">Stocks</span> <span class="arrow"></span> </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $host.'view-products/0' ?>">
                        View All</a>
                </li>
                <li class="nav-item"> <a class="nav-link" href="javascript:;"> View Categories <span class="arrow nav-toggle"></span> </a>
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

    if ($myData['designation'] == 'IT/Software Developer'){
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
    }

    ?>

</ul>
