<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: rgba(102, 126, 234, 0.8);
            --primary-solid: rgb(102, 126, 234);
            --secondary: rgba(118, 75, 162, 0.8);
            --glass: rgba(255, 255, 255, 0.15);
            --glass-dark: rgba(0, 0, 0, 0.1);
            --glass-light: rgba(255, 255, 255, 0.25);
            --text: #333;
            --text-light: rgba(255, 255, 255, 0.9);
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            --border: 1px solid rgba(255, 255, 255, 0.18);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            overflow: hidden;
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

        /* Animation Keyframes */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @keyframes bounce {
            0%, 20%, 53%, 80%, 100% { transform: translateY(0); }
            40%, 43% { transform: translateY(-15px); }
            70% { transform: translateY(-7px); }
            90% { transform: translateY(-3px); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(5deg); }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .signup-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 900px;
            max-height: 90vh;
            overflow-y: auto;
            margin: auto;
            animation: fadeIn 0.8s ease-out;
            transition: all 0.4s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 10;
        }

        .signup-container:hover {
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            transform: translateY(-5px);
        }

        .signup-header {
            text-align: center;
            margin-bottom: 2rem;
            animation: fadeIn 1s ease-out;
        }

        .signup-header h2 {
            color: white;
            margin-bottom: 0.5rem;
            font-size: 2.2rem;
            font-weight: 600;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .signup-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 16px;
        }

        .section-title {
            color: white;
            font-size: 1.4rem;
            margin: 2rem 0 1rem 0;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            font-weight: 600;
            animation: slideInLeft 0.8s ease-out;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .section-title:first-of-type {
            margin-top: 0;
        }

        .form-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            flex: 1;
            margin-bottom: 1.5rem;
            animation: slideInRight 0.8s ease-out;
            animation-fill-mode: both;
        }

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }

        .form-group.full-width {
            width: 100%;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.8rem;
            color: white;
            font-weight: 500;
            font-size: 1.1rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 16px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.4s ease;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
            transform: scale(1.02);
            background: rgba(255, 255, 255, 0.2);
        }

        .form-group textarea {
            min-height: 80px;
            resize: vertical;
            transition: all 0.3s ease;
        }

        .form-group textarea:focus {
            min-height: 100px;
        }

        .form-group select {
            background-color: rgba(255, 255, 255, 0.15);
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M8 12L2 6h12L8 12z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
        }

        .file-input-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-input {
            display: none;
        }

        .file-input-label {
            display: block;
            width: 100%;
            padding: 16px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px dashed rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.4s ease;
            color: rgba(255, 255, 255, 0.8);
            animation: pulse 2s infinite;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .file-input-label:hover {
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.15);
            color: white;
            animation: none;
            transform: translateY(-2px);
        }

        .file-input-label.has-file {
            background: rgba(232, 245, 232, 0.2);
            border-color: rgba(40, 167, 69, 0.5);
            color: #d4edda;
            animation: bounce 0.5s ease;
        }

        .signup-btn {
            width: 100%;
            padding: 18px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s ease;
            margin-top: 1.5rem;
            animation: fadeIn 1s ease-out;
            animation-delay: 0.3s;
            animation-fill-mode: both;
            position: relative;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .signup-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.6s ease;
        }

        .signup-btn:hover::before {
            left: 100%;
        }

        .signup-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            background: rgba(255, 255, 255, 0.25);
        }

        .signup-btn:active {
            transform: translateY(0);
        }

        .signup-btn.loading {
            position: relative;
            color: transparent;
        }

        .signup-btn.loading::after {
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

        .message {
            padding: 14px;
            margin-bottom: 1.5rem;
            border-radius: 10px;
            text-align: center;
            font-weight: 500;
            animation: fadeIn 0.5s ease-out;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .message:hover {
            transform: scale(1.02);
        }

        .success {
            background-color: rgba(212, 237, 218, 0.2);
            color: #d4edda;
            border: 1px solid rgba(195, 230, 203, 0.3);
            animation: bounce 0.8s ease-out;
        }

        .error {
            background-color: rgba(248, 215, 218, 0.2);
            color: #f8d7da;
            border: 1px solid rgba(245, 198, 203, 0.3);
            animation: shake 0.5s ease-in-out;
        }

        .signin-link {
            text-align: center;
            margin-top: 2rem;
            color: rgba(255, 255, 255, 0.8);
            animation: fadeIn 1s ease-out;
            animation-delay: 0.4s;
            animation-fill-mode: both;
            font-size: 16px;
        }

        .signin-link a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            padding-bottom: 2px;
        }

        .signin-link a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: white;
            transition: width 0.3s ease;
        }

        .signin-link a:hover {
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        }

        .signin-link a:hover::after {
            width: 100%;
        }

        .required {
            color: #ff6b6b;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        /* Floating background elements */
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

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .signup-container {
                margin: 0;
                padding: 2rem;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .signup-header h2 {
                font-size: 1.8rem;
            }

            .section-title {
                font-size: 1.2rem;
            }
            
            .floating-bg {
                display: none;
            }
            
            .form-group input,
            .form-group select,
            .form-group textarea {
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

    <div class="signup-container">
        <div class="signup-header">
            <h2>Create Account</h2>
            <p>Join us today and get started with your profile</p>
        </div>

        <?php 
        if (isset($_SESSION['error_message'])) {
            echo "<div class='message error'>" . htmlspecialchars($_SESSION['error_message']) . "</div>";
            unset($_SESSION['error_message']);
        }
        if (isset($_SESSION['success_message'])) {
            echo "<div class='message success'>" . htmlspecialchars($_SESSION['success_message']) . "</div>";
            unset($_SESSION['success_message']);
        }
        ?>

        <form method="POST" action="" enctype="multipart/form-data" autocomplete="off" id="signupForm">
            <h3 class="section-title"><i class="fas fa-lock"></i> Account Information</h3>
            
            <!-- Fake hidden fields to trick browser autofill -->
            <input type="text" name="fakeusernameremembered" style="display:none">
            <input type="password" name="fakepasswordremembered" style="display:none">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username <span class="required">*</span></label>
                    <input type="text" id="username" name="username" placeholder="Choose a username" required autocomplete="new-username">
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-key"></i> Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" placeholder="Create a strong password" required autocomplete="new-password">
                </div>
            </div>

            <h3 class="section-title"><i class="fas fa-user-circle"></i> Personal Information</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="firstname"><i class="fas fa-signature"></i> First Name <span class="required">*</span></label>
                    <input type="text" id="firstname" name="firstname" placeholder="Your first name" required>
                </div>
                <div class="form-group">
                    <label for="lastname"><i class="fas fa-signature"></i> Last Name <span class="required">*</span></label>
                    <input type="text" id="lastname" name="lastname" placeholder="Your last name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="dob"><i class="fas fa-birthday-cake"></i> Date of Birth</label>
                    <input type="date" id="dob" name="dob">
                </div>
                <div class="form-group">
                    <label for="gender"><i class="fas fa-venus-mars"></i> Gender</label>
                    <select id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <h3 class="section-title"><i class="fas fa-envelope"></i> Contact Information</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="email"><i class="fas fa-at"></i> Email Address <span class="required">*</span></label>
                    <input type="email" id="email" name="email" placeholder="your.email@example.com" required>
                </div>
                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone"></i> Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="Your phone number">
                </div>
            </div>

            <div class="form-group full-width">
                <label for="address"><i class="fas fa-home"></i> Address</label>
                <textarea id="address" name="address" placeholder="Your complete address"></textarea>
            </div>

            <div class="form-group full-width">
                <label for="image"><i class="fas fa-camera"></i> Profile Picture</label>
                <div class="file-input-wrapper">
                    <input type="file" id="image" name="image" class="file-input" accept=".jpg,.jpeg,.png,.gif">
                    <label for="image" class="file-input-label" id="file-label">
                        <i class="fas fa-upload"></i> Choose profile picture (JPG, PNG, GIF)
                    </label>
                </div>
            </div>

            <button type="submit" class="signup-btn" id="signupBtn">
                <i class="fas fa-user-plus"></i> Create My Account
            </button>
        </form>

        <div class="signin-link">
            <p>Already have an account? <a href="signin.php"><i class="fas fa-sign-in-alt"></i> Sign in here</a></p>
        </div>
    </div>

    <script>
        // File input handling
        document.getElementById('image').addEventListener('change', function() {
            const label = document.getElementById('file-label');
            const fileName = this.files[0] ? this.files[0].name : '';
            
            if (fileName) {
                label.innerHTML = `<i class="fas fa-check-circle"></i> Selected: ${fileName}`;
                label.classList.add('has-file');
            } else {
                label.innerHTML = '<i class="fas fa-upload"></i> Choose profile picture (JPG, PNG, GIF)';
                label.classList.remove('has-file');
            }
        });

        // Add loading animation on form submission
        document.getElementById('signupForm').addEventListener('submit', function() {
            const signupBtn = document.getElementById('signupBtn');
            signupBtn.classList.add('loading');
            signupBtn.disabled = true;
        });

        // Add focus animations to inputs
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.style.transform = 'translateY(-2px)';
                input.parentElement.style.transition = 'transform 0.3s ease';
            });
            
            input.addEventListener('blur', () => {
                input.parentElement.style.transform = 'translateY(0)';
            });
        });

        // Add animation to select dropdown when changed
        document.querySelectorAll('select').forEach(select => {
            select.addEventListener('change', function() {
                this.style.animation = 'pulse 0.5s ease';
                setTimeout(() => {
                    this.style.animation = '';
                }, 500);
            });
        });

        // Add floating animation to container on load
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.signup-container');
            container.style.animation = 'fadeIn 0.8s ease-out';
        });
    </script>
</body>
</html>