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
echo "uid: " . $uid;
$db = new VkSpyDb($config);

if (!$db->hasUid($uid)) {
    echo "No such id in database";
    die();
}

$stat = $db->getStat($uid);
$rows = array('mobile', 'time');
printTable($stat, $rows);

$pdo = null;
?>

</body>
</html>