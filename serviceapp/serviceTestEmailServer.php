
<p>HIa and a good day </p>

<?php
    include("../data/DBConfig.php");
    include_once("../data/sessioncheck.php");
    $yr_ = date("Y");

if($myData['changePass'] == 0){
    //  $database->redirect_to($host."change-password");
}
?>



        <?php
                            $message = "added a new service call for   : <a href='".$this->host."machine-info/".$machineID."'></a>".$machineName. "</a> assigned to <a href='".$this->host."account-info/".$accountID."'>".$accountName."</a>";

 $email = "support.ng@tenaui.com";

 $subject = "Service Call For BELLO KOLADE With Ticket No ADBGS-TEN-2773";

$message = "Dear engineer Lawerence,  \n<br> Please be informed that a service call has been assigned to you. You are to visit $accountName custormer for service. \n<br> Kindly find details in the service ticket. \n<br> \n<br> Please do not reply to this email, this address is not monitored. Please Contact customer care.";
                                    // use actual sendgrid username and password in this section
  $url = 'https://api.sendgrid.com/'; 
  $user = 'elastic25'; // place SG username here
  $pass = 'Bonke@4445'; // place SG password here

 // note the above parameters now referenced in the 'subject', 'html', and 'text' sections
    // make the to email be your own address or where ever you would like the contact form info sent

    $json_string = array(

      'to' => array($engineerEmail,'kolade.bello@tenaui.com'
    ),
      'category' => 'test_category'
    );

    $params = array(
        'api_user'  => "$user",
        'api_key'   => "$pass",
        'x-smtpapi' => json_encode($json_string),
        'to'        => "suppport.ng@tenaui.com",
        'replyto'        => "",
        'subject'   => "$subject", // Either give a subject for each submission, or set to $subject
        'html'      => "<html><head><title>Contact Form</title><body>
        $message <body></title></head></html>", // Set HTML here.  Will still need to make sure to reference post data names
        'text'      => "
       
        $message",
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
      
 
       

        
   



     echo "Email sent successfully";


                        ?>
           