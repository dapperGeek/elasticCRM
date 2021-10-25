<<<<<<< HEAD
<div class="modal fade bs-example-modal-lg-2-<?php echo $act['ticketNo'];?>" tabindex="-1" role="dialog" >
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">CALL STATUS FOR <?php echo $act['ticketNo'];?> OPENED ON : <?php echo $act['openedDateTime'];?>, CLOSED ON </h4>
                                                            </div>
                                                         <!---- the beginning of the form-->

                                                          <div class="modal-body">
                                                               <div class="invoice">
                            <div class="panel no-margin">
                                <div class="panel-body">
                                    <div class="row gutter">
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                              <address class="to"><h4> <?php echo $act['ticketNo'];?></h4>
                                              <p> <span class="badge badge-<?php if($act['paymentStatus']=='PAID'){echo 'success';}else if($act['paymentStatus']=='UNPAID'){echo 'danger';}else{ echo 'info';}?> col-md-12">
                                                 <?php echo $act['paymentStatus'];?></span></p>
                                              <p><?php echo $act['caseName'];?></p>
                                               <p><?php echo $act['ReportedBy'];?></p>
                                         </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12"><address class="from"><h4><b>Tenaui Africa Limited</b></h4><abbr title="email">E-mail:</abbr> <a href="mailto:#" data-original-title="" title="">support.ng@tenaui.com</a><br><abbr title="Phone">Phone:</abbr> (123) 333-444-555<br><abbr title="Fax">Fax:</abbr> (123) 333-444-555</address></div>
                                        <div class="col-md-5 col-sm-5 col-xs-12"><address class="to"><h4>
                                            <b><?php echo $act['AccountName'] ?></b></h4>
                                            <abbr title="email">E-mail:</abbr> <a href="mailto:#" data-original-title="" title=""><?php echo $act['contactEmail1'];?></a><br>
                                            <abbr title="Phone">Phone:</abbr> <?php echo $act['contactPhone1'];?><br>
                                        <abbr title="Fax">Contact Person:</abbr> <?php echo $act['contactName1'];?></address>
                                        </div>


                                </div>

                                    <div class="row">
                                        <div class="col-md-4"><b>Machine Code :</b> <?php echo $act['machine_code'];?></div>
                                        <div class="col-md-4"><b>Machine Model :</b> <?php echo $act['machineBrand'];?> </div>
                                        <div class="col-md-4"><b>Contract Type :</b> <?php echo $act['contract'];?> </div>
                                    </div>
                                     <div class="row">
                                        <div class="col-md-4"><b>Engineer :</b><?php echo $database->getMyUserInformation($act['engineer'])['fullname'];?></div>
                                        <div class="col-md-8"><b>Machine Address :</b><?php echo $act['Address'].", ".$act['areaname'].", ".$act["lga"]." L.G.A, ".$act['state'];?> </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4"><b>Opened Date :</b> <?php echo $act['openedDateTime'];?></div>
                                        <div class="col-md-4"><b>Closed Date :</b> <?php echo $act['closedDateTime'];?> </div>
                                        <div class="col-md-4"><b>Duration :</b> <?php echo $database->time_space($act['closedTimeStamp'],$act['openedTimeStamp']);?> </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center"><b><h4 style="text-align: center">Issues</h4></b></div>
                                                <?php
                                                        $issues = explode(",",$act['issues']);
                                                        $i = 0;
                                                        foreach($issues as $iss){
                                                        if($iss == "")continue;
                                                          ?>
                                                           <div class="col-md-6" style=" background-color: #CC0000; color: #ffffff;text-align: center"><?php echo $database->getIssueWithId($iss)['issues'];?></div>

                                                 <?php  if($i%2 != 0 && $i!= 0){ ?>
                                                    </div> <div class="row">

                                                       <?php  }  $i++; }  ?>
                                             </div>

                                        <div class="col-lg-12">
                                            <h4 style="text-align: center">Work Done Description</h4>
                                            <p style="text-align: center"><?php echo $act['workDone'];?></p>
                                        </div>

                                        <div class="col-lg-12">

                <div class="row">

                        <div class="col-md-4" style="border-style: inset"><p style="text-align: center"><b>Item</b></p></div>
                        <div class="col-md-3" style="border-style: inset"><p style="text-align: center">Code</p></div>
                        <div class="col-md-2" style="border-style: inset"><p style="text-align: center">Rate</p></div>
                        <div class="col-md-1" style="border-style: inset"><p style="text-align: center">Qty</p></div>
                        <div class="col-md-2" style="border-style: inset"><p style="text-align: center">Price</p></div>
                    </div>


                    <?php
                     $amounted = 0;
                     $amount_ = 0;
                            if($act['purchase'] == 1){
                            $n = 1;

                            $salesorder = (array)$database->getServiceProductOrderCall($act['id']);
                            foreach ($salesorder as $order) {
                    ?>
                                <div class="row">
                                    <div class="col-md-4" style="border-style: inset"><p style="text-align: center"><?php echo $order['productName'];?><?php if($order['ProductType']>1){echo " - ".$order['color'];}?></p></div>
                                    <div class="col-md-3" style="border-style: inset"><p style="text-align: center"><?php echo $order['Code'];?></p></div>
                                    <div class="col-md-2" style="border-style: inset"><p style="text-align: center"> <?php echo $database->convertToMoney($order['Amount']);?></p></div>
                                    <div class="col-md-1" style="border-style: inset"><p style="text-align: center"><?php echo $order['qty'];?></p></div>
                                    <div class="col-md-2" style="border-style: inset"><p style="text-align: center"><?php
                                                            $amount_ = $order['qty'] * $order['Amount'];
                                                    echo $database->convertToMoney($amount_);?></p></div>
                                </div>

                     <?php $n++; $amounted += $amount_;}?>
                    <?php }else{?>
                        <div class="row" ><p style="text-align: center">No Consumable purchased for this ticket</p></div>
                    <?php }?>
                     <div class="row">
                             <div class="col-md-8" style="border-style: inset">&nbsp;</div>
                             <div class="col-md-2" style="border-style: inset">PURCHASE </div>
                             <div class="co-md-2" style="border-style: inset"> <?php
                             $sub_total =$amounted;
                             echo  $database->convertToMoney($sub_total);
                        ?></div>

                         </div>
                           <div class="row">
                             <div class="col-md-8" style="border-style: inset">&nbsp;</div>
                             <div class="col-md-2" style="border-style: inset">SERV-CHARGE </div>
                             <div class="co-md-2" style="border-style: inset"><span style="text-align: center"><?php echo $database->convertToMoney($act['cost']);?></span></div>

                         </div>
                         <div class="row">
                             <div class="col-md-8" style="border-style: inset; ">&nbsp;</div>
                             <div class="col-md-2" style="border-style: inset">TOTAL </div>
                             <div class="co-md-2" style="border-style: inset"><?php $total = $act['cost'] + $sub_total; echo $database->convertToMoney($total); ?></div>

                         </div>
                             <div class="row" style="border-style: inset">
                                  <p style="text-align: center">
                  <b>Amount in words :</b> <?php echo ucwords($database->convert_number_to_words($total));?> Naira Only
                   </p>
                             </div>
                    </div>

                     </div>
                                                           </div>
                                                          </div>
                                                          <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Dismiss</button>


                                                            </div>

                                                        </div>
                                                    </div>
</div>

=======
<div class="modal fade bs-example-modal-lg-2-<?php echo $act['ticketNo'];?>" tabindex="-1" role="dialog" >
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">CALL STATUS FOR <?php echo $act['ticketNo'];?> OPENED ON : <?php echo $act['openedDateTime'];?>, CLOSED ON </h4>
                                                            </div>
                                                         <!---- the beginning of the form-->

                                                          <div class="modal-body">
                                                               <div class="invoice">
                            <div class="panel no-margin">
                                <div class="panel-body">
                                    <div class="row gutter">
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                              <address class="to"><h4> <?php echo $act['ticketNo'];?></h4>
                                              <p> <span class="badge badge-<?php if($act['paymentStatus']=='PAID'){echo 'success';}else if($act['paymentStatus']=='UNPAID'){echo 'danger';}else{ echo 'info';}?> col-md-12">
                                                 <?php echo $act['paymentStatus'];?></span></p>
                                              <p><?php echo $act['caseName'];?></p>
                                               <p><?php echo $act['ReportedBy'];?></p>
                                         </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12"><address class="from"><h4><b>Tenaui Africa Limited</b></h4><abbr title="email">E-mail:</abbr> <a href="mailto:#" data-original-title="" title="">support.ng@tenaui.com</a><br><abbr title="Phone">Phone:</abbr> (123) 333-444-555<br><abbr title="Fax">Fax:</abbr> (123) 333-444-555</address></div>
                                        <div class="col-md-5 col-sm-5 col-xs-12"><address class="to"><h4>
                                            <b><?php echo $act['AccountName'] ?></b></h4>
                                            <abbr title="email">E-mail:</abbr> <a href="mailto:#" data-original-title="" title=""><?php echo $act['contactEmail1'];?></a><br>
                                            <abbr title="Phone">Phone:</abbr> <?php echo $act['contactPhone1'];?><br>
                                        <abbr title="Fax">Contact Person:</abbr> <?php echo $act['contactName1'];?></address>
                                        </div>


                                </div>

                                    <div class="row">
                                        <div class="col-md-4"><b>Machine Code :</b> <?php echo $act['machine_code'];?></div>
                                        <div class="col-md-4"><b>Machine Model :</b> <?php echo $act['machineBrand'];?> </div>
                                        <div class="col-md-4"><b>Contract Type :</b> <?php echo $act['contract'];?> </div>
                                    </div>
                                     <div class="row">
                                        <div class="col-md-4"><b>Engineer :</b><?php echo $database->getMyUserInformation($act['engineer'])['fullname'];?></div>
                                        <div class="col-md-8"><b>Machine Address :</b><?php echo $act['Address'].", ".$act['areaname'].", ".$act["lga"]." L.G.A, ".$act['state'];?> </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4"><b>Opened Date :</b> <?php echo $act['openedDateTime'];?></div>
                                        <div class="col-md-4"><b>Closed Date :</b> <?php echo $act['closedDateTime'];?> </div>
                                        <div class="col-md-4"><b>Duration :</b> <?php echo $database->time_space($act['closedTimeStamp'],$act['openedTimeStamp']);?> </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center"><b><h4 style="text-align: center">Issues</h4></b></div>
                                                <?php
                                                        $issues = explode(",",$act['issues']);
                                                        $i = 0;
                                                        foreach($issues as $iss){
                                                        if($iss == "")continue;
                                                          ?>
                                                           <div class="col-md-6" style=" background-color: #CC0000; color: #ffffff;text-align: center"><?php echo $database->getIssueWithId($iss)['issues'];?></div>

                                                 <?php  if($i%2 != 0 && $i!= 0){ ?>
                                                    </div> <div class="row">

                                                       <?php  }  $i++; }  ?>
                                             </div>

                                        <div class="col-lg-12">
                                            <h4 style="text-align: center">Work Done Description</h4>
                                            <p style="text-align: center"><?php echo $act['workDone'];?></p>
                                        </div>

                                        <div class="col-lg-12">

                <div class="row">

                        <div class="col-md-4" style="border-style: inset"><p style="text-align: center"><b>Item</b></p></div>
                        <div class="col-md-3" style="border-style: inset"><p style="text-align: center">Code</p></div>
                        <div class="col-md-2" style="border-style: inset"><p style="text-align: center">Rate</p></div>
                        <div class="col-md-1" style="border-style: inset"><p style="text-align: center">Qty</p></div>
                        <div class="col-md-2" style="border-style: inset"><p style="text-align: center">Price</p></div>
                    </div>


                    <?php
                     $amounted = 0;
                     $amount_ = 0;
                            if($act['purchase'] == 1){
                            $n = 1;

                            $salesorder = (array)$database->getServiceProductOrderCall($act['id']);
                            foreach ($salesorder as $order) {
                    ?>
                                <div class="row">
                                    <div class="col-md-4" style="border-style: inset"><p style="text-align: center"><?php echo $order['productName'];?><?php if($order['ProductType']>1){echo " - ".$order['color'];}?></p></div>
                                    <div class="col-md-3" style="border-style: inset"><p style="text-align: center"><?php echo $order['Code'];?></p></div>
                                    <div class="col-md-2" style="border-style: inset"><p style="text-align: center"> <?php echo $database->convertToMoney($order['Amount']);?></p></div>
                                    <div class="col-md-1" style="border-style: inset"><p style="text-align: center"><?php echo $order['qty'];?></p></div>
                                    <div class="col-md-2" style="border-style: inset"><p style="text-align: center"><?php
                                                            $amount_ = $order['qty'] * $order['Amount'];
                                                    echo $database->convertToMoney($amount_);?></p></div>
                                </div>

                     <?php $n++; $amounted += $amount_;}?>
                    <?php }else{?>
                        <div class="row" ><p style="text-align: center">No Consumable purchased for this ticket</p></div>
                    <?php }?>
                     <div class="row">
                             <div class="col-md-8" style="border-style: inset">&nbsp;</div>
                             <div class="col-md-2" style="border-style: inset">PURCHASE </div>
                             <div class="co-md-2" style="border-style: inset"> <?php
                             $sub_total =$amounted;
                             echo  $database->convertToMoney($sub_total);
                        ?></div>

                         </div>
                           <div class="row">
                             <div class="col-md-8" style="border-style: inset">&nbsp;</div>
                             <div class="col-md-2" style="border-style: inset">SERV-CHARGE </div>
                             <div class="co-md-2" style="border-style: inset"><span style="text-align: center"><?php echo $database->convertToMoney($act['cost']);?></span></div>

                         </div>
                         <div class="row">
                             <div class="col-md-8" style="border-style: inset; ">&nbsp;</div>
                             <div class="col-md-2" style="border-style: inset">TOTAL </div>
                             <div class="co-md-2" style="border-style: inset"><?php $total = $act['cost'] + $sub_total; echo $database->convertToMoney($total); ?></div>

                         </div>
                             <div class="row" style="border-style: inset">
                                  <p style="text-align: center">
                  <b>Amount in words :</b> <?php echo ucwords($database->convert_number_to_words($total));?> Naira Only
                   </p>
                             </div>
                    </div>

                     </div>
                                                           </div>
                                                          </div>
                                                          <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Dismiss</button>


                                                            </div>

                                                        </div>
                                                    </div>
</div>

>>>>>>> 48136f1b63a2e7fb659fed72c5bf93f60ec79592
