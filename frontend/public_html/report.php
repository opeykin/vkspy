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

$uid = filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_STRING);
$pdo = connect($config);

$userResult = $pdo->query("SELECT * FROM users WHERE uid=$uid");

if (!$userResult) {
    echo "uid is just wrong";
    die();
}

$res = $userResult->fetchAll(PDO::FETCH_ASSOC);

if (count($res) === 0) {
    echo "No such id in database";
    die();
}


$statsResult = $pdo->query("SELECT * FROM stats WHERE uid=$uid");
$rows = array('online', 'time');
printTable($statsResult, $rows);

$pdo = null;
?>

</body>
</html>