<?php
  include("../data/DBConfig.php");
  
  $totalAmount = unserialize($_GET['array1']);
  $eachAmount   =  unserialize($_GET['array2']);
  $eachUnitPrice  = unserialize($_GET['array3']);
  //$eachAmount = unserialize($_GET['array1']);
   //var_dump($eachAmount);
  // exit;
  $id = $database->test_input($_GET['id']);
 
      $grt = $database->getIndGoodsRemovedDeliveryUpdate($id);
     //echo $grt['TicketNo'];
     // if(empty($grt)){
         if($grt['TicketNo'] == null ){
       // $database->redirect_to($host."view-goods-recieve-ticket");
        $grt = $database->getIndGoodsRemoved($id);
      }

      $vat = 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Tenaui Africa | We speak by Image</title>
     <style>
        *
        {
            margin:10;
            padding:10;
            font-family:Arial;
            font-size:10pt;
            color:#000;
        }
        body
        {
            width:100%;
            font-family:Arial;
            font-size:10pt;
            margin:0;
            padding:0;

        }
         
        p
        {
            margin:0;
            padding:0;
        }
         
        #wrapper
        {
            width:180mm;
            margin:0 10mm;
             margin-bottom:  30px;
        }
         
        .page
        {
            height:297mm;
            width:210mm;
            page-break-after:always;
        }
 
        table
        {
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
             
            border-spacing:0;
            border-collapse: collapse; 
             
        }
         
        table td 
        {
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            padding: 2mm;
        }
         
        table.heading
        {
            height:40mm;
        }
         
        h1.heading
        {
            font-size:12pt;
            color:#000;
            font-weight:normal;
        }
         
        h2.heading
        {
            font-size:9pt;
            color:#000;
            font-weight:normal;
        }
         
        hr
        {
            color:#ccc;
            background:#ccc;
        }
         
        #invoice_body
        {
            /*height: 100mm;*/
        }
         
        #invoice_body , #invoice_total
        {   
            width:100%;


        }
        #invoice_body table , #invoice_total table
        {
            width:100%;
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
     
            border-spacing:0;
            border-collapse: collapse; 
             
            margin-top:3mm;
        }
         
        #invoice_body table td , #invoice_total table td
        {
            text-align:center;
            font-size:9pt;
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            padding:2mm 0;
        }
         
        #invoice_body table td.mono  , #invoice_total table td.mono
        {
            font-family:monospace;
            text-align:right;
            padding-right:3mm;
            font-size:10pt;
        }
        #invoice_body table td.mono_  , #invoice_total table td.mono_
        {
            
            text-align:right;
            padding-right:3mm;
            font-size:10pt;
        }
         
        #footer
        {   
            width:180mm;
            margin:0 15mm;
            padding-bottom:3mm;

        }
        #footer table
        {
            width:100%;
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
             
            background:#eee;
             
            border-spacing:0;
            border-collapse: collapse; 
        }
        #footer table td
        {
            width:25%;
            text-align:center;
            font-size:9pt;
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div id="wrapper">
     <p style="text-align:center; font-weight:bold; padding-top:5mm;">&nbsp;</p>

<table class="heading" style="width:100%;" align="center"  border=0>
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
  <table border=1 style="width:100%;font-size:13px" align="center" cellpadding="2" cellspacing="0">

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

</div>

  
     
</body>
</html>