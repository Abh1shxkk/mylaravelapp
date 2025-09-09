<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Get user profile data
$profile_query = "SELECT * FROM user_profile WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $profile_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$profile_result = mysqli_stmt_get_result($stmt);
$profile_data = mysqli_fetch_assoc($profile_result);
mysqli_stmt_close($stmt);

// If no profile data exists, create empty array to prevent errors
if (!$profile_data) {
    $profile_data = [
        'firstname' => '',
        'lastname' => '',
        'email' => '',
        'phone' => '',
        'dob' => '',
        'gender' => '',
        'address' => '',
        'image' => ''
    ];
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: signin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - <?php echo htmlspecialchars($username); ?></title>
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
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Glassmorphism base styles */
        .glass {
            background: var(--glass);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 12px;
            box-shadow: var(--shadow);
            border: var(--border);
        }

        .glass-dark {
            background: var(--glass-dark);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .glass-light {
            background: var(--glass-light);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        /* Header Styles */
        .header {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            color: var(--text);
            padding: 0 2rem;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.6);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .menu-toggle {
            background: none;
            border: none;
            color: var(--primary-solid);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu-toggle:hover {
            background-color: rgba(102, 126, 234, 0.1);
            transform: rotate(90deg);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary-solid);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-menu {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            padding: 0.3rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.5);
        }

        .user-menu:hover {
            background: rgba(255, 255, 255, 0.8);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-solid);
            font-weight: bold;
            border: 2px solid rgba(255, 255, 255, 0.8);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .user-menu:hover .user-avatar {
            transform: scale(1.1);
            box-shadow: 0 0 0 3px var(--primary-solid);
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            min-width: 200px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            display: none;
            z-index: 1001;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .dropdown-menu.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
            animation: fadeInDropdown 0.3s ease;
        }

        @keyframes fadeInDropdown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .dropdown-item:hover {
            background-color: rgba(102, 126, 234, 0.1);
            padding-left: 1.5rem;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 70px;
            width: 280px;
            height: calc(100vh - 70px);
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 999;
            overflow-y: auto;
            border-right: 1px solid rgba(255, 255, 255, 0.6);
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
            opacity: 0;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }

        .sidebar-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-solid);
            margin-bottom: 0.5rem;
        }

        .sidebar-menu {
            list-style: none;
            padding: 1rem 0;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
            padding: 0 0.5rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #666;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .sidebar-menu a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
            transition: all 0.6s ease;
        }

        .sidebar-menu a:hover::before {
            left: 100%;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(102, 126, 234, 0.1);
            color: var(--primary-solid);
            transform: translateX(5px);
        }

        .sidebar-menu .icon {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover .icon {
            transform: scale(1.2);
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            margin-top: 70px;
            padding: 2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: calc(100vh - 70px);
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* Profile Specific Styles */
        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .profile-header {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 16px;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.5);
            animation: fadeInUp 0.6s ease;
        }

        .profile-image-container {
            position: relative;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid var(--primary-solid);
            object-fit: cover;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--primary-solid);
            transition: all 0.3s ease;
        }

        .profile-image-container:hover .profile-image {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .profile-name {
            font-size: 1.8rem;
            color: var(--text);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .profile-username {
            color: #666;
            font-size: 1rem;
            opacity: 0.9;
        }

        .profile-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .profile-section {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 16px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease;
            animation-fill-mode: both;
        }

        .profile-section:nth-child(1) { animation-delay: 0.1s; }
        .profile-section:nth-child(2) { animation-delay: 0.2s; }

        .profile-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
            background: rgba(255, 255, 255, 0.9);
        }

        .section-title {
            font-size: 1.3rem;
            color: var(--primary-solid);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
            font-weight: 600;
        }

        .info-group {
            margin-bottom: 1.5rem;
        }

        .info-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #666;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .info-value {
            font-size: 1.1rem;
            color: #333;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .info-group:hover .info-value {
            padding-left: 10px;
            border-color: var(--primary-solid);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            margin: 5% auto;
            padding: 30px;
            border-radius: 16px;
            width: 95%;
            max-width: 1000px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.6);
            animation: slideInDown 0.4s ease;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .close {
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            color: #333;
            transition: all 0.3s ease;
        }

        .close:hover {
            color: #ff4757;
            transform: rotate(90deg);
        }

        /* Form Styles */
        .popup-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .popup-form .form-group {
            display: flex;
            flex-direction: column;
        }

        .popup-form .form-group.full-width {
            grid-column: span 2;
        }

        .popup-form label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
        }

        .popup-form input,
        .popup-form select,
        .popup-form textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        .popup-form input:focus,
        .popup-form select:focus,
        .popup-form textarea:focus {
            outline: none;
            border-color: var(--primary-solid);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
            background: rgba(255, 255, 255, 1);
        }

        .popup-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 1.5rem;
            grid-column: span 2;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary-solid);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            background: rgba(102, 126, 234, 1);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: rgba(108, 117, 125, 0.8);
            color: white;
        }

        .btn-secondary:hover {
            background: rgba(108, 117, 125, 1);
            transform: translateY(-2px);
        }

        /* Success Modal */
        #successModal .modal-content {
            text-align: center;
            padding: 30px;
            max-width: 500px;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 0 1rem;
            }

            .sidebar {
                width: 100%;
                transform: translateX(-100%);
                opacity: 0;
            }

            .sidebar.show {
                transform: translateX(0);
                opacity: 1;
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .profile-content {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .popup-form {
                grid-template-columns: 1fr;
            }

            .popup-form .form-group.full-width {
                grid-column: span 1;
            }

            .modal-content {
                margin: 10% auto;
                padding: 20px;
                width: 95%;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle" onclick="toggleSidebar()">
                <span id="menu-icon"><i class="fas fa-bars"></i></span>
            </button>
            <div class="logo">
                <span><i class="fas fa-user"></i></span>
                <span>Profile</span>
            </div>
        </div>

        <div class="header-right">
            <div class="user-menu" onclick="toggleDropdown()">
                <div class="user-avatar">
                    <?php if (!empty($profile_data['image'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($profile_data['image']); ?>" alt="Profile">
                    <?php else: ?>
                        <?php echo strtoupper(substr($username, 0, 1)); ?>
                    <?php endif; ?>
                </div>
                <span><i class="fas fa-chevron-down"></i></span>

                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="dashboard.php" class="dropdown-item">
                        <span><i class="fas fa-home"></i></span>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <span><i class="fas fa-cog"></i></span>
                        <span>Settings</span>
                    </a>
                    <a href="?logout=1" class="dropdown-item">
                        <span><i class="fas fa-sign-out-alt"></i></span>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-title">Navigation</div>
        </div>

        <nav>
            <ul class="sidebar-menu">
                <li><a href="dashboard.php"><span class="icon"><i class="fas fa-home"></i></span>Dashboard</a></li>
                <li><a href="profile.php" class="active"><span class="icon"><i class="fas fa-user"></i></span>Profile</a></li>
                <li><a href="filem.php"><span class="icon"><i class="fas fa-folder"></i></span>File Manager</a></li>
                <li><a href="notes.php"><span class="icon"><i class="fas fa-sticky-note"></i></span>Notes</a></li>
                <li><a href="?logout=1"><span class="icon"><i class="fas fa-sign-out-alt"></i></span>Logout</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <div class="profile-container">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-image-container">
                    <?php if (!empty($profile_data['image'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($profile_data['image']); ?>" alt="Profile"
                            class="profile-image">
                    <?php else: ?>
                        <div class="profile-image">
                            <?php echo strtoupper(substr($username, 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <h1 class="profile-name">
                    <?php
                    if (!empty($profile_data['firstname']) || !empty($profile_data['lastname'])) {
                        echo htmlspecialchars($profile_data['firstname'] . ' ' . $profile_data['lastname']);
                    } else {
                        echo htmlspecialchars($username);
                    }
                    ?>
                </h1>
                <p class="profile-username">@<?php echo htmlspecialchars($username); ?></p>
            </div>

            <!-- Profile Content -->
            <div class="profile-content">
                <!-- Personal Information -->
                <div class="profile-section">
                    <h2 class="section-title">
                        <span><i class="fas fa-info-circle"></i></span>
                        Personal Information
                    </h2>

                    <div class="info-group">
                        <span class="info-label">First Name</span>
                        <div class="info-value">
                            <?php echo !empty($profile_data['firstname']) ? htmlspecialchars($profile_data['firstname']) : 'Not set'; ?>
                        </div>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Last Name</span>
                        <div class="info-value">
                            <?php echo !empty($profile_data['lastname']) ? htmlspecialchars($profile_data['lastname']) : 'Not set'; ?>
                        </div>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Email Address</span>
                        <div class="info-value">
                            <?php echo !empty($profile_data['email']) ? htmlspecialchars($profile_data['email']) : 'Not set'; ?>
                        </div>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Phone Number</span>
                        <div class="info-value">
                            <?php echo !empty($profile_data['phone']) ? htmlspecialchars($profile_data['phone']) : 'Not set'; ?>
                        </div>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Date of Birth</span>
                        <div class="info-value">
                            <?php echo !empty($profile_data['dob']) ? htmlspecialchars($profile_data['dob']) : 'Not set'; ?>
                        </div>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Gender</span>
                        <div class="info-value">
                            <?php echo !empty($profile_data['gender']) ? htmlspecialchars($profile_data['gender']) : 'Not set'; ?>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="profile-section">
                    <h2 class="section-title">
                        <span><i class="fas fa-home"></i></span>
                        Address Information
                    </h2>

                    <div class="info-group">
                        <span class="info-label">Address</span>
                        <div class="info-value">
                            <?php echo !empty($profile_data['address']) ? htmlspecialchars($profile_data['address']) : 'Not set'; ?>
                        </div>
                    </div>

                    <h2 class="section-title" style="margin-top: 2rem;">
                        <span><i class="fas fa-user-circle"></i></span>
                        Account Information
                    </h2>

                    <div class="info-group">
                        <span class="info-label">Username</span>
                        <div class="info-value"><?php echo htmlspecialchars($username); ?></div>
                    </div>

                    <div class="info-group">
                        <span class="info-label">User ID</span>
                        <div class="info-value"><?php echo htmlspecialchars($user_id); ?></div>
                    </div>

                    <div style="margin-top: 2rem; text-align: center;">
                        <button id="editProfileBtn" class="btn btn-primary"><i class="fas fa-edit"></i> Edit Profile</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Edit Popup -->
        <div id="editProfileModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Edit Profile</h2>
                <form id="editProfileForm" class="popup-form" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                    <div class="form-group">
                        <label>First Name:</label>
                        <input type="text" name="firstname"
                            value="<?php echo htmlspecialchars($profile_data['firstname']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Last Name:</label>
                        <input type="text" name="lastname"
                            value="<?php echo htmlspecialchars($profile_data['lastname']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($profile_data['email']); ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Phone:</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($profile_data['phone']); ?>">
                    </div>

                    <div class="form-group full-width">
                        <label>Address:</label>
                        <textarea name="address"><?php echo htmlspecialchars($profile_data['address']); ?></textarea>
                    </div>

                    <div class="form-group full-width">
                        <label>Profile Picture:</label>
                        <input type="file" name="image">
                    </div>

                    <div class="popup-buttons">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary close">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="successModal" class="modal" style="display:none;">
            <div class="modal-content" style="text-align:center; padding: 30px;">
                <span class="close">&times;</span>
                <h2>Success</h2>
                <p>Your details are successfully updated!</p>
                <button class="btn btn-primary" id="closeSuccessModal">OK</button>
            </div>
        </div>

        <div id="updateModal"
            style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); z-index:10000; justify-content:center; align-items:center;">
            <div style="background:white; padding:2rem; border-radius:10px; width:300px; text-align:center;">
                <p>Do you want to update your profile?</p>
                <button id="confirmUpdate">Yes</button>
                <button id="cancelUpdate">No</button>
            </div>
        </div>

    </main>

    <script>
        // Sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const menuIcon = document.getElementById('menu-icon');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            
            if (sidebar.classList.contains('collapsed')) {
                menuIcon.innerHTML = '<i class="fas fa-bars"></i>';
            } else {
                menuIcon.innerHTML = '<i class="fas fa-times"></i>';
            }
        }

        // Dropdown toggle
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.querySelector('.user-menu');
            const dropdown = document.getElementById('dropdownMenu');
            
            if (!userMenu.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Mobile sidebar handling
        if (window.innerWidth <= 768) {
            document.getElementById('sidebar').classList.add('collapsed');
            document.getElementById('mainContent').classList.add('expanded');
        }

        // Responsive sidebar
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            if (window.innerWidth <= 768) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            } else if (!sidebar.classList.contains('collapsed')) {
                mainContent.classList.remove('expanded');
            }
        });

        // Add animations on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.header').classList.add('fade-in');
            document.querySelector('.sidebar').classList.add('slide-in-left');
        });
    </script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Open modal
    $("#editProfileBtn").click(function () {
        $("#editProfileModal").show();
    });

    // Close edit modal
    $(".close").click(function () {
        $("#editProfileModal").hide();
    });

    // Single AJAX form submit handler
    $("#editProfileForm").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "update-profile.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                // Hide the edit profile modal
                $("#editProfileModal").hide();

                if (response.includes("successfully")) {
                    // Update profile name
                    var firstName = $("input[name='firstname']").val();
                    var lastName = $("input[name='lastname']").val();
                    $(".profile-name").text((firstName + " " + lastName).trim() || "<?php echo htmlspecialchars($username); ?>");

                    // Update personal info section
                    $(".profile-section .info-group").each(function () {
                        var label = $(this).find(".info-label").text().toLowerCase();
                        if (label === "first name") $(this).find(".info-value").text(firstName || "Not set");
                        else if (label === "last name") $(this).find(".info-value").text(lastName || "Not set");
                        else if (label === "email address") $(this).find(".info-value").text($("input[name='email']").val() || "Not set");
                        else if (label === "phone number") $(this).find(".info-value").text($("input[name='phone']").val() || "Not set");
                    });

                    // Update address info section
                    $(".profile-section .info-group").each(function () {
                        var label = $(this).find(".info-label").text().toLowerCase();
                        if (label === "address") $(this).find(".info-value").text($("textarea[name='address']").val() || "Not set");
                    });

                    // Show success popup
                    $("#successModal").show();
                } else {
                    alert(response);
                }
            },
            error: function () {
                alert("Error updating profile.");
            }
        });
    });

    // Close success popup
    $("#closeSuccessModal, #successModal .close").click(function () {
        $("#successModal").hide();
    });

    // Close popup when clicking outside
    $(document).click(function (event) {
        if (!$(event.target).closest("#successModal .modal-content").length) {
            $("#successModal").hide();
        }
    });
});
</script>
</body>

</html>