<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>

<?php

require('../resources/config.php');
require('util/connection.php');
require('util/prettyPrint.php');

$uid = filter_input(INPUT_GET, "uid", FILTER_SANITIZE_STRING);
echo "uid: " . $uid;
$db = new VkSpyDb($config);

if (!$db->hasUid($uid)) {
    echo "No such id in database";
    die();
}

$stat = $db->getStat($uid);
$rows = array('online', 'time');
printTable($stat, $rows);

$pdo = null;
?>

</body>
</html>