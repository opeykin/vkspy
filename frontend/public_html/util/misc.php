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

function parsePostgreDate($date)
{
    return DateTime::createFromFormat('Y-m-d H:i:s.uP', $date);
}

function dateIntervalInSeconds($dateStr1, $dateStr2)
{
    $date1 = parsePostgreDate($dateStr1);
    $date2 = parsePostgreDate($dateStr2);

    $interval = $date1->diff($date2);
    return date_create('@0')->add($interval)->getTimestamp();
}


