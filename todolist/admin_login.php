<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $_SESSION['error_message'] = "Both username and password are required.";
    } else {
        $check_query = "SELECT id, password FROM admins WHERE username = ?";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($check_stmt, "s", $username);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) == 1) {
            $admin_data = mysqli_fetch_assoc($check_result);
            if (password_verify($password, $admin_data['password'])) {
                $_SESSION['admin_id'] = $admin_data['id'];
                $_SESSION['admin_username'] = $username;
                header("Location: admin_dashboard.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Incorrect password.";
            }
        } else {
            $_SESSION['error_message'] = "Admin not found.";
        }
        mysqli_stmt_close($check_stmt);
    }
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reuse your existing glassmorphism styles from signin.php */
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; height: 100vh; }
        .glass { background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(12px); padding: 2rem; border-radius: 16px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); }
        /* Add more styles as needed */
    </style>
</head>
<body>
    <div class="glass">
        <h2>Admin Login</h2>
        <?php if ($error = $_SESSION['error_message'] ?? '') echo "<p style='color:red;'>$error</p>"; unset($_SESSION['error_message']); ?>
        <form method="POST" id="adminLoginForm">
            <div><input type="text" name="username" placeholder="Username" required></div>
            <div><input type="password" name="password" placeholder="Password" required></div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>