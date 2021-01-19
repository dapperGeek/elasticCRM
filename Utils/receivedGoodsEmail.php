<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

                $email = "abuja_office_accounts@tenaui.com";
                $subject = "SOF from ABUJA With Ticket No $lastSellProductStockOrderTicketNo";

                $html ="<p name='mydata'> good \n";
                //$html.= htmlspecialchars($data)."\n";
                $html.= "</p>";
?>

<table width="80%" align="center"  border=0>
    <tr>
        <th colspan="2"><h2> GOODS RECEIVED TICKET</h2></th>
    </tr>
    <tr>
        <td>
            <b>INVOICE NO:</b> <?php echo $grt['invoiceNo'];?><br/>
            <b>INVOICE DATE:</b> <?php echo $grt['invoiceDate'];?> <br/>
            <b>SUPPLIER NAME:</b> <?php echo $grt['supplierName'];?><br/>
            <b>FILE REFERENCE:</b> <?php echo $grt['FileReference'];?><br/>
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
        <th colspan="7" style="text-align: center"> ITEMS</th>
    </tr>
    <tr>
        <th>S/N</th>
        <th colspan="2">PRODUCT </th>
        <th>QTY</th>
        <th>CODE</th>
        <th>UNIT </th>
        <th colspan="2">REMARKS</th>

    </tr>

    <?php
    $myCollect = (array)$database->getAllGoodsAddedForRecieve($id);
    $N = 1;
    foreach($myCollect as $mc){
        ?>
        <tr>
            <th><?php echo $N;?></th>
            <td colspan="2" align="center"><?php echo $mc['productName'];?> </td>
            <td align="center"><?php echo $mc['AddedQty'];?></td>
            <td align="center"><?php echo $mc['Code'];?></td>
            <td align="center"><?php echo $mc['unitName'];?> </td>
            <td colspan="2"></td>

        </tr>

        <?php $N++;}?>
    <tr>
        <th colspan="7" style="text-align: center">PREPARE BY : <?php echo $grt['fullname'];?></th>
    </tr>


</table>

<?php
    $table = "<table width='80%' align='center'  border=0>
    <tr>
        <th colspan='2'>";

                if ($grt['invoiceNo'] == "TRANSFER")
                {
                    $table.= "<h2>TRANSFER TICKET</h2>";
                }
                else
                { 
                    $table.= "<h2>ELECTRONIC SOF</h2>"; 

                }

                $table.="</th>
    </tr>
    
    <tr>
        <td>
            <b>DATE:</b>".$grt['invoiceDate']. "<br/>
            <b>CUSTOMER NAME:</b>".$grt['supplierID']. "<br/>
            <b>DELIVERY ADDRESS:</b>".$grt['FileReference']."<br/>
            <b>ORDER ID:</b>".str_pad($grt['id'],5,"0",STR_PAD_LEFT)."<br/>
            <b>TICKET NO:</b>".$grt['TicketNo']."<br/>
            <b>SERIAL NO:</b>".$grt['serialNumber']."<br/>
            <b>STORE:</b>".$grt['storeName']."<br/>
        </td>
    
        <td align='right'><img src='http://elastic250.com/img/tenaui-logo.jpg' width='100' height='100'></td>
    </tr>
</table>";

    $table.= "<table border=1 style='width:80%;font-size:13px' align='center' cellpadding='2' cellspacing='0'>

 <tr>
    <th colspan='8' style='background-color: #CCCCCC;text-align: center'> COMMODITY DESCRIPTION</th>
 </tr>
       <tr>
           <th>S/N</th>
              <th colspan='2'>PRODUCT </th>
               <th>Code </th>
              <th>QTY</th>
              <th>PRICE</th>
              <th>UNIT </th>
           <th colspan='2'>AMOUNT</th>

      </tr>";
            
            $myCollect = (array)$database->getAllGoodsAddedForRecieve($lastSellProductStockOrderId);
            $N = 1;
            $j =0;
           
            foreach($myCollect as $mc)
            {
                $table.= " <tr>
                <th>".$N."</th>
                <td colspan='2' align='center'>".$mc['productName']."</td>
                <td  align='center'>".$mc['Code']."</td>
                <td align='center'>".$mc['AddedQty']."</td>
                <td align='center'>". number_format(UtilFunctions::removeComma($eachUnitPrice[$j]), 2)."</td>
                <td align='center'>".$mc['unitName']."</td>
                <td align='center' colspan='2'><b>N<b>".number_format(UtilFunctions::removeComma($eachAmount[$j]), 2)."</td>
                </tr>";

                $N++;
                $j++;
            }

            $table.= 
                "<tr>
                    <th colspan='7' style='text-align: center'><b>TOTAL</b></th>
                    <th><b>N<b>" .number_format(UtilFunctions::removeComma($totalAmount), 2) . "</th>
                </tr>
        
                <tr>
                  <th colspan='8' style='text-align: center'>&nbsp;</th>
                </tr>
                
                <tr>
                  <th colspan='8' style='text-align: center'>PREPARE BY :".$grt['fullname']."</th>
                </tr>
                
                <tr>
                  <th colspan='8' style='text-align: center'>&nbsp;</th>
                </tr>
            </table>";

            // use actual sendgrid username and password in this section
            $url = SendGrid::$url;
            $user = SendGrid::$username; // place SG username here
            $pass = SendGrid::$password; // place SG password here
            $userId = $_SESSION['user_id'];
//                $copyEmails = array('talal@tenaui.com','islamyoussry@tenaui.com','kemi@tenaui.com','rukayat@tenaui.com','uthman@tenaui.com');
            $copyEmails = array('uthman@tenaui.com');
            $myUserDetails = $database->getSingleUserInformation($userId);
            $ccEmail = 'uthman@tenaui.com';

            $devEmail = 'uthmanb@outlook.com';
            $devCopyEmails = array('uthmanb@outlook.com', 'budrhymes@gmail.com');

            //exit;
            // note the above parameters now referenced in the 'subject', 'html', and 'text' sections
            // make the to email be your own address or where ever you would like the contact form info sent

            $json_string = array(
                'to' => $copyEmails,
                'category' => 'test_category'
            );

            $params = array(
                'api_user'  => "$user",
                'api_key'   => "$pass",
                'x-smtpapi' => json_encode($json_string),
                'to'        => "$ccEmail",
                'replyto'   => "$email",
                'cc'        => "$ccEmail",
                'subject'   => "$subject", // Either give a subject for each submission, or set to $subject
                'html'      => "<html lang='en'><head><meta http-equiv=\"Content-Type\" content=\"text/html\"; charset=\"utf-8\"><title>$subject</title></head><body>
$table </body></html>", // Set HTML here.  Will still need to make sure to reference post data names
                'text'      => "$table",
                'from'      => $email, // set from address here, it can really be anything
            );

            $request =  $url.'api/mail.send.json';
            // Generate curl request
            $session = curl_init($request);
            // set the curl SSL version
            curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
            // Tell curl to use HTTP POST
            curl_setopt ($session, CURLOPT_POST, true);
            // Tell curl that this is the body of the POST
            curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
            // Tell curl not to return headers, but do return the response
            curl_setopt($session, CURLOPT_HEADER, false);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
            // obtain response
            curl_exec($session);
            curl_close($session);

            // print everything out
            // print_r($response);
