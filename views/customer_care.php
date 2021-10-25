<?php
/**
 * Created by PhpStorm.
 * User: Uthman A. Bakar
 * Date: 27-Feb-20
 * Time: 9:00 AM
 */
    if (file_exists("includes/mains.php")){
        include ("includes/mains.php");
    }
    else{
        include ("../includes/mains.php");
    }
?>

<div class="row col-lg-12 margin-bottom-10">
    <?php
            include('serviceCallsFigures.php');
    ?>
</div>
    <?php
            echo '<center><h2 class="margin-bottom-10">
    Service Calls
        </h2></center>';
            include('serviceCalls.php');


