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
<title>Purchase UnCollected</title>
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
  <div class="page-content-wrapper">
    <div class="page-content">
      <div class="row wrapper border-bottom page-heading">
        <div class="col-lg-12">
          <h2>View Purchase NOT Collected </h2>
          <ol class="breadcrumb">
            <li> <a href="index-2.html">Home</a> </li>
            <li> <a>Purchase</a> </li>

            <li class="active"> <strong>All Purchases not yet collected</strong> </li>
          </ol>
        </div>
        <div class="col-lg-12"> </div>
      </div>
      <div class="wrapper-content ">

      <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>Consumable & Spare Parts sales not collected</h5>
              </div>
              <div class="ibox-content collapse in">
                <div class="widgets-container">
                  <div class="table-responsive">
                     <?php
                            if(isset($_POST['btncollectOrder'])){
                                     $oID = $database->test_input($_POST['txtOrderID']);
                                     $ocDay = $database->test_input($_POST['txtDay']);
                                     $ocMonth = $database->test_input($_POST['txtMonth']);
                                     $ocYear = $database->test_input($_POST['txtYear']);
                                     $vat = $database->test_input($_POST['txtVat']);
                                     $machineID = $database->test_input($_POST['txtMachineID']);
                                     $accID =  $database->test_input($_POST['txtAccountID']);
                                      $paymentmode = $database->test_input($_POST['txtPaymentMode']);
                                        $database->updateOrderCollected($oID,$ocDay,$ocMonth,$ocYear,$vat,$machineID,$accID,$paymentmode);
                                      $database->showMsg('SUCCESSFUL','ORDER SUCCESSFULLY COLLECTED',2);
                                }
                        ?>
                    <table id="example7"  class="display nowrap table  responsive nowrap table-bordered">
                      <thead>
                                            <tr>
                                                <th>Ticket#</th>
                                                <th>Account</th>
                                                <th>Machine</th>
                                                <th>Order Date</th>

                                                <th>SubTotal</th>
                                                <th>Vat</th>
                                                <th>Discount</th>
                                                <th>Amount</th>
                                                <th></th>

                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Ticket#</th>
                                                <th>Account</th>
                                                <th>Machine</th>
                                                <th>Order Date</th>

                                                <th>SubTotal</th>
                                                <th>Vat</th>
                                                <th>Discount</th>
                                                <th>Amount</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                        <tbody> <?php

                                        $myOrder = (array)$database->purchaseListForMachineCollectedAll(0);
                                            if($myOrder != null){
                                              //  echo count($myOrder);
                                                foreach($myOrder as $mo){
                                                    $demand = $mo;
                                                    $vat = 0;
                                                    $vatv_ = "NO VAT";

                                     ?>
                                     <tr>
                                       <td>

                                            <div class="btn-group">
                                                                     <button data-toggle="dropdown" class="btn btn-info btn-xs dropdown-toggle" type="button"><?php echo $mo['ticketNo'];?>&nbsp;<i class="fa fa-angle-down"></i> </button>
                                                                        <ul role="menu" class="dropdown dropdown-menu">
                                                                       
                                                                            <li> <a href="<?php echo $host;?>purchase-invoice/<?php echo $mo['ticketNo'];?>?vat=1">PFI - VAT</a></li>
                                                                            <li> <a href="<?php echo $host;?>purchase-invoice/<?php echo $mo['ticketNo'];?>?vat=0">PFI - NO VAT</a></li>
                                                                            <li class="divider"> </li>

                                                                            <li><a href="<?php echo $host;?>edit-purchase/<?php echo $mo['ticketNo'];?>">EDIT PURCHASE</a></li>
                                                                        </ul>
                                                                    </div>

                                       </td>
                                       <td><?php echo substr($mo['Name'],0,40);?><?php if(strlen($mo['Name'])>40){echo "...";}?></td>
                                        <td><?php echo $mo['machine_code'];?></td>
                                         <td><a href="<?php echo $host;?>ticket-pop/<?php echo $demand['ticketNo'];?>"  data-toggle="modal" data-target="#myModal<?php echo $demand['ticketNo'];?>">PREVIEW PENDING</a>
                                          <div id="myModal<?php echo $demand['ticketNo'];?>"  tabindex="-1" role="dialog" class="modal fade bs-example-modal-lg-2">
                                                                        <div class="modal-dialog modal-lg" role="document">
                                                                            <div class="modal-content"> <!-- Content will be loaded here from "remote.php" file --></div>
                                                                        </div>
                                                                    </div>
                                         </td>
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
                                       <td>
                                        <?php if($myData['AccessLevel'] == 12){ }else{?>
                                        <button  class="btn btn-warning dropdown-toggle" type="button" data-toggle="modal" data-target=".bs-example-modal-lg-<?php echo $demand['ticketNo'];?>">COLLECT ORDER &nbsp;<i class="fa fa-check-square"></i> </button>
                                        <?php } ?>
                                       </td>
                                        <?php
                                               $accName =  $mo['Name'];
                                               $m_code = $mo['machine_code'];

                                                $m_machineID = $mo['machineID'];
                                                $m_accountID = $mo['accountID'];

                                        include("../serviceapp/followup/collect-purchase-order.php");?>
                                    </tr>

                                     <?php } ?>

                                     <?php }else{?>
                                          <tr>
                                       <td colspan="8">NO ORDER  YET</td>

                                    </tr>
                                     <?php } ?>

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
