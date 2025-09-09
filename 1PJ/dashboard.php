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

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border: none;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.6);
            color: var(--text);
            width: 250px;
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .search-box input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.9);
            width: 300px;
            box-shadow: 0 0 0 2px var(--primary-solid);
        }

        .search-box input::placeholder {
            color: rgba(0, 0, 0, 0.4);
        }

        .search-icon {
            position: absolute;
            left: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-solid);
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
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: calc(100vh - 70px);
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* Dropdown Menu */
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

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background-color: rgba(102, 126, 234, 0.1);
            padding-left: 1.5rem;
        }

        .dropdown-item.logout:hover {
            background-color: rgba(220, 53, 69, 0.1);
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

            .user-info {
                display: none;
            }
        }

        /* Welcome Section */
        .welcome-section {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 16px;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.5);
            animation: fadeInUp 0.6s ease;
        }

        .welcome-title {
            font-size: 1.8rem;
            color: var(--primary-solid);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .welcome-subtitle {
            color: #666;
            font-size: 1rem;
            opacity: 0.9;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease;
            animation-fill-mode: both;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
            background: rgba(255, 255, 255, 0.9);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .stat-icon.blue { 
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        .stat-icon.green { 
            background: linear-gradient(135deg, rgba(86, 171, 47, 0.8), rgba(168, 230, 207, 0.8));
            box-shadow: 0 4px 12px rgba(86, 171, 47, 0.3);
        }
        .stat-icon.orange { 
            background: linear-gradient(135deg, rgba(240, 147, 251, 0.8), rgba(245, 87, 108, 0.8));
            box-shadow: 0 4px 12px rgba(240, 147, 251, 0.3);
        }
        .stat-icon.purple { 
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.8), rgba(0, 242, 254, 0.8));
            box-shadow: 0 4px 12px rgba(79, 172, 254, 0.3);
        }

        .stat-content h3 {
            font-size: 1.8rem;
            color: var(--text);
            margin-bottom: 0.25rem;
            font-weight: 700;
        }

        .stat-content p {
            color: #666;
            font-size: 0.9rem;
            opacity: 0.9;
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

        .slide-in-left {
            animation: slideInLeft 0.5s ease;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Content area */
        #content {
            padding: 2rem;
            margin-top: 70px;
            margin-left: 280px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
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
                <span><i class="fas fa-home"></i></span>
                <span>Dashboard</span>
            </div>
        </div>

      

        <div class="header-right">
            <div class="search-box">
                <span class="search-icon"><i class="fas fa-search"></i></span>
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
                <span><i class="fas fa-chevron-down"></i></span>

                <!-- Dropdown Menu -->
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="profile.php" class="dropdown-item">
                        <span><i class="fas fa-user"></i></span>
                        <span>Profile</span>
                    </a>
        
                
                    <a href="?logout=1" class="dropdown-item logout">
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
            <div class="sidebar-subtitle">Manage your account</div>
        </div>

        <nav>
            <ul class="sidebar-menu">
                <li><a href="#" class="active"><span class="icon"><i class="fas fa-home"></i></span>Dashboard</a></li>
                <li><a href="profile.php"><span class="icon"><i class="fas fa-user"></i></span>Profile</a></li>
                <li><a href="analytics.php"><span class="icon"><i class="fas fa-folder"></i></span>File Manager</a></li>
                <li><a href="notes.php"><span class="icon"><i class="fas fa-sticky-note"></i></span>Notes</a></li>
                <li><a href="#"><span class="icon"><i class="fas fa-calendar"></i></span>Calendar</a></li>
            </ul>

            <div class="sidebar-section">
                <div class="sidebar-section-title">Tools</div>
                <ul class="sidebar-menu">
                    <li><a href="#"><span class="icon"><i class="fas fa-bell"></i></span>Notifications</a></li>
                </ul>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-section-title">Account</div>
                <ul class="sidebar-menu">
                    <li><a href="#"><span class="icon"><i class="fas fa-shield-alt"></i></span>Security</a></li>
                    <li><a href="?logout=1"><span class="icon"><i class="fas fa-sign-out-alt"></i></span>Logout</a></li>
                </ul>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h1 class="welcome-title">
                Welcome back, <?php echo htmlspecialchars($profile_data['firstname'] ?? $username); ?>! <i class="fas fa-hand-wave"></i>
            </h1>
            <p class="welcome-subtitle">
                Here's what's happening with your account today.
            </p>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-chart-bar"></i></div>
                <div class="stat-content">
                    <h3>25</h3>
                    <p>Total Projects</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
                <div class="stat-content">
                    <h3>18</h3>
                    <p>Completed Tasks</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon orange"><i class="fas fa-folder"></i></div>
                <div class="stat-content">
                    <h3>127</h3>
                    <p>Files Uploaded</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon purple"><i class="fas fa-clock"></i></div>
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
            
            // Animate stats cards sequentially
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>