<!DOCTYPE html>
<?php

require('../resources/config.php');
require('util/VkSpyDb.php');
require('util/misc.php');

$uid = filter_input(INPUT_GET, "uid", FILTER_SANITIZE_STRING);
$db = new VkSpyDb($config);

if (!$db->hasUid($uid)) {
    echo "No such id in database";
    die();
}

function datesAreClose($record1, $record2, $diffSeconds)
{
    return dateIntervalInSeconds($record1["time"], $record2["time"]) < $diffSeconds;
}

$stat = $db->getStat($uid)->fetchAll();

$rowCount = count($stat);

$arr = array();

for ($i = 0; $i < $rowCount; $i++) {
    $j = $i + 1;
    while ($j < $rowCount && datesAreClose($stat[$j - 1], $stat[$j], 120)) {
        $j++;
    }

    $first = $stat[$i];
    $last = $stat[$j - 1];

    $date = parsePostgreDate($first["time"])->getTimestamp() * 1000;
    $duration = dateIntervalInSeconds($first["time"], $last["time"]) + 60;
    $mobile = $first["mobile"];

    $entry = array("date" => $date, "duration" => $duration, "mobile" => $mobile);
    $arr[] = $entry;
    $i = $j;
}

$json = json_encode($arr);
echo "<script>var dataJson = $json</script>";

$db = null;
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = new google.visualization.DataTable();

            data.addColumn('date', 'Date');
            data.addColumn('timeofday', 'Time');

            for (var i = 0; i < dataJson.length; ++i) {
                var entry = dataJson[i];
                var date = new Date(entry.date);
                data.addRow([date, [date.getHours(), date.getMinutes(), date.getSeconds()]]);
            }

            var options = {
                title: 'Online statistics',
                hAxis: {title: 'Date'},
                vAxis: {title: 'Time'},
                legend: 'none'
            };

            var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
</body>
</html>