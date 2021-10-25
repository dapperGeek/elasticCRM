<?php
<<<<<<< HEAD
include("../data/DBConfig.php");
include_once("../data/sessioncheck.php");
    $id = $database->test_input($_GET['id']);
    $grt = $database->getIndGoodsRecieved($id);
    if(empty($grt))
    {
        $database->redirect_to($host."view-goods-recieve-ticket");
    }
=======
  include("../data/DBConfig.php");
  include_once("../data/sessioncheck.php");
  $id = $database->test_input($_GET['id']);
  $grt = $database->getIndGoodsRecieved($id);
      if(empty($grt)){
        $database->redirect_to($host."view-goods-recieve-ticket");
      }
>>>>>>> 48136f1b63a2e7fb659fed72c5bf93f60ec79592
?>

<table width="80%" align="center"  border=0>
    <tr>
<<<<<<< HEAD
        <th colspan="2"><h2>GOODS RECEIVED TICKET</h2></th>
    </tr>
    <tr>
        <td>
            <b>INVOICE NO:</b> <?php echo $grt['invoiceNo'];?><br/>
            <b>INVOICE DATE:</b> <?php echo $grt['invoiceDate'];?> <br/>
            <b>SUPPLIER NAME:</b> <?php echo $grt['supplierName'];?><br/>
            <b> FILE REFERENCE:</b> <?php echo $grt['FileReference'];?><br/>
            <b>ORDER ID:</b> <?php echo str_pad($grt['id'],5,"0",STR_PAD_LEFT);?><br/>
            <b>TICKET NO:</b> <?php echo $grt['TicketNo'];?><br/>
            <b>SERIAL NO:</b> <?php echo $grt['serialNumber'];?><br/>
            <b>STORE:</b> <?php echo $grt['storeName'];?><br/>
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
        <th>QTY</th>
        <th>CODE</th>
        <th colspan="2">REMARKS</th>
    </tr>

    <?php
        $myCollect = (array)$database->getAllGoodsAddedForRecieve($id);
        $N = 1;
        foreach($myCollect as $mc)
        {
    ?>
        <tr>
            <th><?php echo $N;?></th>
            <td colspan="2" align="center"><?php echo $mc['productName'];?> </td>
            <td align="center"><?php echo sprintf('%u %s', $mc['AddedQty'], $mc['unitName']);?></td>
            <td align="center"><?php echo $mc['Code'];?></td>
            <td colspan="2"></td>
        </tr>

    <?php 
           $N++;
        }
    ?>
    <tr>
        <th colspan="7" style="text-align: center">RECEIVED BY : <?php echo $grt['fullname'];?></th>
    </tr>

</table>
=======
        <th colspan="2"><h2> GOODS RECIEVED TICKET</h2></th>
    </tr>
  <tr>
    <td>
        <b>INVOICE NO:</b> <?php echo $grt['invoiceNo'];?><br/>
        <b>INVOICE DATE:</b> <?php echo $grt['invoiceDate'];?> <br/>
        <b>SUPPLIER NAME:</b> <?php echo $grt['supplierName'];?><br/>
       <b> FILE REFERENCE:</b> <?php echo $grt['FileReference'];?><br/>
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
          <th colspan="7" style="text-align: center"> ITEMS</th>
 </tr>
       <tr>
           <th>S/N</th>
              <th colspan="2">PRODUCT </th>
              <th>QTY</th>
                   <th>CODE</th>
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
              <td align="center"><?php echo $mc['AddedQty'];?></td>
                <td align="center"><?php echo $mc['Code'];?></td>
              <td align="center"><?php echo $mc['unitName'];?> </td>
           <td colspan="2"></td>

      </tr>

      <?php $N++;}?>
<tr>
          <th colspan="7" style="text-align: center">PREPARE BY : <?php echo $grt['fullname'];?></th>
 </tr>


  </table>
>>>>>>> 48136f1b63a2e7fb659fed72c5bf93f60ec79592
