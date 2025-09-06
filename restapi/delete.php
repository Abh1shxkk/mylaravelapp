<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);
include("config.php");

$id = (int)$data['sid'];

$sql = "DELETE FROM sq1 WHERE id=$id";
if(mysqli_query($conn, $sql)){
    echo json_encode(["success"=>true,"message"=>"Record deleted successfully"]);
}else{
    echo json_encode(["success"=>false,"message"=>"Error: ".mysqli_error($conn)]);
}
?>
