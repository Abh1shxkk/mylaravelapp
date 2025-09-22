<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold">Profile Settings</h1>
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
                    
                    <!-- Dashboard Home Link -->
                    <a href="{{ route('dashboard.home') }}" 
                       class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-sm">
                        <i class="fas fa-home mr-1"></i>Dashboard
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
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Profile Settings</h2>
                <div class="space-y-3">
                    <div class="block bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                        <h4 class="font-semibold text-blue-900 flex items-center">
                            <i class="fas fa-user-edit mr-3 text-blue-600"></i>Edit Profile
                        </h4>
                        <p class="text-blue-700 text-sm mt-1">Update your profile information</p>
                    </div>
                    
                    <div class="block bg-green-50 p-4 rounded-lg hover:bg-green-100 transition-colors cursor-pointer group">
                        <h4 class="font-semibold text-green-900 flex items-center">
                            <i class="fas fa-camera mr-3 text-green-600"></i>Profile Picture
                        </h4>
                        <p class="text-green-700 text-sm mt-1">Upload or update your avatar</p>
                    </div>
                    
                    <div class="block bg-purple-50 p-4 rounded-lg hover:bg-purple-100 transition-colors cursor-pointer group">
                        <h4 class="font-semibold text-purple-900 flex items-center">
                            <i class="fas fa-lock mr-3 text-purple-600"></i>Security
                        </h4>
                        <p class="text-purple-700 text-sm mt-1">Change password & security settings</p>
                    </div>

                    <div class="block bg-orange-50 p-4 rounded-lg hover:bg-orange-100 transition-colors cursor-pointer group">
                        <h4 class="font-semibold text-orange-900 flex items-center">
                            <i class="fas fa-bell mr-3 text-orange-600"></i>Notifications
                        </h4>
                        <p class="text-orange-700 text-sm mt-1">Manage notification preferences</p>
                    </div>
                </div>

                <!-- Account Summary in Sidebar -->
                <div class="mt-6 pt-4 border-t">
                    <h3 class="text-sm font-semibold text-gray-600 mb-3">Account Summary</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Member Since</span>
                            <span class="font-semibold">{{ Auth::user()->created_at->format('M Y') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Email Verified</span>
                            <span class="font-semibold {{ Auth::user()->email_verified_at ? 'text-green-600' : 'text-red-600' }}">
                                {{ Auth::user()->email_verified_at ? 'Yes' : 'No' }}
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Account Status</span>
                            <span class="font-semibold text-green-600">Active</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 p-6 overflow-auto">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span class="font-medium">Please fix the following errors:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Welcome Section -->
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Profile Settings</h3>
                <p class="text-gray-600">Manage your account settings and profile information.</p>
            </div>

            <!-- Profile Cards Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Profile Picture Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-semibold text-gray-800">Profile Picture</h4>
                        <i class="fas fa-camera text-gray-400"></i>
                    </div>
                    
                    <div class="text-center">
                        <div class="mb-4">
                            @if(Auth::user()->profile_picture)
                                <img class="mx-auto h-24 w-24 rounded-full object-cover border-4 border-gray-200" 
                                     src="{{ asset('storage/' . Auth::user()->profile_picture) }}" 
                                     alt="Profile Picture">
                            @else
                                <div class="mx-auto h-24 w-24 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white text-2xl font-semibold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        
                        <form method="POST" action="{{ route('profile.upload-picture') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input type="file" 
                                       name="profile_picture" 
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                       required>
                            </div>
                            <button type="submit" 
                                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                <i class="fas fa-upload mr-2"></i>Upload Picture
                            </button>
                        </form>

                        @if(Auth::user()->profile_picture)
                            <form method="POST" action="{{ route('profile.remove-picture') }}" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-100 text-red-700 px-4 py-2 rounded-lg hover:bg-red-200 transition-colors text-sm"
                                        onclick="return confirm('Are you sure you want to remove your profile picture?')">
                                    <i class="fas fa-trash mr-2"></i>Remove Picture
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Profile Information Card -->
                <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-semibold text-gray-800">Profile Information</h4>
                        <i class="fas fa-user-edit text-gray-400"></i>
                    </div>
                    
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-1"></i>Full Name
                                </label>
                                <input type="text" 
                                       name="name" 
                                       value="{{ old('name', Auth::user()->name) }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       required>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-1"></i>Email Address
                                </label>
                                <input type="email" 
                                       name="email" 
                                       value="{{ old('email', Auth::user()->email) }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       required>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-phone mr-1"></i>Phone Number
                                </label>
                                <input type="tel" 
                                       name="phone" 
                                       value="{{ old('phone', Auth::user()->phone) }}"
                                       placeholder="+1 (555) 123-4567"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user-tag mr-1"></i>Role
                                </label>
                                @if(Auth::user()->role === 'admin')
                                    <select name="role" 
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="user" {{ Auth::user()->role === 'user' ? 'selected' : '' }}>User</option>
                                        <option value="manager" {{ Auth::user()->role === 'manager' ? 'selected' : '' }}>Manager</option>
                                        <option value="admin" {{ Auth::user()->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                @else
                                    <input type="text" 
                                           value="{{ ucfirst(Auth::user()->role) }}" 
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 text-gray-600" 
                                           readonly>
                                @endif
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-edit mr-1"></i>Bio
                            </label>
                            <textarea name="bio" 
                                      rows="3" 
                                      placeholder="Tell us about yourself..."
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('bio', Auth::user()->bio) }}</textarea>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('dashboard.home') }}" 
                               class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-save mr-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password Section -->
            <div class="mt-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-semibold text-gray-800">Change Password</h4>
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    
                    <form method="POST" action="{{ route('profile.change-password') }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Current Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-1"></i>Current Password
                                </label>
                                <input type="password" 
                                       name="current_password" 
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       required>
                            </div>

                            <!-- New Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-key mr-1"></i>New Password
                                </label>
                                <input type="password" 
                                       name="password" 
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       required>
                            </div>

                            <!-- Confirm New Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-key mr-1"></i>Confirm New Password
                                </label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       required>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" 
                                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                <i class="fas fa-shield-alt mr-2"></i>Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>