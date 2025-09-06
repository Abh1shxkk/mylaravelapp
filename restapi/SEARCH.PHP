<?php
header('Content-Type: application/json');
include("config.php");

$search = isset($_GET['s_search']) ? mysqli_real_escape_string($conn, $_GET['s_search']) : '';

$sql = "SELECT * FROM sq1 WHERE name LIKE '%$search%'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode($data);
?>
