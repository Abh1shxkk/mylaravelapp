<?php
session_start();
include 'config.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

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
        // Fetch id, password, and is_admin, ensuring is_admin = 1
        $check_query = "SELECT id, password, is_admin FROM registration WHERE username = ? AND is_admin = 1";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($check_stmt, "s", $username);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) == 0) {
            $_SESSION['error_message'] = "Invalid admin credentials or account is not an admin.";
        } else {
            $user_data = mysqli_fetch_assoc($check_result);
            $hashed_password = $user_data['password'];

            if (password_verify($password, $hashed_password)) {
                // Regenerate session ID for security
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user_data['id'];
                $_SESSION['username'] = $username;
                $_SESSION['is_admin'] = $user_data['is_admin'];
                header("Location: admin_dashboard.php");
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
<title>Admin Sign In</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    *{margin:0;padding:0;box-sizing:border-box;}
    
    :root {
        --primary: rgba(220, 53, 69, 0.8); /* Reddish theme for admin */
        --primary-solid: rgb(220, 53, 69);
        --secondary: rgba(118, 75, 162, 0.8);
        --glass: rgba(255, 255, 255, 0.15);
        --glass-dark: rgba(0, 0, 0, 0.1);
        --glass-light: rgba(255, 255, 255, 0.25);
        --text: #333;
        --text-light: rgba(255, 255, 255, 0.9);
        --shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        --border: 1px solid rgba(255, 255, 255, 0.18);
    }
    
    body{
        font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background:linear-gradient(135deg, #dc3545 0%, #764ba2 100%); /* Adjusted gradient for admin */
        min-height:100vh;
        display:flex;
        align-items:center;
        justify-content:center;
        overflow:hidden;
        position: relative;
    }
    
    /* Glassmorphism base styles */
    .glass {
        background: var(--glass);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 16px;
        box-shadow: var(--shadow);
        border: var(--border);
    }
    
    /* Animation keyframes */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    
    @keyframes bounce {
        0%, 20%, 53%, 80%, 100% { transform: translateY(0); }
        40%, 43% { transform: translateY(-15px); }
        70% { transform: translateY(-7px); }
        90% { transform: translateY(-3px); }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    .signin-container{
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        padding: 2.5rem;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 450px;
        animation: fadeIn 0.8s ease-out;
        transform-origin: center;
        transition: all 0.4s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
        z-index: 10;
    }
    
    .signin-container:hover {
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
        transform: translateY(-5px);
    }
    
    .signin-header{
        text-align:center;
        margin-bottom:2rem;
        animation: slideIn 0.8s ease-out;
    }
    
    .signin-header h2{
        color: white;
        margin-bottom:0.5rem;
        font-size:2.2rem;
        font-weight: 600;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }
    
    .signin-header p{
        color: rgba(255, 255, 255, 0.8);
        font-size:16px;
    }
    
    .form-group{
        margin-bottom:1.8rem;
        animation: slideIn 0.8s ease-out;
        animation-fill-mode: both;
    }
    
    .form-group:nth-child(1) { animation-delay: 0.1s; }
    .form-group:nth-child(2) { animation-delay: 0.2s; }
    
    .form-group label{
        display:block;
        margin-bottom:0.8rem;
        color: white;
        font-weight:500;
        font-size: 1.1rem;
    }
    
    .form-group input{
        width:100%;
        padding:16px;
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius:12px;
        font-size:16px;
        transition: all 0.4s ease;
        background: rgba(255, 255, 255, 0.15);
        color: white;
    }
    
    .form-group input::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }
    
    .form-group input:focus{
        outline:none;
        border-color: rgba(255, 255, 255, 0.5);
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
        transform: scale(1.02);
        background: rgba(255, 255, 255, 0.2);
    }
    
    .password-container{
        position:relative;
    }
    
    .password-toggle{
        position:absolute;
        right:16px;
        top:50%;
        transform:translateY(-50%);
        background:none;
        border:none;
        cursor:pointer;
        font-size:18px;
        color: rgba(255, 255, 255, 0.7);
        padding:0;
        width:24px;
        height:24px;
        display:flex;
        align-items:center;
        justify-content:center;
        transition: all 0.3s ease;
        z-index: 2;
    }
    
    .password-toggle:hover{
        color: white;
        transform: translateY(-50%) scale(1.2);
    }
    
    .form-group .password-container input {
        padding-right:50px;
    }
    
    .signin-btn{
        width:100%;
        padding:16px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        color: white;
        border: none;
        border-radius:12px;
        font-size:18px;
        font-weight:600;
        cursor:pointer;
        transition: all 0.4s ease;
        animation-delay: 0.3s;
        animation-fill-mode: both;
        position: relative;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .signin-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: all 0.6s ease;
    }
    
    .signin-btn:hover::before {
        left: 100%;
    }
    
    .signin-btn:hover{
        transform:translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        background: rgba(255, 255, 255, 0.25);
    }
    
    .signin-btn:active{
        transform:translateY(0);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    }
    
    .signin-btn.loading {
        position: relative;
        color: transparent;
    }
    
    .signin-btn.loading::after {
        content: '';
        position: absolute;
        width: 22px;
        height: 22px;
        top: 50%;
        left: 50%;
        margin: -11px 0 0 -11px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s ease-in-out infinite;
    }
    
    .message{
        padding:14px;
        margin-bottom:1.5rem;
        border-radius:10px;
        text-align:center;
        animation: slideIn 0.5s ease-out;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .message:hover {
        transform: scale(1.02);
    }
    
    .success{
        background-color: rgba(212, 237, 218, 0.2);
        color:#d4edda;
        border:1px solid rgba(195, 230, 203, 0.3);
        animation: bounce 0.8s ease-out;
    }
    
    .error{
        background-color: rgba(248, 215, 218, 0.2);
        color:#f8d7da;
        border:1px solid rgba(245, 198, 203, 0.3);
        animation: shake 0.5s ease-in-out;
    }
    
    .signup-link{
        text-align:center;
        margin-top:2rem;
        color: rgba(255, 255, 255, 0.8);
        animation: fadeIn 1s ease-out;
        animation-delay: 0.4s;
        animation-fill-mode: both;
        font-size: 16px;
    }
    
    .signup-link a{
        color: white;
        text-decoration:none;
        font-weight:600;
        transition: all 0.3s ease;
        position: relative;
        padding-bottom: 2px;
    }
    
    .signup-link a::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: white;
        transition: width 0.3s ease;
    }
    
    .signup-link a:hover{
        text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
    }
    
    .signup-link a:hover::after {
        width: 100%;
    }
    
    /* Floating animation for background */
    .floating-bg {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
        animation: float 6s ease-in-out infinite;
        z-index: -1;
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .floating-bg:nth-child(1) {
        top: 15%;
        left: 10%;
        width: 250px;
        height: 250px;
        animation-delay: 0s;
    }
    
    .floating-bg:nth-child(2) {
        top: 65%;
        right: 12%;
        width: 180px;
        height: 180px;
        animation-delay: 2s;
    }
    
    .floating-bg:nth-child(3) {
        bottom: 10%;
        left: 20%;
        width: 120px;
        height: 120px;
        animation-delay: 4s;
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
        .signin-container {
            padding: 2rem;
            margin: 0 1rem;
        }
        
        .signin-header h2 {
            font-size: 1.8rem;
        }
        
        .form-group input {
            padding: 14px;
        }
    }
</style>
</head>
<body>
    <!-- Floating background elements -->
    <div class="floating-bg"></div>
    <div class="floating-bg"></div>
    <div class="floating-bg"></div>

    <div class="signin-container">
        <div class="signin-header">
            <h2>Admin Sign In</h2>
            <p>Login to access your admin dashboard</p>
        </div>

        <?php if (!empty($message)): ?>
            <div class="message success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off" id="signinForm">
            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> Admin Username:</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    value="<?php echo (!empty($error) && isset($username)) ? htmlspecialchars($username) : ''; ?>"
                    required
                    placeholder="Enter your admin username"
                    autocomplete="new-username"
                >
            </div>

            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password:</label>
                <div class="password-container">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        placeholder="Enter your password"
                        autocomplete="new-password"
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-lock"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="signin-btn" id="signinBtn">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>

        <div class="signup-link">
            <p>Not an admin? <a href="signin.php">Sign in as user</a></p>
        </div>
    </div>

    <script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleButton = document.querySelector('.password-toggle');
        const icon = toggleButton.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-lock');
            icon.classList.add('fa-lock-open');
            toggleButton.style.animation = 'bounce 0.5s ease';
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-lock-open');
            icon.classList.add('fa-lock');
            toggleButton.style.animation = 'bounce 0.5s ease';
        }
        
        // Remove animation after it completes
        setTimeout(() => {
            toggleButton.style.animation = '';
        }, 500);
    }
    
    // Add loading animation on form submission
    document.getElementById('signinForm').addEventListener('submit', function() {
        const signinBtn = document.getElementById('signinBtn');
        signinBtn.classList.add('loading');
        signinBtn.disabled = true;
        
        // Add a small delay to show the loading animation
        setTimeout(() => {
            if (!document.querySelector('.message')) {
                signinBtn.classList.remove('loading');
                signinBtn.disabled = false;
            }
        }, 2000);
    });
    
    // Add focus animations to inputs
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.style.transform = 'translateY(-2px)';
            input.parentElement.style.transition = 'transform 0.3s ease';
        });
        
        input.addEventListener('blur', () => {
            input.parentElement.style.transform = 'translateY(0)';
        });
    });
    
    // Add floating animation to container on load
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.querySelector('.signin-container');
        container.style.animation = 'fadeIn 0.8s ease-out';
    });
    </script>
</body>
</html>