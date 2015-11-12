<?php

require('SafePDO.php');

function connect($config)
{
    $db = $config['db'];
    $host = $db['host'];
    $dbname = $db['name'];
    $port = $db['port'];
    $username = $db['username'];
    $password = $db['password'];
    return new SafePDO("pgsql:host=$host port=$port dbname=$dbname", $username, $password);
}

