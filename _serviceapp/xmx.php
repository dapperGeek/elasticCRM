
<?php
 include("../data/DBConfig.php");
$ddate = "2012-10-18";
$date = new DateTime($ddate);
$week = $date->format("W");
echo "Weeknummer: $week";

// Delimiters may be slash, dot, or hyphen
$date = "04/30/1973";

?>
<table class="table table-bordered table-hover bottom0 ">
                                 <thead>
                                    <tr>
                                       <th>Order #</th>
                                       <th>Order Date</th>
                                       <th>Order Time</th>
                                       <th>Amount (NGN)</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                      <?php

                                        $myOrder = (array)$database->purchaseListForMachineCollected(40,1);
                                        foreach($myOrder as $mo){
                                      ?>
                                         <tr>
                                       <td><?php echo $mo['ticketNo'];?></td>
                                       <td><?php echo $mo['orderCollectedDate'];?></td>
                                       <td>3:29 PM</td>
                                       <td>$323.33</td>
                                    </tr>
                                      <?php }?>


                                 </tbody>
                              </table>
?>

