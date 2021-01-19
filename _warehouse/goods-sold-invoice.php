<?php
include("../data/DBConfig.php");
include_once("../data/sessioncheck.php");

if(isset($_SESSION['user_id']) ){
    $totalAmount = isset($_SESSION['product_total_price'])
        ? $_SESSION['product_total_price']
        : 0 ;
    $eachAmount   = isset($_SESSION['amount'])
        ? $_SESSION['amount']
        : 0 ;
    $eachUnitPrice  = isset($_SESSION['unitPrice'])
        ? $_SESSION['unitPrice']
        : 0 ;
}

$id = $database->test_input($_GET['id']);

$grt = $database->getIndGoodsRemovedDeliveryUpdate($id);

if($grt['TicketNo'] == null ){
    $grt = $database->getIndGoodsRemoved($id);
}

$vat = 0;
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tenaui + | We speak by Images</title>

    <!-- Bootstrap -->
    <link href="<?php echo $host;?>assets/css/morris.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="<?php echo $host;?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $host;?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="<?php echo $host;?>assets/css/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $host;?>assets/css/bootstrap-select.min.css" />
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

    <!-- Ion Range Slider -->
    <link rel="stylesheet" href="<?php echo $host;?>assets/css/normalize.css" />
    <link rel="stylesheet" href="<?php echo $host;?>assets/css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="<?php echo $host;?>assets/css/ion.rangeSlider.skinFlat.css" />

</head>

<body class="white-bg">
<a id="printpagebutton2" href="<?php echo $host;?>ticket/<?php echo $grt['id'];?>/<?php echo $vat;?>" class="btn btn-success buttonshow" target="_blank">Convert to PDF </a>


<input id="printpagebutton" type="button" value="Print this page" class="btn btn-success buttonshow" onclick="printpage()"/>

<table width="80%" align="center"  border=0>
    <tr>
        <th colspan="2">
            <?php if ($grt['invoiceNo'] == "TRANSFER")
            {
                echo "<h2>TRANSFER TICKET</h2>";
            }
            else
            { 
                echo "<h2> ELECTRONIC SOF </h2>";

            } ?>
        </th>
    </tr>
    <tr>
        <td>
            <!--<b>INVOICE NO:</b> <?php echo $grt['invoiceNo'];?><br/>-->
            <b>DATE:</b> <?php echo $grt['invoiceDate'];?> <br/>
            <b>CUSTOMER NAME:</b> <?php echo $grt['supplierID'];?><br/>
            <b>DELIVERY ADDRESS:</b> <?php echo $grt['FileReference'];?><br/>
            <b>ORDER ID:</b> <?php echo str_pad($grt['id'],5,"0",STR_PAD_LEFT);?><br/>
            <b>TICKET NO:</b> <?php echo $grt['TicketNo'];?><br/>
            <b>SERIAL NO:</b> <?php echo $grt['serialNumber'];?><br/>
            <b>STORE:</b> <?php echo $grt['storeName'];?><br/>

        </td>
        <td align="right"><img src="../img/tenaui-logo.jpg" width="100" height="100"></td>
    </tr>
</table>
<br/><br/>
<table border=1 style="width:80%;font-size:13px" align="center" cellpadding="2" cellspacing="0">

    <tr>
        <th colspan="8" style=" background-color: #CCCCCC;text-align: center"> COMMODITY DESCRIPTION</th>
    </tr>
    <tr>
        <th style="text-align: center">S/N</th>
        <th style="text-align: center" colspan="2">PRODUCT </th>
        <th style="text-align: center">Code </th>
        <th style="text-align: center">QTY</th>
        <th style="text-align: center">PRICE</th>
        <th style="text-align: center">UNIT </th>
        <th style="text-align: center" colspan="2">AMOUNT</th>

    </tr>

    <?php
    $myCollect = (array)$database->getAllGoodsAddedForRecieve($id);
    $N = 1;
    $j =0;
    $total = 0;
    foreach($myCollect as $mc){
        ?>
        <tr>
            <th style="text-align: center"><?php echo $N;?></th>
            <td colspan="2" align="center"><?php echo $mc['productName'];?> </td>
            <td  align="center"><?php echo $mc['Code'];?> </td>
            <td align="center"><?php echo $mc['AddedQty'];?></td>
            <td align="center"><?php echo number_format($mc['amount'] / $mc['AddedQty'], 2);?></td>
            <td align="center"> <?php echo $mc['unitName'];?> </td>

            <td align="center" colspan="2"><?php echo '<b>N<b>'.number_format($mc['amount'], 2); ?></td>

        </tr>

    <?php
        $total += $mc['amount'];
        $N++;
        $j++;
        }
    ?>

    <tr>
        <th colspan="7" style="text-align: center"><b>TOTAL</b></th>
        <th style="text-align: center"> <?php echo '<b>N<b>'.number_format($total, 2); ?> </th>
    </tr>

    <tr>
        <th colspan="8" style="text-align: center">&nbsp;</th>
    </tr>
    <tr>
        <th colspan="8" style="text-align: center">PREPARE BY : <?php echo $grt['fullname'];?></th>
    </tr>
    <tr>
        <th colspan="8" style="text-align: center">&nbsp;</th>
    </tr>


</table>

<!-- Mainly scripts -->
<script src="<?php echo $host;?>js/jquery-3.1.1.min.js"></script>
<script src="<?php echo $host;?>js/bootstrap.min.js"></script>
<script src="<?php echo $host;?>js/plugins/metisMenu/jquery.metisMenu.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo $host;?>js/inspinia.js"></script>

<script type="text/javascript">
    //window.print();
</script>
<script type="text/javascript">
    function printpage() {
        //Get the print button and put it into a variable
        var printButton = document.getElementById("printpagebutton");
        //Set the print button visibility to 'hidden'
        printButton.style.visibility = 'hidden';
        //Print the page content
        var printButton2 = document.getElementById("printpagebutton2");
        printButton2.style.visibility = 'hidden';
        window.print()
        //Set the print button to 'visible' again
        //[Delete this line if you want it to stay hidden after printing]
        printButton.style.visibility = 'visible';
        printButton2.style.visibility = 'visible';
    }
</script>

</body>

</html>

