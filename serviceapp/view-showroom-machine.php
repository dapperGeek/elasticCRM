 <?php
     $title = 'View Showroom Machine';
     $pageHeader = 'viewShowroomMachine';
     include("../includes/header_with_pageHeading.php");
?>

      <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
               <!--  <h5>Workshop </h5> -->
              </div>
              <div class="ibox-content collapse in">
                <div class="widgets-container">
                  <div class="table-responsive">
                    <table id="example7"  class="display nowrap table  responsive nowrap table-bordered">
                      <thead>
                                            <tr>
                                              <th>S/N</th>
                                             <th>TicketNo.</th>
                                                <th>Account</th>
                                                <th>Category</th>
                                                <th>Product Name</th>
                                                 <th>Code</th>
                                                <th>SerialNo.</th>
                                                <th>Date&Time</th>
                                                <th>Engineer</th>
                                                <th>Status</th>
                                                
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                               <th>S/N</th>
                                              <th>TicketNo.</th>
                                                 <th>Account</th>
                                                 <th>Category</th>
                                                <th>Product Name</th>
                                                 <th>Code</th>
                                                <th>SerialNo.</th>
                                                <th>Date&Time</th>
                                                <th>Engineer</th>
                                                <th>Status</th>
                                                
                                                
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        <?php
                                        $i=0;
                                            $machines = (array)$database->getAllMachineShowroomInformation();
                                            foreach ($machines as $machine) {
                                               $i++;
                                        ?>
                                            <tr>
                                              <td><?php echo $i;?></td>

                                              <td><a href="<?php echo $host;?>workshop-ticket-info/<?php echo $machine['ticketGen']?>"> <?php echo $machine['ticketGen']?> </td>
                                                 <td><?php echo strtoupper($machine['account_name']);?></td>
                                                 <td><?php echo $machine['category'];?></td>
                                                 <td><?php echo $machine['machine_name'];?></td>
                                                <td><?php echo $machine['machine_code'];?></a></td>
                                                
                                                
                                                <td><?php echo $machine['serialNo'];?></td>

                                                <td><?php echo $machine['doi'];?></td>
                                                <td><?php echo $machine['assign_engineer'];?></td>
                                          <td><a class="badge badge-warning" href="<?php echo $host;?>workshop-follow-up/<?php echo $machine['ticketGen'];?>">FOLLOW-UP</a> </td>

                                               




                                            </tr>

                                        <?php }?>

                                        </tbody>
                    </table>
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



        });
    </script>
</body>

<!-- Mirrored from adminui-v1.0.bittyfox.com/default/aqua-black/table_datatables.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Jul 2017 16:01:14 GMT -->
</html>
