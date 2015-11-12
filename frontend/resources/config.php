<?php

$config = array(
    "db" => array(
        "name" => "alex",
        "username" => "vkspy_stat_collector",
        "password" => "password",
        "host" => "localhost",
        "port" => 5432
    ),
    "urls" => array(
    "baseUrl" => "http://vkspy.info"
    ),
    "paths" => array(
    "resources" => "/path/to/resources",
    "images" => array(
        "content" => $_SERVER["DOCUMENT_ROOT"] . "/images/content",
        "layout" => $_SERVER["DOCUMENT_ROOT"] . "/images/layout"
    )
)
);


//defined("LIBRARY_PATH")
//or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));
//
//defined("TEMPLATES_PATH")
//or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));

ini_set("error_reporting", "true");
error_reporting(E_ALL);

?>