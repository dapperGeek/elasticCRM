<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from adminui-v1.0.bittyfox.com/default/aqua-black/forgot_password.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Jul 2017 15:57:32 GMT -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Elastic25</title>
	<!-- Bootstrap -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<!-- slimscroll -->
	<link href="assets/css/jquery.slimscroll.css" rel="stylesheet">
	<!-- Fontes -->
	<link href="assets/css/font-awesome.min.css" rel="stylesheet">
	<link href="assets/css/simple-line-icons.css" rel="stylesheet">
	<!-- all buttons css -->
	<link href="assets/css/buttons.css" rel="stylesheet">
	<!-- animate css -->
<link href="assets/css/animate.css" rel="stylesheet">
<!-- top nev css -->
<link href="assets/css/page-header.css" rel="stylesheet">
<!-- adminui main css -->
	<link href="assets/css/main.css" rel="stylesheet">
	<!-- aqua black theme css -->
	<link href="assets/css/aqua-black.css" rel="stylesheet">
	<!-- media css for responsive  -->
	<link href="assets/css/main.media.css" rel="stylesheet">
	<!--[if lt IE 9]> <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
	<!--[if lt IE 9]> <script src="dist/html5shiv.js"></script> <![endif]-->
</head>

<body class="aqua-bg  login">
	<div class="logo">
		<a href="index.php"> <img src="assets/images/w-logo.png" alt=""> </a>
	</div>
	<div class="passwordBox">
		<div class="row">
			<div class="col-md-12">
				<div class="widgets-container">
					<h2 class="font-bold">Forgot password</h2>
					<?php include("data/MySQLDatabase.php");
                      include("data/DBConfig.php");
?>

               <?php
                      



                     if (isset($_POST['forget_password'])) {

                 $database->ForgetPasswor($_POST['forget_password']);

                       
 
                          } ?>
					<p> Enter your email address and your password will be reset and emailed to you. </p>
					<div class="row">
						<div class="col-lg-12">
							<form action="" method="POST" class="top15">


								<div class="form-group">
									<input type="email" name="change_pass" required="" placeholder="Email address" class="form-control">
								</div>
								<button name="forget_password" class="btn aqua block bottom15" type="submit">Send new password</button>
								<a href="login.php" class="btn aqua btn-outline pull-right ">Back</a>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 login-copyright"> <strong>Copyright</strong> Elastic25 &copy; 2017-<?php echo date('Y');?> </div>
		</div>
	</div>
</body>


<!-- Mirrored from adminui-v1.0.bittyfox.com/default/aqua-black/forgot_password.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Jul 2017 15:57:32 GMT -->
</html>