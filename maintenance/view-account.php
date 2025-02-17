<?php
    $pageHeader = 'viewPmAccounts';
    $title = 'View Accounts';
    include("../includes/header_with_pageHeading.php");

    if ($upcomingSchedules > 0 OR $pendingSchedules > 0){
?>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>
<?php

                    $number = $upcomingSchedules > 0 ? $upcomingSchedules : 'No';
                    echo 'You have ' . $number . ' Preventive Maintenance Schedules within the next 1 month.'
                    ?>
                </h5>
                <div class="ibox-tools">
                    <a class="collapse-link" data-target="#demo1"  data-toggle="collapse"> <i class="fa fa-chevron-up"></i>
                        <i class="fa fa-chevron-down"></i>
                    </a>

                    <a class="close-link"> <i class="fa fa-times"></i> </a> </div>
                <!-- ibox-tools -->
            </div>
            <!-- / ibox-title -->
            <div id="demo1" class="ibox-content collapse in">

<!--                tabs-->
<!--                <ul class="nav nav-tabs">-->
<!--                    <li class="active"><a href="#tab-4" data-toggle="tab" >-->
<!--                            Upcoming PM Schedules-->
                            <!--<span class="label label-warning">NEW</span>-->
<!--                        </a></li>-->
<!--                    <li ><a href="#tab-5" data-toggle="tab" >-->
<!--                            Pending PM Schedules </a></li>-->
<!--                </ul>-->
                <div class="tab-content">

<!--                    <div class="tab-pane active" id="tab-4">-->
<!--                        <div class="panel-body">-->

                <div class="table-responsive">

                    <table id="example10" class="display nowrap table  responsive nowrap table-bordered">
                        <thead>
                        <tr style="color: #FFF">
                            <td>Account</td>
                            <td>Machine Code</td>
                            <td>Department</td>
                            <td>Area</td>
                            <td>Date</td>
                        </tr>
                        </thead>
                        <tbody>
<?php
                if (isset($getPmsSchedules[UtilFunctions::$newSchedule])){
                    foreach ($getPmsSchedules[UtilFunctions::$newSchedule] as $schedule){
                        $url = $host. 'pm-view-account-details/' . $schedule->accID
                        ?>
                        <tr>
                            <td>
                                <a target="_blank" href="<?php echo $url ?>">
                                    <?php echo $schedule->brandName ?>
                                </a>

                            </td>
                            <td><?php echo $schedule->machine_code ?></td>
                            <td><?php echo $schedule->department ?></td>
                            <td><?php // $schedule->area ?></td>
                            <td><?php echo UtilFunctions::makeDate($schedule->nextSchedule) ?></td>
                        </tr>
                        <?php
                    }
                }
                else{
?>
                <tr><td colspan="5"><span><center>No Data Found</center></span></td> </tr>
<?php
                }
?>

                        </tbody>
                    </table>

                </div>

<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="tab-pane" id="tab-5">-->
<!--                        <div class="panel-body">-->


<!--                        </div>-->
<!--                    </div>-->

                <div class="ibox-footer">

                </div>
            </div>

        </div>
        <hr>
<?php
    }
?>

     <div class="row">

        <div class="ibox float-e-margins">

              <div class="ibox-content collapse in">

                    <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-1" data-toggle="tab" > MPS <!--<span class="label label-warning">NEW</span>--></a></li>
                <li ><a href="#tab-2" data-toggle="tab" >AMC </a></li>
                <li ><a href="#tab-3" data-toggle="tab" >FSMA</a></li>
              </ul>
                  <div class="tab-content">
                <div class="tab-pane active" id="tab-1">
                  <div class="panel-body">

                  <div class="table-responsive">
                      <table id="example7" class="display nowrap table  responsive nowrap table-bordered">
                      <thead>
                                            <tr>
                                                <th>Account</th>
                                                <th>Sector</th>
                                                <th>Address</th>
                                                <th>Area</th>


                                                 <th>Contact-1</th>
                                                <th>Email-1</th>
                                                <th>Phone-1</th>
                                                <th>Desig-1</th>
                                                <th>Contact-2</th>
                                               <th>Email-2</th>
                                                <th>Phone-2</th>
                                                <th>Desig-2</th>
                                                <th>Contact-3</th>
                                                <th>Email-3</th>
                                                <th>Phone-3</th>
                                                <th>Desig-3</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                 <th>Account</th>
                                                <th>Sector</th>
                                                <th>Address</th>
                                                <th>Area</th>


                                                <th>Contact-1</th>
                                                <th>Email-1</th>
                                                <th>Phone-1</th>
                                                <th>Desig-1</th>
                                                <th>Contact-2</th>
                                               <th>Email-2</th>
                                                <th>Phone-2</th>
                                                <th>Desig-2</th>
                                                <th>Contact-3</th>
                                                <th>Email-3</th>
                                                <th>Phone-3</th>
                                                <th>Desig-3</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        <?php
                                            $accounts = (array)$database->getAllAccountInformation();
                                            foreach ($accounts as $account) {

                                        ?>
                                            <tr>
                                                 <td><a href="<?php if($myData['AccessLevel'] == 12){echo '#';}else{echo $host;}?>pm-view-account-details/<?php echo $account['id'];?>"><?php echo strtoupper($account['Name']);?></a></td>
                                                <td><?php echo strtoupper($account['sector']);?></td>
                                                <td><?php echo strtoupper($account['Address']);?></td>
                                                 <td><?php echo strtoupper($account['areaname'])." - ".$account['state'];?></td>



                                                <td><?php echo $account['ContactName1']."</td><td>".$account['email1']."</td><td>".$account['phone1']."</td><td>".$account['desig1'];?></td>
                                                <td><?php echo $account['ContactName2']."</td><td>".$account['email2']."</td><td>".$account['phone2']."</td><td>".$account['desig2'];?></td>
                                                <td><?php echo $account['ContactName3']."</td><td>".$account['email3']."</td><td>".$account['phone3']."</td><td>".$account['desig3'];?></td>

                                            </tr>

                                        <?php }?>

                                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="tab-2">
                  <div class="panel-body">
                  <div class="table-responsive">
                    <table id="example8" class="display nowrap table  responsive nowrap table-bordered">
                      <thead>
                                            <tr>
                                                <th>Account</th>
                                                <th>Sector</th>
                                                <th>Address</th>
                                                <th>Area</th>


                                                 <th>Contact-1</th>
                                                <th>Email-1</th>
                                                <th>Phone-1</th>
                                                <th>Desig-1</th>
                                                <th>Contact-2</th>
                                               <th>Email-2</th>
                                                <th>Phone-2</th>
                                                <th>Desig-2</th>
                                                <th>Contact-3</th>
                                                <th>Email-3</th>
                                                <th>Phone-3</th>
                                                <th>Desig-3</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                 <th>Account</th>
                                                <th>Sector</th>
                                                <th>Address</th>
                                                <th>Area</th>


                                                <th>Contact-1</th>
                                                <th>Email-1</th>
                                                <th>Phone-1</th>
                                                <th>Desig-1</th>
                                                <th>Contact-2</th>
                                               <th>Email-2</th>
                                                <th>Phone-2</th>
                                                <th>Desig-2</th>
                                                <th>Contact-3</th>
                                                <th>Email-3</th>
                                                <th>Phone-3</th>
                                                <th>Desig-3</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>


                                        </tbody>
                    </table>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-3">
                  <div class="panel-body">
                                  <div class="table-responsive">
                        <table id="example9" class="display nowrap table  responsive nowrap table-bordered">
                      <thead>
                                            <tr>
                                                <th>Account</th>
                                                <th>Sector</th>
                                                <th>Address</th>
                                                <th>Area</th>


                                                 <th>Contact-1</th>
                                                <th>Email-1</th>
                                                <th>Phone-1</th>
                                                <th>Desig-1</th>
                                                <th>Contact-2</th>
                                               <th>Email-2</th>
                                                <th>Phone-2</th>
                                                <th>Desig-2</th>
                                                <th>Contact-3</th>
                                                <th>Email-3</th>
                                                <th>Phone-3</th>
                                                <th>Desig-3</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                 <th>Account</th>
                                                <th>Sector</th>
                                                <th>Address</th>
                                                <th>Area</th>


                                                <th>Contact-1</th>
                                                <th>Email-1</th>
                                                <th>Phone-1</th>
                                                <th>Desig-1</th>
                                                <th>Contact-2</th>
                                               <th>Email-2</th>
                                                <th>Phone-2</th>
                                                <th>Desig-2</th>
                                                <th>Contact-3</th>
                                                <th>Email-3</th>
                                                <th>Phone-3</th>
                                                <th>Desig-3</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>


                                        </tbody>
                    </table id="example9" class="display nowrap table  responsive nowrap table-bordered">
                </div>
              </div>
            </div>
            </div>
                </div>
              </div>
            </div>
  </div>

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
        <div> <strong>Copyright</strong> AdminUI Company &copy; 2017 </div>
      </div>
    </div>
  </div>
</div>
<!-- Go top -->
<a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>
<!-- Go top -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo $host;?>assets/js/vendor/jquery.min.js"></script>
<!-- bootstrap js -->
<script src="<?php echo $host;?>assets/js/vendor/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jasny-bootstrap.min.js" charset="UTF-8"></script>
<!-- slimscroll js -->
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jquery.slimscroll.js"></script>
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
<!-- pace js -->
<script src="<?php echo $host;?>assets/js/vendor/pace/pace.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $host;?>assets/js/vendor/jquery.sparkline.min.js"></script>
<!-- main js -->
<script src="<?php echo $host;?>assets/js/main.js"></script>
<script>

        $(document).ready(function() {
            // Flexible table

            $('#example').DataTable();

            // Scroll Horizontal example



            // Individual column searching

            // Setup - add a text input to each footer cell
            $('#example6 tfoot th').each(function() {
                var title = $(this).text();
                $(this).html('<input class="form-control dataSearch" type="text" placeholder="Search ' + title + '" />');
            });

            // DataTable
            var table = $('#example6').DataTable();

            // Apply the search
            table.columns().every(function() {
                var that = this;

                $('input', this.footer()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });


            // Advanced
            $('#example7').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                    text: 'copy',
                    extend: "copy",
                    className: 'btn dark btn-outline'
                }, {
                    text: 'csv',
                    extend: "csv",
                    className: 'btn aqua btn-outline'
                }, {
                    text: 'excel',
                    extend: "excel",
                    className: 'btn aqua btn-outline'
                }, {
                    text: 'pdf',
                    extend: "pdf",
                    className: 'btn yellow  btn-outline'
                }, {
                    text: 'print',
                    extend: "print",
                    className: 'btn purple  btn-outline'
                }]
            });


             $('#example8').DataTable({

                dom: 'Bfrtip',
                buttons: [{
                    text: 'copy',
                    extend: "copy",
                    className: 'btn dark btn-outline'
                }, {
                    text: 'csv',
                    extend: "csv",
                    className: 'btn aqua btn-outline'
                }, {
                    text: 'excel',
                    extend: "excel",
                    className: 'btn aqua btn-outline'
                }, {
                    text: 'pdf',
                    extend: "pdf",
                    className: 'btn yellow  btn-outline'
                }, {
                    text: 'print',
                    extend: "print",
                    className: 'btn purple  btn-outline'
                }],

                "pageLength": 20
            });

             $('#example9').DataTable({

                dom: 'Bfrtip',
                buttons: [{
                    text: 'copy',
                    extend: "copy",
                    className: 'btn dark btn-outline'
                }, {
                    text: 'csv',
                    extend: "csv",
                    className: 'btn aqua btn-outline'
                }, {
                    text: 'excel',
                    extend: "excel",
                    className: 'btn aqua btn-outline'
                }, {
                    text: 'pdf',
                    extend: "pdf",
                    className: 'btn yellow  btn-outline'
                }, {
                    text: 'print',
                    extend: "print",
                    className: 'btn purple  btn-outline'
                }],

                "pageLength": 20
            });

             $('#example10').DataTable({

                dom: 'Bfrtip',
                buttons: [{
                    text: 'copy',
                    extend: "copy",
                    className: 'btn dark btn-outline'
                }, {
                    text: 'csv',
                    extend: "csv",
                    className: 'btn aqua btn-outline'
                }, {
                    text: 'excel',
                    extend: "excel",
                    className: 'btn aqua btn-outline'
                }, {
                    text: 'pdf',
                    extend: "pdf",
                    className: 'btn yellow  btn-outline'
                }, {
                    text: 'print',
                    extend: "print",
                    className: 'btn purple  btn-outline'
                }],

                "pageLength": 10
            });

             $('#example11').DataTable({

                dom: 'Bfrtip',
                buttons: [{
                    text: 'copy',
                    extend: "copy",
                    className: 'btn dark btn-outline'
                }, {
                    text: 'csv',
                    extend: "csv",
                    className: 'btn aqua btn-outline'
                }, {
                    text: 'excel',
                    extend: "excel",
                    className: 'btn aqua btn-outline'
                }, {
                    text: 'pdf',
                    extend: "pdf",
                    className: 'btn yellow  btn-outline'
                }, {
                    text: 'print',
                    extend: "print",
                    className: 'btn purple  btn-outline'
                }],

                "pageLength": 20
            });



        });
    </script>
</body>

</html>
