<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>

<?php

require('../resources/config.php');
require('util/VkSpyDb.php');
require('util/misc.php');

$uid = filter_input(INPUT_GET, "uid", FILTER_SANITIZE_STRING);
echo "uid: " . $uid . "\n";
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

    $date = parsePostgreDate($first["time"]);
    $duration = dateIntervalInSeconds($first["time"], $last["time"]) + 60;
    $mobile = $first["mobile"];

    $entry = array("date" => $date, "duration" => $duration, "mobile" => $mobile);
    $arr[] = $entry;
}

$json = json_encode($arr);
echo $json;

$pdo = null;
?>

</body>
</html>