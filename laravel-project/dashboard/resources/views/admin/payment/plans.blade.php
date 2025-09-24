<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Plans - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold">Manage Plans</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.payment.index') }}" 
                       class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-sm">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Payment
                    </a>
                    <a href="{{ route('dashboard.home') }}" 
                       class="bg-gray-500 text-white px-3 py-2 rounded hover:bg-gray-600 text-sm">
                        <i class="fas fa-home mr-1"></i>Dashboard
                    </a>
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
                       class="block bg-gray-50 p-4 rounded-lg hover:bg-gray-100 transition-colors group">
                        <h4 class="font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-tachometer-alt mr-3 text-gray-600"></i>Overview
                        </h4>
                        <p class="text-gray-700 text-sm mt-1">Payment dashboard and stats</p>
                    </a>
                    
                    <a href="{{ route('admin.payment.plans') }}" 
                       class="block bg-green-50 p-4 rounded-lg border-l-4 border-green-500">
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

            <!-- Header Actions -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Subscription Plans</h2>
                <a href="{{ route('admin.payment.plans.create') }}" 
                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Create New Plan
                </a>
            </div>

            <!-- Plans Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($plans as $plan)
                <div class="bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $plan->name }}</h3>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.payment.plans.edit', $plan) }}" 
                                   class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.payment.plans.destroy', $plan) }}" 
                                      class="inline" onsubmit="return confirm('Are you sure you want to delete this plan?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-3xl font-bold text-blue-600">₹{{ number_format($plan->price) }}</p>
                            <p class="text-sm text-gray-500">{{ ucfirst($plan->billing_period) }}</p>
                        </div>

                        @if($plan->description)
                            <p class="text-sm text-gray-600 mb-4">{{ $plan->description }}</p>
                        @endif

                        <div class="space-y-2 mb-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Slug:</span>
                                <span class="font-mono text-gray-700">{{ $plan->slug }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Subscriptions:</span>
                                <span class="font-semibold text-gray-700">{{ $plan->subscriptions_count }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Razorpay ID:</span>
                                @if($plan->razorpay_plan_id)
                                    <span class="text-green-600 text-xs font-mono">{{ Str::limit($plan->razorpay_plan_id, 15) }}</span>
                                @else
                                    <span class="text-red-600 text-xs">Not set</span>
                                @endif
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Created:</span>
                                <span class="text-sm text-gray-700">{{ $plan->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @if($plans->isEmpty())
                <div class="col-span-full bg-white rounded-lg shadow-md p-12 text-center">
                    <i class="fas fa-list text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Plans Found</h3>
                    <p class="text-gray-600 mb-6">Create your first subscription plan to get started.</p>
                    <a href="{{ route('admin.payment.plans.create') }}" 
                       class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Create First Plan
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>


