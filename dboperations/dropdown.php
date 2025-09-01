<?php
include("./config.php");
$sql="SELECT name FROM `sq1`";

$output=$conn->prepare($sql);
$output->execute();
$results=$output->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Select Name</title>
  <style>
    select {
      width: 250px;
      padding: 8px;
      border: 2px solid #007bff;
      border-radius: 5px;
      font-size: 16px;
      background-color: #f8f9fa;
      color: #333;
    }

    select:focus {
      outline: none;
      border-color: #0056b3;
      box-shadow: 0 0 5px rgba(0, 91, 187, 0.6);
    }

    option {
      padding: 5px;
    }
  </style>
</head>
<body>

  <?php
  echo "<select>";
  echo "<option value=''>Select Name</option>";
  foreach($results as $result){
      echo "<option value='" . $result['id'] . "'>" . $result['name'] . "</option>";
  }
  echo "</select>";
  ?>

</body>
</html>
