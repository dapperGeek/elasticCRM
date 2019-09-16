<?php
    include("../data/DBConfig.php");
    include_once("../data/sessioncheck.php");

    $yr_ = date("Y");
     $vat = 0;
    if(!isset($_GET['id'])){$database->redirect_to($host);}
    $ticketID = $database->test_input($_GET['id']);
    $ticket = $database->getPurchaseTicket($ticketID);
    if($ticket == null){
        $database->redirect_to($host);
    }
     $sof = $ticket['orderCollect'];
    if($sof == 1){
        $vat = $ticket['vat'];
    }else if(isset($_GET['vat'])){
        $vat= $database->test_input($_GET['vat']);
    }


?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Invoice</title>
        <!--<link href="<?php echo $host;?>css/bootstrap.min.css" rel="stylesheet">  -->
    </head>
    <body>


    <style>
    /* reset */

*
{
    border: 0;
    box-sizing: content-box;
    color: inherit;
    font-family: inherit;
    font-size: inherit;
    font-style: inherit;
    font-weight: inherit;
    line-height: inherit;
    list-style: none;
    margin: 0;
    padding: 0;
    text-decoration: none;
    vertical-align: top;
}

/* content editable */

*[contenteditable] { border-radius: 0.25em; min-width: 1em; outline: 0; }

*[contenteditable] { cursor: pointer; }

*[contenteditable]:hover, *[contenteditable]:focus, td:hover *[contenteditable], td:focus *[contenteditable], img.hover { background: #DEF; box-shadow: 0 0 1em 0.5em #DEF; }

span[contenteditable] { display: inline-block; }

/* heading */

h1 { font: bold 100% sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; }

/* table */

table { font-size: 75%; table-layout: fixed; width: 100%; }
table { border-collapse: separate; border-spacing: 0.5px; }
th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; }
th, td { border-radius: 0.25em; border-style: solid; }
th { background: #EEE; border-color: #BBB; }
td { border-color: #DDD; }

/* page */

html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; }
html { background: #999; cursor: default; }

body { box-sizing: border-box; height: 11in; margin: 0 auto; overflow: hidden; padding: 0.5in; width: 8.5in; }
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

/* header */

header { margin: 0 0 0; }
header:after { clear: both; content: ""; display: table; }

header h1 { background: #000; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; }
header address { float: left; font-size: 75%; font-style: normal; line-height: 1.25em; margin: 0 1em 1em 0; }
header address p { margin: 0 0 0.25em; }
header span, header img { display: block; float: right; }
header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
header img { max-height: 100%; max-width: 100%; }
header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }

/* article */

article, article address, table.meta, table.inventory { margin: 0 0 2em; }
article:after { clear: both; content: ""; display: table; }
article h1 { clip: rect(0 0 0 0); position: absolute; }

article address { float: left; font-size: 125%; font-weight: bold; }

/* table meta & balance */

table.meta, table.balance { float: right; width: 36%; }
table.meta:after, table.balance:after { clear: both; content: ""; display: table; }

table.meta, table.balance2 { float: left; width: 60%; }
table.meta:after, table.balance2:after { clear: both; content: ""; display: table; }

/* table meta */

table.meta th { width: 40%; }
table.meta td { width: 60%; }

/* table items */

table.inventory { clear: both; width: 100%; }
table.inventory th { font-weight: bold; text-align: center; }
table.inventory th:nth-child-1{
    width: 70%;
}

table.inventory td:nth-child(1) { width: 26%; }
table.inventory td:nth-child(2) { width: 38%; }
table.inventory td:nth-child(3) { text-align: right; width: 12%; }
table.inventory td:nth-child(4) { text-align: right; width: 12%; }
table.inventory td:nth-child(5) { text-align: right; width: 12%; }

/* table balance */

table.balance th, table.balance td { width: 50%; }
table.balance td { text-align: right; }
table.balance2 th, table.balance2 td { width: 30%; }
table.balance td { text-align: left; }

/* aside */

aside h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em; }
aside h1 { border-color: #999; border-bottom-style: solid; }

/* javascript */

.add, .cut
{
    border-width: 1px;
    display: block;
    font-size: .8rem;
    padding: 0.25em 0.5em;
    float: left;
    text-align: center;
    width: 0.6em;
}

.add, .cut
{
    background: #9AF;
    box-shadow: 0 1px 2px rgba(0,0,0,0.2);
    background-image: -moz-linear-gradient(#00ADEE 5%, #0078A5 100%);
    background-image: -webkit-linear-gradient(#00ADEE 5%, #0078A5 100%);
    border-radius: 0.5em;
    border-color: #0076A3;
    color: #FFF;
    cursor: pointer;
    font-weight: bold;
    text-shadow: 0 -1px 2px rgba(0,0,0,0.333);
}

.add { margin: -2.5em 0 0; }

.add:hover { background: #00ADEE; }

.cut { opacity: 0; position: absolute; top: 0; left: -1.5em; }
.cut { -webkit-transition: opacity 100ms ease-in; }

tr:hover .cut { opacity: 1; }

@media print {
    * { -webkit-print-color-adjust: exact; }
    html { background: none; padding: 0; }
    body { box-shadow: none; margin: 0; }
    span:empty { display: none; }
    .add, .cut { display: none; }
    header h1 { background: #000; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; }

}

@page { margin: 0; }
    </style>
        <header>
            <h1><?php if($sof==1){echo 'SUPPLY TICKET';}else{echo 'PROFOMA INVOICE';}?></h1>
            <h3>Tenaui Africa Limited</h3>
            <address contenteditable>

                <p>51, Allen Avenue, Ikeja<br>Lagos, Nigeria</p>
                <p>+2348023553203 , +2348101173838</p>
                <p><b><i>support.ng@tenaui.com</i></b></p>
                <p>www.tenauiafrica.com</p>
                <strong>Generated By :<?php echo $database->getMyUserInformation($ticket['adminID'])['fullname'];?></strong>
            </address>

           <span><img alt="" src="<?php echo $host;?>img/tenaui-logo.jpg" width="70"><br/><img alt="" src="<?php echo $host;?>img/canon_logo.png" height="20" width="70"><br/></span>

        </header>
        <article>

             <table >
                <tr>
                    <th><span contenteditable>Supply #</span></th>
                    <td><span contenteditable><?php echo $ticket['ticketNo'];?></span></td>
                     <th><span contenteditable>Order Collected</span></th>
                    <td><span contenteditable><?php echo $ticket['orderCollectedDate'];?></span></td>
                </tr>
                 <tr>
                    <th><span contenteditable>Account Name</span></th>
                    <td colspan="3"><span contenteditable><?php echo $ticket['AccountName'];?></span></td>
                </tr>
                <tr>
                    <th><span contenteditable>Address</span></th>
                    <td colspan="3"><span contenteditable><?php echo $ticket['Address'].", ".$ticket['areaname'].", ".$ticket["lga"]." L.G.A, ".$ticket['state'];?></span></td>
                </tr>
                <tr>
                    <th><span contenteditable>Machine Code</span></th>
                    <td><span contenteditable><?php echo $ticket['machine_code'];?></span></td>
                     <th><span contenteditable>Machine Model</span></th>
                    <td><span contenteditable><?php echo $ticket['machineBrand'];?></span></td>
                </tr>
                <tr>
                     <th><span contenteditable>Contract Type</span></th>
                    <td><span id="prefix" contenteditable><?php echo $ticket['contract'];?></span></td>
                    <th><span contenteditable>Payment Mode</span></th>
                    <td><span id="prefix" contenteditable><?php echo $ticket['paymentmode'];?></span></td> 
                </tr>
            </table>
                <br/><hr/>
            <table class="inventory">
                <thead>
                    <tr>
                        <th style="width: 40%"><span contenteditable>Item</span></th>
                        <th style="width: 25%"><span contenteditable>Code</span></th>
                        <th style="width: 15%"><span contenteditable>Rate</span></th>
                        <th style="width: 5%"><span contenteditable>Qty</span></th>
                        <th style="width: 20%"><span contenteditable>Price</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                     $amounted = 0;


                            $salesorder = (array)$database->getPurchaseProductOrderCall($ticket['id']);
                            foreach ($salesorder as $order) {
                    ?>
                    <tr>
                        <td><span contenteditable><?php echo $order['productName'];?><?php if($order['ProductType']>1){echo " - ".$order['color'];}?></span></td>
                        <td><span contenteditable><?php echo $order['Code'];?></span></td>
                        <td><span data-prefix> <?php echo $database->convertToMoney($order['Amount']);?></span></td>
                        <td><span contenteditable><?php echo $order['qty'];?></span></td>
                        <td><span data-prefix><?php
                                                $amount_ = $order['qty'] * $order['Amount'];
                                        echo $database->convertToMoney($amount_);?></span></td>
                    </tr>
                     <?php $amounted += $amount_;}?>

                </tbody>
            </table>
           <div class="row">

               <table class="balance2">
                <tr>
                    <th><span contenteditable>Payment Terms</span></th>
                    <td></td>
                </tr>

            </table>
            <table class="balance">
                  <tr>
                    <th><span contenteditable>SERVICE CHARGE</span></th>
                    <td><span data-prefix>
                       <?php
                        $sc = $ticket['svc'];

                        echo $database->convertToMoney($sc);
                        ?>
                        </span></td>
                </tr>

                <tr>
                    <th><span contenteditable>SUBTOTAL</span></th>
                    <td><span data-prefix>
                        <?php
                             $sub_total =($amounted)+$sc;

                             echo  $database->convertToMoney($sub_total);
                        ?>
                        </span></td>
                </tr>
               
                  <tr>
                     <?php 
                      $vatValue = 0;
                     $added = $sub_total + $vatValue;?>
                    <th><span contenteditable>DISCOUNT <?php echo $ticket['discount'];?>%</span></th>
                    <td><span data-prefix>
                       <?php
                                        $disc = (($ticket['discount']/100) *  $added);
                                     echo $database->convertToMoney($disc);

                                             ?>
                        </span></td>
                </tr>


                 <tr>
                    <th><span contenteditable>VAT</span></th>
                    <td><span data-prefix>
                        <?php
                         $ServiceChargeWithVAT =  $sub_total;
                        $vatValue = 0;
                        if($vat == 0){$vatValue == 0;}else{$vatValue = 0.05 * $ServiceChargeWithVAT ;}
                             echo  $database->convertToMoney($vatValue);
                        ?>
                        <?php $added = $sub_total + $vatValue;?>
                        </span></td>
                </tr>
              
                <tr>
                    <th><span contenteditable>Total Amount</span></th>
                    <td><span data-prefix>
                        <?php
                            $dis = $added - $disc ;
                            echo $database->convertToMoney($dis);

                        ?>
                                                 
                                             </span></td>
                </tr>
            </table>

     </div>
        </article>
      <table>
          <tr>
              <td colspan="2">
                  <p style="text-align: center">
                  <b>Amount in words :</b> <?php echo ucwords($database->convert_number_to_words($dis));?> Naira Only
                   </p>
              </td>
          </tr>

      </table>
    </body>
</html>