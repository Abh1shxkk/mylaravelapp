<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Allow-Headers: Content-Type");

$data= json_decode(file_get_contents("php://input"),true);
$name= $data['sname'];
$city= $data['scity'];
$course= $data['scourse'];
$batch= $data['sbatch'];
$year= $data['syear'];
$age= $data['sage'];
$dob= $data['sdob'];


include("config.php");
$sql = "INSERT INTO sq1 (name, city, course, batch, year, age, dob) 
        VALUES ('{$name}', '{$city}', '{$course}', '{$batch}', '{$year}', '{$age}', '{$dob}')";
if(mysqli_query($conn,$sql)){
    echo json_encode(array('message'=>'data successfully inserted ', 'success'=>true));

 
}else{
    echo json_encode(array('message'=>'data not inserted ', 'success'=>false));

}
?>