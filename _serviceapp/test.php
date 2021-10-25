<<<<<<< HEAD
<?php
    include("../data/DBConfig.php");
    include_once("../data/sessioncheck.php");
    $yr_ = date("Y");

if($myData['changePass'] == 0){
    //  $database->redirect_to($host."change-password");
}
?>
<script type="text/javascript">
var parent = <?php echo $database->getArrayAllAccounts();?>;

var gchild = <?php echo $database->getArrayOfMachines();?>;
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
  <div class="col-md-3">
                                                <label class="control-label">STATE</label>
                                               <select class="form-control m-b" id="parent" name="txtState" onChange="LoadChild();" required data-validation-required-message="State is required">
                                        <option value="" disabled selected hidden>- select -</option>
                                        <script type="text/javascript">
                                            for(var i = 0 ; i < parent.length ; i ++){
                                                document.write('<option value="'+parent[i][0]+'">'+parent[i][1]+'</option>');
                                            }
                                        </script>

                                    </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label">AREA</label>
                                                 <select class="form-control m-b" name="txtAreaID" required data-validation-required-message="area is required" id="gchild" onChange="LoadGChild();">


                                    </select>
=======
<?php
    include("../data/DBConfig.php");
    include_once("../data/sessioncheck.php");
    $yr_ = date("Y");

if($myData['changePass'] == 0){
    //  $database->redirect_to($host."change-password");
}
?>
<script type="text/javascript">
var parent = <?php echo $database->getArrayAllAccounts();?>;

var gchild = <?php echo $database->getArrayOfMachines();?>;
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
  <div class="col-md-3">
                                                <label class="control-label">STATE</label>
                                               <select class="form-control m-b" id="parent" name="txtState" onChange="LoadChild();" required data-validation-required-message="State is required">
                                        <option value="" disabled selected hidden>- select -</option>
                                        <script type="text/javascript">
                                            for(var i = 0 ; i < parent.length ; i ++){
                                                document.write('<option value="'+parent[i][0]+'">'+parent[i][1]+'</option>');
                                            }
                                        </script>

                                    </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label">AREA</label>
                                                 <select class="form-control m-b" name="txtAreaID" required data-validation-required-message="area is required" id="gchild" onChange="LoadGChild();">


                                    </select>
>>>>>>> 48136f1b63a2e7fb659fed72c5bf93f60ec79592
                                            </div>