 <?php
  include("../data/DBConfig.php");
  include_once("../data/sessioncheck.php");
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>View Accounts</title>
<!-- dataTables -->
<link href="<?php echo $host;?>assets/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="<?php echo $host;?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $host;?>assets/css/responsive.dataTables.min.css" rel="stylesheet">
<link href="<?php echo $host;?>assets/css/fixedHeader.dataTables.min.css" rel="stylesheet">
<!-- Bootstrap -->
<link href="<?php echo $host;?>assets/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $host;?>assets/css/jasny-bootstrap.min.css">
<!-- slimscroll -->
<link href="<?php echo $host;?>assets/css/jquery.slimscroll.css" rel="stylesheet">
<!-- Fontes -->
<link href="<?php echo $host;?>assets/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo $host;?>assets/css/simple-line-icons.css" rel="stylesheet">
<link href="<?php echo $host;?>assets/css/buttons.css" rel="stylesheet">
<!-- animate css -->
<link href="<?php echo $host;?>assets/css/animate.css" rel="stylesheet">
<!-- top nev css -->
<link href="<?php echo $host;?>assets/css/page-header.css" rel="stylesheet">
<!-- adminui main css -->
<link href="<?php echo $host;?>assets/css/main.css" rel="stylesheet">
<!-- aqua black theme css -->
<link href="<?php echo $host;?>assets/css/aqua-black.css" rel="stylesheet">
<!-- media css for responsive  -->
<link href="<?php echo $host;?>assets/css/main.media.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<?php include("../includes/header_.php");?>
  <div class="page-content-wrapper animated fadeInRight">
    <div class="page-content">
      <div class="row wrapper border-bottom page-heading">
        <div class="col-lg-12">
          <h2>View All Machines </h2>
          <ol class="breadcrumb">
            <li> <a href="index-2.html">Home</a> </li>
            <li> <a>Administrative</a> </li>
            <li> <a>Accounts</a> </li>
            <li class="active"> <strong>View Accounts</strong> </li>
          </ol>
        </div>
        <div class="col-lg-12"> </div>
      </div>
      <div class="wrapper-content ">

     <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>View All Accounts</h5>
              </div>
              <div class="ibox-content collapse in">
                <div class="widgets-container">
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
                                            $machines = (array)$database->getAllAccountInformation();
                                            foreach ($machines as $machine) {

                                        ?>
                                            <tr>
                                                 <td><a href="<?php if($myData['AccessLevel'] == 12){echo '#';}else{echo $host;}?>account-info/<?php echo $machine['id'];?>"><?php echo strtoupper($machine['Name']);?></a></td>
                                                <td><?php echo strtoupper($machine['sector']);?></td>
                                                <td><?php echo strtoupper($machine['Address']);?></td>
                                                 <td><?php echo strtoupper($machine['areaname'])." - ".$machine['state'];?></td>



                                                <td><?php echo $machine['ContactName1']."</td><td>".$machine['email1']."</td><td>".$machine['phone1']."</td><td>".$machine['desig1'];?></td>
                                                <td><?php echo $machine['ContactName2']."</td><td>".$machine['email2']."</td><td>".$machine['phone2']."</td><td>".$machine['desig2'];?></td>
                                                <td><?php echo $machine['ContactName3']."</td><td>".$machine['email3']."</td><td>".$machine['phone3']."</td><td>".$machine['desig3'];?></td>

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

</html>
