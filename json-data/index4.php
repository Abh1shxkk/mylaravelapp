<?php
$conn = mysqli_connect("localhost", "root", "", "sqllearn") or die("connection failed");


$sql = "SELECT * FROM sq1";
$results = mysqli_query($conn, $sql);

$output = mysqli_fetch_all($results, MYSQLI_ASSOC);

$jsondata= json_encode($output, JSON_PRETTY_PRINT);

$file_name= "my-" .  date("m-d-Y") . ".json";

if(file_put_contents($file_name,$jsondata)){

    echo  $file_name . "file created";
}
else{
     echo "not done";
}
?>
