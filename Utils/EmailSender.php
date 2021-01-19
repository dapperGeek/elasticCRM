<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmailSender
 *
 * @author DapperGeek0
 */
class EmailSender {
    public $transcationDetails;
    private $noReply = 'noreply@tenaui.com' ;


    public function __construct()
    {
        
    }
    
    public function stockEmails() 
    {
                    //Send Emails
            $email = $this->noReply;
            $subject = "Received Goods Ticket No. ". $grt['TicketNo'];
            $N = 1;
            $j =0;

//            $html ="<p name='mydata'> good \n";
            //$html.= htmlspecialchars($data)."\n";
//            $html.= "</p>";
            
            $table = "<table width='80%' align='center'  border=0>
    <tr>
        <th colspan='2'>";
                    $table.= "<h2>GOODS RECEIVED TICKET</h2>"; 
        $table.="</th>
    </tr>
    
    <tr>
        <td>
            <b>INVOICE NO:</b>" . $grt['invoiceNo'] . "<br/>
            <b>INVOICE DATE:</b>". $grt['invoiceDate'] ."<br/>
            <b>SUPPLIER NAME:</b>". $grt['supplierName'] ."<br/>
            <b> FILE REFERENCE:</b>". $grt['FileReference'] ."<br/>
            <b>ORDER ID:</b>". $grt['id'] ."<br/>
            <b>TICKET NO:</b>". $grt['TicketNo'] ."<br/>
            <b>SERIAL NO:</b>". $grt['serialNumber'] ."<br/>
            <b>STORE:</b>". $grt['storeName'] ."<br/>
        </td>
    
        <td align='right'><img src='https://elastic250.com/img/tenaui-logo.png' width='100' height='100'></td>
    </tr>
        </table><br/><br/>";

        $table.= "<table border=1 style='width:80%;font-size:13px' align='center' cellpadding='2' cellspacing='0'>
                    <tr>
                       <th colspan='8' style='background-color: #CCCCCC;text-align: center'> COMMODITY DESCRIPTION</th>
                    </tr>

                    <tr>
                        <th>S/N</th>
                        <th colspan='2'> PRODUCT </th>
                        <th>QTY</th>
                        <th>CODE</th>
                   </tr>";
        
//            for ($i = 0; $i < $count; $i++)
            foreach ($productsData as $data)
            {
                $table.= " <tr>
                <td>".$N."</td>
                <td colspan='2' align='left' style='padding-left:15px'>". $data['productName'] ."</td>
                <td  align='center'>". sprintf("%u %s", $data['AddedQty'], $data['unitName']) ."</td>
                <td  align='center'>".$data['Code'] ."</td>
                </tr>";

                $N++;
                $j++;
            }
            
            $table.= "<tr>
                  <th colspan='8' style='text-align: center'>RECEIVED BY :". $grt['fullname']."</th>
                </tr>
                
            </table>";
            
//            $table = "This is the email body";
            
            // use actual sendgrid username and password in this section
            $url = SendGrid::$url;
            $user = SendGrid::$username; // place SG username here
            $pass = SendGrid::$password; // place SG password here
//            $copyEmails = array('talal@tenaui.com','islamyoussry@tenaui.com','kemi@tenaui.com','rukayat@tenaui.com','uthman@tenaui.com', 'rukayya@tenaui.com');
            $copyEmails = array('uthman@tenaui.com', 'dappergeek0@gmail.com');
            $ccEmail = 'uthmanb@outlook.com';

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
                'to'        => "uthmanb@outlook.com",
                'replyto'   => $this->noReply,
                'cc'        => "uthmanb@outlook.com",
                'subject'   => "$subject", // Either give a subject for each submission, or set to $subject
                'html'      => "<html lang='en'><head><meta http-equiv=\"Content-Type\" content=\"text/html\"; charset=\"utf-8\"><title>$subject</title></head><body>
$table </body></html>", // Set HTML here.  Will still need to make sure to reference post data names
                'text'      => "$table",
                'from'      => $this->noReply, // set from address here, it can really be anything
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

    }
}
