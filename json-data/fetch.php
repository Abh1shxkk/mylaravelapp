<?php
$conn = mysqli_connect("localhost", "root", "", "sqllearn") or die("connection failed");

$id = (int) $_GET['id'];   // GET se id lo
$sql = "SELECT * FROM `sq1` WHERE id=$id";
$results = mysqli_query($conn, $sql);

$output = mysqli_fetch_all($results, MYSQLI_ASSOC);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($output, JSON_PRETTY_PRINT);

mysqli_close($conn);
?>
