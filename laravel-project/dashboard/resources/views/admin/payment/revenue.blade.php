<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Reports - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold">Revenue Reports</h1>
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
                       class="block bg-orange-50 p-4 rounded-lg border-l-4 border-orange-500">
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
            <!-- Revenue Stats -->
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
                            <p class="text-sm font-medium text-gray-600">This Month</p>
                            <p class="text-2xl font-bold text-gray-900">₹{{ number_format($revenueStats['monthly_revenue']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Active Subscriptions</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $revenueStats['active_subscriptions'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Subscriptions</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $revenueStats['total_subscriptions'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-receipt text-orange-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Monthly Revenue Chart -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Monthly Revenue</h3>
                    <canvas id="monthlyRevenueChart" width="400" height="200"></canvas>
                </div>

                <!-- Plan Performance Chart -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Plan Performance</h3>
                    <canvas id="planPerformanceChart" width="400" height="200"></canvas>
                </div>
            </div>

            <!-- Monthly Revenue Table -->
            <div class="bg-white rounded-lg shadow-md mb-8">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Monthly Revenue Breakdown</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscriptions</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg. Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($monthlyRevenue as $month)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::create($month->year, $month->month, 1)->format('F Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ₹{{ number_format($month->revenue) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $month->subscriptions }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ₹{{ number_format($month->subscriptions > 0 ? $month->revenue / $month->subscriptions : 0) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Plan Statistics -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Plan Statistics</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($planStats as $plan)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-semibold text-gray-900">{{ $plan->name }}</h4>
                                <span class="text-sm px-2 py-1 rounded bg-blue-100 text-blue-600">
                                    ₹{{ number_format($plan->price) }}
                                </span>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Total Subscriptions:</span>
                                    <span class="font-medium">{{ $plan->total_subscriptions }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Active Subscriptions:</span>
                                    <span class="font-medium text-green-600">{{ $plan->active_subscriptions }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Total Revenue:</span>
                                    <span class="font-medium">₹{{ number_format($plan->total_subscriptions * $plan->price) }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Monthly Revenue Chart
        const monthlyCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
        const monthlyData = @json($monthlyRevenue->reverse()->values());
        
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: monthlyData.map(item => {
                    const date = new Date(item.year, item.month - 1);
                    return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
                }),
                datasets: [{
                    label: 'Revenue (₹)',
                    data: monthlyData.map(item => item.revenue),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₹' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Plan Performance Chart
        const planCtx = document.getElementById('planPerformanceChart').getContext('2d');
        const planData = @json($planStats);
        
        new Chart(planCtx, {
            type: 'doughnut',
            data: {
                labels: planData.map(plan => plan.name),
                datasets: [{
                    data: planData.map(plan => plan.active_subscriptions),
                    backgroundColor: [
                        'rgb(34, 197, 94)',
                        'rgb(59, 130, 246)',
                        'rgb(168, 85, 247)',
                        'rgb(245, 158, 11)',
                        'rgb(239, 68, 68)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>


