<?php
$student_id = $_POST['id'];

$host = "localhost";
$username = "root";
$password = "";
$database = "ajax";

$conn = mysqli_connect($host, $username, $password, $database) or die("connection failed");

$sql = "DELETE FROM random WHERE id = {$student_id}";
if(mysqli_query($conn, $sql)){
    echo 1;   // success
}else{
    echo 0;   // fail
}

mysqli_close($conn);
?>
