<?php
include("./config.php");

$output = $conn->prepare("SELECT * FROM sq1");
$output->execute();
$finaloutput = $output->fetchAll();

// CSS styling
echo "<style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }
        table th, table td {
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #222;
            color: #fff;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
      </style>";

echo "<table>";
echo "<tr>
        <th>Name</th>
        <th>City</th>
        <th>Course</th>
        <th>Batch</th>
        <th>Year</th>
        <th>Age</th>
        <th>DOB</th>
      </tr>";

foreach ($finaloutput as $fno) {
    echo "<tr>";
    echo "<td>" . $fno['name'] . "</td>";
    echo "<td>" . $fno['city'] . "</td>";
    echo "<td>" . $fno['course'] . "</td>";
    echo "<td>" . $fno['batch'] . "</td>";
    echo "<td>" . $fno['year'] . "</td>";
    echo "<td>" . $fno['age'] . "</td>";
    echo "<td>" . $fno['dob'] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>
