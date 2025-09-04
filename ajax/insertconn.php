<?php
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];

$host = "localhost";
$username = "root";
$password = "";
$database = "ajax";

$conn = mysqli_connect($host, $username, $password, $database) or die("connection failed");

$sql = "INSERT INTO random(first_name, last_name) VALUES ('{$first_name}', '{$last_name}')";
$results = mysqli_query($conn, $sql) or die("Insert query failed");

mysqli_close($conn);
?>


