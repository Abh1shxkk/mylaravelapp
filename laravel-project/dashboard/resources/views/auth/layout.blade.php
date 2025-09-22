<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-purple-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white/80 backdrop-blur-sm shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-tachometer-alt text-white text-sm"></i>
                        </div>
                        <h1 class="text-xl font-bold text-gray-900">Dashboard</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">New to our platform?</span>
                    <a href="/dashboard/register" 
                       class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors text-sm font-medium">
                        <i class="fas fa-user-plus mr-2"></i>Sign Up
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="flex min-h-[calc(100vh-4rem)]">
        <!-- Left Side - Branding/Info -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-blue-700 to-purple-700"></div>
            <div class="relative z-10 flex flex-col justify-center px-12 text-white">
                <div class="max-w-md">
                    <div class="mb-8">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-rocket text-2xl text-white"></i>
                        </div>
                        <h2 class="text-4xl font-bold mb-4">Welcome Back!</h2>
                        <p class="text-blue-100 text-lg">Sign in to access your dashboard and manage your account with ease.</p>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-shield-alt text-sm"></i>
                            </div>
                            <span>Secure and encrypted</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-lightning-bolt text-sm"></i>
                            </div>
                            <span>Lightning fast performance</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
<i class="fas fa-rocket text-sm"></i>                            </div>
                            <span>Trusted by thousands</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Decorative elements -->
            <div class="absolute top-20 right-20 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
            <div class="absolute bottom-20 right-32 w-24 h-24 bg-purple-400/20 rounded-full blur-lg"></div>
            <div class="absolute top-1/2 right-12 w-16 h-16 bg-blue-400/20 rounded-full blur-md"></div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <!-- Login Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-sign-in-alt text-2xl text-white"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Sign In</h2>
                        <p class="text-gray-600">Enter your credentials to access your account</p>
                    </div>

                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span class="font-medium">Authentication failed</span>
                            </div>
                            <ul class="text-sm space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="/dashboard/login" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2 text-gray-400"></i>Email Address
                            </label>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   placeholder="Enter your email">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2 text-gray-400"></i>Password
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="password" 
                                       required
                                       id="password"
                                       class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                       placeholder="Enter your password">
                                <button type="button" 
                                        onclick="togglePassword()"
                                        class="absolute inset-y-0 right-0 px-3 text-gray-400 hover:text-gray-600 transition-colors">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="remember" 
                                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                            <a href="{{ route('dashboard.password.forgot') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                Forgot password?
                            </a>
                        </div>

                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-4 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 font-semibold flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Sign In
                        </button>
                    </form>
<div class="mt-6">
    <a href="{{ route('auth.google') }}" 
       class="w-full flex items-center justify-center bg-red-500 hover:bg-red-600 text-white py-3 px-4 rounded-lg transition-colors font-medium">
        <i class="fab fa-google mr-2"></i>Sign in with Google
    </a>
</div>
                    <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                        <p class="text-sm text-gray-600">
                            Don't have an account?
                            <a href="/dashboard/register" 
                               class="text-blue-600 hover:text-blue-700 font-semibold ml-1">
                                Create one now
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="mt-8 text-center">
                    <p class="text-xs text-gray-500">
                        By signing in, you agree to our 
                        <a href="#" class="text-blue-600 hover:text-blue-700">Terms of Service</a> and 
                        <a href="#" class="text-blue-600 hover:text-blue-700">Privacy Policy</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.className = 'fas fa-eye-slash';
            } else {
                passwordField.type = 'password';
                toggleIcon.className = 'fas fa-eye';
            }
        }
    </script>
</body>
</html>