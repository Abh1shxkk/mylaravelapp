<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-md w-full max-w-md p-6">
        <h2 class="text-xl font-bold mb-2">Forgot your password?</h2>
        <p class="text-sm text-gray-600 mb-6">Enter the email you used to sign up. We'll send a reset link if it matches an account.</p>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('dashboard.password.email') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                <input type="email" name="email" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="you@example.com">
            </div>
            <div class="flex items-center justify-between">
                <a href="{{ route('dashboard.login') }}" class="text-sm text-gray-600">Back to login</a>
                <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700">Send reset link</button>
            </div>
        </form>
    </div>
</body>
</html>


