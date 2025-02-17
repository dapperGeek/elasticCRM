<?php
$pageTitle = 'Reports';

include 'includes/header.php';
$Department = $myData['Department'];

    if($myData['changePass'] == 0)
    {
        //  $database->redirect_to($host."change-password");
    }
?>

<!-- Chart code -->
<script>
    am4core.ready(function() {

    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end

    var chart = am4core.create("chartdiv", am4charts.XYChart);

    var data = [];
    var value = 50;
    for(var i = 0; i < 300; i++)
    {
      var date = new Date();
      date.setHours(0,0,0,0);
      date.setDate(i);
      value -= Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);
      data.push({date:date, value: value});
    }

    //chart.data = data;
    chart.data = [
                    <?php
                        $yr = date('Y');

                        for($i = 1; $i <= 12; $i++)
                        {
                            $j = cal_days_in_month(CAL_GREGORIAN, $i, $yr);
                            $j = $j;
                            for($k = 1; $k <= $j; $k++)
                            {
                               $r = $database->getDailySales($k,$i,$yr);
                    ?>
                        {
                            <?php $myDate =  $yr."-".$i."-".$k;  ?>
                            "date": "<?php echo $myDate; ?>",
                            "value": <?php echo $r['Amount'] == '' ? 0 : $r['Amount'] ?>
                        },
                    <?php 
                            }
                        }
                    ?>
                ];

    // Create axes
    var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
    dateAxis.renderer.minGridDistance = 60;

    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

    // Create series
    var series = chart.series.push(new am4charts.LineSeries());
    series.dataFields.valueY = "value";
    series.dataFields.dateX = "date";
    series.tooltipText = "{value}"

    series.tooltip.pointerOrientation = "vertical";

    chart.cursor = new am4charts.XYCursor();
    chart.cursor.snapToSeries = series;
    chart.cursor.xAxis = dateAxis;

    //chart.scrollbarY = new am4core.Scrollbar();
    chart.scrollbarX = new am4core.Scrollbar();

    }); // end am4core.ready()
</script>

        <div class="row">
                <?php include("includes/make-purchase.php");?>
                    <div class="row">
                        <div class="col-md-2 col-sm-6">
                            <div class="widget widget-stats orange-bg">
                                <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
                                <div class="stats-title">TOTAL MACHINE IN FIELD</div>
                                <div class="stats-number"> <?php
                                    $mif = sizeof($database->getAllMachineInformation());
                                    echo $mif;
                                    ?></div>
                                <div class="stats-progress progress">
                                    <div style="width: 70.1%;" class="progress-bar"></div>
                                </div>
                                <!--<div class="stats-desc">Better than last week (70.1%)</div>-->
                            </div>
                        </div>
                        <!-- end col-3 -->
                        <!-- begin col-3 -->
                        <div class="col-md-2 col-sm-6 mtop15">
                            <div class="widget widget-stats aqua-bg ">
                                <div class="stats-icon stats-icon-lg"><i class="fa fa-tags fa-fw"></i></div>
                                <div class="stats-title">TOTAL ACCOUNTS</div>
                                <div class="stats-number"><?php
                                    $acInfo = sizeof($database->getAllAccountInformation());
                                    echo $acInfo;
                                    ?></div>
                                <div class="stats-progress progress">
                                    <div style="width: 40.5%;" class="progress-bar"></div>
                                </div>
                                <!--<div class="stats-desc">Better than last week (40.5%)</div> -->
                            </div>
                        </div>
                        <!-- end col-3 -->
                        <!-- begin col-3 -->
                        <div class="col-md-2 col-sm-6 mtop15">
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
                        <!-- begin col-3 -->
                        <div class="col-md-2 col-sm-6 mtop15">
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
                        <div class="col-md-2 col-sm-6 mtop15">
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

                    <div class="row">

                        <div style="margin-left:35px;">
                            <h2>DAILY SALES GRAPH</h2>
                        </div>
                        <div id="chartdiv" style="width: 100%; height: 500px;"></div>
                        <div style="margin-left:35px; text-align: right">
                <span style=" text-align: right; font-size: medium"><input type="radio" name="group" id="rb1" onclick="setPanSelect()">Select
            <input type="radio" checked="true" name="group" id="rb2" onclick="setPanSelect()">Pan</span>
                        </div>
                    </div>

                    <div class="row">
                        <!--
                            A simple Column 3D chart showing monthly revenue of Harry's SuperMart for last year.
                        -->
                        <script src="https://static.fusioncharts.com/code/latest/fusioncharts.js"></script>
                        <script src="https://static.fusioncharts.com/code/latest/fusioncharts.charts.js"></script>

                        <!--
    <?php
                        for($i = 1; $i < 13; $i++)
                        {
                            $jd=gregoriantojd($i,1,$yr);
                            $monthly = jdmonthname($jd,0);

                            $r = $database->getMonthlySales($i,$yr);

                            if($r['Amount'] =='')
                            {
                                echo 0 . "<br>";
                            }
                            else
                            {
                                echo "<h1>";
                                echo $r['Amount'] . $i."<br>";
                                echo "</h1>";
                            }
                        }
                        ?> -->

                        <?php ?>
                        <div id="chart-container"></div>

                        <script type="text/javascript">
                            FusionCharts.ready(function () {
                                var revenueChart = new FusionCharts({
                                    type: 'column3d',
                                    renderAt: 'chart-container',
                                    width: '100%',
                                    height: '500',
                                    dataFormat: 'json',
                                    dataSource: {
                                        "chart": {
                                            "caption": "MONTHLY SALES GRAPH",
                                            "subCaption": "",
                                            "xAxisName": "MONTH",
                                            "yAxisName": "AMOUNT",
                                            "paletteColors": "#0075c2",
                                            "valueFontColor": "#000",
                                            "baseFont": "Helvetica Neue,Arial",
                                            "captionFontSize": "14",
                                            "subcaptionFontSize": "14",
                                            "subcaptionFontBold": "0",
                                            "placeValuesInside": "1",
                                            "rotateValues": "1",
                                            "showShadow": "0",
                                            "divlineColor": "#999999",
                                            "divLineIsDashed": "1",
                                            "divlineThickness": "1",
                                            "divLineDashLen": "1",
                                            "divLineGapLen": "1",
                                            "canvasBgColor": "#ffffff"
                                        },

                                        "data": [
                                            <?php
                                                $yr = date('Y');
                                                for($i = 1; $i < 13; $i++)
                                                {
                                                $jd=gregoriantojd($i,1,$yr);
                                                $monthly = jdmonthname($jd,0);
                                                $r = $database->getMonthlySales($i,$yr);
                                            ?>
                                                {
                                                    "label": "<?php echo $monthly; ?>",
                                                    "value": <?php if($r['Amount'] ==''){echo 0;}else{echo $r['Amount'];}?>
                                                },
                                            <?php
                                                }
                                            ?>
                                        ]
                                    }
                                });
                                revenueChart.render();
                            });
                        </script>
                        <!--<div class="col-lg-3">
            <div class="widget green-bg no-padding">
                <div class="widget-m">
                    <h1><?php echo $database->convertToMoney($database->purchaseListForMachineCollectedDaily(date('d'),date('n'),date('Y'))); ?></h1>
                      <?php echo date('d')."- ".date('n')."- ".date('Y'); ?>
                    <h3 class="font-bold no-margins">
                        Today's Income
                    </h3>
                     <small>Sales of Consumables & Spareparts Only</small>
                </div>
                <div class="flot-chart">
                    <div class="flot-chart-content" id="flot-chart2"></div>
                </div>
            </div>
</div>-->
                    </div>
                    <br>
                    <br>

            <div id="main" role="main">
                        <div class="block">
                            <div class="clearfix"></div>

                            <!--page title-->

                            <form class="form-inline" role="form" method="post">
                                <div class="form-group" >
                                    <label class="col-md-2 control-label">SALES RANGE</label>
                                    <div class="col-md-10 row">
                                        <div class="col-lg-4">
                                            <div class="input-group date form_date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                <input class="form-control" size="16" type="text" value="<?php if(isset($_POST['txtFrom'])){echo $_POST['txtFrom'];}else{echo "01-06-2017";}?>" name="txtFrom" readonly>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="input-group date form_date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                <input class="form-control" size="16" type="text" name="txtTo" value="<?php if(isset($_POST['txtTo'])){echo $_POST['txtTo'];}else{echo date('d')."-".date('m')."-".date("Y");}?>" readonly>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span> <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4"><input type="submit" class="btn btn-large btn-success" value="preview" name="btnprev" /></div>
                                    </div>

                            </form>
                            <hr>
                        </div>
                        <!--page title end-->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="grid">
                                <div class="grid-title">
                                    <h2>&nbsp;</h2>
                                </div>
                                <div class="grid-content overflow">

                        <?php
                            $from = 20170601;
                            $to =  date("Y").date('m').date('d');
                            $totalMyAmount = 0;
                            if(isset($_POST['btnprev']))
                            {
                                $from = explode('-', $database->test_input($_POST['txtFrom']));
                                $to = explode('-', $database->test_input($_POST['txtTo']));
                                $from = $from[2].str_pad($from[1],2,"0",STR_PAD_LEFT).str_pad($from[0],2,"0",STR_PAD_LEFT);
                                $to = $to[2].str_pad($to[1],2,"0",STR_PAD_LEFT).str_pad($to[0],2,"0",STR_PAD_LEFT);
                                $myOrder = (array)$database->purchaseListForMachineCollectedAllRange($from,$to);
                        ?>
                            <div class="table-responsive">
                                <table id="tblGetPrev" class="display nowrap table responsive nowrap table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="hidden-mobile">Customer</th>
                                        <th class="hidden-mobile">Payment</th>
                                        <th class="hidden-mobile">TicketNo</th>
                                        <th class="hidden-mobile">Date</th>
                                        <th class="hidden-mobile">Amount</th>
                                        <th class="hidden-mobile">Vat</th>
                                        <th class="hidden-mobile">Discount</th>
                                        <th class="hidden-mobile">Total</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                        <?php
                                            if($myOrder != null)
                                            {
                                                //  echo count($myOrder);
                                                foreach($myOrder as $mo)
                                                {
                                                    $vat = 0;
                                                    $vatv_ = "NO VAT";
                                                    ?>
                                                    <tr>
                                                        <td class="t_center"><?php echo str_pad($mo['id'],5,"0",STR_PAD_LEFT);?></td>
                                                        <td><?php echo $mo['Name'];?></td>
                                                        <td><?php echo $mo['paymentMode'];?></td>
                                                        <td class="hidden-mobile"><a href="<?php echo $host;?>purchase-invoice/<?php echo $mo['ticketNo'];?>" target="_blank" ><?php echo $mo['ticketNo'];?></a></td>
                                                        <td><?php echo $mo['orderCollectedDate'];?></td>
                                                        <td><?php echo $database->convertToMoney($mo['myAmount']);?></td>
                                                        <td><?php
                                                            if($mo['vat'] == 1){$vat = 0.05 *$mo['myAmount'];$vatv_ = "5%";}
                                                            echo $vatv_. " - ".$database->convertToMoney($vat);
                                                            $added = $mo['myAmount'] + $vat;
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $discount = ($mo['discount']/100) * $added;
                                                            echo $mo['discount']."% - ".$database->convertToMoney($discount);
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $finalAmount = $added - $discount;
                                                            echo $database->convertToMoney($finalAmount);
                                                            $totalMyAmount = $totalMyAmount +  $finalAmount;
                                                            ?>
                                                        </td>
                                                        <td class="action-table">
                                                            <a data-toggle="modal" data-target="#myModal<?php echo $mo['ticketNo'];?>"><img src="<?php echo $host;?>images/icon/table_view.png" alt=""></a>
                                                            <div id="myModal<?php echo $mo['ticketNo'];?>"  tabindex="-1" role="dialog" style="width: 100%"  class="modal large col-lg-12"aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <?php include("../_tickets/ticket-pop.php");?>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                                                Dismiss
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                        <?php
                                        }
                                    }
                        ?>
                                        <tr>
                                            <th colspan="8">
                                                <p style="text-align: right">TOTAL:</p>
                                            </th>
                                            <th>
                                                <?php echo $database->convertToMoney($totalMyAmount);?>
                                            </th>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                        <?php
                                }
                        ?>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>

            <div class="ibox float-e-margins">
                <div id="demo2" class="ibox-content collapse in">
                    <div class="demo-container" style="height: auto !important;">
                        <div class="widgets-container">

                            <!-- Full Calendar -->
                            <div id='calendar'></div>
                            <div style='clear:both'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    include 'includes/footer.php';