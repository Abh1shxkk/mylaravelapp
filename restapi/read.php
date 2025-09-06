<?php
header('Content-Type: application/json');
include("config.php");

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
$offset = ($page - 1) * $limit;
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Count total records
$count_sql = "SELECT COUNT(*) as total FROM sq1 WHERE 
name LIKE '%$search%' OR city LIKE '%$search%' OR course LIKE '%$search%' OR batch LIKE '%$search%'";
$count_result = mysqli_query($conn, $count_sql);
$total = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total / $limit);

// Fetch data
$sql = "SELECT * FROM sq1 WHERE 
name LIKE '%$search%' OR city LIKE '%$search%' OR course LIKE '%$search%' OR batch LIKE '%$search%' 
ORDER BY $sort_by $order LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode([
    "data" => $data,
    "total" => $total,
    "total_pages" => $total_pages,
    "current_page" => $page
]);
?>
