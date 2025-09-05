<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$data= json_decode(file_get_contents("php://input"),true);
$studentsid= $data['sid'];


include("config.php");
$sql = "SELECT * FROM sq1";
$results= mysqli_query($conn,$sql);
if(mysqli_num_rows($results)>0){
    $output=mysqli_fetch_all($results, MYSQLI_ASSOC);

    echo json_encode($output, JSON_PRETTY_PRINT);
}else{

}
?>