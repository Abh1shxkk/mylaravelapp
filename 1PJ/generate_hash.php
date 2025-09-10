<?php
$password = '00000000'; // Change this to your desired password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo "Generated hash: " . $hashed_password;
?>