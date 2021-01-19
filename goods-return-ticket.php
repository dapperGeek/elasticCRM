


<?php
  include("data/DBConfig.php");
  include_once("data/sessioncheck.php");
  $id = $database->test_input($_GET['id']);

  // echo "<h1>$id</h1>";
  $grt1 = $database->getAllReturnTicketId($id);
      if(empty($grt)){
        //$database->redirect_to($host."view-goods-recieve-ticket");
      }
?>

<table width="80%" align="center"  border=0>
    <tr>
        <th colspan="2"><h2> GOODS RETURN TICKET</h2></th>
    </tr>
  <tr>
    <td> 
    	<?php    foreach($grt1 as $grt){  }?>
        <b>INVOICE NO:</b> <?php echo $grt['invoiceNo'];?><br/>
        <b>INVOICE DATE:</b> <?php echo $grt['invoiceDate'];?> <br/>
         <b>RETURN DATE:</b> <?php echo $grt['invoiceDate'];?> <br/>
        <b>CUSTOMER NAME:</b> <?php echo $grt['custormerName'];?><br/>
      
       <b>ORDER ID:</b> <?php echo str_pad($grt['id'],5,"0",STR_PAD_LEFT);?><br/>
        <b>TICKET NO:</b> <?php echo $grt['ticketGen'];?><br/>
        <b>STORE:</b> <?php echo $grt['store'];?><br/>

        <?php?>

    </td>
    <td align="right"><img src="img/tenaui-logo.jpg" width="100" height="100"></td>
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
            $myCollect = (array)$database->getAllReturnTicketId($id);
            $N = 1;
            foreach($myCollect as $mc){
      ?>
      <tr>
           <th><?php echo $N;?></th>
              <td colspan="2" align="center"><?php  $Product = $mc['productName'];
                                        $Product = $database->getProductName($Product);
                                        foreach ($Product as $Products) {
                                          echo  $Products['productName'];
                                       
                                    ?> </td>
              <td align="center"><?php echo $mc['returned'];?></td>
                <td align="center"><?php echo $Products['Code'];?></td>
              <td align="center"><?php echo $Products['unitID']; }?> </td>
           <td colspan="2"></td>

      </tr>

      <?php $N++;}?>
<tr>
          <th colspan="7" style="text-align: center">PREPARE BY : <?php echo $mc['store'];?></th>
 </tr>


  </table>