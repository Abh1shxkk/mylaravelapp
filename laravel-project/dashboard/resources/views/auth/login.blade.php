@extends('dashboard-auth::layout')

@section('title', 'Login - Dashboard')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Sign in to Dashboard</h2>
        <p class="mt-2 text-sm text-gray-600">Welcome back! Please sign in to your account</p>
    </div>

    <form method="POST" action="{{ route('dashboard.login') }}" class="space-y-6">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
            <input id="email" 
                   name="email" 
                   type="email" 
                   value="{{ old('email') }}" 
                   required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <div class="relative">
                <input id="password" 
                       name="password" 
                       type="password" 
                       required
                       class="mt-1 block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                
            </div>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
            </div>

            <div class="text-sm">
                <a href="{{ route('dashboard.password.forgot') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Forgot your password?
                </a>
            </div>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Sign in
            </button>
        </div>

        <!-- Or divider -->
        <div class="mt-6 relative">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Or continue with</span>
            </div>
        </div>

        <!-- Google Sign-In -->
        <div class="mt-6">
            <a href="{{ route('auth.google') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="h-5 w-5"><path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303C33.602,32.091,29.197,36,24,36c-6.627,0-12-5.373-12-12s5.373-12,12-12 c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20 s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,16.108,18.961,13,24,13c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657 C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/><path fill="#4CAF50" d="M24,44c5.113,0,9.81-1.953,13.362-5.148l-6.164-5.238C29.197,36,24.792,32.091,24,32.091 c-5.176,0-9.567-3.5-11.289-8.366l-6.542,5.036C9.499,39.556,16.227,44,24,44z"/><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-1.024,2.971-3.242,5.431-6.14,6.843l0.004-0.003l6.164,5.238 C33.789,41.046,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg>
                <span>Sign in with Google</span>
            </a>
        </div>

        <!-- Register Link -->
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Don't have an account? 
                <a href="{{ route('dashboard.register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Sign up
                </a>
            </p>
        </div>
    </form>

<script></script>
</div>
@endsection