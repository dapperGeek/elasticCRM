<?php
  include("../data/DBConfig.php");
  include_once("../data/sessioncheck.php");
  $id = $database->test_input($_GET['id']);
  $grt = $database->getIndGoodsRemoved($id);
      if(empty($grt)){
       // $database->redirect_to($host."view-goods-recieve-ticket");
      }
?>

<table width="80%" align="center"  border=0>
    <tr>
        <th colspan="2"><h2> TRANSFER TICKET</h2></th>
    </tr>
  <tr>
    <td>
        <!-- <b>INVOICE NO:</b> <?php //echo $grt['invoiceNo'];?><br/> -->
        <b>TRANSFER DATE:</b> <?php echo $grt['invoiceDate'];?> <br/>
        <b>RECEIVING STORE:</b> <?php echo $grt['supplierID'];?><br/>
        <!-- <b>DELIVERY ADDRESS:</b> <?php //echo $grt['FileReference'];?><br/> -->
       <b>ORDER ID:</b> <?php echo str_pad($grt['id'],5,"0",STR_PAD_LEFT);?><br/>
        <b>TICKET NO:</b> <?php echo $grt['TicketNo'];?><br/>
        <b>SENDING STORE:</b> <?php echo $grt['storeName'];?><br/>

    </td>
    <td align="right"><img src="../img/tenaui-logo.jpg" width="100" height="100"></td>
  </tr>
</table>
     <br/><br/>
  <table border=1 style="width:80%;font-size:13px" align="center" cellpadding="2" cellspacing="0">

 <tr>
          <th colspan="7" style="text-align: center"> ITEMS</th>
 </tr>
       <tr>
           <th>S/N</th>
              <th colspan="2">PRODUCT </th>
                <th>CODE</th>
              <th>QTY</th>
              <th>UNIT </th>
           <th colspan="2">REMARKS</th>

      </tr>

      <?php
            $myCollect = (array)$database->getAllGoodsAddedForRecieve($id);
            $N = 1;
            foreach($myCollect as $mc){
      ?>
      <tr>
           <th><?php echo $N;?></th>
              <td colspan="2" align="center"><?php echo $mc['productName'];?> </td>
              <td align="center"><?php echo $mc['Code'];?></td>
              <td align="center"><?php echo $mc['AddedQty'];?></td>
              <td align="center"><?php echo $mc['unitName'];?> </td>
           <td colspan="2"></td>

      </tr>

      <?php $N++;}?>
<tr>
          <th colspan="7" style="text-align: center">PREPARE BY : <?php echo $grt['fullname'];?></th>
 </tr>

 <tr>
          <th colspan="2" style="text-align: center">SIGNATURE : </th>
 </tr>


  </table>
 
 <table border=1 style="width:80%;font-size:13px" align="center" cellpadding="2" cellspacing="0">
      <tr>
        
      </tr>
 </table>