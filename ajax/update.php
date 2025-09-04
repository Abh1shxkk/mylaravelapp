<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "ajax";

$conn = mysqli_connect($host, $username, $password, $database) or die("Connection Failed");

$id = $_POST['id'];
$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);

// Validation: dono fields required
if($first_name == "" || $last_name == ""){
    echo "error: All fields are required.";
    exit;
}

$sql = "UPDATE random SET first_name = '{$first_name}', last_name = '{$last_name}' WHERE id = {$id}";
if(mysqli_query($conn, $sql)){
    echo "success";
} else {
    echo "error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
