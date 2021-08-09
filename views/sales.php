<?php
/**
 * Created by PhpStorm.
 * User: Bakar U.A.
 * Date: 13-Nov-19
 * Time: 12:33 PM
 */

if (file_exists('data/DBConfig.php')){
    include 'data/DBConfig.php';
}
else{
    include '../data/DBConfig.php';
}

    //    echo $data;
    if (!isset($_GET['id']))
    {
?>
        <div class="row col-lg-12" style="margin-top: 20px">
            <div class="row">
<!--                MPS Machines Number Charts-->
<?php

    include('mpsNumbersChart.php');
    include ('mpsNumbersTable.php');
    include ('machineFigures.php');
?>
                <!--  MPS Machines Number Table div-->

            </div>
        </div>

<?php
    }
    else
    {
        $account = $database->getSingleAccountInformation($_GET['id']);
        $billingInfo = $database->getMpsContracts($_GET['id']);
?>
    <div class="col-lg-12 row">
        <h3><center><?php  echo $account['Name'] . " Billing Details for " . date('Y') ?></center></h3>
        <div class="table-responsive">
            <table class="display nowrap table  responsive nowrap table-bordered">
                <thead>
                    <th width="5%">S/No.</th>
                    <th width="10%">Machine</th>
                    <th width="10%>Code</th>
                    <th width="10%>Department</th>
                </tr>
            </thead>
            <tbody>
<?php
        foreach ($billingInfo as $item)
        {
            $machineID = $item->machineID;
            $contractID = $item->contractID;
            $machineCode = $item->machine_code;
            $rentalCharge = $item->RentalCharge;
            $minVolumeMono = $item->minVolMono;
            $minVolumeColor = $item->minVolColor;
            $excessMonoCharge = $item->excessCostMono;
            $excessColorCharge = $item->excessCostColor;
            $mReading = $database->getBillingFromMeterReading($contractID, $machineID, $machineCode, $rentalCharge, $minVolumeMono, $minVolumeColor, $excessMonoCharge, $excessColorCharge);
            $metrics[] = $mReading;
        }

        $n = 1;
        foreach ($metrics as $met)
        {
//          for ($x = 0; $x < count($met); $x++){
            echo '<pre>';
            print_r($met);
            echo '</pre>';
?>
                <tr>
                    <td><?php echo $n ?></td>
                    <td><?php echo $met[0]['machineCode'] ?></td>
                    <td><?php echo '' ?></td>
                    <td><?php echo '' ?></td>
                </tr>
<?php
//           }
            $n++;
        }
?>
            </tbody>
            </table>
        </div>
    </div>
<?php
    }
?>
