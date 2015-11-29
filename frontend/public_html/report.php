<!DOCTYPE html>
<?php

require('../resources/config.php');
require('util/VkSpyDb.php');
require('util/misc.php');

$uid = filter_input(INPUT_GET, "uid", FILTER_SANITIZE_STRING);
$db = new VkSpyDb($config);

$user = $db->getUser($uid);
if (!$user) {
    errorRedirectRoot("No such id in database");
}

$firstName = $user["first_name"];
$lastName = $user["last_name"];

echo "<script>var uid = $uid; var firstName = '$firstName'; var lastName = '$lastName';</script>";

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

        function getTimeZone() {
            return -Math.floor(new Date().getTimezoneOffset() / 60);
        }

        google.load("visualization", "1", {packages:["bar"]});
        google.setOnLoadCallback(loadDataAndDrawChart);

        function loadDataAndDrawChart() {
            var timeZone = getTimeZone();
            loadDailyUsageData(uid, timeZone, drawChart);
        }

        function drawChart(jsonResponse) {
            var response = JSON.parse(jsonResponse).response;

            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Date');
            data.addColumn('timeofday', 'Duration');

            for (var i = 0; i < response.length; ++i) {
                var entry = response[i];

                var date = new Date(entry.date);

                var hours = Math.floor(entry.duration / 3600);
                var minutes = Math.floor((entry.duration - hours * 3600) / 60);

                data.addRow([date, [hours, minutes, 0]]);
            }

            var options = google.charts.Bar.convertOptions({
                title: "vk.com daily usage statistics for " + firstName + " " + lastName,
                hAxis: {
                    format: 'd/MMM/yy',
                    gridlines: {color: 'none'}
                },
                vAxis: {
                    minValue: 0,
                    format: 'H:mm'
                },
                legend: {position: 'none'}
            });

            var chart = new google.charts.Bar(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
</body>
</html>