  <div class="row">
          <?php
               if(isset($_POST['btnGenerate'])){

                  /* if($machineInfo['cummulative'] == 1){

                   }else{

                   }*/
                   $contractID = $id;
                   $machineID = $_POST['txtmachineID'];
                   $accID = $_POST['txtaccID'];
                   $month = date('n');
                   $year = date('Y');
                   $currentMono = $_POST['txtCurrentMono'];
                   $currentColor = $_POST['txtCurrentColor'];
                   $copyMono = $_POST['txtCopyMono'];
                   $copyColor = $_POST['txtCopyColor'];
                   $previousMono = $_POST['pmono'];
                   $previousColor = $_POST['pcolor'];
                   $amountMono = $_POST['BillMono'];
                   $amountColor = $_POST['BillColor'];
                   $amountRental = $_POST['txtRental'];
                   $dMonth = $month + 1;

                   // $moment = 201709;
                   // $nextMoment = 20170920;
                   // $thisMoment =20170906;
                 $moment = date('Y').date('m');
                 $nextMoment = date('Y').str_pad($dMonth,2,"0",STR_PAD_LEFT).'28';
                 $thisMoment = date('Y').date('m').date('d');
                    $readingID = 2;
                    if($database->checkM_reading($contractID,$moment)){
                        $readingID = $database->createM_reading($contractID,$moment,$nextMoment,$user_id,date("l jS \of F Y h:i:s A"));
                        $co = count($currentMono);

                            for($i=0; $i < $co; $i++)
                            {
                                $totalmonovalueCum = $_POST['totalmonoVal'];
                                $totalcolorvalueCum = $_POST['totalcolorVal'];
                                 $totalmonovalueCum = $totalmonovalueCum / $co;
                                 $totalcolorvalueCum = $totalcolorvalueCum/$co;
                                if($machineInfo['cummulative'] == 1){
                                     $amountMono[$i] = $totalmonovalueCum;
                                     $amountColor[$i] = $totalcolorvalueCum;
                                }

                                $database->InputBillingInformation($readingID,$contractID,$accID[$i],$machineID[$i],$month,$year,$currentMono[$i],$currentColor[$i],$moment,$copyMono[$i],$copyColor[$i],$previousMono[$i],$previousColor[$i],$amountMono[$i],$amountColor[$i],$amountRental[$i]);

                            }
                        echo $database->showMsg("Success", "BILLING HAS BEEN GENERATED SUCCESSFULLY",2);
                    }else{
                        echo $database->showMsg("ERROR", "BILLING CANNOT BE GENERATED BECAUSE IT IS NOT YET TIME",1);
                    }


               }

          ?>


        <div class="col-lg-12 top20 bottom20">
          <div class="widgets-container">
          <form method="post">
              <div class="col-md-12">
                   <?php if(isset($err) && $err != ""){$database->showMsg('',$err,1);}?>
                            <?php if(isset($msg) && $msg != ""){$database->showMsg('',$msg,2);}?>
                </div>
                  <table style="font-size: smaller" class="display nowrap table  responsive nowrap table-bordered">
                     <tr>
                       <th rowspan="2">MACHINE</th>

                       <th rowspan="2"> MONO <br/>MINIMUM <br/>BILLING</th>
                       <th rowspan="2">EXCESS <br/>MONO <br/>BILLING</th>
                       <th rowspan="2">COLOR <br/>MINIMUM <br/>BILLING</th>
                       <th rowspan="2">EXCESS <br/>COLOR <br/>BILLING</th>
                       <th rowspan="2">MACHINE <br/>RENTAL <br/>CHARGE</th>
                       <th colspan="2">PREVIOUS MONTH METER READING</th>


                       <th colspan="2">THIS MONTH METER READING</th>
                       <th colspan="2">TOTAL COPIES PRINTS DONE</th>
                       <th colspan="2" <?php if($machineInfo['cummulative'] == 1){echo "style='display:none;'";}?>>BILLING</th>
                       <th rowspan="2" <?php if($machineInfo['cummulative'] == 1){echo "style='display:none;'";}?>>PAYABLE <br/> WITH RENT<BR/>INCLUSIVE</th>


                     </tr>
                      <tr>

                       <th>MONO</th>
                       <th>COLOR</th>

                       <th>MONO</th>
                       <th>COLOR</th>

                       <th>MONO</th>
                       <th>COLOR</th>
                       <th <?php if($machineInfo['cummulative'] == 1){echo "style='display:none;'";}?>>MONO</th>
                       <th <?php if($machineInfo['cummulative'] == 1){echo "style='display:none;'";}?>>COLOR</th>

                     </tr>
                     <?php
                     $total_worth_ = 0;
                     $total_rental = 0;
                     $total_min_mono = 0;
                     $total_min_color = 0;
                     $total_excess_mono = 0;
                     $total_excess_color = 0;
                     $n = 1;
                            $getcont = (array)$database->getContractValue($id);
                            $countTo = count($getcont);
                            $countTo = $countTo - 1;
                            foreach($getcont as $getconts){

                     ?>
                        <tr>
                            <input type="hidden" value="<?php echo $getconts['machineID'];?>" name="txtmachineID[]" />
                            <input type="hidden" value="<?php echo $getconts['contractID'];?>" name="txtcontractID[]" />
                            <input type="hidden" value="<?php echo $getconts['AccID'];?>" name="txtaccID[]" />
                            <input type="hidden" value="<?php echo $getconts['RentalCharge'];?>" name="txtRental[]" />
                               <td><?php echo $getconts['machine_code'];?></td>
                                   <?php
                                            $total_min_mono = $total_min_mono + $getconts['min_vol_mono'];
                                            $total_min_color = $total_min_color + $getconts['min_vol_color'];
                                            $total_rental = $total_rental + $getconts['RentalCharge'];
                                            $total_excess_color = $total_excess_color + $getconts['excess_color'];
                                            $total_excess_mono = $total_excess_mono + $getconts['excess_mono'];
                                   ?>
                               <td class="success">C : <b><?php echo $database->convertToMoney($getconts['cost_mono']);?></b><br/> MV : <b><?php echo $getconts['min_vol_mono'];?></b></td>
                               <td><b style="color:red"><?php echo $getconts['excess_mono'];?></b><br/> <b style="color:blue"><?php echo $database->convertToMoney($getconts['excess_cost_mono']);?></b></td>
                               <td class="success">C : <b><?php echo $database->convertToMoney($getconts['cost_color']);?></b><br/> MV : <b><?php echo $getconts['min_vol_color'];?></b></td>
                               <td><b style="color:red"><?php echo $getconts['excess_color'];?></b><br/> <b style="color:blue"><?php echo $database->convertToMoney($getconts['excess_cost_color']);?></b></td>
                               <td class="success">
                                   <?php
                                        $rnt = $getconts['RentalCharge'];
                                        echo $database->convertToMoney($rnt);

                                         $readingID = $database->getLastContractMoment($id);

                                        ?>
                               </td>
                               <td><?php
                                       $monoval = $database->getPreviousMeterReading($id,$getconts['machineID'],$readingID,1);

                                    ?>
                                    <!-- readonly="readonly" -->
                                    <input type="text" class="form-control" value="<?php echo $monoval;?>"  size="5" id="pmono<?php echo $getconts['machineID'];?>" name="pmono[]"/>
                               </td>
                               <td><?php
                                        $colorval = $database->getPreviousMeterReading($id,$getconts['machineID'],$readingID,2);

                                    ?>
                                    <!-- readonly="readonly" -->
                                    <input type="text" class="form-control" value="<?php echo $colorval;?>"  size="5" id="pcolor<?php echo $getconts['machineID'];?>" name="pcolor[]"/>
                               </td>
                               <script>
                               function addComma(x){
                                       // var part = x.toString().split(".");
                                       // part[0] = part[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                       // return part.join(".");
                                       return x.toLocaleString();
                                    }

                               function updateCurrentColor<?php echo $getconts['machineID'];?>(val){
                                    var current_color = val;
                                    var previous_color = document.getElementById('pcolor<?php echo $getconts['machineID'];?>').value;
                                    var myvalue = current_color - previous_color;
                                    document.getElementById('copy_color<?php echo $getconts['machineID'];?>').value = myvalue;
                                    getColorBilling<?php echo $getconts['machineID'];?>(myvalue);
                                    Payable<?php echo $getconts['machineID'];?>();

                                }

                                function updateCurrentMono<?php echo $getconts['machineID'];?>(val){
                                    var current_mono = val;
                                    var previous_mono = document.getElementById('pmono<?php echo $getconts['machineID'];?>').value;
                                    var myvalue = current_mono - previous_mono;
                                    document.getElementById('copy_mono<?php echo $getconts['machineID'];?>').value = myvalue;
                                    getMonoBilling<?php echo $getconts['machineID'];?>(myvalue);
                                    Payable<?php echo $getconts['machineID'];?>();
                                    addMonoCopy();

                                }

                                function Payable<?php echo $getconts['machineID'];?>(){
                                    var rent = parseFloat(<?php echo $getconts['RentalCharge'];?>);
                                   // alert("Message : "+rent);
                                    var monobill = parseFloat(document.getElementById('bill_mono<?php echo $getconts['machineID'];?>').value);
                                    var colorbill = parseFloat(document.getElementById('bill_color<?php echo $getconts['machineID'];?>').value);
                                    var totalPay = rent+monobill+colorbill;
                                    document.getElementById('tp<?php echo $getconts['machineID'];?>').value = addComma(totalPay);
                                    document.getElementById('total_pay<?php echo $getconts['machineID'];?>').value = totalPay;
                                    addIndividual();
                                }

                                function getColorBilling<?php echo $getconts['machineID'];?>(vali){
                                addColorCopy();
                                var copyMade = vali;

                                    var cost = <?php echo $getconts['cost_color'];?>;
                                    var min =  <?php echo $getconts['min_vol_color'];?>.00;
                                    var bill = cost * min;
                                    // alert("COST: "+cost+" min: "+min+" bill : "+bill);
                                    var excess =  <?php echo $getconts['excess_color'];?>;
                                    var excess_cost =  <?php echo $getconts['excess_cost_color'];?>;
                                    if (min == 0){
                                    
                                    bill = cost * copyMade;
                                    }else{

                                    if(copyMade < min){
                                          bill = bill;
                                    }else if(copyMade > min && (excess == 0 || copyMade < excess)){
                                        bill = cost * copyMade;
                                    }else if(copyMade > excess){
                                        var value = copyMade - excess;
                                        var b1 = excess * cost;
                                        var b2 = value * excess_cost;
                                        bill = b1 + b2;
                                    }
                                    }
                                      document.getElementById('bill_color<?php echo $getconts['machineID'];?>').value = bill;
                                      Payable<?php echo $getconts['machineID'];?>();

                                }


                                 function getMonoBilling<?php echo $getconts['machineID'];?>(vali){
                                     addMonoCopy();
                                 var copyMade = vali;

                                    var cost = <?php echo $getconts['cost_mono'];?>;
                                    var min =  <?php echo $getconts['min_vol_mono'];?>.00;
                                    var bill = cost * min;
                                    // alert("COST: "+cost+" min: "+min+" bill : "+bill);
                                    var excess =  <?php echo $getconts['excess_mono'];?>;
                                    var excess_cost =  <?php echo $getconts['excess_cost_mono'];?>;

                                    if (min == 0){
                                    
                                    bill = cost * copyMade;
                                    }else{
                                    if(copyMade < min){
                                          bill = bill;
                                    }else if(copyMade > min && (excess == 0 || copyMade < excess)){
                                        bill = cost * copyMade;
                                    }else if(copyMade > excess){
                                        var value = copyMade - excess;
                                        var b1 = excess * cost;
                                        var b2 = value * excess_cost;
                                        bill = b1 + b2;
                                    }
                                  }
                                      document.getElementById('bill_mono<?php echo $getconts['machineID'];?>').value = bill;
                                      Payable<?php echo $getconts['machineID'];?>();



                                }

                               </script>

                               <td>
                                   <input type="text" class="form-control" size="5" id="current_mono<?php echo $getconts['machineID'];?>" name="txtCurrentMono[]" required="required" onchange="updateCurrentMono<?php echo $getconts['machineID'];?>(this.value)" oninput="updateCurrentMono<?php echo $getconts['machineID'];?>(this.value)" />
                               </td>
                               <td>
                                   <input type="text" class="form-control" size="5" name="txtCurrentColor[]" id="current_color<?php echo $getconts['machineID'];?>" required="required" onchange="updateCurrentColor<?php echo $getconts['machineID'];?>(this.value)" oninput="updateCurrentColor<?php echo $getconts['machineID'];?>(this.value)"  />
                               </td>

                                <td>
                                   <input type="text" class="form-control" size="5" name="txtCopyMono[]" id="copy_mono<?php echo $getconts['machineID'];?>" value="0" readonly="readonly"  onchange="getMonoBilling<?php echo $getconts['machineID'];?>(this.value)" oninput="getMonoBilling<?php echo $getconts['machineID'];?>(this.value)" />
                               </td>
                               <td>
                                   <input type="text" class="form-control" size="5" name="txtCopyColor[]" id="copy_color<?php echo $getconts['machineID'];?>" value="0" readonly="readonly"  onchange="getColorBilling<?php echo $getconts['machineID'];?>(this.value)" oninput="getColorBilling<?php echo $getconts['machineID'];?>(this.value)"   />
                               </td>
                               <td <?php if($machineInfo['cummulative'] == 1){echo "style='display:none;'";}?>>
                                   <input type="text" class="form-control" size="5"  id="bill_mono<?php echo $getconts['machineID'];?>" name="BillMono[]" readonly="readonly" />
                               </td>
                               <td <?php if($machineInfo['cummulative'] == 1){echo "style='display:none;'";}?>>
                                   <input type="text" class="form-control" size="5" name="BillColor[]" id="bill_color<?php echo $getconts['machineID'];?>" readonly="readonly"  />
                               </td>

                               <td <?php if($machineInfo['cummulative'] == 1){echo "style='display:none;'";}?>>
                                   <input type="text" class="form-control" size="8"  id="tp<?php echo $getconts['machineID'];?>" readonly="readonly"  />
                                   <input type="hidden" class="form-control" size="8" id="total_pay<?php echo $getconts['machineID'];?>" name="total_pay[]" readonly="readonly"  />
                               </td>

                     </tr>

                     <?php $n++;}?>
                     <tr >

                             <th colspan="5" <?php if($machineInfo['cummulative'] == 0){echo "style='display:none;'";}?> style="text-align: right">
                                   TOTAL RENTAL CHARGE:
                             </th>
                             <td <?php if($machineInfo['cummulative'] == 0){echo "style='display:none;'";}?>>
                                 <?php echo $database->convertToMoney($total_rental);?>
                             </td>
                             <th colspan="2" <?php if($machineInfo['cummulative'] == 0){echo "style='display:none;'";}?> style="text-align: right">
                                 MINIMUM VOLUME:
                             </th>
                             <th <?php if($machineInfo['cummulative'] == 0){echo "style='display:none;'";}?>>
                                 <?php echo number_format($total_min_mono);?>
                             </th>
                             <th <?php if($machineInfo['cummulative'] == 0){echo "style='display:none;'";}?>>
                                 <?php echo number_format($total_min_color);?>
                             </th>

                             <th <?php if($machineInfo['cummulative'] == 0){echo "style='display:none;'";}?>>
                                 <input type="text" class="form-control" size="6" id="totalmonovalue" readonly="readonly" onchange="checkMonoPrint(this.value)" oninput="checkMonoPrint(this.value)"  />
                             </th>
                             <th <?php if($machineInfo['cummulative'] == 0){echo "style='display:none;'";}?>>
                                 <input type="text" class="form-control" size="6" id="totalcolorvalue" readonly="readonly" onchange="checkColorPrint(this.value)" oninput="checkColorPrint(this.value)" />
                             </th>
                             </div>
                             <th colspan="14" style="text-align: right" <?php if($machineInfo['cummulative'] == 1){echo "style='display:none;";}?>>TOTAL PAYABLE</th>
                             <th <?php if($machineInfo['cummulative'] == 1){echo "style='display:none;'";}?>><input type="text" class="form-control" size="6" id="totalpayableInd" readonly="readonly" /></th>
                     </tr>
                     <tr <?php if($machineInfo['cummulative'] == 0){echo "style='display:none;'";}?>>
                             <th colspan="10" style="text-align: right">
                                   TOTAL COLOR AND MONO PRINTING CHARGE:
                             </th>


                             <th>
                                 <input type="text" class="form-control" size="6" id="totalmonovalue_" name="totalmonoVal" readonly="readonly" />
                             </th>
                             <th>
                                 <input type="text" class="form-control" size="6" id="totalcolorvalue_" name="totalcolorVal" readonly="readonly" />
                             </th>
                     </tr>
                      <tr <?php if($machineInfo['cummulative'] == 0){echo "style='display:none;'";}?>>
                             <th colspan="10" style="text-align: right">
                                   TOTAL PRINTING CHARGE + TOTAL RENTAL:
                             </th>


                             <th colspan="2">
                                 <input type="text" class="form-control" size="6" id="totalallvalueN_" readonly="readonly" />
                                 <input type="hidden" id="totalallvalue_" readonly="readonly" />
                             </th>

                     </tr>

                  </table>

          <div class="row">
             <input type="submit" class="btn btn-success col-lg-12" name="btnGenerate" value="GENERATE BILLING" />
          </div>
           </form>

           <script>
                    function addMonoCopy(){
                                    var inps = document.getElementsByName('txtCopyMono[]');
                                    var totalMono = 0;
                                    for (var i = 0; i <inps.length; i++) {
                                            var inp=inps[i];
                                            inp = parseInt(inp.value);
                                            totalMono = totalMono + inp;
                                    }
                                    document.getElementById("totalmonovalue").value = totalMono;
                                    checkMonoPrint(totalMono);
                                }

                    function addColorCopy(){
                                    var inps = document.getElementsByName('txtCopyColor[]');
                                    var totalColor = 0;
                                    for (var i = 0; i <inps.length; i++) {
                                            var inp=inps[i];
                                            inp = parseInt(inp.value);
                                            totalColor = totalColor + inp;
                                    }
                                    document.getElementById("totalcolorvalue").value = totalColor;
                                    checkColorPrint(totalColor);

                                }

                                function addIndividual(){
                                    var inps = document.getElementsByName('total_pay[]');
                                    var totalColor = 0;
                                    for (var i = 0; i <inps.length; i++) {
                                            var inp=inps[i];
                                            inp = parseInt(inp.value);
                                            totalColor = totalColor + inp;
                                    }
                                    document.getElementById("totalpayableInd").value = totalColor;
                                    //checkColorPrint(totalColor);

                                }

                    function checkMonoPrint(vali){
                                    var copyMade = vali;

                                    var cost = <?php echo $getconts['cost_mono'];?>;
                                    var min =  <?php echo $total_min_mono;?>.00;
                                    var bill = cost * min;
                                     //alert("COST: "+cost+" min: "+min+" bill : "+bill);
                                    var excess =  <?php echo $total_excess_mono;?>;
                                    var excess_cost =  <?php echo $getconts['excess_cost_mono'];?>;
                                     
                                    if (min == 0){
                                    
                                    bill = cost * copyMade;
                                    }else{

                                    if(copyMade < min){
                                          bill = bill;
                                    }else if(copyMade > min && (excess == 0 || copyMade < excess)){
                                        bill = cost * copyMade;
                                    }else if(copyMade > excess){
                                        var value = copyMade - excess;
                                        var b1 = excess * cost;
                                        var b2 = value * excess_cost;
                                        bill = b1 + b2;
                                    }
                                  }
                                      document.getElementById('totalmonovalue_').value = bill;
                                      computeGeneralPrice();
                                     // Payable<?php echo $getconts['machineID'];?>();

                                }

                    function computeGeneralPrice(){
                        var monovalue__ = parseInt(document.getElementById('totalmonovalue_').value);
                        var colorvalue__ = parseInt(document.getElementById('totalcolorvalue_').value);

                        var totalmoney__ = monovalue__ + colorvalue__ +<?php echo $total_rental;?> ;
                        //alert("mono amount: "+monovalue__+" --- color amount : "+colorvalue__+" ---- TOTAL :"+totalmoney__);
                        //totalallvalue_

                        document.getElementById('totalallvalue_').value = totalmoney__;
                        document.getElementById('totalallvalueN_').value = addComma(totalmoney__);

                    }


                    function checkColorPrint(vali){
                                    var copyMade = vali;

                                    var cost = <?php echo $getconts['cost_color'];?>;
                                    var min =  <?php echo $total_min_color;?>.00;
                                    var bill = cost * min;

                                    var excess =  <?php echo $total_excess_color;?>;
                                    var excess_cost =  <?php echo $getconts['excess_cost_color'];?>;

                                    if (min == 0){
                                    
                                    bill = cost * copyMade;
                                    }else{
                                    if(copyMade < min){
                                          bill = bill;
                                    }else if(copyMade > min && (excess == 0 || copyMade < excess)){
                                        bill = cost * copyMade;
                                    }else if(copyMade > excess){
                                        var value = copyMade - excess;
                                        var b1 = excess * cost;
                                        var b2 = value * excess_cost;
                                        bill = b1 + b2;
                                    }
                                  }
                                      document.getElementById('totalcolorvalue_').value = bill;
                                     computeGeneralPrice();

                                }

           </script>
          </div>
        </div>
        <!--All form elements  End -->
      </div>