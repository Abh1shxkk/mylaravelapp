<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold">Dashboard</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Profile Picture -->
                    @if(Auth::user()->profile_picture)
                        <img class="h-8 w-8 rounded-full object-cover" 
                             src="{{ asset('storage/' . Auth::user()->profile_picture) }}" 
                             alt="Profile">
                    @else
                        <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                            <i class="fas fa-user text-gray-600 text-sm"></i>
                        </div>
                    @endif
                    
                    <div class="flex flex-col">
                        <span class="text-gray-700">Welcome, {{ Auth::user()->name }}</span>
                        <span class="text-xs text-blue-600">{{ ucfirst(Auth::user()->role ?? 'user') }}</span>
                    </div>
                    
                    <!-- Profile Settings Link -->
                    <a href="{{ route('profile.settings') }}" 
                       class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-sm">
                        <i class="fas fa-user-cog mr-1"></i>Profile
                    </a>

                    @if(Auth::user() && method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())
                        <!-- Admin Settings Link (visible only for admins) -->
                        <a href="{{ route('admin.users.index') }}"
                           class="bg-gray-700 text-white px-3 py-2 rounded hover:bg-gray-800 text-sm"
                           title="Admin-only: manage users">
                            <i class="fas fa-shield-alt mr-1"></i>Admin Settings
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('dashboard.logout') }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="flex h-screen ">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Navigation</h2>
                <div class="space-y-3">
                    <a href="{{ route('profile.settings') }}" class="block bg-blue-50 p-4 rounded-lg hover:bg-blue-100 transition-colors group">
                        <h4 class="font-semibold text-blue-900 flex items-center">
                            <i class="fas fa-user mr-3 text-blue-600"></i>Profile
                        </h4>
                        <p class="text-blue-700 text-sm mt-1">Manage your profile and settings</p>
                    </a>
                    
                    <div class="block bg-green-50 p-4 rounded-lg hover:bg-green-100 transition-colors cursor-pointer group">
                        <h4 class="font-semibold text-green-900 flex items-center">
                            <i class="fas fa-cog mr-3 text-green-600"></i>Settings
                        </h4>
                        <p class="text-green-700 text-sm mt-1">Configure application settings</p>
                    </div>
                    
                    <div class="block bg-purple-50 p-4 rounded-lg hover:bg-purple-100 transition-colors cursor-pointer group">
                        <h4 class="font-semibold text-purple-900 flex items-center">
                            <i class="fas fa-chart-bar mr-3 text-purple-600"></i>Analytics
                        </h4>
                        <p class="text-purple-700 text-sm mt-1">View your statistics and reports</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 p-6 overflow-auto">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Welcome Section -->
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Dashboard Home</h3>
                <p class="text-gray-600">Welcome to your dashboard! You are successfully logged in.</p>
            </div>

            <!-- Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 auto-rows-auto">
                <!-- Large Card - Recent Activity -->
                <div class="bg-white rounded-lg shadow-md p-6 col-span-1 md:col-span-2 row-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-semibold text-gray-800">Recent Activity</h4>
                        <i class="fas fa-history text-gray-400"></i>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Profile updated</p>
                                <p class="text-xs text-gray-500">2 hours ago</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Task completed</p>
                                <p class="text-xs text-gray-500">1 day ago</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded">
                            <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-bell text-white text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">New notification</p>
                                <p class="text-xs text-gray-500">3 days ago</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium opacity-80">Total Users</h4>
                        <i class="fas fa-users"></i>
                    </div>
                    <p class="text-2xl font-bold">1,247</p>
                    <p class="text-xs opacity-80 mt-1">+12% from last month</p>
                </div>

                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium opacity-80">Revenue</h4>
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <p class="text-2xl font-bold">$12,340</p>
                    <p class="text-xs opacity-80 mt-1">+8% from last month</p>
                </div>

                <!-- Medium Card - Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6 col-span-1 lg:col-span-2">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h4>
                    <div class="grid grid-cols-2 gap-3">
                        <button class="bg-blue-50 hover:bg-blue-100 p-3 rounded-lg text-left transition-colors">
                            <i class="fas fa-plus text-blue-600 mb-2"></i>
                            <p class="text-sm font-medium text-blue-900">Create New</p>
                        </button>
                        <button class="bg-green-50 hover:bg-green-100 p-3 rounded-lg text-left transition-colors">
                            <i class="fas fa-upload text-green-600 mb-2"></i>
                            <p class="text-sm font-medium text-green-900">Upload File</p>
                        </button>
                        <button class="bg-purple-50 hover:bg-purple-100 p-3 rounded-lg text-left transition-colors">
                            <i class="fas fa-download text-purple-600 mb-2"></i>
                            <p class="text-sm font-medium text-purple-900">Export Data</p>
                        </button>
                        <button class="bg-orange-50 hover:bg-orange-100 p-3 rounded-lg text-left transition-colors">
                            <i class="fas fa-share text-orange-600 mb-2"></i>
                            <p class="text-sm font-medium text-orange-900">Share</p>
                        </button>
                    </div>
                </div>

                <!-- Small Cards -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-md p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium opacity-80">Tasks</h4>
                        <i class="fas fa-tasks"></i>
                    </div>
                    <p class="text-2xl font-bold">24</p>
                    <p class="text-xs opacity-80 mt-1">5 pending</p>
                </div>

                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-md p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium opacity-80">Messages</h4>
                        <i class="fas fa-envelope"></i>
                    </div>
                    <p class="text-2xl font-bold">18</p>
                    <p class="text-xs opacity-80 mt-1">3 unread</p>
                </div>

                <!-- Calendar Widget -->
                <div class="bg-white rounded-lg shadow-md p-6 col-span-1 md:col-span-1 lg:col-span-1">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-semibold text-gray-800">Calendar</h4>
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">22</div>
                        <div class="text-sm text-gray-600">September 2025</div>
                        <div class="text-xs text-gray-400 mt-2">Monday</div>
                    </div>
                </div>

                <!-- Weather Widget -->
                <div class="bg-gradient-to-br from-sky-400 to-sky-500 rounded-lg shadow-md p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium opacity-80">Weather</h4>
                        <i class="fas fa-sun"></i>
                    </div>
                    <p class="text-2xl font-bold">28°C</p>
                    <p class="text-xs opacity-80 mt-1">Sunny</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>