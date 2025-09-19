<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <div class="bg-white shadow border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/dashboard" class="text-blue-600 hover:text-blue-800 mr-4">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                    <h1 class="text-xl font-semibold text-gray-900">Profile Settings</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">{{ Auth::user()->name }}</span>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Picture Section -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Profile Picture</h3>
                    </div>
                    <div class="px-6 py-6 text-center">
                        <div class="mb-4">
                            @if(Auth::user()->profile_picture)
                                <img class="mx-auto h-32 w-32 rounded-full object-cover border-4 border-gray-200" 
                                     src="{{ asset('storage/' . Auth::user()->profile_picture) }}" 
                                     alt="Profile Picture">
                            @else
                                <div class="mx-auto h-32 w-32 rounded-full bg-gray-300 flex items-center justify-center">
                                    <i class="fas fa-user text-4xl text-gray-600"></i>
                                </div>
                            @endif
                        </div>
                        
                        <form method="POST" action="{{ route('profile.upload-picture') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Choose new picture
                                </label>
                                <input type="file" 
                                       name="profile_picture" 
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                       required>
                            </div>
                            <button type="submit" 
                                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                                <i class="fas fa-upload mr-2"></i>Upload Picture
                            </button>
                        </form>

                        @if(Auth::user()->profile_picture)
                            <form method="POST" action="{{ route('profile.remove-picture') }}" class="mt-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200"
                                        onclick="return confirm('Are you sure you want to remove your profile picture?')">
                                    <i class="fas fa-trash mr-2"></i>Remove Picture
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Profile Information Section -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Profile Information</h3>
                    </div>
                    <div class="px-6 py-6">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-user mr-1"></i>Full Name
                                    </label>
                                    <input type="text" 
                                           name="name" 
                                           value="{{ old('name', Auth::user()->name) }}"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <!-- Role (Read-only for non-admin users) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-user-tag mr-1"></i>Role
                                    </label>
                                    @if(Auth::user()->role === 'admin')
                                        <select name="role" 
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-edit mr-1"></i>Bio
                                </label>
                                <textarea name="bio" 
                                          rows="4" 
                                          placeholder="Tell us about yourself..."
                                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('bio', Auth::user()->bio) }}</textarea>
                            </div>

                            <div class="mt-8 flex justify-end space-x-3">
                                <a href="{{ route('dashboard') }}" 
                                   class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition duration-200">
                                    Cancel
                                </a>
                                <button type="submit" 
                                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                                    <i class="fas fa-save mr-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password Section -->
                <div class="bg-white shadow rounded-lg overflow-hidden mt-8">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Change Password</h3>
                    </div>
                    <div class="px-6 py-6">
                        <form method="POST" action="{{ route('profile.change-password') }}">
                            @csrf
                            @method('PATCH')
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Current Password -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-lock mr-1"></i>Current Password
                                    </label>
                                    <input type="password" 
                                           name="current_password" 
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           required>
                                </div>

                                <!-- New Password -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-key mr-1"></i>New Password
                                    </label>
                                    <input type="password" 
                                           name="password" 
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           required>
                                </div>

                                <!-- Confirm New Password -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-key mr-1"></i>Confirm New Password
                                    </label>
                                    <input type="password" 
                                           name="password_confirmation" 
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           required>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="submit" 
                                        class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                                    <i class="fas fa-shield-alt mr-2"></i>Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>