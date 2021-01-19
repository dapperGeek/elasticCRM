<?php
  include("../data/DBConfig.php");
  include_once("../data/sessioncheck.php");
  if(isset($_SESSION['user_id']) ){
  $totalAmount = $_SESSION['product_total_price'];
  $eachAmount   =  $_SESSION['amount'];
  $eachUnitPrice  = $_SESSION['unitPrice'];
  //var_dump($eachAmount);
  //exit;
}
  $id = $database->test_input($_GET['id']);
 
      $grt = $database->getIndGoodsRemovedDeliveryUpdate($id);
     //echo $grt['TicketNo'];
     // if(empty($grt)){
         if($grt['TicketNo'] == null ){
       // $database->redirect_to($host."view-goods-recieve-ticket");
        $grt = $database->getIndGoodsRemoved($id);
      }
?>

<table width="80%" align="center"  border=0>
    <tr>
        <th colspan="2"><?php if ($grt['invoiceNo'] == "TRANSFER") {
          echo "<h2>TRANSFER TICKET</h2>";
        }else{ echo "<h2> ELECTRONIC SOF </h2>";} ?></th>
    </tr>
  <tr>
    <td>
        <!--<b>INVOICE NO:</b> <?php echo $grt['invoiceNo'];?><br/>-->
        <b>DATE:</b> <?php echo $grt['invoiceDate'];?> <br/>
        <b>CUSTOMER NAME:</b> <?php echo $grt['supplierID'];?><br/>
        <b>DELIVERY ADDRESS:</b> <?php echo $grt['FileReference'];?><br/>
       <b>ORDER ID:</b> <?php echo str_pad($grt['id'],5,"0",STR_PAD_LEFT);?><br/>
        <b>TICKET NO:</b> <?php echo $grt['TicketNo'];?><br/>
        <b>STORE:</b> <?php echo $grt['storeName'];?><br/>

    </td>
    <td align="right"><img src="../img/tenaui-logo.jpg" width="100" height="100"></td>
  </tr>
</table>
     <br/><br/>
  <table border=1 style="width:80%;font-size:13px" align="center" cellpadding="2" cellspacing="0">

 <tr>
          <th colspan="8" style=" background-color: #CCCCCC;text-align: center"> COMMODITY DESCRIPTION</th>
 </tr>
       <tr>
           <th>S/N</th>
              <th colspan="2">PRODUCT </th>
               <th>Code </th>
              <th>QTY</th>
              <th>PRICE</th>
              <th>UNIT </th>
           <th colspan="2">AMOUNT</th>

      </tr>

      <?php
            $myCollect = (array)$database->getAllGoodsAddedForRecieve($id);
            $N = 1;
            $j =0;
            foreach($myCollect as $mc){
      ?>
      <tr>
           <th><?php echo $N;?></th>
              <td colspan="2" align="center"><?php echo $mc['productName'];?> </td>
              <td  align="center"><?php echo $mc['Code'];?> </td>
              <td align="center"><?php echo $mc['AddedQty'];?></td>
              <td align="center"><?php echo number_format($eachUnitPrice[$j], 2);?></td>
              <td align="center"> <?php echo $mc['unitName'];?> </td>
              
           <td align="center" colspan="2"><?php echo '<b>N<b>'.number_format($eachAmount[$j], 2); ?></td>

      </tr>

      <?php $N++;
            $j++;}?>
      
      <tr>
          <th colspan="7" style="text-align: center"><b>TOTAL</b></th>
          <th> <?php echo '<b>N<b>'.number_format($totalAmount, 2); ?> </th>
 </tr>

      <tr>
          <th colspan="8" style="text-align: center">&nbsp;</th>
 </tr>
<tr>
          <th colspan="8" style="text-align: center">PREPARE BY : <?php echo $grt['fullname'];?></th>
 </tr>
 <tr>
          <th colspan="8" style="text-align: center">&nbsp;</th>
 </tr>


  </table>

 