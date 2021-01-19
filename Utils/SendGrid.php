<?php
/**
 * Created by PhpStorm.
 * User: Bakar U.A.
 * Date: 10-Dec-19
 * Time: 2:53 PM
 */

class SendGrid
{
    public static $username = 'elastic25';
    public static $password = 'T3n@U!Afric@#2020';
    public static $url = 'https://api.sendgrid.com/';
    public static $supportEmail = 'support.ng@tenaui.com';
    public static $noReplyEmail = 'noreply@tenaui.com';
    public static $apiKey = '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';
    
    public static function stockEmails($grt, $productsData) 
    {
        switch ($grt['transType'])
        {
            case 'RECIEVED':
                $subject = "Received Goods Ticket No. ". $grt['TicketNo'];
                $header = 'GOODS RECEIVED TICKET';
                $footNote = 'Received By';
                $customer = 'SUPPLIER NAME';
                break;
            case 'TRANSFERED':
                $subject = "Transferred Goods Ticket No. ". $grt['TicketNo'];
                $header = 'TRANSFER TICKET';
                $footNote = 'Prepared By';
                $customer = 'RECEIVING STORE';
                break;
            default:
                $subject = "Goods Sold Ticket No. ". $grt['TicketNo'];
                $header = 'SALES INVOICE';
                $footNote = 'Prepared By';
                $customer = 'CUSTOMER NAME';
                break;
        }
        //Send Emails
        $N = 1;
        $j =0;

        $table = "<table width='80%' align='center'  border=0>
        <tr>
            <th colspan='2'>";
                        $table.= "<h2>$header</h2>"; 
            $table.="</th>
        </tr>

        <tr>
            <td>
                <b>INVOICE NO:</b>" . $grt['invoiceNo'] . "<br/>
                <b>INVOICE DATE:</b>". $grt['invoiceDate'] ."<br/>
                <b>$customer:</b>". $grt['supplierID'] ."<br/>
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
                  <th colspan='8' style='text-align: center'>$footNote:" . $grt['fullname']."</th>
                </tr>
                
            </table>";
            
            // use actual sendgrid username and password in this section
            $url = SendGrid::$url;
            $user = SendGrid::$username; // place SG username here
            $pass = SendGrid::$password; // place SG password here
            $primaryEmail = 'talal@tenaui.com';
            $supportEmail = SendGrid::$supportEmail;
            $copyEmails = array('islamyoussry@tenaui.com', 'kemi@tenaui.com', "$supportEmail", 'rukayat@tenaui.com', 'uthman@tenaui.com', 'rukayya@tenaui.com', 'ramez@tenaui.com', 'tastore@tenaui.com');

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
                'to'        => "$primaryEmail",
                'replyto'   => self::$noReplyEmail,
                'cc'        => "islamyoussry@tenaui.com",
                'subject'   => "$subject", // Either give a subject for each submission, or set to $subject
                'html'      => "<html lang='en'><head><meta http-equiv=\"Content-Type\" content=\"text/html\"; charset=\"utf-8\"><title>$subject</title></head><body>
$table </body></html>", // Set HTML here.  Will still need to make sure to reference post data names
                'text'      => "$table",
                'from'      => self::$noReplyEmail, // set from address here, it can really be anything
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