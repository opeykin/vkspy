<?php

header('Content-type: application/json');
require('../resources/config.php');
require('util/VkSpyDb.php');
require('util/misc.php');
require('util/OnlineCalculator.php');

$uid = filter_input(INPUT_GET, "uid", FILTER_SANITIZE_STRING);
$timeZoneOffset = filter_input(INPUT_GET, "time_zone", FILTER_SANITIZE_STRING);

$db = new VkSpyDb($config);

if (!$db->hasUid($uid)) {
    errorJsonResponseAndDie("No such user id in database");
}

$timeZone = toPHPTimeZone($timeZoneOffset);

if (!$timeZone) {
    errorJsonResponseAndDie("Invalid time zone " . $timeZoneOffset);
}

$stat = $db->getStat($uid);

$calculator = new OnlineCalculator();

foreach ($db->getStat($uid) as $value) {
    $date = parsePostgreDate($value["time"]);
    $date->setTimezone($timeZone);
    $calculator->add($date);
}

$arr = $calculator->getResult();

echo json_encode(array("response" => $arr));

$db = null;