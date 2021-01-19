<?php
    include 'topHeader.php';

    if (isset($pageHeader) && $pageHeader != 'contractAccountInfo')
    {
?>
    <div class="row wrapper border-bottom page-heading">
        <div class="col-lg-12">
            <?php
            echo PageHeaders::getHeading($pageHeader);
            ?>
        </div>
        <div class="col-lg-12"> </div>
    </div>

    <div class="row">

        <div class="col-lg-12">

            <!-- start page main section -->
            <div class="widget white-bg box-shadow p-xl">
<?php
    }