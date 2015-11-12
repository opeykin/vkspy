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

$pdo = connect($config);

$rows = array('uid', 'first_name', 'last_name', 'add_time');
$result = $pdo->query('SELECT * FROM users');

printTable($result, $rows);

$pdo = null;

?>

</body>
</html>