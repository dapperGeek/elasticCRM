<?php
  include("../data/DBConfig.php");
  include_once("../data/sessioncheck.php");

  $id = 0;
    $msg = "";
    $err = "";

    if(!isset($_GET['id']) || $_GET['id'] == ""){
        $database->redirect_to($host."view-workshop-machine");
    }else{
        $id = $_GET['id'];

        $ticket = $database->getWorkshopTicket($id);
        if($ticket == null){
            $database->redirect_to($host."view-workshop-machine");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Add Machine to WorkShop</title>
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
    <link href="<?php echo $host;?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
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


///////////////////////////////////////////////////////////


</script>



<?php
                             $msg = ""; $err = "";

                                    if(isset($_POST['btnAddMachine'])){

                                       $serviceID = $ticket['id'];
                                       $closeDate = date("l jS \of F Y h:i:s A");
                                      $st = $database->test_input($_POST['txtST']);
                                      $et = $database->test_input($_POST['txtET']);

                                      $colour = $database->test_input($_POST['txtColour']);
                                      $Mono = $database->test_input($_POST['txtMono']);
                                      $meterReading = $database->test_input($_POST['meterReading']);
                                      $engineer = $database->test_input($_POST['txtEngineer']);

                                       

                                      $wd = "<b>Scheduled Date/Time :</b> ".$ticket['schDate']." / ".$ticket['schTime']." \n <b>START TIME:</b> ".$st." / <b>FINISH TIME:</b> ".$et." \n";
                                      $wd2 = $database->test_input($_POST['txtWorkDone']);
                                      if($wd2 != ""){
                                      $workDone = $_POST['txtWrkDone2'].$wd.$wd2."\n\n";
                                      }else{
                                      $workDone = $_POST['txtWrkDone2'];
                                      }

                                      $database->workshopFollowUp($serviceID,$closeDate,$workDone,$engineer,$st,$et,$meterReading,$colour,$Mono);   
                                        $msg = "This Ticket has been followed Up";

                                        }
                                        $ticket = $database->getWorkshopTicket($id);
                                        if($ticket == null){
                                        $database->redirect_to($host."view-workshop-machine");
                                

                                      }




                            ?>

<div class="page-content-wrapper animated fadeInRight">
  <div class="page-content" >
    <div class="row wrapper border-bottom page-heading">
       <div class="col-lg-12">
                            <h2> Follow Up For <?php  echo $ticket['ticketGen'];?> | <span class="btn btn-primary"><?php echo $ticket['machine_code'];?></span> |
        <span class="btn btn-primary"><?php echo $ticket['account_name'];?></span>  </h2>
                            <ol class="breadcrumb">
                                <li> <a href="#">Home</a> </li>
                                <li> <a>Workshop</a> </li>
                                <li class="active"> <strong>Follow Up </strong> </li>
                            </ol>
                        </div>
    </div>
    <div class="wrapper-content ">
      <div class="row">
        <div class="col-lg-12 top10 bottom20">
          <div class="widgets-container">

            <form method="post" class="form-horizontal">
             <div class="form-group">
                  <label class="col-sm-2 control-label">&nbsp;</label>
                 <div class="col-sm-6">
                   <?php if(isset($err) && $err != ""){$database->showMsg('',$err,1);}?>
                            <?php if(isset($msg) && $msg != ""){$database->showMsg('',$msg,2);}?>
                </div>

             </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">ACCOUNT NAME</label>
                <div class="col-sm-6">
                
                   <input list="browsers" readonly="" class="form-control m-b" name="txtAccount" value="<?php echo $ticket['account_name']; ?>" required data-validation-required-message="File Reference is required" />
                  <datalist id="browsers">
                          
                          
                                                <option value="">--select--</option>
                                                <?php
                                                     $myMachines = (array)$database->getAllAcounts();
                                                     foreach ($myMachines as $machine) {?>
                                                <option value="<?php if(isset($_POST['txtAccount']) && $_POST['txtAccount'] == $machine['id']){echo "selected";}?><?php echo strtoupper($machine['Name']);?>">
                                                   </option>
                                                <?php }?>
                                                </datalist>
                                               </div>
              </div>

              <hr>
              <div class="form-group">
                
                <label class="col-sm-2 control-label">MACHINE CODE</label>
                <div class="col-sm-6">
                <input type="text" readonly=""  name="txtMachineCode" value="<?php echo $ticket['machine_code']; ?>" class="form-control" required>

                  </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label">MACHINE MODEL</label>
                <div class="col-sm-6">
                  <select class="form-control" name="txtMachineType" readonly="" >
                                      <option value="<?php echo $ticket['machine_name']; ?>"><?php echo $ticket['machine_name'];?></option>
                                                
                                                </select>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label">MACHINE SERIAL NO</label>
                <div class="col-sm-6">
                  <input type="text" readonly="" class="form-control" name="txtMachineSerialNo"
                                                value="<?php echo $ticket['serialNo']; ?>" required>
                     </div>
              </div>
   <hr>


    <div class="form-group">
                <label class="col-sm-2 control-label">CATEGORY</label>
                <div class="col-sm-6">
                  <select class="form-control" name="txtContractType" readonly="">
                                                <option value="<?php echo $ticket['category']; ?>"><?php echo $ticket['category']; ?></option>
                                                
                                                </select>
              </div>
              </div>
              <hr>
<div class="form-group">
                                            <h4 style="padding-left: 500px;">ENGINEER'S FEED BACK</h4>

                                        </div>
              <hr>

            <div class="form-group">
            <label for="dtp_input3" class="col-lg-2 control-label">START-TIME</label>
            <div class="col-lg-2">
            <div class="input-group date form_time" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
            <input class="form-control" name="txtST" size="16" type="text" value="" readonly>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
            </div>
            </div>
            <label for="dtp_input3" class="col-lg-2 control-label">END-TIME</label>
            <div class="col-lg-2">
            <div class="input-group date form_time" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
            <input class="form-control" name="txtET" size="16" type="text" value="" readonly>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
            </div>
            </div>

            <br>
            <br>







            <input type="hidden" id="dtp_input3" value="" />

            </div>
                                                <hr>

                                                    <hr>
                                        <div class="form-group">
                                            <h4 style="padding-left: 500px;">CURRENT METER READING</h4>

                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">METER READING</label>
                                            <div class="col-sm-6">
                                                <input  type="text" name="meterReading" value="<?php echo $ticket['meterReading'];?>" class="form-control"> </div>
                                        </div>
                                        <div class="form-group">
                                                    <label for="dtp_input3" class="col-lg-2 control-label">COLOUR</label>
                                                    <div class="col-lg-2">
                                                        <div class="input-group">
                                                                <input class="form-control" name="txtColour" size="19" type="text"  value="<?php echo $ticket['colour']; ?>" >
                                                                
                                                        </div>
                                                    </div>
                                                        <label for="dtp_input4" class="col-lg-2 control-label">MONO</label>
                                                    <div class="col-lg-2">
                                                        <div class="input-group">
                                                                <input class="form-control" name="txtMono" size="19" value="<?php echo $ticket['Mono']; ?>" type="text" >
                                                                
                                                        </div>
                                                    </div>
                                               
                                               <br>
                                                <br>
                                               

                                               




                                                    
                                              
                                                </div>
<hr>
      <div class="form-group">
      <label class="col-sm-2 control-label">MACHINE FAULT DESCRIPTION</label>
      <div class="col-sm-6">
      <textarea name="txtWorkDone" class="form-control" id="" rows="10" placeholder="ENTER MACHINE FAULT BY THE ENGINEER"></textarea>
      </div>
      </div>

       <div class="form-group">
                                            <label class="col-sm-2 control-label">&nbsp;</label>
                                            <div class="col-sm-10">
                                                <input type="hidden" name="txtWrkDone2" value="<?php echo $ticket['Machine_fault'];?>" />

                                                    <?php echo nl2br($ticket['Machine_fault']); ?>
                                            </div>
                                        </div>

              <!-- <label class="col-sm-2 control-label">CONTRACT START</label> -->
            <!--     <div class="col-sm-2">
                  <div class="input-group date form_date col-md-12" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2"
														data-link-format="yyyy-mm-dd">
														<input class="form-control" type="text" name="txtCS" value="<?php //if(isset($_POST['txtCS'])){ echo $_POST['txtCS'];}?>" readonly>
														<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
													</div>
													<input type="hidden" id="dtp_input2" value="" />

              </div> -->
         <!--      <label class="col-sm-2 control-label">CONTRACT END</label>
                <div class="col-sm-2">
                  <div class="input-group date form_date col-md-12" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2"
														data-link-format="yyyy-mm-dd">
														<input class="form-control" type="text" name="txtCE" value="<?php //if(isset($_POST['txtCE'])){ echo $_POST['txtCE'];}?>" readonly>
														<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
													</div>
													<input type="hidden" id="dtp_input2" value="" />

              </div> -->
              
              <hr>

               

     
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">ASSIGNED ENGINEER</label>
                                            <div class="col-lg-6">
                                                <select class="form-control m-b" name="txtEngineer" required data-validation-required-message="engineer is required">
                                                    <option value="<?php echo $ticket['assign_engineer'] ?>"><?php echo $ticket['assign_engineer'] ?> </option>
                                                    <?php
                            $engs = (array)$database->getAllEngineers();
                                foreach($engs as $eng){
                        ?>
                                                        <option value="<?php echo $eng['fullname']; ?>" <?php if(isset($_POST[ 'txtEngineer']) && $_POST[ 'txtEngineer']==$eng[ 'id']){echo "selected";}?>>
                                                            <?php echo $eng['fullname']; ?>
                                                        </option>
                                                        <?php } ?>

                                                </select>
                                            </div>

                                        </div>
                                        <hr>

                                         <div class="form-group">
      <label class="col-md-2 control-label">DATE & TIME </label>
      <div class="input-group date form_datetime col-md-6" data-date="<?php echo date('Y-m-d'); ?>T<?php echo date('H:i:s'); ?>Z" data-date-format="dd MM yyyy - HH:ii p"
      data-link-field="dtp_input1">
      <input class="form-control" size="20" type="text" name="txtInD" value="<?php echo $ticket['doi'] ?>" readonly>
      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
      </div>
      <input type="hidden" id="dtp_input1" value="" />
      <br/>
      </div>
      <hr>


             <div class="form-group">
                <div class="col-sm-6 col-sm-offset-2">

                  <button class="btn aqua btn-block" type="submit" name="btnAddMachine" class="btn btn-success btn-lg col-lg-12">PROCESS FOLLOW UP</button>
                </div>
              </div>
              <hr>



             
            </form>
          </div>
        </div>
        <!--All form elements  End -->
      </div>
    </div>

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
<script type="text/javascript" src="<?php echo $host;?>assets/js/vendor/bootstrap-datetimepicker.js" charset="UTF-8"></script>
               <script type="text/javascript">
                    $('.form_datetime').datetimepicker({
                        //language:  'fr',
                        weekStart: 1,
                        todayBtn: 1,
                        autoclose: 1,
                        todayHighlight: 1,
                        startView: 2,
                        forceParse: 0,
                        showMeridian: 1
                    });
                    $('.form_date').datetimepicker({
                       // language: 'fr',
                        weekStart: 1,
                        todayBtn: 1,
                        autoclose: 1,
                        todayHighlight: 1,
                        startView: 2,
                        minView: 2,
                        forceParse: 0
                    });
                    $('.form_time').datetimepicker({
                       // language: 'fr',
                        weekStart: 1,
                        todayBtn: 1,
                        autoclose: 1,
                        todayHighlight: 1,
                        startView: 1,
                        minView: 0,
                        maxView: 1,
                        forceParse: 0
                    });

                    $(function() {
                        $('#datetimepicker12').datetimepicker({
                            inline: true,
                            sideBySide: true
                        });

                        $('input[name="daterange"]').daterangepicker();

                        $('input[name="dateTimeRange"]').daterangepicker({
                            timePicker: true,
                            timePickerIncrement: 30,
                            locale: {
                                format: 'MM/DD/YYYY h:mm A'
                            }
                        });

                    });
                </script>
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
