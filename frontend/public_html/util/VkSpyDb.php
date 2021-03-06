<?php

require('SafePDO.php');

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

    public function getUser($uid)
    {
        $userResult = $this->pdo->query("SELECT * FROM users WHERE uid=$uid");

        if (!$userResult) {
            return false;
        }

        $res = $userResult->fetchAll(PDO::FETCH_ASSOC);
        if (count($res) === 0)
            return false;

        return $res[0];
    }

    public function hasUid($uid)
    {
        return $this->getUser($uid) !== false;
    }

    public function getStat($uid)
    {
        return $this->pdo->query("SELECT * FROM stats WHERE uid=$uid ORDER BY time");
    }

    public function getAllUsers()
    {
        return $this->pdo->query("SELECT * FROM users");
    }

    public function addUser($user)
    {
        $statement = "INSERT INTO users VALUES ({$user->uid}, '{$user->first_name}', '{$user->last_name}', now());";
        return $this->pdo->exec($statement);
    }
}
