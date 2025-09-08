<?php
session_start();
include 'config.php'; // database connection

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Authentication info
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Profile info
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $dob = trim($_POST['dob']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $gender = trim($_POST['gender']);
    $address = trim($_POST['address']);

    // Basic validation
    if (empty($username) || empty($password) || empty($firstname) || empty($lastname) || empty($email)) {
        $_SESSION['error_message'] = "Please fill all required fields.";
        header("Location: signup.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email address.";
        header("Location: signup.php");
        exit();
    }

    // Check if username already exists
    $check_query = "SELECT id FROM registration WHERE username = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error_message'] = "Username already exists.";
        header("Location: signup.php");
        exit();
    }
    mysqli_stmt_close($stmt);

    // Hash password and insert into registration table
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $insert_reg = "INSERT INTO registration (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $insert_reg);
    mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
    if (!mysqli_stmt_execute($stmt)) {
        $_SESSION['error_message'] = "Error creating account.";
        header("Location: signup.php");
        exit();
    }
    $user_id = mysqli_insert_id($conn); // get inserted id
    mysqli_stmt_close($stmt);

    // Handle profile image upload
    $image_name = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg','jpeg','png','gif'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $_SESSION['error_message'] = "Only JPG, PNG, GIF allowed.";
            header("Location: signup.php");
            exit();
        }
        $image_name = "profile_".$user_id."_".time().".".$ext;
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image_name);
    }

    // Insert profile info
    $insert_profile = "INSERT INTO user_profile 
        (user_id, firstname, lastname, dob, email, phone, gender, address, image)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_profile);
    mysqli_stmt_bind_param($stmt, "issssssss", $user_id, $firstname, $lastname, $dob, $email, $phone, $gender, $address, $image_name);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_message'] = "Account created successfully! Please sign in.";
        header("Location: signin.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error saving profile.";
        header("Location: signup.php");
        exit();
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

       body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    overflow: hidden; /* Scroll remove */
}

.signup-container {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 900px; /* Horizontal space increase */
    max-height: 90vh; /* Prevent vertical overflow */
    overflow-y: auto;  /* Internal scroll if really needed */
    margin: auto;
}


        .signup-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .signup-header h2 {
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }

        .signup-header p {
            color: #666;
            font-size: 14px;
        }

        .section-title {
            color: #333;
            font-size: 1.3rem;
            margin: 2rem 0 1rem 0;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f0f0f0;
            font-weight: 600;
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
        }

        .form-group.full-width {
            width: 100%;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            font-family: Arial, sans-serif;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-group textarea {
            min-height: 80px;
            resize: vertical;
        }

        .form-group select {
            background-color: white;
            cursor: pointer;
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
            padding: 12px;
            background: #f8f9fa;
            border: 2px dashed #ddd;
            border-radius: 6px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #666;
        }

        .file-input-label:hover {
            border-color: #667eea;
            background: #f0f4ff;
            color: #333;
        }

        .file-input-label.has-file {
            background: #e8f5e8;
            border-color: #28a745;
            color: #155724;
        }

        .signup-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease;
            margin-top: 1rem;
        }

        .signup-btn:hover {
            transform: translateY(-2px);
        }

        .message {
            padding: 12px;
            margin-bottom: 1.5rem;
            border-radius: 6px;
            text-align: center;
            font-weight: 500;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .signin-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
        }

        .signin-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .signin-link a:hover {
            text-decoration: underline;
        }

        .required {
            color: #e74c3c;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem 0;
            }
            
            .signup-container {
                margin: 1rem;
                padding: 1.5rem;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .signup-header h2 {
                font-size: 1.5rem;
            }

            .section-title {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
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

        <form method="POST" action="" enctype="multipart/form-data" autocomplete="off">
    <h3 class="section-title">🔐 Account Information</h3>
    
    <!-- Fake hidden fields to trick browser autofill -->
    <input type="text" name="fakeusernameremembered" style="display:none">
    <input type="password" name="fakepasswordremembered" style="display:none">
    
    <div class="form-row">
        <div class="form-group">
            <label for="username">Username <span class="required">*</span></label>
            <input type="text" id="username" name="username" placeholder="Choose a username" required autocomplete="new-username">
        </div>
        <div class="form-group">
            <label for="password">Password <span class="required">*</span></label>
            <input type="password" id="password" name="password" placeholder="Create a strong password" required autocomplete="new-password">
        </div>
    </div>


            <h3 class="section-title">👤 Personal Information</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="firstname">First Name <span class="required">*</span></label>
                    <input type="text" id="firstname" name="firstname" placeholder="Your first name" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name <span class="required">*</span></label>
                    <input type="text" id="lastname" name="lastname" placeholder="Your last name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob">
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <h3 class="section-title">📧 Contact Information</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input type="email" id="email" name="email" placeholder="your.email@example.com" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="Your phone number">
                </div>
            </div>

            <div class="form-group full-width">
                <label for="address">Address</label>
                <textarea id="address" name="address" placeholder="Your complete address"></textarea>
            </div>

            <div class="form-group full-width">
                <label for="image">Profile Picture</label>
                <div class="file-input-wrapper">
                    <input type="file" id="image" name="image" class="file-input" accept=".jpg,.jpeg,.png,.gif">
                    <label for="image" class="file-input-label" id="file-label">
                        📷 Choose profile picture (JPG, PNG, GIF)
                    </label>
                </div>
            </div>

            <button type="submit" class="signup-btn">Create My Account</button>
        </form>

        <div class="signin-link">
            <p>Already have an account? <a href="signin.php">Sign in here</a></p>
        </div>
    </div>

    <script>
        // File input handling
        document.getElementById('image').addEventListener('change', function() {
            const label = document.getElementById('file-label');
            const fileName = this.files[0] ? this.files[0].name : '';
            
            if (fileName) {
                label.textContent = `📷 Selected: ${fileName}`;
                label.classList.add('has-file');
            } else {
                label.textContent = '📷 Choose profile picture (JPG, PNG, GIF)';
                label.classList.remove('has-file');
            }
        });
    </script>
</body>
</html>