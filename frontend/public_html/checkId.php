<?php

require("../resources/config.php");
require("util/connection.php");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

$url = $config["urls"]["vkUsers"] . $id;
$responseText = file_get_contents($url);
$response = json_decode($responseText);

if (property_exists($response, "error") || count($response->response) === 0) {
    echo "Error: invalid id";
    header("Refresh:3; url=/", true);
    die();
}

$uid = $response->response[0]->uid;
$db = new VkSpyDb($config);
if ($db->hasUid($uid)) {
    header("Location: /report.php?id=" . $uid, true);
    die();
}

echo "no such id in database";
