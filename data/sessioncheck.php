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