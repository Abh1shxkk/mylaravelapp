<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "ajax";

$conn = mysqli_connect($host, $username, $password, $database) or die("connection failed");

$sql = "SELECT * FROM random";
$results = mysqli_query($conn, $sql);

if (mysqli_num_rows($results) > 0) {

    echo "<table border='1' cellspacing='0' cellpadding='10' style='margin:20px auto; text-align:center;'>";
    echo "<tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($results)) {
        echo "<tr>
                <td>".$row['id']."</td>
                <td>".$row['first_name']."</td>
                <td>".$row['last_name']."</td>
              </tr>";
    }

mysqli_close($conn);
    echo "</table>";

} else {
    echo "<h3 style='text-align:center;'>No records found.</h3>";
}
?>
