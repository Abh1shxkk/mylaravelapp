<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);
include("config.php");

$id = (int)$data['sid'];
$name = mysqli_real_escape_string($conn, $data['sname']);
$city = mysqli_real_escape_string($conn, $data['scity']);
$course = mysqli_real_escape_string($conn, $data['scourse']);
$batch = mysqli_real_escape_string($conn, $data['sbatch']);
$year = mysqli_real_escape_string($conn, $data['syear']);
$age = mysqli_real_escape_string($conn, $data['sage']);
$dob = mysqli_real_escape_string($conn, $data['sdob']);

$sql = "UPDATE sq1 SET name='$name', city='$city', course='$course', batch='$batch', year='$year', age='$age', dob='$dob' WHERE id=$id";
if(mysqli_query($conn, $sql)){
    echo json_encode(["success"=>true,"message"=>"Record updated successfully"]);
}else{
    echo json_encode(["success"=>false,"message"=>"Error: ".mysqli_error($conn)]);
}
?>
