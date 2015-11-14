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

class VkSpyDb
{
    private $pdo;

    public function __construct($config)
    {
        $db = $config['db'];
        $host = $db['host'];
        $dbname = $db['name'];
        $port = $db['port'];
        $username = $db['username'];
        $password = $db['password'];
        $this->pdo = new SafePDO("pgsql:host=$host port=$port dbname=$dbname", $username, $password);
    }

    public function __destruct()
    {
        $pdo = null;
    }

    public function hasUid($uid)
    {
        $userResult = $this->pdo->query("SELECT * FROM users WHERE uid=$uid");

        if (!$userResult) {
            return false;
        }

        $res = $userResult->fetchAll(PDO::FETCH_ASSOC);
        return count($res) !== 0;
    }

    public function getStat($uid)
    {
        return $this->pdo->query("SELECT * FROM stats WHERE uid=$uid");
    }
}
