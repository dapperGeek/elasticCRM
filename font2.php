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
<br>
<br>
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
           <!-- <li>
                <span class="fa fa-phone m-r-xs"></span>
                <label>Contact:</label> <?php echo $myData['phone'];?>
            </li> -->
        </ul>

    </div>

</div>