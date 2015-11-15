<?php

require("../resources/config.php");
require("util/VkSpyDb.php");
require("util/VkApi.php");
require("util/misc.php");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

$user = VkApi::getUser($id);

if (!$user) {
    errorRedirectRoot("invalid id");
}

$uid = $user->uid;
$db = new VkSpyDb($config);

if ($db->hasUid($uid)) {
    header("Location: /report.php?uid=" . $uid, true);
    die();
}

header("Location: /addId.php?uid=" . $uid, true);
die();
