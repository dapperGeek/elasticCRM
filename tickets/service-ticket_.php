<?php
include("../data/DBConfig.php");
include_once("../data/sessioncheck.php");

    $yr_ = date("Y");

    $ticketID = $database->test_input($_GET['id']);
    $ticket = $database->getServiceTicket($ticketID);
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

    body { box-sizing: border-box; height: auto; margin: 0 auto; overflow: hidden; padding: 0.5in; width: 8.5in; }
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
    <h1>SERVICE TICKET</h1>

    <address contenteditable><br/>

        <p>51, Allen Avenue, Ikeja<br>Lagos, Nigeria</p>
        <p>+2348023553203 , +2348101173838</p>
        <p><b><i>support.ng@tenaui.com</i></b></p>
        <p>www.tenauiafrica.com</p>
        <strong>Ticket Opened by :<?php echo $database->getMyUserInformation($ticket['openedBy'])['fullname'];?></strong>
    </address>

    <span><img alt="" src="<?php echo $host;?>img/tenaui-logo.jpg" width="70"><br/><img alt="" src="<?php echo $host;?>img/canon_logo.png" height="20" width="70"><br/></span>
</header>
<article>

    <table >
        <tr>
            <th><span contenteditable>Invoice #</span></th>
            <td><span contenteditable><?php echo $ticket['ticketNo'];?></span></td>
            <th><span contenteditable>Opened Date</span></th>
            <td><span contenteditable><?php echo $ticket['openedDateTime'];?></span></td>
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
            <th><span contenteditable>Model</span></th>
            <td><span contenteditable><?php echo $ticket['machineBrand'];?></span></td>
        </tr>
        <tr>
            <th><span contenteditable>Contract Type</span></th>
            <td><span id="prefix" contenteditable><?php echo $ticket['contract'];?></span></td>
            <th><span contenteditable>Engineer Assigned</span></th>
            <td><span id="prefix" contenteditable><?php echo $database->getMyUserInformation($ticket['engineer'])['fullname'];?></span></td>
        </tr>

        <tr>
            <th><span contenteditable>Meter Reading</span></th>
            <td colspan="3"><span contenteditable><?php echo $ticket['meterReading'];?></span></td>
        </tr>

        <tr>
            <th><span contenteditable>Colour</span></th>
            <td><span id="prefix" contenteditable><?php echo $ticket['colour'];?></span></td>
            <th><span contenteditable>Mono</span></th>
            <td><span id="prefix" contenteditable><?php echo $ticket['Mono'];?></span></td>
        </tr>
    </table>
    <br/>
    <table class="inventory">
        <thead>
        <tr>
            <th colspan="2"><span contenteditable>Issue Logged</span></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            $issues = explode(",",$ticket['issues']);
            $i = 0;
                foreach($issues as $iss)
                {
                    if($iss == "")
                    {
                        continue;
                    }
            ?>
            <td><?php echo $database->getIssueWithId($iss)['issues'];?></td>

            <?php  
                    if($i % 2 != 0 && $i != 0)
                    { 
            ?>
        </tr><tr>
            <?php       
                    }  
                    $i++; 
                }  
            ?>

        </tr>

        </tbody>
    </table>
    <table>
        <tr>
            <th><span contenteditable>Service Cost</span></th>
            <td>
                <span id="prefix" contenteditable>
                    <?php 
                        echo $database->convertToMoney($act['cost']);
                    ?>
                </span>
            </td>
        </tr>
    </table>
    <p>&nbsp;</p>

    <u>Work Description/Solution Provided</u>
    <textarea class="inventory"  rows="12"  style=" width:100%; border: solid"><?php echo strip_tags(nl2br($ticket['workDone']));?>
               </textarea>

    <table class="inventory">
        <thead>
        <tr>
            <th style="width: 5%"><span contenteditable>S/N</span></th>
            <th style="width: 50%"><span contenteditable>Part Name</span></th>
            <th style="width: 15%"><span contenteditable>Part No</span></th>
            <th style="width: 15%"><span contenteditable>Qty</span></th>
            <!--<th style="width: 5%"><span contenteditable>PriceQty</span></th>
            <th style="width: 20%"><span contenteditable>Amount</span></th> -->
        </tr>
        </thead>
        <tbody>
        <?php
        for($i=0;$i <3; $i++){
            ?>
            <tr>
                <td><span contenteditable>&nbsp;</span></td>
                <td><span contenteditable>&nbsp;</span></td>
                <td><span contenteditable>&nbsp;</span></td>
                <td><span contenteditable>&nbsp;</span></td>
                <!--  <td><span contenteditable></span></td>
                  <td><span data-prefix></span></td>-->
            </tr>
        <?php }?>

        </tbody>
    </table>

    <table class="balance2">
        <tr>
            <th><span contenteditable>Scheduled Date</span></th>
            <td><?php echo $ticket['schDate'];?></td>
        </tr>
        <tr>
            <th><span contenteditable>Scheduled Time</span></th>
            <td><span data-prefix>

                        </span><?php echo $ticket['schTime'];?></td>
        </tr>

    </table>
    <table class="balance">
        <tr>
            <th><span contenteditable>Start Time</span></th>
            <td><span data-prefix></span></td>
        </tr>
        <tr>
            <th><span contenteditable>Finish Time</span></th>
            <td><span data-prefix>

                        </span></td>
        </tr>

    </table>
    <br/>

    <table >

        <tr>

            <td><p style="text-align: left"><BR/>CUSTOMER NAME:</p></td>
            <td rowspan="2"><p style="text-align: left"><b><u>CUSTOMER SIGNATURE & DATE:</u></b></p><p style="text-align: center">&nbsp;</p></td>

        </tr>
        <tr>

            <td><p style="text-align: left; color: red; font-style: bold"><BR/>CUSTOMER SHOULD RATE THE ENGINEER'S SERVICE</p></td>

        </tr>
    </table>
    <table>
        <tr>
            <td><p style="color: black">EXCELLENT - 5</p></td>
            <td><p style="color: black">VERY GOOD - 4</p></td>
            <td><p style="color: black">GOOD - 3</p></td>
            <td><p style="color: orange">FAIR - 2</p></td>
            <td><p style="color: red">POOR - 1</p></td>
            <td><p style="color: red">VERY POOR - 0</p></td>
        </tr>
    </table>
</article>

</body>
</html>