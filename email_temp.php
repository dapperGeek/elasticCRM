<?php

$url = 'https://api.sendgrid.com/'; 
	$user = 'elastic25'; // place SG username here
	$pass = 'Bonke@4445'; // place SG password here

	$name ="adebola"; 
	$email = "kolade.bello@tenaui.com"; 
	$subject ="Oluyemi"; 
	
                                      $token = 123;

    $link = 'http://demos.eggslab.net/forgot-password-recovery-script/forget.php?email='.$email.'&token='.$token;

$message = "<p>You have requested for your password recovery. <a href='$link' target='_blank'>Click here</a> to reset your password.</p> 
<p>If you are unable to click the link then copy the below link and paste in your browser to reset your password<br><i>$link</i></p> ";

	 if ($name=='' OR $email=='' OR $message=='')  {
               
                                  	echo "<h1><script>alert('Please fill in the required field')</script></h1>";
                                  	exit();
                                  }

	// note the above parameters now referenced in the 'subject', 'html', and 'text' sections
	// make the to email be your own address or where ever you would like the contact form info sent

	$json_string = array(

	  'to' => array(
	'kolade.bello@tenaui.com'
	),
	  'category' => 'test_category'
	);




	$params = array(
	    'api_user'  => "$user",
	    'api_key'   => "$pass",
	    'x-smtpapi' => json_encode($json_string),
	    'to'        => "kolade.bello@tenaui.com",
	    'replyto'        => "$email",
	    'subject'   => "Password Recovery Instruction", // Either give a subject for each submission, or set to $subject
	    'html'      => "<html><head><title>Contact Form</title><body>
	    
	    Dear, $subject\n<br>
	     $message <body></title></head></html>", // Set HTML here.  Will still need to make sure to reference post data names
	    'text'      => "
	   
	    Dear, $subject\n
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
		//echo "<script>alert('Your Message has been Sent successfull thank.')</script>";
		//	echo "<script>window.open('index.html','_self')</script>";
	//	exit();
		// print everything out
		print_r($response);


?>