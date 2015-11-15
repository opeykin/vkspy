<?php

require("../resources/config.php");
require("util/VkApi.php");
require("util/VkSpyDb.php");
require("util/misc.php");

$uid = filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_STRING);

if (!VkApi::isValidUid($uid)) {
    errorRedirectRoot("invalid uid");
}

$db = new VkSpyDb($config);

if ($db->hasUid($uid)) {
    errorRedirectRoot("already have this id in database");
}



