<?php
include("../data/DBConfig.php");
include_once("../data/sessioncheck.php");
$id = 0;

if(!isset($_GET['id']) || $_GET['id'] == ""){
    $database->redirect_to($host."view-machine");
}else{
    $id = $_GET['id'];
    $machineInfo = $database->selectFromContractInfo($id);
    if($machineInfo == null){
        $database->redirect_to($host."view-contract");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $machineInfo['Name']; ?></title>
    <!-- Bootstrap -->
    <link href="<?php echo $host;?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- slimscroll -->
    <link href="<?php echo $host;?>assets/css/jquery.slimscroll.css" rel="stylesheet">
    <!-- Fontes -->
    <link href="<?php echo $host;?>assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $host;?>assets/css/simple-line-icons.css" rel="stylesheet">
    <!-- all buttons css -->
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
    <!--[if lt IE 9]> <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
    <!--[if lt IE 9]> <script src="dist/html5shiv.js"></script> <![endif]-->
</head>

<?php include("../includes/header_.php");?>
<!-- End page sidebar wrapper -->
<!-- Start page content wrapper -->
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row wrapper border-bottom page-heading">
            <div class="col-lg-12">
                <h2><?php echo strtoupper($machineInfo['contractName']);?> FOR <?php echo strtoupper($machineInfo['Name']);?> </h2>
                <ol class="breadcrumb">
                    <li> <a><?php echo $machineInfo['Address']; ?></a> </li>

                    <li class="active"> <strong><?php echo $machineInfo['areaname']; ?></strong> </li>
                    <li> <a><?php echo $machineInfo['state']; ?> </a> </li>
                </ol>
            </div>
        </div>
        <div class="wrapper-content ">
            <!-- tabs -->
            <div class="col-lg-12 top20">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-1" data-toggle="tab" >BASIC INFO</a></li>
                        <li ><a href="#tab-2" data-toggle="tab" >METER READINGS </a></li>
                        <li role="presentation" class="dropdown"> <a  href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop1-contents">ORDERS<span class="caret"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                                <li><a href="#tab-3"   data-toggle="tab" >COLLECTED</a></li>
                                <li><a href="#tab-4"  data-toggle="tab" >NOT COLLECTED</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-1">
                            <div class="panel-body">

                                <h2><?php echo $machineInfo['Name']; ?> <a href="<?php echo $host;?>generate-billing/<?php echo $id;?>" class="btn btn-success">GENERATE BILLING</a></h2>
                            <?php 
//                                $mpsorder = (array)$database->getLeadMPSOrderOnLeadDemand($id);
                                $n = 1;
                                $total_amount = 0;
                                $totalValue = 0;
                            ?>

                                <!--you can start here to cut for other contracts--->
                                <table style="font-size: smaller" class="display nowrap table  responsive nowrap table-bordered">
                                    <tr>
                                        <th>MACHINE</th>
                                        <th>SERIAL-NO</th>
                                        <th>C-MONO</th>
                                        <th>V-MONO</th>
                                        <th>C-COLOR</th>
                                        <th>V-COLOR</th>
                                        <th>RENTAL</th>
                                        <th>BW-PAY</th>
                                        <th>C-PAY</th>

                                        <th>BILLING</th>
                                        <th>PAY</th>
                                        <th>DURATION</th>
                                        <th>OCCURRENCE</th>
                                        <th>TOTAL COLLECTION</th>
                                    </tr>
                                    <?php
                                    $total_worth_ = 0;

                                    $getcont = (array)$database->getContractValue($id);
                                    foreach($getcont as $getconts)
                                    {

                                ?>
                                    <tr>
                                        <td><?php echo $getconts['machine_code'];?></td>
                                        <td><?php echo $getconts['serialNo'];?></td>
                                        <td><?php echo $database->convertToMoney($getconts['cost_mono']);?></td>
                                        <td><?php echo $getconts['min_vol_mono'];?></td>
                                        <td><?php echo $database->convertToMoney($getconts['cost_color']);?></td>
                                        <td><?php echo $getconts['min_vol_color'];?></td>
                                        <td>
                                            <?php
                                            $rnt = $getconts['RentalCharge'];
                                            echo $database->convertToMoney($rnt);?>
                                        </td>
                                        <td><?php
                                            $bw = $getconts['cost_mono'] * $getconts['min_vol_mono'];
                                            echo $database->convertToMoney($bw);

                                            ?>
                                        </td>
                                        <td><?php
                                            $cl = $getconts['cost_color'] * $getconts['min_vol_color'];
                                            echo $database->convertToMoney($cl);

                                            ?>
                                        </td>

                                        <td>
                                            <?php echo $database->getBillingType($getconts['billingType'])['BillingType'];?>
                                        </td>
                                        <td>
                                            <?php
                                            $monthPay = $cl+$bw+$rnt;
                                            echo $database->convertToMoney($monthPay);

                                            ?>
                                        </td>
                                        <td><?php echo strtoupper($database->convert_number_to_words($getconts['contract_duration']));?> YEARS</td>
                                        <td><?php $occurance = $getconts['billingType'] * $getconts['contract_duration']; echo $occurance;?> TIMEs</td>
                                        <td>
                                            <?php
                                            $total_worth = $monthPay * $occurance;
                                            $total_worth_ = $total_worth_ +  $total_worth;
                                            //$totalValue = $totalValue + $total_worth;
                                            echo $database->convertToMoney( $total_worth);
                                            ?>

                                        </td>

                                    </tr>

                                <?php 
                                    }
                                ?>

                                </table>

                                <table class="display nowrap table  responsive nowrap table-bordered">

                                    <tr>
                                        <td colspan="4">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <h3 style="text-align: center;">
                                                <b>TOTAL VALUE: <?php echo $database->convertToMoney($total_worth_);?></b></h3>
                                            <h4 style="text-align: center;">
                                                <?php echo strtoupper($database->convert_number_to_words($total_worth_))?> NAIRA ONLY
                                            </h4>
                                        </td>
                                    </tr>


                                </table>


                            </div>
                        </div>
                        <div class="tab-pane" id="tab-2">
                            <div class="panel-body">

                                <div class="table-responsive">
                                    <table id="myExample" style="font-size: 12px;" class="dataTables-example display myExample table table-striped table-bordered" border="1" cellspacing="1">
                                        <tbody>
                                        <tr>
                                            <td>&nbsp;MACHINE</td>
                                            <td>&nbsp;MODEL</td>
                                            <td>&nbsp;S/N</td>
                                            <td>&nbsp;START</td>
                                            <td>&nbsp;OCCURENCE</td>
                                            <td>&nbsp;BILLING</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;TAL 001</td>
                                            <td>&nbsp;IR-ADV C3320</td>
                                            <td>&nbsp;QTT17760</td>
                                            <td>&nbsp;22-05-2017</td>
                                            <td>&nbsp;48 TIMES</td>
                                            <td>
                                                <table style="font-size: 12px; text-align: center" class="dataTables-example display myExample table table-striped table-bordered">
                                                    <tbody>
                                                    <tr>
                                                        <th colspan="2">MAY</th>
                                                        <th colspan="2">JUNE</th>
                                                        <th colspan="2">JULY</th>
                                                    </tr>
                                                    <tr>
                                                        <th>COLOR</th>
                                                        <th>MONO</th>
                                                        <th>COLOR</th>
                                                        <th>MONO</th>
                                                        <th>COLOR</th>
                                                        <th>MONO</th>
                                                    </tr>
                                                    <tr>
                                                        <td>282</td>
                                                        <td>185</td>
                                                        <td>378</td>
                                                        <td>282</td>
                                                        <td>477</td>
                                                        <td>381</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>


                                </div>


                            </div>
                        </div>
                        <div class="tab-pane" id="tab-3">
                            <div class="panel-body">
                                <h1><strong>COLLECTED ORDERS</strong></h1>
                                <div class="table-responsive">
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

                                        $myOrder = (array)$database->purchaseListForAccountCollected($machineInfo['id'],1);
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
                                    <div class="panel-footer text-right"><a href="#" class="btn aqua btn-sm">View All Transactions</a></div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane" id="tab-4">
                            <div class="panel-body">
                                <h1><strong>UNCOLLECTED ORDERS</strong></h1>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover bottom0 ">
                                        <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Generated Date</th>
                                            <th>Total (NGN)</th>
                                            <th>VAT 5%</th>
                                            <th>Grand Total</th>
                                            <th>Generated By</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        $myOrder = (array)$database->getContractBillingValuesPerContractID($id);
                                        if($myOrder != null){
                                            foreach($myOrder as $mo){
                                                ?>
                                                <tr>
                                                    <td><a href="<?php echo $host;?>mps-billing/<?php echo $mo['id'];?>">#<?php echo str_pad($mo['id'],4,"0",STR_PAD_LEFT);?></a></td>
                                                    <td><?php echo $mo['generatedDate'];?></td>
                                                    <td><?php
                                                        $money = $database->getGeneratedAmountOfContract($mo['id']);
                                                        echo $database->convertToMoney($money);


                                                        ?></td>
                                                    <td><?php $vat = 0.05 *$money;
                                                        echo $database->convertToMoney($vat);
                                                        $added = $money + $vat;
                                                        ?></td>
                                                    <td><?php
                                                        echo $database->convertToMoney($added);
                                                        ?>
                                                    </td>

                                                    <td><?php ?></td>
                                                </tr>

                                            <?php } ?>

                                        <?php }else{?>
                                            <tr>
                                                <td colspan="6">NO ORDER  YET</td>

                                            </tr>
                                        <?php } ?>

                                        </tbody>
                                    </table>
                                    <!--<div class="panel-footer text-right"><a href="#" class="btn aqua btn-sm">View All Transactions</a></div> -->
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- tabs -->



        </div>

    </div>
</div>
<!-- Go top -->
<a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>
<!-- Go top -->
<script src="<?php echo $host;?>assets/js/vendor/jquery.min.js"></script>
<!-- bootstrap js -->
<script src="<?php echo $host;?>assets/js/vendor/bootstrap.min.js"></script>
<!-- slimscroll js -->
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jquery.slimscroll.js"></script>
<!-- pace js -->
<script src="<?php echo $host;?>assets/js/vendor/pace/pace.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $host;?>assets/js/vendor/jquery.sparkline.min.js"></script>
<!-- main js -->
<script src="<?php echo $host;?>assets/js/main.js"></script>
</body>
</body>
</html>