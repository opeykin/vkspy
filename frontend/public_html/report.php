<!DOCTYPE html>
<?php

require('../resources/config.php');
require('util/VkSpyDb.php');
require('util/misc.php');

$uid = filter_input(INPUT_GET, "uid", FILTER_SANITIZE_STRING);
$db = new VkSpyDb($config);

if (!$db->hasUid($uid)) {
    errorRedirectRoot("No such id in database");
}

echo "<script>var uid = $uid;</script>";

$db = null;
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        function httpGet(url, callback) {
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.onreadystatechange = function () {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
                    callback(xmlHttp.responseText);
            };
            xmlHttp.open("GET", url, true); // true for asynchronous
            xmlHttp.send(null);
        }

        function getDailyUsageReportUrl(uid, timeZone) {
            return "http://" + window.location.host + "/dailyUsage.php?uid=" + uid + "&time_zone=" + timeZone;
        }

        function loadDailyUsageData(uid, timeZone, callback) {
            var url = getDailyUsageReportUrl(uid, timeZone);
            httpGet(url, callback);
        }

        google.load("visualization", "1", {packages:["bar"]});
        google.setOnLoadCallback(loadDataAndDrawChart);

        function loadDataAndDrawChart() {
            loadDailyUsageData(uid, "3", drawChart);
        }

        function drawChart(jsonResponse) {
            var response = JSON.parse(jsonResponse).response;

            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Date');
            data.addColumn('number', 'Duration');

            for (var i = 0; i < response.length; ++i) {
                var entry = response[i];
                var date = new Date(entry.date);

                // TODO: change timezone here. date is in UTC
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