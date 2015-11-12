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
