

<?php
$host = "localhost";   // Database server (local system ke liye localhost hi hota hai)
$user = "root";        // MySQL username (XAMPP/LAMP/WAMP me mostly 'root' hota hai)
$pass = "";            // MySQL password (agar tumne set kiya ho to daalo, warna XAMPP me default khali hota hai)
$db   = "todo_app";    // Tumhara database ka naam

try {
    // PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

    // Error mode ko Exception pe set karna (better debugging ke liye)
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optional: Encoding set karna (UTF-8)
    $conn->exec("SET NAMES utf8");

    // echo "Database connected successfully";  // Debugging ke liye
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>



