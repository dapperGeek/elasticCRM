<?php
  include("../data/DBConfig.php");
  include_once("../data/sessioncheck.php");
   $id = $database->test_input($_GET['id']);

if($myData['changePass'] == 0){
  //  $database->redirect_to($host."change-password");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Add Account</title>
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
<!-- icheck -->
<link href="<?php echo $host;?>assets/css/skins/all.css" rel="stylesheet">
<!--[if lt IE 9]> <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
<!--[if lt IE 9]> <script src="dist/html5shiv.js"></script> <![endif]-->
</head>
<?php include("../includes/header_.php");?>
<script type="text/javascript">
var parent = <?php echo $database->getArrayStates();?>;
var child = <?php echo $database->getLGAofStates();?>;
var gchild = <?php echo $database->getAreasofLGA();?>;
    function LoadChild(){
        var i = document.getElementById("parent").selectedIndex ;
       // var dp = document.getElementById("child");
        var dp2 = document.getElementById("gchild");
      //  var count = child[i-1].length;
        var count2 = gchild[i-1].length;

        //var html = "<option value=\"\" disabled selected hidden>- select -</option>";
       // for(var k = 0 ; k < count ; k ++){
       //     html += "<option value=\""+child[i-1][k][0]+"\">"+child[i-1][k][1]+"</option>";
       // }

        var html2 = "<option value=\"\" disabled selected hidden>- select -</option>";
        for(var k = 0 ; k < count2 ; k ++){
            html2 += "<option value=\""+gchild[i-1][k][0]+"\">"+gchild[i-1][k][1]+"</option>";
        }

       // dp.innerHTML = html;
        dp2.innerHTML = html2;
    }

</script>
<?php
        $msg = "";
        $err = "";

        if(isset($_POST['btnAddAccount'])){
            $leadID = 0;
            $name = $database->test_input($_POST['txtAccountName']);
            $industry = $database->test_input($_POST['txtIndustry']);
            $address = $database->test_input($_POST['txtAddress']);
            $state = $database->test_input($_POST['txtState']);
            $area = $database->test_input($_POST['txtAreaID']);
            $contactN1 = $database->test_input($_POST['txtContactName1']);
            $contactP1 = $database->test_input($_POST['txtPhone1']);
            $contactE1 = $database->test_input($_POST['txtEmail1']);
            $contactD1 = $database->test_input($_POST['txtDesig1']);

            $contactN2 = $database->test_input($_POST['txtContactName2']);
            $contactP2 = $database->test_input($_POST['txtPhone2']);
            $contactE2 = $database->test_input($_POST['txtEmail2']);
            $contactD2 = $database->test_input($_POST['txtDesig2']);

            $contactN3 = $database->test_input($_POST['txtContactName3']);
            $contactP3 = $database->test_input($_POST['txtPhone3']);
            $contactE3 = $database->test_input($_POST['txtEmail3']);
            $contactD3 = $database->test_input($_POST['txtDesig3']);



            if($name!= "" && $industry != "" && $address != "" && $state != "" && $area != "")
            {
                $database->updateAccountInfo($id,$name,$address,$area,$contactN1,$contactN2,$contactN3,$contactP1,$contactP2,$contactP3,$contactE1,$contactE2,$contactE3,$contactD1,$contactD2,$contactD3,$industry);
                $msg = "your account has been editted successfully!.";

            }else{
                $err = "Make sure Name, Industry, Address, State and Area is filled up";
            }
        }

?>
<?php  $accInfo = $database->getSingleAccountInformation($id);?>
 <div class="page-content-wrapper animated fadeInRight">
  <div class="page-content" >
    <div class="row wrapper border-bottom page-heading">
      <div class="col-lg-12">
        <h2> Edit Account Information for <?php echo $accInfo['Name'];?></h2>
        <ol class="breadcrumb">
          <li> <a href="index-2.html">Home</a> </li>
          <li> <a>Account</a> </li>
          <li class="active"> <strong>Edit Account </strong> </li>
        </ol>
      </div>
    </div>
    <div class="wrapper-content ">
      <div class="row">


        <div class="col-lg-12 top20 bottom20">
          <div class="widgets-container">

            <form method="post" class="form-horizontal">
             <div class="form-group">
                  <label class="col-sm-2 control-label">&nbsp;</label>
                 <div class="col-sm-10">
                  <?php if(isset($err) && $err != ""){$database->showMsg('',$err,1);}?>
                            <?php if(isset($msg) && $msg != ""){$database->showMsg('',$msg,2);}?>
                </div>

             </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">ACCOUNT NAME</label>
                <div class="col-sm-10">
                  <input type="text" name="txtAccountName"
                                                value="<?php echo $accInfo['Name'];?>" class="form-control" readonly="readonly" required>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label">INDUSTRY</label>
                <div class="col-sm-10">
                 <select class="form-control" name="txtIndustry">
                                                <option value="">--select--</option>
                                                <?php
                                                     $myMachines = (array)$database->getAllIndustries();
                                                     foreach ($myMachines as $machine) {

                                                ?>
                                                    <option value="<?php echo $machine['id'];?>"
                                                    <?php if($accInfo['industryID'] == $machine['id']){echo "selected";}?>><?php echo $machine['sector'];?></option>
                                                <?php }?>
                                                </select>
                  <span class="help-block bottom15-none">Choose an industry that best describes this account.</span> </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label">ADDRESS</label>
                <div class="col-sm-10">
                 <input type="text" class="form-control" name="txtAddress"
                                                value="<?php echo $accInfo['Address'];?>" required>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label">STATE & L.G.A</label>
                <div class="col-sm-5">
                   <select class="form-control m-b" id="parent" name="txtState" onChange="LoadChild();" required data-validation-required-message="State is required">
                                        <option value="" disabled selected hidden>- select -</option>
                                        <script type="text/javascript">
                                           for(var i = 0 ; i < parent.length ; i ++){
                                              if(parent[i][0] == <?php echo $accInfo['stateID'];?>){
                                                document.write('<option value="'+parent[i][0]+'" selected>'+parent[i][1]+'</option>');

                                                continue;
                                              }
                                                document.write('<option value="'+parent[i][0]+'">'+parent[i][1]+'</option>');

                                              }
                                        </script>

                                    </select>
                </div>
                <div class="col-sm-5">
                    <select class="form-control m-b" name="txtAreaID" required data-validation-required-message="area is required" id="gchild" onChange="LoadGChild();">

                                                        <option value="<?php echo $accInfo['areaID'] ?>"><?php echo $accInfo['areaname'] ?></option>

                                    </select>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-lg-2 control-label">CONTACT 1</label>
                <div class="col-lg-3">
                    <input type="text" name="txtContactName1"
                                                value="<?php echo $accInfo['ContactName1'];?>" class="form-control" required>
                </div>
                <div class="col-md-2">

                                               <input type="text" name="txtPhone1"
                                                value="<?php echo $accInfo['phone1'];?>" class="form-control" required>

                                        </div>
                                         <div class="col-md-3">

                                                <input type="text" name="txtEmail1"
                                                value="<?php echo $accInfo['email1'];?>" class="form-control" required>
                                        </div>
                                        <div class="col-md-2">

                                              <input type="text" name="txtDesig1"
                                                value="<?php echo $accInfo['desig1'];?>" class="form-control" required>
                                        </div>
              </div>
               <div class="form-group">
                <label class="col-lg-2 control-label">CONTACT 2</label>
                <div class="col-lg-3">
                 <input type="text" name="txtContactName2"
                                                value="<?php echo $accInfo['ContactName2'];?>" class="form-control">
                </div>
                <div class="col-md-2">

                                             <input type="text" name="txtPhone2"
                                                value="<?php echo $accInfo['phone2'];?>" class="form-control">
                                        </div>
                                         <div class="col-md-3">

                                                <input type="text" name="txtEmail2"
                                                value="<?php echo $accInfo['email2'];?>" class="form-control">
                                        </div>
                                        <div class="col-md-2">

                                               <input type="text" name="txtDesig2"
                                                value="<?php echo $accInfo['desig2'];?>" class="form-control">

                                        </div>
              </div>
               <div class="form-group">
                <label class="col-lg-2 control-label">CONTACT 3</label>
                <div class="col-lg-3">
                   <input type="text" name="txtContactName3"
                                                value="<?php echo $accInfo['ContactName1'];?>" class="form-control">

                </div>
                <div class="col-md-2">

                                               <input type="text" name="txtPhone3"
                                                value="<?php echo $accInfo['phone3'];?>" class="form-control">
                                        </div>
                                         <div class="col-md-3">

                                               <input type="text" name="txtEmail3"
                                                value="<?php echo $accInfo['email3'];?>" class="form-control">

                                        </div>
                                        <div class="col-md-2">

                                                <input type="text" name="txtDesig3"
                                                value="<?php echo $accInfo['desig3'];?>" class="form-control">

                                        </div>
              </div>
              <hr>

              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">

                  <button class="btn aqua" type="submit" name="btnAddAccount" class="btn btn-success col-lg-12">Save changes</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!--All form elements  End -->
      </div>
    </div>

<!-- start footer
<div class="footer">
      <div class="pull-right">
        <ul class="list-inline">
          <li><a title="" href="index-2.html">Dashboard</a></li>
          <li><a title="" href="mailbox.html"> Inbox </a></li>
          <li><a title="" href="blog.html">Blog</a></li>
          <li><a title="" href="contacts.html">Contacts</a></li>
        </ul>
      </div>
      <div> <strong>Copyright</strong> AdminUI Company &copy; 2017 </div>
    </div>  -->
  </div>
</div>
<!-- Go top -->
<a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>
<!-- Go top -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo $host;?>assets/js/vendor/jquery.min.js"></script>
<script src="<?php echo $host;?>assets/js/vendor/validator.js"></script>
<!-- icheck -->
<script src="<?php echo $host;?>assets/js/vendor/icheck.js"></script>
<!-- bootstrap js -->
<script src="<?php echo $host;?>assets/js/vendor/bootstrap.min.js"></script>
<!-- slimscroll js -->
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/jquery.slimscroll.js"></script>
<!-- pace js -->
<script src="<?php echo $host;?>assets/js/vendor/pace/pace.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $host;?>assets/js/vendor/jquery.sparkline.min.js"></script>
<!-- main js -->
<script src="<?php echo $host;?>assets/js/main.js"></script>
<script>
 $(function () {
  $('#myForm').validator();
});

  $(document).ready(function(){
            var callbacks_list = $('.demo-callbacks ul');
            $('input.iCheck').on('ifCreated ifClicked ifChanged ifChecked ifUnchecked ifDisabled ifEnabled ifDestroyed', function(event){
              callbacks_list.prepend('<li><span>#' + this.id + '</span> is ' + event.type.replace('if', '').toLowerCase() + '</li>');
            }).iCheck({
               checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
              increaseArea: '20%'
            });
          });

</script>
</body>
</html>
