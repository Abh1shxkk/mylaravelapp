<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-green-50 via-white to-blue-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white/80 backdrop-blur-sm shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-600 to-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-tachometer-alt text-white text-sm"></i>
                        </div>
                        <h1 class="text-xl font-bold text-gray-900">Dashboard</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Already have an account?</span>
                    <a href="/dashboard/login" 
                       class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors text-sm font-medium">
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="flex min-h-[calc(100vh-4rem)]">
        <!-- Left Side - Registration Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <!-- Register Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user-plus text-2xl text-white"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Create Account</h2>
                        <p class="text-gray-600">Join us today and get started in minutes</p>
                    </div>

                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span class="font-medium">Please fix the following errors:</span>
                            </div>
                            <ul class="text-sm space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="/dashboard/register" class="space-y-5">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user mr-2 text-gray-400"></i>Full Name
                            </label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                   placeholder="Enter your full name">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2 text-gray-400"></i>Email Address
                            </label>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
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
                                       class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                       placeholder="Create a password">
                                <button type="button" 
                                        onclick="togglePassword('password', 'toggleIcon1')"
                                        class="absolute inset-y-0 right-0 px-3 text-gray-400 hover:text-gray-600 transition-colors">
                                    <i class="fas fa-eye" id="toggleIcon1"></i>
                                </button>
                            </div>
                            <div class="mt-1">
                                <div class="flex items-center space-x-1 text-xs">
                                    <div class="h-1 bg-gray-200 rounded flex-1">
                                        <div id="strength-bar" class="h-full rounded transition-all duration-300"></div>
                                    </div>
                                    <span id="strength-text" class="text-gray-500 font-medium">Weak</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2 text-gray-400"></i>Confirm Password
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="password_confirmation" 
                                       required
                                       id="password_confirmation"
                                       class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                       placeholder="Confirm your password">
                                <button type="button" 
                                        onclick="togglePassword('password_confirmation', 'toggleIcon2')"
                                        class="absolute inset-y-0 right-0 px-3 text-gray-400 hover:text-gray-600 transition-colors">
                                    <i class="fas fa-eye" id="toggleIcon2"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <input type="checkbox" 
                                   required
                                   class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 mt-1">
                            <label class="ml-2 text-sm text-gray-600">
                                I agree to the 
                                <a href="#" class="text-green-600 hover:text-green-700 font-medium">Terms of Service</a> 
                                and 
                                <a href="#" class="text-green-600 hover:text-green-700 font-medium">Privacy Policy</a>
                            </label>
                        </div>

                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-green-600 to-blue-600 text-white py-3 px-4 rounded-lg hover:from-green-700 hover:to-blue-700 transition-all duration-200 font-semibold flex items-center justify-center">
                            <i class="fas fa-user-plus mr-2"></i>
                            Create Account
                        </button>
                    </form>

                    <!-- Or divider -->
                    <div class="mt-6 relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Or sign up with</span>
                        </div>
                    </div>

                    <!-- Google Sign-Up -->
                    <div class="mt-6">
                        <a href="{{ route('auth.google') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="h-5 w-5"><path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303C33.602,32.091,29.197,36,24,36c-6.627,0-12-5.373-12-12s5.373-12,12-12 c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20 s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,16.108,18.961,13,24,13c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657 C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/><path fill="#4CAF50" d="M24,44c5.113,0,9.81-1.953,13.362-5.148l-6.164-5.238C29.197,36,24.792,32.091,24,32.091 c-5.176,0-9.567-3.5-11.289-8.366l-6.542,5.036C9.499,39.556,16.227,44,24,44z"/><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-1.024,2.971-3.242,5.431-6.14,6.843l0.004-0.003l6.164,5.238 C33.789,41.046,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg>
                            <span>Sign up with Google</span>
                        </a>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                        <p class="text-sm text-gray-600">
                            Already have an account?
                            <a href="/dashboard/login" 
                               class="text-green-600 hover:text-green-700 font-semibold ml-1">
                                Sign in here
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="mt-8 text-center">
                    <div class="flex items-center justify-center space-x-6 text-xs text-gray-500">
                        <div class="flex items-center">
                            <i class="fas fa-shield-alt text-green-500 mr-1"></i>
                            SSL Encrypted
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock text-blue-500 mr-1"></i>
                            2-min setup
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-gift text-purple-500 mr-1"></i>
                            Free forever
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Branding/Info -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-green-600 via-green-700 to-blue-700"></div>
            <div class="relative z-10 flex flex-col justify-center px-12 text-white">
                <div class="max-w-md">
                    <div class="mb-8">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-sparkles text-2xl text-white"></i>
                        </div>
                        <h2 class="text-4xl font-bold mb-4">Join Our Community!</h2>
                        <p class="text-green-100 text-lg">Create your account and unlock powerful features designed to enhance your productivity.</p>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-rocket text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold mb-1">Get Started Instantly</h3>
                                <p class="text-green-100 text-sm">Set up your account in under 2 minutes and start exploring our features right away.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-users text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold mb-1">Join 10,000+ Users</h3>
                                <p class="text-green-100 text-sm">Be part of our growing community of professionals and creators.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-star text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold mb-1">Premium Features</h3>
                                <p class="text-green-100 text-sm">Access advanced tools and analytics to boost your productivity and success.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Decorative elements -->
            <div class="absolute top-20 right-20 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
            <div class="absolute bottom-20 left-32 w-24 h-24 bg-blue-400/20 rounded-full blur-lg"></div>
            <div class="absolute top-1/2 right-12 w-16 h-16 bg-green-400/20 rounded-full blur-md"></div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId, iconId) {
            const passwordField = document.getElementById(fieldId);
            const toggleIcon = document.getElementById(iconId);
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.className = 'fas fa-eye-slash';
            } else {
                passwordField.type = 'password';
                toggleIcon.className = 'fas fa-eye';
            }
        }

        // Password strength checker
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strengthBar = document.getElementById('strength-bar');
            const strengthText = document.getElementById('strength-text');
            
            let strength = 0;
            let color = '';
            let text = '';
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            switch(strength) {
                case 0:
                case 1:
                    color = 'bg-red-500';
                    text = 'Weak';
                    break;
                case 2:
                    color = 'bg-yellow-500';
                    text = 'Fair';
                    break;
                case 3:
                    color = 'bg-blue-500';
                    text = 'Good';
                    break;
                case 4:
                    color = 'bg-green-500';
                    text = 'Strong';
                    break;
            }
            
            strengthBar.className = `h-full rounded transition-all duration-300 ${color}`;
            strengthBar.style.width = `${(strength / 4) * 100}%`;
            strengthText.textContent = text;
            strengthText.className = `font-medium ${color.replace('bg-', 'text-')}`;
        });
    </script>
</body>
</html>