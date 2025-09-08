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
    <title>Dashboard - <?php echo htmlspecialchars($username); ?></title>
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

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border: none;
            border-radius: 20px;
            background: rgba(255,255,255,0.2);
            color: white;
            placeholder-color: rgba(255,255,255,0.7);
            width: 250px;
            transition: all 0.3s;
        }

        .search-box input:focus {
            outline: none;
            background: rgba(255,255,255,0.3);
            width: 300px;
        }

        .search-box input::placeholder {
            color: rgba(255,255,255,0.7);
        }

        .search-icon {
            position: absolute;
            left: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.7);
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

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 500;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.7rem;
            opacity: 0.8;
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

        .sidebar-subtitle {
            font-size: 0.85rem;
            color: #666;
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

        .sidebar-section {
            margin-top: 2rem;
        }

        .sidebar-section-title {
            padding: 0 1.5rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #999;
            letter-spacing: 1px;
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

        /* Dropdown Menu */
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

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item.logout:hover {
            background-color: #fee;
            color: #dc3545;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 0 1rem;
            }

            .search-box {
                display: none;
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

            .user-info {
                display: none;
            }
        }

        /* Welcome Section */
        .welcome-section {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .welcome-title {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            color: #666;
            font-size: 1rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-icon.blue { background: linear-gradient(135deg, #667eea, #764ba2); }
        .stat-icon.green { background: linear-gradient(135deg, #56ab2f, #a8e6cf); }
        .stat-icon.orange { background: linear-gradient(135deg, #f093fb, #f5576c); }
        .stat-icon.purple { background: linear-gradient(135deg, #4facfe, #00f2fe); }

        .stat-content h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 0.25rem;
        }

        .stat-content p {
            color: #666;
            font-size: 0.9rem;
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
                <span>🏠</span>
                <span>Dashboard</span>
            </div>
        </div>
<div id="content">
    <!-- Default dashboard content -->
    <h2>Welcome to your Dashboard</h2>
</div>

        <div class="header-right">
            <div class="search-box">
                <span class="search-icon">🔍</span>
                <input type="text" placeholder="Search anything...">
            </div>

            <div class="user-menu" onclick="toggleDropdown()">
                <div class="user-avatar">
                    <?php if (!empty($profile_data['image'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($profile_data['image']); ?>" alt="Profile">
                    <?php else: ?>
                        <?php echo strtoupper(substr($username, 0, 1)); ?>
                    <?php endif; ?>
                </div>
                <div class="user-info">
                    <div class="user-name"><?php echo htmlspecialchars($profile_data['firstname'] ?? $username); ?></div>
                    <div class="user-role">Member</div>
                </div>
                <span>▼</span>

                <!-- Dropdown Menu -->
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="profile.php" class="dropdown-item">
                        <span>👤</span>
                        <span>Profile</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <span>⚙️</span>
                        <span>Settings</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <span>💬</span>
                        <span>Help & Support</span>
                    </a>
                    <a href="?logout=1" class="dropdown-item logout">
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
            <div class="sidebar-subtitle">Manage your account</div>
        </div>

        <nav>
            <ul class="sidebar-menu">
                <li><a href="#" class="active"><span class="icon">🏠</span>Dashboard</a></li>
                <li><a href="profile.php"><span class="icon">👤</span>Profile</a></li>
                <li><a href="#"><span class="icon">📊</span>Analytics</a></li>
                <li><a href="#"><span class="icon">📁</span>File Manager</a></li>
                <li><a href="#"><span class="icon">📝</span>Notes</a></li>
                <li><a href="#"><span class="icon">📅</span>Calendar</a></li>
            </ul>

            <div class="sidebar-section">
                <div class="sidebar-section-title">Tools</div>
                <ul class="sidebar-menu">
                    <li><a href="#"><span class="icon">💬</span>Messages</a></li>
                    <li><a href="#"><span class="icon">🔔</span>Notifications</a></li>
                    <li><a href="#"><span class="icon">📈</span>Reports</a></li>
                    <li><a href="#"><span class="icon">⚙️</span>Settings</a></li>
                </ul>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-section-title">Account</div>
                <ul class="sidebar-menu">
                    <li><a href="#"><span class="icon">🛡️</span>Security</a></li>
                    <li><a href="#"><span class="icon">💳</span>Billing</a></li>
                    <li><a href="#"><span class="icon">❓</span>Help</a></li>
                    <li><a href="?logout=1"><span class="icon">🚪</span>Logout</a></li>
                </ul>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h1 class="welcome-title">
                Welcome back, <?php echo htmlspecialchars($profile_data['firstname'] ?? $username); ?>! 👋
            </h1>
            <p class="welcome-subtitle">
                Here's what's happening with your account today.
            </p>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">📊</div>
                <div class="stat-content">
                    <h3>25</h3>
                    <p>Total Projects</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">✅</div>
                <div class="stat-content">
                    <h3>18</h3>
                    <p>Completed Tasks</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon orange">📁</div>
                <div class="stat-content">
                    <h3>127</h3>
                    <p>Files Uploaded</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon purple">⏰</div>
                <div class="stat-content">
                    <h3>8.5</h3>
                    <p>Hours Today</p>
                </div>
            </div>
        </div>

        <!-- More content sections can be added here -->
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
    </script>
</body>
</html>