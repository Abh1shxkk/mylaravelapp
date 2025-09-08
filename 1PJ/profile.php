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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        /* Header Styles */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Popup Styles */
.popup-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 2000;
    justify-content: center;
    align-items: center;
}

.popup-content {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    width: 90%;
    max-width: 500px;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.popup-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0f0f0;
}

.popup-title {
    font-size: 1.5rem;
    color: #333;
}

.close-popup {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #666;
}

/* Modal background */
.modal {
    display: none; /* hidden by default */
    position: fixed; 
    z-index: 1000; /* सबसे ऊपर दिखे */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto; /* अगर content बड़ा हो तो scroll */
    background-color: rgba(0,0,0,0.5); /* black overlay */
}

/* Modal box */
.modal-content {
    background: #fff;
    margin: 5% auto;
    padding: 30px;
    border-radius: 10px;
    width: 95%;
    max-width: 1000px; /* horizontal width increase */
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

/* 2-column grid for form */
.popup-form {
    display: grid;
    grid-template-columns: 1fr 1fr; /* 2 columns */
    gap: 20px;
}

/* Each field styling */
.popup-form .form-group {
    display: flex;
    flex-direction: column;
}

/* Full width fields */
.popup-form .form-group.full-width {
    grid-column: span 2;
}

/* Buttons full width row */
.popup-buttons {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 1.5rem;
    grid-column: span 2;
}


/* Close button (X) */
.close {
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    color: #333;
}

.close:hover {
    color: red;
}


.close-popup:hover {
    color: #333;
}

.popup-form .form-group {
    margin-bottom: 1rem;
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
    padding: 10px;
    border: 2px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

.popup-form input:focus,
.popup-form select:focus,
.popup-form textarea:focus {
    outline: none;
    border-color: #667eea;
}

.popup-buttons {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.popup-buttons .btn {
    flex: 1;              /* Dono buttons same width */
    font-size: 16px;       /* Dono buttons same font-size */
    text-align: center;    /* Text center */
    padding: 10px 0;       /* Vertical padding same */
    border-radius: 5px;
    box-sizing: border-box;
}


.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 500;
}

.btn-primary {
    background: #667eea;
    color: white;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

/* Message styles */
.alert {
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 1rem;
    display: none;
    position: fixed;
    top: 80px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 3000;
    max-width: 80%;
}

.alert.show {
    display: block;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Loading spinner */
.spinner {
    width: 20px;
    height: 20px;
    border: 2px solid #ffffff;
    border-top: 2px solid transparent;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    display: none;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .menu-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .menu-toggle:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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
            padding: 0.5rem;
            border-radius: 25px;
            transition: background-color 0.3s;
        }

        .user-menu:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #667eea;
            font-weight: bold;
            border: 2px solid rgba(255,255,255,0.3);
            overflow: hidden;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            min-width: 200px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            display: none;
            z-index: 1001;
            overflow: hidden;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s;
            border-bottom: 1px solid #f1f3f4;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 70px;
            width: 280px;
            height: calc(100vh - 70px);
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            z-index: 999;
            overflow-y: auto;
        }
        

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e9ecef;
        }

        .sidebar-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .sidebar-menu {
            list-style: none;
            padding: 1rem 0;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: #666;
            text-decoration: none;
            transition: all 0.3s;
            border-right: 3px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: linear-gradient(90deg, rgba(102,126,234,0.1) 0%, transparent 100%);
            color: #667eea;
            border-right-color: #667eea;
        }

        .sidebar-menu .icon {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            margin-top: 70px;
            padding: 2rem;
            transition: margin-left 0.3s ease;
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
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            text-align: center;
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
            border: 4px solid #667eea;
            object-fit: cover;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #667eea;
        }

        .profile-name {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .profile-username {
            color: #666;
            font-size: 1rem;
        }

        .profile-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .profile-section {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 1.3rem;
            color: #333;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f0f0f0;
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
            border-bottom: 1px solid #f0f0f0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 0 1rem;
            }

            .sidebar {
                width: 100%;
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .profile-content {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle" onclick="toggleSidebar()">
                <span id="menu-icon">☰</span>
            </button>
            <div class="logo">
                <span>👤</span>
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
                <span>▼</span>

                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="dashboard.php" class="dropdown-item">
                        <span>🏠</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <span>⚙️</span>
                        <span>Settings</span>
                    </a>
                    <a href="?logout=1" class="dropdown-item">
                        <span>🚪</span>
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
                <li><a href="dashboard.php"><span class="icon">🏠</span>Dashboard</a></li>
                <li><a href="profile.php" class="active"><span class="icon">👤</span>Profile</a></li>
                <li><a href="#"><span class="icon">📊</span>Analytics</a></li>
                <li><a href="#"><span class="icon">📁</span>File Manager</a></li>
                <li><a href="#"><span class="icon">📝</span>Notes</a></li>
                <li><a href="#"><span class="icon">📅</span>Calendar</a></li>
                <li><a href="?logout=1"><span class="icon">🚪</span>Logout</a></li>
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
                        <img src="uploads/<?php echo htmlspecialchars($profile_data['image']); ?>" 
                             alt="Profile" class="profile-image">
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
                        <span>ℹ️</span>
                        Personal Information
                    </h2>
                    
                    <div class="info-group">
                        <span class="info-label">First Name</span>
                        <div class="info-value"><?php echo !empty($profile_data['firstname']) ? htmlspecialchars($profile_data['firstname']) : 'Not set'; ?></div>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Last Name</span>
                        <div class="info-value"><?php echo !empty($profile_data['lastname']) ? htmlspecialchars($profile_data['lastname']) : 'Not set'; ?></div>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Email Address</span>
                        <div class="info-value"><?php echo !empty($profile_data['email']) ? htmlspecialchars($profile_data['email']) : 'Not set'; ?></div>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Phone Number</span>
                        <div class="info-value"><?php echo !empty($profile_data['phone']) ? htmlspecialchars($profile_data['phone']) : 'Not set'; ?></div>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Date of Birth</span>
                        <div class="info-value"><?php echo !empty($profile_data['dob']) ? htmlspecialchars($profile_data['dob']) : 'Not set'; ?></div>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Gender</span>
                        <div class="info-value"><?php echo !empty($profile_data['gender']) ? htmlspecialchars($profile_data['gender']) : 'Not set'; ?></div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="profile-section">
                    <h2 class="section-title">
                        <span>🏠</span>
                        Address Information
                    </h2>
                    
                    <div class="info-group">
                        <span class="info-label">Address</span>
                        <div class="info-value"><?php echo !empty($profile_data['address']) ? htmlspecialchars($profile_data['address']) : 'Not set'; ?></div>
                    </div>

                    <h2 class="section-title" style="margin-top: 2rem;">
                        <span>👤</span>
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
                       <button id="editProfileBtn" class="btn btn-primary">✏️ Edit Profile</button>

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
                <input type="text" name="firstname" value="<?php echo htmlspecialchars($profile_data['firstname']); ?>" required>
            </div>

            <div class="form-group">
                <label>Last Name:</label>
                <input type="text" name="lastname" value="<?php echo htmlspecialchars($profile_data['lastname']); ?>" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($profile_data['email']); ?>" required>
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


    </main>

    <script>
        // Sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const menuIcon = document.getElementById('menu-icon');

            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            
            menuIcon.textContent = sidebar.classList.contains('collapsed') ? '☰' : '✕';
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

        // Responsive handling
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
    </script>

    

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Open modal
    $("#editProfileBtn").click(function() {
        $("#editProfileModal").show();
    });

    // Close modal
    $(".close").click(function() {
        $("#editProfileModal").hide();
    });

    // AJAX form submit
    $("#editProfileForm").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "update-profile.php",  
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response);
                location.reload(); 
            },
            error: function() {
                alert("Error updating profile.");
            }
        });
    });
});
</script>

</body>
</html>