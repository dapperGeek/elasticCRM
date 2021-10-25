<?php
$pageHeader = 'viewWorkshop';
include("../includes/header_with_pageHeading.php");
?>

    <div class="row">
        <div class="col-lg-12 top20 bottom20">
            <div class="widgets-container">
                <div class="table-responsive">
                    <table id="example7"  class="display nowrap table  responsive nowrap table-bordered">
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>TicketNo.</th>
                            <th>Account</th>
                            <th>Category</th>
                            <th>Product Name</th>
                            <th>Code</th>
                            <th>SerialNo.</th>
                            <th>Date&Time</th>
                            <th>Engineer</th>
                            <th>Status</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>S/N</th>
                            <th>TicketNo.</th>
                            <th>Account</th>
                            <th>Category</th>
                            <th>Product Name</th>
                            <th>Code</th>
                            <th>SerialNo.</th>
                            <th>Date&Time</th>
                            <th>Engineer</th>
                            <th>Status</th>


                        </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        $i=0;
                        $machines = (array)$database->getAllMachineWorkshopInformation();
                        foreach ($machines as $machine) {
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i;?></td>

                                <td><a href="<?php echo $host;?>workshop-ticket-info/<?php echo $machine['ticketGen']?>"> <?php echo $machine['ticketGen']?> </td>
                                <td><?php echo strtoupper($machine['account_name']);?></td>
                                <td><?php echo $machine['category'];?></td>
                                <td><?php echo $machine['machine_name'];?></td>
                                <td><?php echo $machine['machine_code'];?></a></td>


                                <td><?php echo $machine['serialNo'];?></td>

                                <td><?php echo $machine['doi'];?></td>
                                <td><?php echo $machine['assign_engineer'];?></td>
                                <td><a class="badge badge-warning" href="<?php echo $host;?>workshop-follow-up/<?php echo $machine['ticketGen'];?>">FOLLOW-UP</a> </td>

                            </tr>

                        <?php }?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php
include '../includes/footer.php';