<?php
    $pageHeader = 'viewServiceCall';
    include("../includes/header_with_pageHeading.php");
    $engineers = $database->getAllEngineers();
?>
    <div class="row">
        <div class="row col-lg-12 margin-bottom-10">
        <?php
                    include('../views/serviceCallsFigures.php');
        ?>
        </div>
        <?php
            $view = file_exists('../views/serviceCalls.php')
                    ? '../views/serviceCalls.php' : 'views/serviceCalls.php';
            echo '<center><h2 class="margin-bottom-10">Service Calls</h2></center>';
            include '../views/serviceCalls.php';
        ?>
        </div>
    </div>
</div>

<!-- start footer -->

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

<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/dataTables.fixedHeader.min.js"></script>
<!-- pace js -->
<script src="<?php echo $host;?>assets/js/vendor/pace/pace.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $host;?>assets/js/vendor/jquery.sparkline.min.js"></script>
<!-- main js -->
<script src="<?php echo $host;?>assets/js/main.js"></script>
<script>

    $(document).ready(function() 
    {
        // Flexible table

        $('#example').DataTable();

        // Scroll Horizontal example



        // Individual column searching

        // Setup - add a text input to each footer cell


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
            }],

            "pageLength": 20
        });
        
        $('#example6').DataTable({

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
            "pageLength": 20,

            "columnDefs": [
                { "width": "5px", "targets": 0 },
                { "width": "5px", "targets": 1 },
                { "width": "5px", "targets": 2 },
                { "width": "5px", "targets": 3 },
                { "width": "5px", "targets": 4 },
                { "width": "5px", "targets": 5 }
            ]
        });
        
        $('#supportCalls').DataTable({

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

<!-- Mirrored from adminui-v1.0.bittyfox.com/default/aqua-black/alerts_Modal_Tooltip.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Jul 2017 15:58:53 GMT -->
</html>
