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
        .delete-btn {
            background: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .delete-btn:hover {
            background: darkred;
        }
        .update-btn {
            background: #6c757d;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            margin-left: 5px;
        }
        .update-btn:hover {
            background: #5a6268;
        }
            
.update-btn {
    display: inline-block;
    background: #6c757d;
    color: white;
    text-decoration: none;   /* underline hatane ke liye */
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
}
.update-btn:hover {
    background: #5a6268;
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
        <th colspan='2'>Action</th>
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
    echo "<td>
            <form method='POST'>
                <button class='delete-btn' name='delete' value='" . $fno['id'] . "'>Delete</button>
            </form>
          </td>";


    echo "<td>
        <a href='update.php?id=" . $fno['id'] . "' class='update-btn'>Update</a>
      </td>";

    
    echo "</tr>";
}
echo "</table>";

if(isset($_POST['delete'])){
    $id=$_POST['delete'];
    $out = $conn->prepare("DELETE FROM sq1 WHERE id= $id");
    $out->execute();
}
?> 
