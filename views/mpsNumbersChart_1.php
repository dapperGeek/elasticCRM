<?php
/**
 * Created by PhpStorm.
 * User: Bakar U.A.
 * Date: 23-Dec-19
 * Time: 9:52 AM
 */
?>


<!--        Graph div -->
<div class="col-lg-6">
    <script>
        am4core.ready(function() {

// Themes begin
            am4core.useTheme(am4themes_animated);
// Themes end

            // Create chart instance
            var chart = am4core.create("chartdiv", am4charts.XYChart);

            chart.data = <?php echo $data ?> ;

// Create axes
            var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "name";
            categoryAxis.numberFormatter.numberFormat = "#";
            categoryAxis.renderer.inversed = true;
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.renderer.cellStartLocation = 0.1;
            categoryAxis.renderer.cellEndLocation = 0.9;

            var  valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
            valueAxis.renderer.opposite = true;

// Create series
            function createSeries(field, name) {
                var series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.valueX = field;
                series.dataFields.categoryY = "name";
                series.name = name;
                series.columns.template.tooltipText = "{companyName}: [bold]{valueX}[/]";
                series.columns.template.height = am4core.percent(100);
                series.sequencedInterpolation = true;

                var valueLabel = series.bullets.push(new am4charts.LabelBullet());
                valueLabel.label.text = "{valueX}";
                valueLabel.label.horizontalCenter = "left";
                valueLabel.label.dx = 10;
                valueLabel.label.hideOversized = false;
                valueLabel.label.truncate = false;

                var categoryLabel = series.bullets.push(new am4charts.LabelBullet());
                categoryLabel.label.text = "{name}";
                categoryLabel.label.horizontalCenter = "right";
                categoryLabel.label.dx = -10;
                categoryLabel.label.fill = am4core.color("#fff");
                categoryLabel.label.hideOversized = false;
                categoryLabel.label.truncate = false;
            }

            createSeries("number", "Number of Machines");
            // createSeries("expenses", "Expenses");

        }); // end am4core.ready()
    </script>

    <h2><center>MPS Accounts Showing Number of Machines</center></h2>

    <div class="col-md-8" id="chartdiv"></div>
</div>

