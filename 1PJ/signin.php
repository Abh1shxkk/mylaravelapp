<?php
session_start();
include 'config.php';

$message = "";
$error = "";

// Get messages from session and clear them
if (isset($_SESSION['success_message'])) {
    $message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    $error = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $_SESSION['error_message'] = "Both username and password are required.";
    } else {
        $check_query = "SELECT id, password FROM registration WHERE username = ?";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($check_stmt, "s", $username);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) == 0) {
            $_SESSION['error_message'] = "Username not found. Please sign up first.";
        } else {
            $user_data = mysqli_fetch_assoc($check_result);
            $hashed_password = $user_data['password'];

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $user_data['id'];
                $_SESSION['username'] = $username;

                // Redirect to dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Incorrect password. Please try again.";
            }
        }
        mysqli_stmt_close($check_stmt);
    }

    // Redirect to prevent form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In</title>
<style>
    *{margin:0;padding:0;box-sizing:border-box;}
    body{font-family:Arial,sans-serif;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;}
    .signin-container{background:white;padding:2rem;border-radius:10px;box-shadow:0 15px 35px rgba(0,0,0,0.1);width:100%;max-width:400px;}
    .signin-header{text-align:center;margin-bottom:2rem;}
    .signin-header h2{color:#333;margin-bottom:0.5rem;}
    .signin-header p{color:#666;font-size:14px;}
    .form-group{margin-bottom:1.5rem;}
    .form-group label{display:block;margin-bottom:0.5rem;color:#333;font-weight:500;}
    .form-group input{width:100%;padding:12px;border:2px solid #ddd;border-radius:6px;font-size:16px;transition:border-color 0.3s ease;}
    .password-container{position:relative;}
    .password-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:18px;color:#666;padding:0;width:24px;height:24px;display:flex;align-items:center;justify-content:center;}
    .password-toggle:hover{color:#333;}
    .form-group .password-container input{padding-right:45px;}
    .form-group input:focus{outline:none;border-color:#667eea;}
    .signin-btn{width:100%;padding:12px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:white;border:none;border-radius:6px;font-size:16px;font-weight:500;cursor:pointer;transition:transform 0.3s ease;}
    .signin-btn:hover{transform:translateY(-2px);}
    .message{padding:10px;margin-bottom:1rem;border-radius:4px;text-align:center;}
    .success{background-color:#d4edda;color:#155724;border:1px solid #c3e6cb;}
    .error{background-color:#f8d7da;color:#721c24;border:1px solid #f5c6cb;}
    .signup-link{text-align:center;margin-top:1.5rem;color:#666;}
    .signup-link a{color:#667eea;text-decoration:none;}
    .signup-link a:hover{text-decoration:underline;}
</style>
</head>
<body>
<div class="signin-container">
    <div class="signin-header">
        <h2>Sign In</h2>
        <p>Login to access your account</p>
    </div>

    <?php if (!empty($message)): ?>
        <div class="message success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="message error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off">
        <div class="form-group">
            <label for="username">Username:</label>
            <input 
                type="text" 
                id="username" 
                name="username" 
                value="<?php echo (!empty($error) && isset($username)) ? htmlspecialchars($username) : ''; ?>"
                required
                placeholder="Enter your username"
                autocomplete="new-username"
            >
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <div class="password-container">
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    placeholder="Enter your password"
                    autocomplete="new-password"
                >
                <button type="button" class="password-toggle" onclick="togglePassword()">🔒</button>
            </div>
        </div>

        <button type="submit" class="signin-btn">Sign In</button>
    </form>

    <div class="signup-link">
        <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleButton = document.querySelector('.password-toggle');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleButton.innerHTML = '🔓';
    } else {
        passwordInput.type = 'password';
        toggleButton.innerHTML = '🔒';
    }
}
</script>
</body>
</html>
