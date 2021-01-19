<?php
/**
 * Created by PhpStorm.
 * User: Uthman A.B.
 * Date: 26 - Feb - 20
 * Time: 1:14 PM
 */
?>
</div>
<!-- end page main section --->
</div>
</div>

<!-- start footer -->
<div class="footer">
    <div class="pull-right">
        <span>We Speak By Image</span>
        <!--        <ul class="list-inline">-->
        <!--            <li><a title="" href="index-2.html">Dashboard</a></li>-->
        <!--            <li><a title="" href="mailbox.html"> Inbox </a></li>-->
        <!--            <li><a title="" href="blog.html">Blog</a></li>-->
        <!--            <li><a title="" href="contacts.html">Contacts</a></li>-->
        <!--        </ul>-->
    </div>
    <div> <strong>Copyright</strong> Elastic 25  &copy; <?php echo date('Y');?> </div>
</div>
<!--- end footer -->

</div>
<!-- end page content -->

</div>
<!-- end page content wrapper -->

<!-- Go top -->
<a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>
<!-- Go top -->
<!-- Flot -->
<script src="<?php echo $host;?>assets/js/vendor/flotCart/jquery.flot.js"></script>
<script src="<?php echo $host;?>assets/js/vendor/flotCart/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo $host;?>assets/js/vendor/flotCart/jquery.flot.resize.js"></script>

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

<script src="<?php echo $host;?>assets/js/vendor/chartJs/Chart.bundle.js"></script>
<script src="<?php echo $host;?>assets/js/dashboard1.js"></script>

<!-- pace js -->
<script src="<?php echo $host;?>assets/js/vendor/pace/pace.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $host;?>assets/js/vendor/jquery.sparkline.min.js"></script>
<!-- main js -->
<script src="<?php echo $host;?>assets/js/main.js"></script>
<!-- AdminUI demo js-->
<!--<script src="--><?php //echo $host;?><!--assets/js/adminUIdemo.js"></script>-->

<!-- start theme config -->
<div class="theme-config">
    <div class="theme-config-box">
        <div class="spin-icon"> <i class="fa fa-cogs fa-spin"></i> </div>
        <div class="skin-setttings">
            <div class="title">Configuration</div>
            <div class="setings-item"> <span> Collapse menu </span>
                <div class="switch">
                    <div class="onoffswitch">
                        <input name="collapsemenu" class="onoffswitch-checkbox" id="collapsemenu" type="checkbox">
                        <label class="onoffswitch-label" for="collapsemenu">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="setings-item"> <span> Fixed sidebar </span>
                <div class="switch">
                    <div class="onoffswitch">
                        <input name="fixedsidebar" class="onoffswitch-checkbox" id="fixedsidebar" type="checkbox">
                        <label class="onoffswitch-label" for="fixedsidebar">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="setings-item"> <span> Header Fixed </span>
                <div class="switch">
                    <div class="onoffswitch">
                        <input name="headerfixed" class="onoffswitch-checkbox" id="headerfixed" type="checkbox" checked>
                        <label class="onoffswitch-label" for="headerfixed">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="setings-item"> <span> Boxed layout </span>
                <div class="switch">
                    <div class="onoffswitch">
                        <input name="boxedlayout" class="onoffswitch-checkbox" id="boxedlayout" type="checkbox">
                        <label class="onoffswitch-label" for="boxedlayout">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="setings-item"> <span> Fixed footer </span>
                <div class="switch">
                    <div class="onoffswitch">
                        <input name="fixedfooter" class="onoffswitch-checkbox" id="fixedfooter" type="checkbox">
                        <label class="onoffswitch-label" for="fixedfooter">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- end theme config -->

<!-- DataTables script-->
<script>
    $(document).ready(function() {
        // Flexible table
        $('#example').DataTable();

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
            ],
        });
    });
</script>

<!--    FlotChart Script-->
<script>
    $(document).ready(function(){
        var data2 = [
            { label: "Data 1", data: d1, color: '#19a0a1'}
        ];
        $.plot($("#flot-chart2"), data2, {
            xaxis: {
                tickDecimals: 0
            },
            series: {
                lines: {
                    show: true,
                    fill: true,
                    fillColor: {
                        colors: [{
                            opacity: 1
                        }, {
                            opacity: 1
                        }]
                    }
                },
                points: {
                    width: 0.1,
                    show: false
                }
            },
            grid: {
                show: false,
                borderWidth: 0
            },
            legend: {
                show: false
            }
        });

        var data3 = [
            { label: "Data 1", data: d1, color: '#fbbe7b'},
            { label: "Data 2", data: d2, color: '#f8ac59' }
        ];
        $.plot($("#flot-chart3"), data3, {
            xaxis: {
                tickDecimals: 0
            },
            series: {
                lines: {
                    show: true,
                    fill: true,
                    fillColor: {
                        colors: [{
                            opacity: 1
                        }, {
                            opacity: 1
                        }]
                    }
                },
                points: {
                    width: 0.1,
                    show: false
                }
            },
            grid: {
                show: false,
                borderWidth: 0
            },
            legend: {
                show: false
            }
        });


    });

</script>

</body>
</html>