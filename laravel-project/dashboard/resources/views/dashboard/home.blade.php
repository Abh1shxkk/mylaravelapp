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

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    Dashboard Home
                </h3>
                <p class="text-gray-600">
                    Welcome to your dashboard! You are successfully logged in.
                </p>
                
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a href="{{ route('profile.settings') }}" class="bg-blue-50 p-4 rounded-lg hover:bg-blue-100 transition-colors">
                        <h4 class="font-semibold text-blue-900">
                            <i class="fas fa-user mr-2"></i>Profile
                        </h4>
                        <p class="text-blue-700 text-sm mt-1">Manage your profile and settings</p>
                    </a>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-green-900">
                            <i class="fas fa-cog mr-2"></i>Settings
                        </h4>
                        <p class="text-green-700 text-sm mt-1">Configure application settings</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-purple-900">
                            <i class="fas fa-chart-bar mr-2"></i>Analytics
                        </h4>
                        <p class="text-purple-700 text-sm mt-1">View your statistics and reports</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>