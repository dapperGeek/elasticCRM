
        <div class="row">
             <div class="col-md-2 col-sm-6">
                            <div class="widget widget-stats orange-bg">
                                <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
                                <div class="stats-title">TOTAL MACHINE IN FIELD</div>
                                <div class="stats-number"> <?php
                                                    $mif = sizeof($database->getAllMachineInformation());
                                                    echo $mif;
                                            ?></div>
                                <div class="stats-progress progress">
                                    <div style="width: 70.1%;" class="progress-bar"></div>
                                </div>
                                <!--<div class="stats-desc">Better than last week (70.1%)</div>-->
                            </div>
                        </div>
                        <!-- end col-3 -->
                        <!-- begin col-3 -->
                        <div class="col-md-2 col-sm-6 mtop15">
                            <div class="widget widget-stats aqua-bg ">
                                <div class="stats-icon stats-icon-lg"><i class="fa fa-tags fa-fw"></i></div>
                                <div class="stats-title">TOTAL ACCOUNTS</div>
                                <div class="stats-number"><?php
                                                    $acInfo = sizeof($database->getAllAccountInformation());
                                                    echo $acInfo;
                                            ?></div>
                                <div class="stats-progress progress">
                                    <div style="width: 40.5%;" class="progress-bar"></div>
                                </div>
                                <!--<div class="stats-desc">Better than last week (40.5%)</div> -->
                            </div>
                        </div>
                        <!-- end col-3 -->
                        <!-- begin col-3 -->
                        <div class="col-md-2 col-sm-6 mtop15">
                            <div class="widget widget-stats purple-bg">
                                <div class="stats-icon stats-icon-lg"><i class="fa fa-volume-control-phone fa-fw"></i></div>
                                <div class="stats-title">TOTAL CALLS LOGGED</div>
                                <div class="stats-number"><?php
                                                    $sc = sizeof($database->getAllServiceCall());
                                                    echo $sc;
                                            ?></div>
                                <div class="stats-progress progress">
                                    <div style="width: <?php echo $sc."%";?>" class="progress-bar"></div>
                                </div>
                                <!--<div class="stats-desc">Better than last week (76.3%)</div> -->
                            </div>
                        </div>
                        <!-- end col-3 -->
                        <!-- begin col-3 -->
                        <div class="col-md-2 col-sm-6 mtop15">
                            <div class="widget widget-stats black-bg">
                                <div class="stats-icon stats-icon-lg"><i class="fa fa-phone-square fa-fw"></i></div>
                                <div class="stats-title">TOTAL CALLS RESOLVED</div>
                                <div class="stats-number"><?php
                                                    $rsc = sizeof($database->getAllResolvedServiceCall());
                                                    echo $rsc;
                                            ?></div>
                                <div class="stats-progress progress">
                                    <div style="width: <?php echo $rsc."%";?>;" class="progress-bar"></div>
                                </div>
                                <!--<div class="stats-desc">Better than last week (54.9%)</div>  -->
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 mtop15">
                            <?php
                                    $color = "red";
                                    $icon = "level-down";
                                   $xValue = $database->calculatePercentage($rsc,$sc);
                                   if($xValue > 60){$color="blue";$icon="level-up";}

                            ?>
                            <div class="widget widget-stats <?php echo $color;?>-bg">
                                <div class="stats-icon stats-icon-lg"><i class="fa fa-<?php echo $icon;?> fa-fw"></i></div>
                                <div class="stats-title">CALLS PERCENTAGE</div>
                                <div class="stats-number">
                                     <?php echo round($xValue,2)."%";?>

                                </div>
                                <div class="stats-progress progress">
                                    <div style="width: <?php echo round($xValue,2)."%";?>;" class="progress-bar"></div>
                                </div>
                                <!--<div class="stats-desc">Better than last week (54.9%)</div>  -->
                            </div>
                        </div>

        </div>

<div class="row">
    <div class="col-lg-6 top15">

    <!-- begin col-3 -->
    <div class="col-lg-6">
        <div class="widget aqua-bg box-shadow">
            <div class="row">
                <div class="col-xs-4 text-center">
                    <i class="fa fa-bank fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span>Total Expenses</span>

                    <h2 class="font-bold"></h2>
                </div>
            </div>
        </div>
    </div>
    <!-- begin col-3 -->
    <div class="col-lg-6">
        <div class="widget white-bg box-shadow">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-cloud fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Unresolved Calls </span>

                    <h2 class="font-bold"></h2>
                </div>
            </div>
        </div>
    </div>
    <!-- begin col-3 -->
    <div class="col-lg-6">
        <div class="widget red-bg box-shadow">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-line-chart fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span>Calls Above 2 days</span>

                    <h2 class="font-bold"></h2>
                </div>
            </div>
        </div>
    </div>
    <!-- begin col-3 -->
    <div class="col-lg-6">
        <div class="widget white-bg box-shadow">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-shopping-cart fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span>Uncollected Orders</span>

                    <h2 class="font-bold"></h2>
                </div>
            </div>
        </div>
    </div>

 <!-- begin col-2
                        <div class="col-lg-4">
                            <div class="widget box-shadow green-bg">
                                <div class="row vertical-align">
                                    <div class="col-xs-3">
                                        <i class="fa fa-bus fa-2x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <span>Last Booking</span>
                                        <h2 class="font-bold">320</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="widget box-shadow aqua-bg">
                                <div class="row vertical-align">
                                    <div class="col-xs-3">
                                        <i class="fa fa-ship fa-2x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <span>Last Booking</span>
                                        <h2 class="font-bold">10</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="widget box-shadow red-bg">
                                <div class="row vertical-align">
                                    <div class="col-xs-3">
                                        <i class="fa fa-plane fa-2x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <span>Last Booking</span>
                                        <h2 class="font-bold">610</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    -->


</div>
<div class="col-lg-3">
                            <div class="widget green-bg no-padding">
                                <div class="widget-m">
                                    <h1><?php echo $database->convertToMoney($database->purchaseListForMachineCollectedDaily(date('j'),date('n'),date('Y'))); ?></h1>
                                      <?php echo date('d')."- ".date('n')."- ".date('Y'); ?>
                                    <h3 class="font-bold no-margins">
                                        Today's Income
                                    </h3>
                                     <small>Sales of Consumables & Spareparts Only</small>
                                </div>
                                <div class="flot-chart">
                                    <div class="flot-chart-content" id="flot-chart2"></div>
                                </div>
                            </div>
                        </div>
                        <!-- begin col-3 -->
                        <div class="col-lg-3">
                            <div class="widget orange-bg no-padding">
                                <div class="widget-m">
                                    <h1><?php echo $database->convertToMoney($database->purchaseListForMachineCollectedMonthly(date('n'),date('Y'))); ?></h1>

                                    <h3 class="font-bold no-margins">
                                        This Month Income
                                    </h3>
                                    <small>Sales of Consumables & Spareparts Only</small>
                                </div>
                                <div class="flot-chart">
                                <div class="flot-chart-content" id="flot-chart3"></div>
                            </div>

                            </div>
 
                        </div>



                        <div class="container-fluid">
                          
                          
    <!-- begin col-3 -->

    <div class="col-lg-3">

        <div class="widget red-bg box-shadow">

            <div class="row">
                <div class="col-xs-4 text-center">
                    <i class="fa fa-users fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span>NC</span>

                  <h2 class="font-bold"><?php $database->getAllContractsByNC();?> 
                </h2>
                </div>
            </div>
        </div>
    </div>

    <!-- begin col-3 -->
    <div class="col-lg-3">
        <div class="widget aqua-bg box-shadow">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-database fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> FMSA </span>

                    <h2 class="font-bold"><?php $database->getAllContractsByFMSA();?></h2>
                </div>
            </div>
        </div>
    </div>
    <!-- begin col-3 -->
    <div class="col-lg-3">
        <div class="widget aqua-bg box-shadow">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-line-chart fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> AMC </span>

                    <h2 class="font-bold"><?php $database->getAllContractsByAMC();?></h2>
                </div>
            </div>
        </div>
    </div>
    <!-- begin col-3 -->
    <div class="col-lg-3">
        <div class="widget red-bg box-shadow">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-user fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span>MPS</span>

                    <h2 class="font-bold"><?php $database->getAllContractsByMPS();?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
                        </div>

















                          <!-- tabs -->
          <div class="col-lg-8 top20">
            <div class="tabs-container">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-money" aria-hidden="true"></i> Orders Collected Today  </a></li>
                <li><a href="#tab-2" data-toggle="tab"><i class="fa fa-tasks" aria-hidden="true"></i> Activities</a></li>

              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab-1">
                <div class="panel-body"> <div class="table-responsive">
                              <table class="table table-bordered table-hover bottom0 ">
                                 <thead>
                                    <tr>
                                       <th>Order #</th>
                                       <th>Order Date</th>
                                       <th>SubTotal (NGN)</th>
                                        <th>VAT 5%</th>
                                       <th>Discount %</th>

                                       <th>Amount (NGN)</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php

                                        $myOrder = (array)$database->purchaseListForMachineCollectedToday(date('j'),date('n'),date('Y'));            
                                            if($myOrder != null){
                                              //  echo count($myOrder);
                                                foreach($myOrder as $mo){
                                                    $vat = 0;
                                                    $vatv_ = "NO VAT";

                                     ?>
                                     <tr>
                                       <td><?php echo $mo['ticketNo'];?></td>
                                       <td><?php echo $mo['orderCollectedDate'];?></td>
                                       <td><?php echo $database->convertToMoney($mo['myAmount']);?></td>
                                       <td><?php if($mo['vat'] == 1){$vat = 0.05 *$mo['myAmount'];$vatv_ = "5%";}
                                            echo $vatv_. " - ".$database->convertToMoney($vat);
                                            $added = $mo['myAmount'] + $vat;
                                       ?></td>
                                       <td><?php
                                               $discount = ($mo['discount']/100) * $added;
                                               echo $mo['discount']."% - ".$database->convertToMoney($discount);
                                            ?>
                                       </td>

                                       <td><?php

                                                $finalAmount = $added - $discount;

                                       echo $database->convertToMoney($finalAmount);?></td>
                                    </tr>

                                     <?php } ?>

                                     <?php }else{?>
                                          <tr>
                                       <td colspan="6">NO ORDER  YET</td>

                                    </tr>
                                     <?php } ?>
                                 </tbody>
                              </table>
                              <div class="panel-footer text-right">
                              <a class="btn aqua btn-sm dropdown-toggle" data-toggle="modal" data-target=".bs-example-modal-lg-make-purchase">Make Purchase </a>

                           </div>
                           </div></div>
                </div>
                <div class="tab-pane" id="tab-2">
                  <div class="panel-body">   <!-- START list group-->
                           <div class="task-list">
                              <a href="#" class="list-group-item bt0">
                                 <span class="label label-warning pull-right">just now</span>
                                 <em class="fa fa-fw fa-calendar mr"></em>Calendar updated</a>
                              <a href="#" class="list-group-item">
                                 <span class="label label-warning pull-right">4 minutes ago</span>
                                 <em class="fa fa-fw fa-comment mr"></em>Commented on a post</a>
                              <a href="#" class="list-group-item">
                                 <span class="label label-warning pull-right">23 minutes ago</span>
                                 <em class="fa fa-fw fa-truck mr"></em>Order 392 shipped</a>
                              <a href="#" class="list-group-item">
                                 <span class="label label-warning pull-right">46 minutes ago</span>
                                 <em class="fa fa-fw fa-money mr"></em>Invoice 653 has been paid</a>
                              <a href="#" class="list-group-item">
                                 <span class="label label-warning pull-right">1 hour ago</span>
                                 <em class="fa fa-fw fa-user mr"></em>A new user has been added</a>
                              <a href="#" class="list-group-item">
                                 <span class="label label-warning pull-right">2 hours ago</span>
                                 <em class="fa fa-fw fa-check mr"></em>Completed task: "pick up dry cleaning"</a>
                              <a href="#" class="list-group-item">
                                 <span class="label label-warning pull-right">yesterday</span>
                                 <em class="fa fa-fw fa-globe mr"></em>Saved the world</a>
                              <a href="#" class="list-group-item">
                                 <span class="label label-warning pull-right">two days ago</span>
                                 <em class="fa fa-fw fa-check mr"></em>Completed task: "fix error on sales page"</a>
                              <a href="#" class="list-group-item">
                                 <span class="label label-warning pull-right">two days ago</span>
                                 <em class="fa fa-fw fa-check mr"></em>Completed task: "fix error on sales page"</a>
                           </div>
                           <!-- END list group-->
                           <div class="panel-footer text-right"><a href="#" class="btn aqua btn-sm">View All Activity</a>
                           </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <!-- tabs -->


<br>

          <div class="col-lg-4">

    <div class="widget white-bg box-shadow p-xl">

        <h2>
            <?php echo $myData['fullname']?>
        </h2>
        <ul class="list-unstyled m-t-md">
            <li>
                <span class="fa fa-envelope m-r-xs"></span>
                <label>Email:</label> <?php echo $myData['email'];?>
            </li>
            <li>
                <span class="fa fa-home m-r-xs"></span>
                <label>Designation:</label> <?php echo $myData['designation'];?>
            </li>
            <li>
                <span class="fa fa-lock m-r-xs"></span>
                <label>Security:</label> <a href="<?php echo $host . 'change-password' ?>">Update Login Password</a>
            </li>
            <li>
                <span class="fa fa-phone m-r-xs"></span>
                <label>Contact:</label> <?php echo $myData['phoneNo'];?>
            </li>
        </ul>

    </div>



</div>

