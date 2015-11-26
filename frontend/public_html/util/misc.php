<?php

/**
 * @param $data
 * @param $rows
 */
function printTable($data, $rows)
{
    echo "<table>\n";

    echo '<tr>';
    foreach ($rows as $row) {
        echo '<td>' . $row . '</td>';
    }
    echo '</tr>';


    foreach ($data as $line) {
        echo '<tr>';
        foreach ($rows as $row) {
            echo '<td>' . $line[$row] . '</td>';
        }
        echo '</tr>';
    }

    echo "</table>\n";
}

function errorRedirectRoot($msg)
{
    echo "Error: " . $msg;
    header("Refresh:3; url=/", true);
    exit();
}

function errorJsonResponseAndDie($error_msg)
{
    $json = json_encode(array("error" => array("reason" => $error_msg)));
    echo $json;
    die();
}

function parsePostgreDate($date)
{
    return DateTime::createFromFormat('Y-m-d H:i:s.uP', $date);
}

function dateIntervalInSeconds($date1, $date2)
{
    $interval = $date1->diff($date2);
    return date_create('@0')->add($interval)->getTimestamp();
}

function sameDay($date1, $date2)
{
    $format = "Y-m-d";
    return $date1->format($format) === $date2->format($format);
}

function datesAreClose($date1, $date2, $diffSeconds)
{
    return dateIntervalInSeconds($date1, $date2) < $diffSeconds;
}

function toPHPTimeZone($timeZoneOffset)
{
    $timeZone = 'Etc/GMT'.($timeZoneOffset <= 0 ? '+' : '').(-$timeZoneOffset);
    return timezone_open($timeZone);
}



