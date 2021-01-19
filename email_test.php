<?php






$email = "kolade.bello@tenaui.com";



$subject = "SOF from ABUJA With Ticket No $ticketNo";

$message = "Dear Customer Care, \n<br> Please be informed that a service call has been followed up by engineer  for custormer ticket No \n<br> Kindly find details in the followed up call. \n<br> \n<br> Please do not reply to this email, this address is not monitored. Please Contact customer care.";
    
    $html ="<p name='mydata'> good \n";
     //$html.= htmlspecialchars($data)."\n";
     $html.= "</p>";
     
    $table = "<table width='80%' align='center'  border=0>
    <tr>
        <th colspan='2'>"; 
        
        if ($grt['invoiceNo'] == "TRANSFER") {
          $table.= "<h2>TRANSFER TICKET</h2>";
       }else{ $table.= "<h2>ELECTRONIC SOF</h2>"; } 
       
      $table.="</th>
    </tr>
  <tr>
    <td>
        <b>DATE:</b>".$grt['invoiceDate']. "<br/>
        <b>CUSTOMER NAME:</b>".$grt['supplierID']. "<br/>
        <b>DELIVERY ADDRESS:</b>".$grt['FileReference']."<br/>
        <b>ORDER ID:</b>".str_pad($grt['id'],5,"0",STR_PAD_LEFT)."<br/>
        <b>TICKET NO:</b>".$grt['TicketNo']."<br/>
        <b>STORE:</b>".$grt['storeName']."<br/>
      </td>
    <td align='right'><img src='http://elastic25.com/img/tenaui-logo.jpg' width='100' height='100'></td>
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

      
           // $myCollect = (array)$database->getAllGoodsAddedForRecieve($id);
            $N = 1;
            $j =0;
            //foreach($myCollect as $mc){
            /*for($i=0; $i < 7; $i++) {
                $N++;
                echo $N;
            $j++;}*/
            for($i=0; $i < 7; $i++) {
      $table.= " <tr>
           <th>".$N."</th>
              <td colspan='2' align='center'>".$mc['productName']."</td>
              <td  align='center'>".$mc['Code']."</td>
              <td align='center'>".$mc['AddedQty']."</td>
              <td align='center'>". number_format($eachUnitPrice[$j], 2)."</td>
              <td align='center'>".$mc['unitName']."</td>
              
           <td align='center' colspan='2'><b>N<b>".number_format($eachAmount[$j], 2)."</td>

      </tr>";

           $N++;
            $j++;}
     

           
      
      $table.= "<tr>
          <th colspan='7' style='text-align: center'><b>TOTAL</b></th>
          <th>'<b>N<b>'".number_format($totalAmount, 2)."</th>
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
  $url = 'https://api.sendgrid.com/'; 
  $user = 'elastic25'; // place SG username here
  $pass = 'Bonke@4445'; // place SG password here

 // note the above parameters now referenced in the 'subject', 'html', and 'text' sections
    // make the to email be your own address or where ever you would like the contact form info sent

    $json_string = array(

      'to' => array('kolade.bello@tenaui.com'),
      'category' => 'test_category'
    );

    $params = array(
        'api_user'  => "$user",
        'api_key'   => "$pass",
        'x-smtpapi' => json_encode($json_string),
        'to'        => "$email",
        'replyto'        => "$email",
        'subject'   => "$subject", // Either give a subject for each submission, or set to $subject
        'html'      => "<html><head><title>Contact Form</title><body>
        $table <body></title></head></html>", // Set HTML here.  Will still need to make sure to reference post data names
        'text'      => "
       
        $table",
        'from'      => $email, // set from address here, it can really be anything
      );

        curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        $request =  $url.'api/mail.send.json';
        // Generate curl request
        $session = curl_init($request);
        // Tell curl to use HTTP POST
        curl_setopt ($session, CURLOPT_POST, true);
        // Tell curl that this is the body of the POST
        curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        // obtain response
        $response = curl_exec($session);
        curl_close($session);
        // Redirect to thank you page upon successfull completion, will want to build one if you don't alreday have one available
      //$this->createActivityNotifications($message,$mID,$aID);

        // print everything out
        print_r($response);












?>