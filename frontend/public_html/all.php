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


$db = new VkSpyDb($config);
$result = $db->getAllUsers();
$rows = array('uid', 'first_name', 'last_name', 'add_time');

printTable($result, $rows);

$pdo = null;

?>

</body>
</html>