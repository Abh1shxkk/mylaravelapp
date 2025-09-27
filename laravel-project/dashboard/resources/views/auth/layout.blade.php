<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        
                        <!-- Sign in with switch -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Sign in with</span>
                            <div class="flex p-1 bg-gray-100 rounded-xl shadow-inner">
                                <button type="button" id="btn-email" class="px-3 py-1.5 text-xs sm:text-sm font-semibold rounded-lg transition-colors flex items-center gap-1.5"> 
                                    <img src="{{ asset('images/icons/email.png') }}" alt="Email" class="h-4 w-4 object-contain" onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">
                                    <i class="fas fa-envelope mr-1 hidden"></i>
                                    <span>Email</span>
                                </button>
                                <button type="button" id="btn-phone" class="px-3 py-1.5 text-xs sm:text-sm font-semibold rounded-lg transition-colors flex items-center gap-1.5"> 
                                    <img src="{{ asset('images/icons/phone.png') }}" alt="Phone" class="h-4 w-4 object-contain" onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">
                                    <i class="fas fa-phone mr-1 hidden"></i>
                                    <span>Phone</span>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label id="identifier-label" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i id="identifier-label-icon" class="fas fa-envelope mr-2 text-gray-400"></i>Email address
                            </label>
                            <div class="relative">
                                <input type="email" 
                                       id="identifier"
                                       name="identifier" 
                                       value="{{ old('identifier') }}" 
                                       required
                                       class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('identifier') border-red-500 @enderror"
                                       placeholder="name@example.com">
                                <i id="identifier-leading-icon" class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('identifier')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
                            <div class="flex items-center gap-3">
                                <a href="{{ route('dashboard.password.forgot') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Forgot password?</a>
                                <button type="button" id="open-forgot-email" class="hidden text-sm text-blue-600 hover:text-blue-700 font-medium"
                                    onclick="(function(){var m=document.getElementById('forgot-email-modal');if(m){m.classList.remove('hidden');m.classList.add('flex');}})()"
                                >Forgot email?</button>
                            </div>
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

    <!-- Forgot Email Modal -->
    <div id="forgot-email-modal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white w-full max-w-md mx-4 rounded-xl shadow-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Find your account email</h3>
                <button type="button" id="close-forgot-email" class="text-gray-400 hover:text-gray-600"
                    onclick="(function(){var m=document.getElementById('forgot-email-modal');if(m){m.classList.add('hidden');m.classList.remove('flex');}})()"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <p class="text-sm text-gray-600">Enter your registered phone number. We will show the email linked to it.</p>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone number (India)</label>
                    <div class="relative">
                        <input type="tel" id="forgot-phone" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="+91 98765 43210">
                        <i class="fas fa-phone absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <p id="forgot-email-error" class="mt-1 text-sm text-red-600 hidden"></p>
                    <p id="forgot-email-success" class="mt-1 text-sm text-green-600 hidden"></p>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 flex items-center justify-end gap-2">
                <button type="button" id="cancel-forgot-email" class="px-4 py-2 text-sm text-gray-700 hover:text-gray-900"
                    onclick="(function(){var m=document.getElementById('forgot-email-modal');if(m){m.classList.add('hidden');m.classList.remove('flex');}})()"
                >Cancel</button>
                <button type="button" id="submit-forgot-email" class="px-4 py-2 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded-lg"
                    onclick="forgotEmailSubmit()"
                >Find email</button>
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

        // Email/Phone mode toggle
        (function(){
            const btnEmail = document.getElementById('btn-email');
            const btnPhone = document.getElementById('btn-phone');
            const input = document.getElementById('identifier');
            const leadIcon = document.getElementById('identifier-leading-icon');
            const label = document.getElementById('identifier-label');
            const labelIcon = document.getElementById('identifier-label-icon');
            const forgotEmailBtn = document.getElementById('open-forgot-email');

            function setMode(mode){
                const activeClass = 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow';
                const inactiveClass = 'text-gray-700 hover:text-gray-900';
                btnEmail.className = 'px-3 py-1.5 text-xs sm:text-sm font-semibold rounded-lg transition-colors ' + (mode==='email'?activeClass:inactiveClass);
                btnPhone.className = 'px-3 py-1.5 text-xs sm:text-sm font-semibold rounded-lg transition-colors ' + (mode==='phone'?activeClass:inactiveClass);

                if(mode==='email'){
                    input.type = 'email';
                    input.placeholder = 'name@example.com';
                    label.innerHTML = '<i id="identifier-label-icon" class="fas fa-envelope mr-2 text-gray-400"></i>Email address';
                    leadIcon.className = 'fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400';
                    input.removeAttribute('pattern');
                    if(forgotEmailBtn){ forgotEmailBtn.classList.remove('hidden'); }
                } else {
                    input.type = 'tel';
                    input.placeholder = '+91 98765 43210';
                    label.innerHTML = '<i id="identifier-label-icon" class="fas fa-phone mr-2 text-gray-400"></i>Phone number';
                    leadIcon.className = 'fas fa-phone absolute left-3 top-1/2 -translate-y-1/2 text-gray-400';
                    input.setAttribute('pattern','^[0-9+\-\s()]{7,20}$');
                    if(forgotEmailBtn){ forgotEmailBtn.classList.add('hidden'); }
                }
            }

            // Heuristic: if previous value contains '@', default to email; else phone
            const prev = (input && input.value) ? input.value : '';
            setMode(prev.includes('@') ? 'email' : 'phone');

            btnEmail.addEventListener('click', ()=>setMode('email'));
            btnPhone.addEventListener('click', ()=>setMode('phone'));
        })();

        // Global handler for the Forgot Email modal submit
        async function forgotEmailSubmit(){
            const phoneInput = document.getElementById('forgot-phone');
            const err = document.getElementById('forgot-email-error');
            const ok = document.getElementById('forgot-email-success');
            const btn = document.getElementById('submit-forgot-email');
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrf = csrfMeta ? csrfMeta.getAttribute('content') : '';

            if(!phoneInput || !err || !ok){ return; }
            err.classList.add('hidden');
            ok.classList.add('hidden');

            const phone = (phoneInput.value || '').trim();
            if(!phone){
                err.textContent = 'Please enter your phone number.';
                err.classList.remove('hidden');
                return;
            }

            try{
                if(btn){ btn.disabled = true; btn.classList.add('opacity-70','cursor-not-allowed'); }
                const res = await fetch('{{ route('dashboard.forgot-email') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ phone })
                });
                const data = await res.json();
                if(!res.ok || !data.success){
                    throw new Error(data.message || 'Unable to find email for that phone number.');
                }
                ok.innerHTML = 'Email associated with this number: <strong>' + data.email + '</strong>';
                ok.classList.remove('hidden');
            }catch(e){
                err.textContent = e.message || 'Something went wrong.';
                err.classList.remove('hidden');
            }finally{
                if(btn){ btn.disabled = false; btn.classList.remove('opacity-70','cursor-not-allowed'); }
            }
        }

        // Close modals when clicking on overlay background for this layout
        (function(){
            const tryBindOverlay = (id) => {
                const overlay = document.getElementById(id);
                if (!overlay || overlay.__overlayBound) return;
                overlay.__overlayBound = true;
                overlay.addEventListener('mousedown', function(e){
                    if (e.target === overlay) {
                        overlay.classList.add('hidden');
                        overlay.classList.remove('flex');
                    }
                });
            };
            // Currently used on this layout
            tryBindOverlay('forgot-email-modal');
        })();
    </script>
</body>
</html>