<?php include("data/DBConfig.php");?>
<?php
$url = "";
        if(isset($_GET['url'])){
                $url = $_GET['url'];
        }else{
                $url = $host;
        }
if(isset($_SESSION['user_id'])){
                $database->redirect_to($url);
            }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Elastic 250</title>
<!-- Bootstrap -->
<link href="<?php echo $host;?>assets/css/bootstrap.min.css" rel="stylesheet">
<!-- slimscroll -->
<link href="<?php echo $host;?>assets/css/jquery.slimscroll.css" rel="stylesheet">
<!-- Fontes -->
<link href="<?php echo $host;?>assets/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo $host;?>assets/css/simple-line-icons.css" rel="stylesheet">
<!-- all buttons css -->
<link href="<?php echo $host;?>assets/css/buttons.css" rel="stylesheet">
<!-- animate css -->
<link href="<?php echo $host;?>assets/css/animate.css" rel="stylesheet">
<!-- top nev css -->
<link href="<?php echo $host;?>assets/css/page-header.css" rel="stylesheet">
<!-- adminui main css -->
<link href="<?php echo $host;?>assets/css/main.css" rel="stylesheet">
<!-- aqua black theme css -->
<link href="<?php echo $host;?>assets/css/aqua-black.css" rel="stylesheet">
<!-- media css for responsive  -->
<link href="<?php echo $host;?>assets/css/main.media.css" rel="stylesheet">
<!--[if lt IE 9]> <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
<!--[if lt IE 9]> <script src="dist/html5shiv.js"></script> <![endif]-->
<?php
                        $err = "";

                if(isset($_POST['btnLogin'])){
                   $username = $database->test_input($_POST['txtUsername']);
                   $password = $database->test_input($_POST['txtPassword']);
        
                   if($username != "" && $password != ""){
                        $login = (array)$database->authenticateStaff($username,$password);
                        if($login[0] == 0){
                                $err = 'invalid username or password';
                            }
                        elseif($login[0] > 0){
                                    // no password error passed
                                    if($login[1] == 0){
                                        $err = "your account is not yet activated";
                                    }
                                    // invalid password error passed
                                    elseif($login[1] === 1){
                                        $err = "Your password is invalid";
                                    }
                                    else {
                                            $_SESSION['user_id'] = $login[0];
                                            setcookie("i_am2309384384304302349438933", $_SESSION['user_id'], time() + (86400),"/");
                                            $database->redirect_to($url);
                                        }
                                }
                       }
                       else{
                            if($username == ""){$err.= "enter username<br/>";}
                            if($password == ""){$err.= "enter password";}
                       }
                }

            ?>
</head>
<body class="login-layout-full login">
<div class="page-brand-info">
    <div class="brand"> <img class="brand-img" src="assets/images/w-logo.png" alt="..."> </div>
    <p class="font-size-20">Elastic250 is a service application that helps monitor customer service progress and stores proper information of burchases and billing. Log in to have a feel</p>
</div>
<div class="loginColumns ">
    <div>
        <h1 class="logo-name">E!-250</h1>
    </div>
    <h3>Welcome to Elastic250</h3>
   <!-- <p>fully responsive admin dashboard template built with Bootstrap Framework, HTML5 and CSS3, Media query. </p>  -->
    <p>Login in. To see it in action.</p>
    <form  class="top15" method="post">
         <div class="form-group">
              <?php if($err!= ""){ echo "<p style='color:red;'>".$err."</p>";}?>
         </div>
        <div class="form-group">
            <input required="" name="txtUsername" placeholder="Username" class="form-control" type="text">
        </div>
        <div class="form-group">
            <input required="" name="txtPassword" placeholder="Password" class="form-control" type="password">
        </div>
        <button class="btn aqua block full-width bottom15" name="btnLogin" type="submit">Login</button>
         <p style="text-align: center;"><a href="forgot_password.php"> Forgot password?</a></p>
       
    </form>
    <p class=" copyR"> <small>Elastic250 is easy to use &copy; 2017-2018</small> </p>
</div>
</body>

<!-- Mirrored from adminui-v1.0.bittyfox.com/default/aqua-black/login_v2.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Jul 2017 15:57:32 GMT -->
</html>
