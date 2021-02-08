<?php
/**
 * Created by PhpStorm.
 * User: Uthman A. Bakar
 * Date: 26-Feb-20
 * Time: 10:01 AM
 */

    if (file_exists("includes/mains.php"))
    {
        include ("includes/mains.php");
    }
    else
    {
        include ("../includes/mains.php");
    }
?>
<div class="col-lg-12">

        <h2 class="margin-bottom-10"><center>Service Calls Summary</center></h2>
<?php
        $serviceCalls = $database->getAllServiceCall(date('F'));
        $delayedCalls = UtilFunctions::getDelayedCalls($serviceCalls);
    //                echo '<pre>';
    //                echo time();
    //                print_r($times);
    //                echo  '</pre>';
    ?>
    <!--            Total monthly calls logged -->
    <div class="col-md-4 col-sm-4">
        <div class="widget widget-stats orange-bg">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-volume-control-phone fa-fw"></i></div>
            <div class="stats-title">TOTAL CALLS <?php echo strtoupper(date('F')) ?></div>
            <div class="stats-number"> <?php

                $serviceCallsRows = sizeof($serviceCalls);
                echo $serviceCallsRows;
                ?></div>
            <div class="stats-progress progress">
                <div style="width: 100%;" class="progress-bar"></div>
            </div>
            <!--<div class="stats-desc">Better than last week (70.1%)</div>-->
        </div>
    </div>

    <!--        Monthly calls resolved-->
    <div class="col-md-4 col-sm-4">
        <div class="widget widget-stats green-bg">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-phone-square fa-fw"></i></div>
            <div class="stats-title">RESOLVED CALLS </div>
            <div class="stats-number"> <?php
                $resolvedCalls = sizeof($database->getAllResolvedServiceCall(date('F')));
                echo $resolvedCalls;
                ?></div>
            <div class="stats-progress progress">
                <div style="width: <?php echo UtilFunctions::getPercentage($resolvedCalls, $serviceCallsRows) ?>;" class="progress-bar"></div>
            </div>
            <!--<div class="stats-desc">Better than last week (70.1%)</div>-->
        </div>
    </div>
    <!-- end Monthly calss resolved -->

    <!-- Monthly calls delayed -->
    <div class="col-md-4 col-sm-4">
        <div class="widget widget-stats aqua-bg ">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-tags fa-fw"></i></div>
            <div class="stats-title">DELAYED CALLS</div>
            <div class="stats-number">
                <?php
                $delayed = UtilFunctions::getDelayedCalls($serviceCalls);
                $acInfo = sizeof($delayed);
                echo $acInfo;
                ?></div>
            <div class="stats-progress progress">
                <div style="width: <?php echo UtilFunctions::getPercentage(sizeof($delayedCalls) , sizeof($serviceCalls)) ?>;" class="progress-bar"></div>
            </div>
            <!--<div class="stats-desc">Better than last week (40.5%)</div> -->
        </div>
    </div>
    <!-- end Monthly calls delayed -->

    <!-- begin Total calls logged -->
    <div class="col-md-4 col-sm-4">
        <div class="widget widget-stats purple-bg">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-volume-control-phone fa-fw"></i></div>
            <div class="stats-title">TOTAL CALLS LOGGED</div>
            <div class="stats-number"><?php
                $sc = sizeof($database->getAllServiceCall());
                echo $sc;
                ?></div>
            <div class="stats-progress progress">
                <div style="width: <?php echo $sc."%";?>" class="progress-bar"></div>
            </div>
            <!--<div class="stats-desc">Better than last week (76.3%)</div> -->
        </div>
    </div>
    <!-- end col-3 -->

    <!-- Total calls resolved -->
    <div class="col-md-4 col-sm-4">
        <div class="widget widget-stats black-bg">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-phone-square fa-fw"></i></div>
            <div class="stats-title">TOTAL CALLS RESOLVED</div>
            <div class="stats-number"><?php
                $rsc = sizeof($database->getAllResolvedServiceCall());
                echo $rsc;
                ?></div>
            <div class="stats-progress progress">
                <div style="width: <?php echo $rsc."%";?>;" class="progress-bar"></div>
            </div>
            <!--<div class="stats-desc">Better than last week (54.9%)</div>  -->
        </div>
    </div>

    <div class="col-md-4 col-sm-4">
        <?php
        $color = "red";
        $icon = "level-down";
        $xValue = $database->calculatePercentage($rsc,$sc);
        if($xValue > 60){$color="blue";$icon="level-up";}

        ?>
        <div class="widget widget-stats <?php echo $color;?>-bg">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-<?php echo $icon;?> fa-fw"></i></div>
            <div class="stats-title">CALLS PERCENTAGE</div>
            <div class="stats-number">
                <?php echo round($xValue,2)."%";?>

            </div>
            <div class="stats-progress progress">
                <div style="width: <?php echo round($xValue,2)."%";?>;" class="progress-bar"></div>
            </div>
            <!--<div class="stats-desc">Better than last week (54.9%)</div>  -->
        </div>
    </div>

</div>

