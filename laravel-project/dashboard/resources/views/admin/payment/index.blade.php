<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Management - Admin</title>
     @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold">Payment Management</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard.home') }}" 
                       class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-sm">
                        <i class="fas fa-home mr-1"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" 
                       class="bg-gray-600 text-white px-3 py-2 rounded hover:bg-gray-700 text-sm">
                        <i class="fas fa-users mr-1"></i>Users
                    </a>
                    <form method="POST" action="{{ route('dashboard.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Payment Management</h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.payment.index') }}" 
                       class="block bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                        <h4 class="font-semibold text-blue-900 flex items-center">
                            <i class="fas fa-tachometer-alt mr-3 text-blue-600"></i>Overview
                        </h4>
                        <p class="text-blue-700 text-sm mt-1">Payment dashboard and stats</p>
                    </a>
                    
                    <a href="{{ route('admin.payment.plans') }}" 
                       class="block bg-green-50 p-4 rounded-lg hover:bg-green-100 transition-colors group">
                        <h4 class="font-semibold text-green-900 flex items-center">
                            <i class="fas fa-list mr-3 text-green-600"></i>Manage Plans
                        </h4>
                        <p class="text-green-700 text-sm mt-1">Create and edit subscription plans</p>
                    </a>
                    
                    <a href="{{ route('admin.payment.subscribers') }}" 
                       class="block bg-purple-50 p-4 rounded-lg hover:bg-purple-100 transition-colors group">
                        <h4 class="font-semibold text-purple-900 flex items-center">
                            <i class="fas fa-users mr-3 text-purple-600"></i>Subscribers
                        </h4>
                        <p class="text-purple-700 text-sm mt-1">View and manage subscriptions</p>
                    </a>
                    
                    <a href="{{ route('admin.payment.revenue') }}" 
                       class="block bg-orange-50 p-4 rounded-lg hover:bg-orange-100 transition-colors group">
                        <h4 class="font-semibold text-orange-900 flex items-center">
                            <i class="fas fa-chart-line mr-3 text-orange-600"></i>Revenue Reports
                        </h4>
                        <p class="text-orange-700 text-sm mt-1">Financial analytics and reports</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 overflow-auto">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                            <p class="text-2xl font-bold text-gray-900">₹{{ number_format($revenueStats['total_revenue']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Active Subscriptions</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $revenueStats['active_subscriptions'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Subscriptions</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $revenueStats['total_subscriptions'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-receipt text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">This Month</p>
                            <p class="text-2xl font-bold text-gray-900">₹{{ number_format($revenueStats['monthly_revenue']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar text-orange-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Plans Overview -->
            <div class="bg-white rounded-lg shadow-md mb-8">
                <div class="p-6 border-b">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Subscription Plans</h3>
                        <a href="{{ route('admin.payment.plans') }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                            <i class="fas fa-cog mr-1"></i>Manage Plans
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($plans as $plan)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-semibold text-gray-900">{{ $plan->name }}</h4>
                                <span class="text-sm px-2 py-1 rounded bg-gray-100 text-gray-600">
                                    {{ $plan->subscriptions_count }} subs
                                </span>
                            </div>
                            <p class="text-2xl font-bold text-blue-600">₹{{ number_format($plan->price) }}</p>
                            <p class="text-sm text-gray-500">{{ ucfirst($plan->billing_period) }}</p>
                            @if($plan->razorpay_plan_id)
                                <p class="text-xs text-green-600 mt-2">
                                    <i class="fas fa-check-circle mr-1"></i>Razorpay Connected
                                </p>
                            @else
                                <p class="text-xs text-red-600 mt-2">
                                    <i class="fas fa-exclamation-circle mr-1"></i>No Razorpay ID
                                </p>
                            @endif
                            @if($plan->stripe_price_id)
                                <p class="text-xs text-violet-600 mt-1">
                                    <i class="fas fa-check-circle mr-1"></i>Stripe Connected
                                </p>
                            @else
                                <p class="text-xs text-red-600 mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>No Stripe Price ID
                                </p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Payment Gateways Toggle -->
            <div class="bg-white rounded-lg shadow-md mb-8">
                <div class="p-6 border-b">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Payment Gateways</h3>
                    </div>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.payment.gateways.update') }}" class="space-y-4">
                        @csrf
                        <div class="flex items-center justify-between p-4 border rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">Razorpay</p>
                                <p class="text-sm text-gray-500">Enable/disable Razorpay for users</p>
                            </div>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="hidden" name="razorpay" value="0">
                                <input type="checkbox" name="razorpay" value="1" class="sr-only peer" {{ ($gateways['razorpay'] ?? false) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600 relative"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-4 border rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">Stripe</p>
                                <p class="text-sm text-gray-500">Enable/disable Stripe for users</p>
                            </div>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="hidden" name="stripe" value="0">
                                <input type="checkbox" name="stripe" value="1" class="sr-only peer" {{ ($gateways['stripe'] ?? false) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600 relative"></div>
                            </label>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Subscriptions -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6 border-b">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Subscriptions</h3>
                        <a href="{{ route('admin.payment.subscribers') }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentSubscriptions as $subscription)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-600 text-sm"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $subscription->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $subscription->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ ucfirst($subscription->plan_id) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($subscription->status === 'active') bg-green-100 text-green-800
                                        @elseif($subscription->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($subscription->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($subscription->created_at)->format('M d, Y') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
