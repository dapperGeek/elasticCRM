<?php
/**
 * Created by PhpStorm.
 * User: Bakar U.A.
 * Date: 23-Dec-19
 * Time: 9:55 AM
 */

        $analytic = $database->mpsAnalytics();
//        $mpsChartsData = json_encode($analytic);
?>

<div class="col-lg-6 table-responsive">
    <table id="example6" class="display table responsive table-bordered" style="">
        <thead>
        <tr>
            <th>ID</th>
            <th>Company</th>
            <th># Machines</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $n = 1;
        foreach ($analytic as $item){
            ?>
            <tr>
                <td><?php echo $n ; ?></td>
                <td>
                    <a href="<?php echo $host . 'contracts/mps/' . $item['id'] ?>">
                        <?php echo $item['name'] ; ?>
                    </a>
                </td>
                <td><?php echo $item['number'] ; ?></td>
            </tr>
            <?php
            $n++;
        }
        ?>
        </tbody>
    </table>
</div>

