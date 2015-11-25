<!DOCTYPE html>
<?php

require('../resources/config.php');
require('util/VkSpyDb.php');
require('util/misc.php');
require('util/OnlineCalculator.php');

$uid = filter_input(INPUT_GET, "uid", FILTER_SANITIZE_STRING);
//$uid = 7860407;
$db = new VkSpyDb($config);

if (!$db->hasUid($uid)) {
    echo "No such id in database";
    die();
}

$stat = $db->getStat($uid);

$calculator = new OnlineCalculator();

foreach ($db->getStat($uid) as $value) {
    $date = parsePostgreDate($value["time"]);
    $calculator->add($date);
}

$arr = $calculator->getResult();

$json = json_encode($arr);
echo "<script>var dataJson = $json</script>";

$db = null;
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["bar"]});
        google.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = new google.visualization.DataTable();

            data.addColumn('date', 'Date');
            data.addColumn('number', 'Duration');

            for (var i = 0; i < dataJson.length; ++i) {
                var entry = dataJson[i];
                var date = new Date(entry.date);

                date.setHours(0);
                date.setMinutes(0);
                date.setSeconds(0);
                date.setMilliseconds(0);

                data.addRow([date, entry.duration]);
            }

            var options = {
                title: 'Online statistics',
                hAxis: {title: 'Date'},
                vAxis: {title: 'Time'},
                legend: 'none'
            };

            var chart = new google.charts.Bar(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
</body>
</html>