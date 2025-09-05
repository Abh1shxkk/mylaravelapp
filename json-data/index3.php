<?php
$json = 'json/my.json';
$json1 = file_get_contents($json);
$json2 = json_decode($json1, true); // array me convert

if (!empty($json2)) {
    echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse:collapse;'>";
    
    // Table header
    echo "<tr>";
    foreach (array_keys($json2[0]) as $header) {
        echo "<th>$header</th>";
    }
    echo "</tr>";

    // Table rows
    foreach ($json2 as $row) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No data found.";
}
?>
