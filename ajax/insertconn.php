<?php
$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);

// Check for empty values after trimming
if(empty($first_name) || empty($last_name)) {
    die("error: Please fill all fields with valid data.");
}

$host = "localhost";
$username = "root";
$password = "";
$database = "ajax";

$conn = mysqli_connect($host, $username, $password, $database) or die("connection failed");

$sql = "INSERT INTO random(first_name, last_name) VALUES ('{$first_name}', '{$last_name}')";
$results = mysqli_query($conn, $sql) or die("Insert query failed");

mysqli_close($conn);
?>