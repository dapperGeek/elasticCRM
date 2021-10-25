<<<<<<< HEAD
<?php
 
    if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0)
    {
       $user_id = $_SESSION['user_id'];
       $myData = $database->getMyUserInformation($user_id);
    }
    else
    {
       $database->redirect_to($host."login");
    }
=======
 <?php 
 
 if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0){
	$user_id = $_SESSION['user_id'];
    $myData = $database->getMyUserInformation($user_id);
  }else{
  	$database->redirect_to($host."login");
  }
>>>>>>> 48136f1b63a2e7fb659fed72c5bf93f60ec79592
