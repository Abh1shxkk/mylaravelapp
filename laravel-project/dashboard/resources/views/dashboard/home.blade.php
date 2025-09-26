<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery for AJAX -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    @php
        // Compute active subscription early for header rendering
        $activeSubscriptionHeader = Auth::user()->subscriptions()->where('status', 'active')->latest('started_at')->first();
        $currentPlanHeader = $activeSubscriptionHeader ? $activeSubscriptionHeader->plan_id : null;
    @endphp
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold">Dashboard</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Profile Picture -->
                    @if(Auth::user()->profile_picture)
                        <img class="h-8 w-8 rounded-full object-cover"
                            src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile">
                    @else
                        <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                            <i class="fas fa-user text-gray-600 text-sm"></i>
                        </div>
                    @endif

                    <div class="flex flex-col">
                        <span class="text-gray-700">Welcome, {{ Auth::user()->name }}</span>
                        <span class="text-xs text-blue-600">{{ ucfirst(Auth::user()->role ?? 'user') }}</span>
                    </div>

                    <!-- Profile Settings Link -->
                    <a href="{{ route('profile.settings') }}"
                        class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-sm">
                        <i class="fas fa-user-cog mr-1"></i>Profile
                    </a>

                    @if(Auth::user() && method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())
                        <!-- Admin Settings Link (visible only for admins) -->
                        <a href="{{ route('admin.users.index') }}"
                            class="bg-gray-700 text-white px-3 py-2 rounded hover:bg-gray-800 text-sm"
                            title="Admin-only: manage users">
                            <i class="fas fa-shield-alt mr-1"></i>Admin Settings
                        </a>
                        
                        <!-- Payment Settings Link (visible only for admins) -->
                        <a href="{{ route('admin.payment.index') }}"
                            class="bg-purple-600 text-white px-3 py-2 rounded hover:bg-purple-700 text-sm"
                            title="Admin-only: manage payments and subscriptions">
                            <i class="fas fa-credit-card mr-1"></i>Payment Settings
                        </a>
                    @endif

                    <!-- Subscribe Button (always rendered; hidden when user has an active plan) -->
                    <button id="btn-subscribe" type="button" onclick="openModal('modal-subscribe')"
                        class="@if($currentPlanHeader) hidden @endif bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 text-sm">
                        <i class="fas fa-crown mr-1"></i>Subscribe
                    </button>

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

    <div class="flex h-screen ">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Navigation</h2>
                <div class="space-y-3">
                    <a href="{{ route('profile.settings') }}"
                        class="block bg-blue-50 p-4 rounded-lg hover:bg-blue-100 transition-colors group">
                        <h4 class="font-semibold text-blue-900 flex items-center">
                            <i class="fas fa-user mr-3 text-blue-600"></i>Profile
                        </h4>
                        <p class="text-blue-700 text-sm mt-1">Manage your profile and settings</p>
                    </a>

                    <a href="{{ route('profile.settings') }}#change-password"
                        class="block bg-green-50 p-4 rounded-lg hover:bg-green-100 transition-colors group">
                        <h4 class="font-semibold text-green-900 flex items-center">
                            <i class="fas fa-cog mr-3 text-green-600"></i>Settings
                        </h4>
                        <p class="text-green-700 text-sm mt-1">Change your password & manage settings</p>
                    </a>

                    <div
                        class="block bg-purple-50 p-4 rounded-lg hover:bg-purple-100 transition-colors cursor-pointer group">
                        <h4 class="font-semibold text-purple-900 flex items-center">
                            <i class="fas fa-chart-bar mr-3 text-purple-600"></i>Analytics
                        </h4>
                        <p class="text-purple-700 text-sm mt-1">View your statistics and reports</p>
                    </div>

                    <!-- Basic / Premium entries in navigation -->
                    @php
                        $activeSubscription = Auth::user()->subscriptions()->where('status', 'active')->latest('started_at')->first();
                        $currentPlan = $activeSubscription ? $activeSubscription->plan_id : null; // 'basic' | 'premium' | null
                    @endphp
                    <div onclick="handlePlanClick('basic')"
                        class="block bg-yellow-50 p-4 rounded-lg hover:bg-yellow-100 transition-colors cursor-pointer group">
                        <h4 class="font-semibold text-yellow-900 flex items-center">
                            <i class="fas fa-star mr-3 text-yellow-600"></i>Basic Content
                        </h4>
                        <p class="text-yellow-700 text-sm mt-1">Open basic content</p>
                    </div>
                    <div onclick="handlePlanClick('premium')"
                        class="block bg-rose-50 p-4 rounded-lg hover:bg-rose-100 transition-colors cursor-pointer group">
                        <h4 class="font-semibold text-rose-900 flex items-center">
                            <i class="fas fa-gem mr-3 text-rose-600"></i>Premium Content
                        </h4>
                        <p class="text-rose-700 text-sm mt-1">Open premium content</p>
                    </div>

                    <!-- My Plans -->
                    <div onclick="openModal('modal-my-plans')"
                        class="block bg-indigo-50 p-4 rounded-lg hover:bg-indigo-100 transition-colors cursor-pointer group">
                        <h4 class="font-semibold text-indigo-900 flex items-center">
                            <i class="fas fa-receipt mr-3 text-indigo-600"></i>My Plans
                        </h4>
                        <p class="text-indigo-700 text-sm mt-1">View or cancel your current plan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 p-6 overflow-auto">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Welcome Section -->
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Dashboard Home</h3>
                <p class="text-gray-600">Welcome to your dashboard! You are successfully logged in.</p>
            </div>

            <!-- Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 auto-rows-auto">
                <!-- Large Card - Recent Activity -->
                <div class="bg-white rounded-lg shadow-md p-6 col-span-1 md:col-span-2 row-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-semibold text-gray-800">Recent Activity</h4>
                        <i class="fas fa-history text-gray-400"></i>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Profile updated</p>
                                <p class="text-xs text-gray-500">2 hours ago</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Task completed</p>
                                <p class="text-xs text-gray-500">1 day ago</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded">
                            <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-bell text-white text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">New notification</p>
                                <p class="text-xs text-gray-500">3 days ago</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium opacity-80">Total Users</h4>
                        <i class="fas fa-users"></i>
                    </div>
                    <p class="text-2xl font-bold">1,247</p>
                    <p class="text-xs opacity-80 mt-1">+12% from last month</p>
                </div>

                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium opacity-80">Revenue</h4>
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <p class="text-2xl font-bold">$12,340</p>
                    <p class="text-xs opacity-80 mt-1">+8% from last month</p>
                </div>

              
                <!-- Small Cards -->
               

                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-md p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium opacity-80">Messages</h4>
                        <i class="fas fa-envelope"></i>
                    </div>
                    <p class="text-2xl font-bold">18</p>
                    <p class="text-xs opacity-80 mt-1">3 unread</p>
                </div>

                <!-- Calendar Widget -->
                <div class="bg-white rounded-lg shadow-md p-6 col-span-1 md:col-span-1 lg:col-span-1">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-semibold text-gray-800">Calendar</h4>
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">22</div>
                        <div class="text-sm text-gray-600">September 2025</div>
                        <div class="text-xs text-gray-400 mt-2">Monday</div>
                    </div>
                </div>

                <!-- Weather Widget -->
                <div class="bg-gradient-to-br from-sky-400 to-sky-500 rounded-lg shadow-md p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium opacity-80">Weather</h4>
                        <i class="fas fa-sun"></i>
                    </div>
                    <p class="text-2xl font-bold">28°C</p>
                    <p class="text-xs opacity-80 mt-1">Sunny</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Subscribe Modal with plan cards -->
    <div id="modal-subscribe" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center p-4">
        <div data-modal-panel class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl overflow-hidden transform transition-all duration-200 opacity-0 scale-95 max-h-[85vh] flex flex-col">
            <div class="flex items-center justify-between px-5 py-3 border-b sticky top-0 bg-white/95 backdrop-blur">
                <h3 class="text-xl font-semibold">Choose Your Plan</h3>
                <button onclick="closeModals()" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 overflow-y-auto">
                @foreach($plans as $plan)
                <div class="relative rounded-xl border border-gray-200 p-4 bg-gradient-to-br from-white to-gray-50 transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-lg font-bold">{{ $plan->name }}</h4>
                        @if($plan->slug === 'basic')
                            <span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-700">Best for starters</span>
                        @elseif($plan->slug === 'premium')
                            <span class="text-xs px-2 py-1 rounded bg-purple-100 text-purple-700">Most popular</span>
                        @else
                            <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-700">Available</span>
                        @endif
                    </div>
                    @php
                        $displayPeriod = $plan->billing_period === 'custom'
                            ? trim(($plan->duration_value ?? '') . ' ' . ($plan->duration_unit ?? ''))
                            : $plan->billing_period;
                    @endphp
                    <p class="text-3xl font-extrabold tracking-tight">₹{{ number_format($plan->price) }}
                        <span class="text-sm font-medium text-gray-500">/ {{ $displayPeriod }}</span>
                    </p>
                    @if($plan->description)
                        <div class="mt-4 text-sm text-gray-700">
                            <p>{{ $plan->description }}</p>
                        </div>
                    @else
                        <ul class="mt-4 space-y-2 text-sm text-gray-700">
                            @if($plan->slug === 'basic')
                                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i>Access to basic content</li>
                                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i>Weekly updates</li>
                                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i>Email support</li>
                            @elseif($plan->slug === 'premium')
                                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i>Everything in Basic</li>
                                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i>Premium-only content</li>
                                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i>Priority support</li>
                            @else
                                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i>Full access to all features</li>
                                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i>Priority support</li>
                            @endif
                        </ul>
                    @endif
                    <button type="button" onclick="confirmBuy('{{ $plan->slug }}')"
                        class="mt-6 w-full {{ $plan->slug === 'basic' ? 'bg-blue-600 hover:bg-blue-700' : ($plan->slug === 'premium' ? 'bg-purple-600 hover:bg-purple-700' : 'bg-green-600 hover:bg-green-700') }} text-white py-2.5 rounded-lg font-medium">
                        Buy {{ $plan->name }}
                    </button>
                </div>
                @endforeach
            </div>
            <div class="px-5 pb-5 text-right border-t">
                <button onclick="closeModals()" class="px-4 py-2 rounded-md border transition-colors hover:bg-gray-50">Close</button>
            </div>
        </div>
    </div>
    <div id="modal-basic-only" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center">
        <div data-modal-panel class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 transform transition-all duration-200 opacity-0 scale-95">
            <h3 class="text-lg font-semibold mb-2">Basic Content</h3>
            <p class="text-gray-700 mb-4">You are on the Basic plan. You can access basic content only.</p>
            <div class="text-right">
                <button onclick="closeModals()" class="px-4 py-2 rounded-md border transition-colors hover:bg-gray-50">Close</button>
            </div>
        </div>
    </div>

    <div id="modal-need-premium" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center">
        <div data-modal-panel class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 transform transition-all duration-200 opacity-0 scale-95">
            <h3 class="text-lg font-semibold mb-2">Subscription Required</h3>
            <p class="text-gray-700 mb-4">Please subscribe to a plan to access this content.</p>
            <div class="text-right">
                <button onclick="closeModals()" class="px-4 py-2 rounded-md border mr-2 transition-colors hover:bg-gray-50">Close</button>
            </div>
        </div>
    </div>

    <!-- My Plans Modal -->
    <div id="modal-my-plans" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center p-4">
        <div data-modal-panel class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all duration-200 opacity-0 scale-95">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h3 class="text-xl font-semibold">My Current Plan</h3>
                <button onclick="closeModals()" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <div id="plan-details-none" class="hidden">
                    <p class="text-gray-700">You don't have an active subscription. Please subscribe to a plan.</p>
                </div>
                @foreach($plans as $plan)
                <div id="plan-details-{{ $plan->slug }}" class="hidden">
                    <h4 class="text-lg font-semibold mb-1">{{ $plan->name }} Plan</h4>
                    @php
                        $displayPeriodDetails = $plan->billing_period === 'custom'
                            ? trim(($plan->duration_value ?? '') . ' ' . ($plan->duration_unit ?? ''))
                            : $plan->billing_period;
                    @endphp
                    <p class="text-gray-600 mb-4">₹{{ number_format($plan->price) }} / {{ $displayPeriodDetails }}</p>
                    @if($plan->description)
                        <div class="text-sm text-gray-700 mb-6">
                            <p>{{ $plan->description }}</p>
                        </div>
                    @else
                        <ul class="text-sm text-gray-700 space-y-2 mb-6">
                            @if($plan->slug === 'basic')
                                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i>Access to basic content</li>
                                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i>Weekly updates</li>
                                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i>Email support</li>
                            @elseif($plan->slug === 'premium')
                                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i>Everything in Basic</li>
                                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i>Premium-only content</li>
                                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i>Priority support</li>
                            @else
                                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i>Full access to all features</li>
                                <li class="flex items-center"><i class="fas fa-check text-green-600 mr-2"></i>Priority support</li>
                            @endif
                        </ul>
                    @endif
                    
                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        @if(($currentPlan ?? null) !== 'lifetime')
                            @php
                                $gateways = config('payment.gateways');
                                $isPurchasable = function($p) use ($gateways) {
                                    $stripeOk = !empty($gateways['stripe']) && !empty($p->stripe_price_id);
                                    $razorOk  = !empty($gateways['razorpay']) && !empty($p->razorpay_plan_id);
                                    return $stripeOk || $razorOk;
                                };
                                $higherPlans = $plans
                                    ->filter(function($p) use ($plan) { return $p->price > $plan->price; })
                                    ->filter(function($p) use ($isPurchasable) { return $isPurchasable($p); })
                                    ->sortBy('price');
                            @endphp
                            @if($higherPlans->count())
                                <div class="border rounded-lg p-4 bg-blue-50">
                                    <h5 class="text-sm font-semibold text-blue-900 mb-3">Upgrade options</h5>
                                    <div class="space-y-2">
                                        @foreach($higherPlans as $higher)
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">{{ $higher->name }}</p>
                                                    @php
                                                        $higherPeriod = $higher->billing_period === 'custom'
                                                            ? trim(($higher->duration_value ?? '') . ' ' . ($higher->duration_unit ?? ''))
                                                            : $higher->billing_period;
                                                    @endphp
                                                    <p class="text-xs text-gray-600">₹{{ number_format($higher->price) }} / {{ $higherPeriod }}</p>
                                                </div>
                                                <button type="button" onclick="confirmBuy('{{ $higher->slug }}')" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-md">Upgrade</button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif

                        @if(($currentPlan ?? null) !== 'lifetime')
                            @php
                                $gateways = $gateways ?? config('payment.gateways');
                                $isPurchasable = $isPurchasable ?? function($p) use ($gateways) {
                                    $stripeOk = !empty($gateways['stripe']) && !empty($p->stripe_price_id);
                                    $razorOk  = !empty($gateways['razorpay']) && !empty($p->razorpay_plan_id);
                                    return $stripeOk || $razorOk;
                                };
                                $lowerPlans = $plans
                                    ->filter(function($p) use ($plan) { return $p->price < $plan->price; })
                                    ->filter(function($p) use ($isPurchasable) { return $isPurchasable($p); })
                                    ->sortByDesc('price');
                            @endphp
                            @if($lowerPlans->count())
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <h5 class="text-sm font-semibold text-gray-800 mb-3">Downgrade options</h5>
                                    <div class="space-y-2">
                                        @foreach($lowerPlans as $lower)
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">{{ $lower->name }}</p>
                                                    @php
                                                        $lowerPeriod = $lower->billing_period === 'custom'
                                                            ? trim(($lower->duration_value ?? '') . ' ' . ($lower->duration_unit ?? ''))
                                                            : $lower->billing_period;
                                                    @endphp
                                                    <p class="text-xs text-gray-600">₹{{ number_format($lower->price) }} / {{ $lowerPeriod }}</p>
                                                </div>
                                                <button type="button" onclick="confirmBuy('{{ $lower->slug }}')" class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white text-sm rounded-md">Switch</button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
                        
                        <button type="button" onclick="openModal('modal-confirm-cancel')"
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-lg font-medium">Cancel {{ $plan->name }}</button>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="px-6 pb-6 text-right">
                <button onclick="closeModals()" class="px-4 py-2 rounded-md border transition-colors hover:bg-gray-50">Close</button>
            </div>
        </div>
    </div>

    <div id="modal-access-granted" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center">
        <div data-modal-panel class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 transform transition-all duration-200 opacity-0 scale-95">
            <h3 class="text-lg font-semibold mb-2">Access Granted</h3>
            <p class="text-gray-700 mb-4">You have access. Enjoy the content!</p>
            <div class="text-right">
                <button onclick="closeModals()" class="px-4 py-2 rounded-md border transition-colors hover:bg-gray-50">Close</button>
            </div>
        </div>
    </div>
    <div id="modal-basic-content" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center">
        <div data-modal-panel class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 transform transition-all duration-200 opacity-0 scale-95">
            <h3 class="text-lg font-semibold mb-2">Basic Content</h3>
            <p class="text-gray-700 mb-4">Here is your basic content.</p>
            <div class="text-right">
                <button onclick="closeModals()" class="px-4 py-2 rounded-md border transition-colors hover:bg-gray-50">Close</button>
            </div>
        </div>
    </div>

    <!-- New Success Modal -->
    <div id="modal-subscribe-success" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center p-4">
        <div data-modal-panel class="bg-white rounded-2xl shadow-2xl w-full max-w-xl p-8 transform transition-all duration-200 opacity-0 scale-95">
            <div class="flex flex-col items-center text-center">
                <div class="relative mb-4">
                    <div class="absolute -inset-1 rounded-full bg-green-500/20 animate-ping"></div>
                    <div class="relative w-16 h-16 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                        <i class="fas fa-check text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Subscription Successful</h3>
                <p class="text-gray-700 mb-6">You have successfully subscribed to the <span id="success-plan-name" class="font-semibold"></span> plan.</p>
                <div class="flex items-center gap-3">
                    <button onclick="closeModal('modal-subscribe-success')" class="px-5 py-2.5 rounded-md border transition-colors hover:bg-gray-50">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- New Cancel Success Modal -->
    <div id="modal-cancel-success" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center p-4">
        <div data-modal-panel class="bg-white rounded-2xl shadow-2xl w-full max-w-xl p-8 transform transition-all duration-200 opacity-0 scale-95">
            <div class="flex flex-col items-center text-center">
                <div class="relative mb-4">
                    <div class="absolute -inset-1 rounded-full bg-red-500/20 animate-ping"></div>
                    <div class="relative w-16 h-16 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                        <i class="fas fa-times text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Plan Cancelled</h3>
                <p class="text-gray-700 mb-6">Your plan has been successfully cancelled.</p>
                <div class="flex items-center gap-3">
                    <button onclick="closeModal('modal-cancel-success')" class="px-5 py-2.5 rounded-md border transition-colors hover:bg-gray-50">Close</button>
                    <button onclick="openModal('modal-subscribe'); closeModal('modal-cancel-success');" class="px-5 py-2.5 rounded-md bg-blue-600 text-white hover:bg-blue-700">Choose Another Plan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Cancel Modal -->
    <div id="modal-confirm-cancel" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center p-4">
        <div data-modal-panel class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all duration-200 opacity-0 scale-95">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h3 class="text-xl font-semibold">Cancel Subscription</h3>
                <button onclick="closeModals()" class="text-gray-500 hover:text-gray-700 transition-colors"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <p class="text-gray-800 font-medium">Are you sure you want to cancel your current plan?</p>
                        <p class="text-sm text-gray-500 mt-1">This will stop future renewals. You may lose access to premium content.</p>
                    </div>
                </div>
            </div>
            <div class="px-6 pb-6 flex justify-end gap-3">
                <button onclick="closeModals()" class="px-4 py-2 rounded-md border transition-colors hover:bg-gray-50">Keep Plan</button>
                <button id="confirm-cancel-plan-btn" class="px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors">Cancel Plan</button>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="hidden fixed inset-0 z-[100] bg-black/40 items-center justify-center">
        <div class="bg-white rounded-lg shadow p-4 flex items-center space-x-3">
            <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg>
            <span class="text-sm text-gray-700">Please wait...</span>
        </div>
    </div>

    <!-- Confirm Purchase Modal -->
    <div id="modal-confirm-purchase" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center p-4">
        <div data-modal-panel class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all duration-200 opacity-0 scale-95">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h3 class="text-xl font-semibold">Confirm Purchase</h3>
                <button onclick="closeModals()" class="text-gray-500 hover:text-gray-700 transition-colors"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6">
                <p class="text-gray-700">Are you sure you want to buy the <span id="confirm-plan-name" class="font-semibold"></span> plan?</p>
            </div>
            <div class="px-6 pb-6 flex justify-end gap-3">
                <button onclick="closeModals()" class="px-4 py-2 rounded-md border transition-colors hover:bg-gray-50">Cancel</button>
                <button id="confirm-purchase-btn" class="px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700 transition-colors">Confirm</button>
            </div>
        </div>
    </div>

    <!-- Payment Gateway Selection Modal -->
    <div id="modal-payment-gateways" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center p-4">
        <div data-modal-panel class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all duration-200 opacity-0 scale-95">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h3 class="text-xl font-semibold">Choose Payment Method</h3>
                <button onclick="closeModals()" class="text-gray-500 hover:text-gray-700 transition-colors"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6">
                <p class="text-gray-600 mb-6">Select your preferred payment gateway for the <span id="gateway-plan-name" class="font-semibold"></span> plan:</p>
                
                <!-- Payment Gateway Options -->
                <div class="space-y-3">
                    @if(config('payment.gateways.razorpay'))
                    <button onclick="selectPaymentGateway('razorpay')" class="w-full p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 flex items-center justify-between group">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-credit-card text-blue-600"></i>
                            </div>
                            <div class="text-left">
                                <h4 class="font-medium text-gray-900">Razorpay</h4>
                                <p class="text-sm text-gray-500">Cards, UPI, Net Banking, Wallets</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                    </button>
                    @endif
                    
                    <!-- Stripe gateway -->
                    @if(config('payment.gateways.stripe'))
                    <button onclick="selectPaymentGateway('stripe')" class="w-full p-4 border border-gray-200 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-all duration-200 flex items-center justify-between group">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-credit-card text-purple-600"></i>
                            </div>
                            <div class="text-left">
                                <h4 class="font-medium text-gray-900">Stripe</h4>
                                <p class="text-sm text-gray-500">Cards</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-purple-500 transition-colors"></i>
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        let pendingPlan = null;
        let selectedGateway = null;

        function confirmBuy(plan) {
            pendingPlan = plan;
            document.getElementById('confirm-plan-name').textContent = plan.charAt(0).toUpperCase() + plan.slice(1);
            openModal('modal-confirm-purchase');
            const btn = document.getElementById('confirm-purchase-btn');
            btn.onclick = function() {
                closeModals();
                // Add small delay to ensure modal closes before opening next one
                setTimeout(() => {
                    showPaymentGateways(plan);
                }, 200);
            };
        }

        function showPaymentGateways(plan) {
            document.getElementById('gateway-plan-name').textContent = plan.charAt(0).toUpperCase() + plan.slice(1);
            openModal('modal-payment-gateways');
        }

        function selectPaymentGateway(gateway) {
            selectedGateway = gateway;
            closeModals();
            if (gateway === 'razorpay') {
                buyPlan(pendingPlan);
            } else if (gateway === 'stripe') {
                buyPlanStripe(pendingPlan);
            }
            // Future gateways can be handled here
            pendingPlan = null; // Reset after processing
        }

        function showLoading() {
            const el = document.getElementById('loading-overlay');
            if (el) { el.classList.remove('hidden'); el.classList.add('flex'); }
        }
        function hideLoading() {
            const el = document.getElementById('loading-overlay');
            if (el) { el.classList.add('hidden'); el.classList.remove('flex'); }
        }
        function showError(message) {
            alert(message || 'Something went wrong.');
        }

        let currentPlan = @json($currentPlan); // Initial value from server

        // Toggle subscribe button based on currentPlan presence
        function updateSubscribeVisibility() {
            try {
                const btn = document.getElementById('btn-subscribe');
                if (!btn) return; // Not rendered when already had plan
                if (currentPlan) {
                    btn.classList.add('hidden');
                } else {
                    btn.classList.remove('hidden');
                }
            } catch (e) { /* ignore */ }
        }

        function buyPlan(plan) {
            showLoading();
            $.ajax({
                url: '{{ route('subscription.subscribe') }}',
                type: 'POST',
                data: { plan_id: plan, _token: '{{ csrf_token() }}' },
                success: function (response) {
                    if (response.success) {
                        // Open Razorpay Checkout
                        var options = {
                            "key": response.razorpay_key,
                            "subscription_id": response.subscription_id,
                            "name": "Your App Name",
                            "description": "Subscription for " + plan.charAt(0).toUpperCase() + plan.slice(1) + " Plan",
                            "handler": function (response) {
                                // Verify payment signature and activate subscription
                                $.ajax({
                                    url: '{{ route('subscription.verify') }}',
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        razorpay_payment_id: response.razorpay_payment_id,
                                        razorpay_subscription_id: options.subscription_id,
                                        razorpay_signature: response.razorpay_signature
                                    },
                                    success: function () {
                                        currentPlan = plan;
                                        closeModals();
                                        document.getElementById('success-plan-name').textContent = plan.charAt(0).toUpperCase() + plan.slice(1);
                                        openModal('modal-subscribe-success');
                                        hideLoading();
                                        updateSubscribeVisibility();
                                    },
                                    error: function () {
                                        hideLoading();
                                        alert('Payment verified but activation failed. Please contact support.');
                                    }
                                });
                            },
                            "modal": {
                                "ondismiss": function () {
                                    hideLoading();
                                    openModal('modal-cancel-success');
                                }
                            },
                            "prefill": {
                                "name": "{{ Auth::user()->name }}",
                                "email": "{{ Auth::user()->email }}",
                            },
                            "theme": {
                                "color": "#3399cc"
                            }
                        };
                        var rzp = new Razorpay(options);
                        hideLoading();
                        rzp.open();
                    }
                },
                error: function (xhr) {
                    hideLoading();
                    const errorMsg = xhr.responseJSON?.message || 'Error subscribing. Please try again.';
                    showError(errorMsg);
                }
            });
        }

        async function buyPlanStripe(plan) {
            showLoading();
            try {
                const res = await $.ajax({
                    url: '{{ route('stripe.checkout') }}',
                    type: 'POST',
                    data: { plan_id: plan, _token: '{{ csrf_token() }}' }
                });
                if (res.success && res.url) {
                    hideLoading();
                    window.location.href = res.url; // Redirect to hosted Checkout
                    return;
                }
                if (res.success && res.public_key && res.id) {
                    // Fallback: redirectToCheckout with sessionId
                    const stripe = Stripe(res.public_key);
                    await stripe.redirectToCheckout({ sessionId: res.id });
                }
            } catch (e) {
                hideLoading();
                const msg = e?.responseJSON?.message || e?.message || 'Stripe checkout failed.';
                showError(msg);
            }
        }
        function handlePlanClick(plan) {
            // Premium users can access both
            if (currentPlan === 'premium') {
                return openModal('modal-access-granted');
            }
            // Basic users
            if (currentPlan === 'basic') {
                if (plan === 'basic') {
                    return openModal('modal-basic-content');
                } else {
                    return openModal('modal-need-premium');
                }
            }
            // No subscription
            return openModal('modal-need-premium');
        }

        function openModal(id) {
            const el = document.getElementById(id);
            if (el) {
                el.classList.remove('hidden');
                el.classList.add('flex');
                const panel = el.querySelector('[data-modal-panel]');
                if (panel) {
                    requestAnimationFrame(() => {
                        panel.classList.remove('opacity-0','scale-95');
                        panel.classList.add('opacity-100','scale-100');
                    });
                }
            }
            if (id === 'modal-my-plans') {
                // Toggle plan details inside modal
                document.getElementById('plan-details-none')?.classList.add('hidden');
                // Hide all plan details first
                @foreach($plans as $plan)
                document.getElementById('plan-details-{{ $plan->slug }}')?.classList.add('hidden');
                @endforeach
                
                if (!currentPlan) {
                    document.getElementById('plan-details-none')?.classList.remove('hidden');
                } else {
                    // Show the current plan details
                    const currentPlanElement = document.getElementById('plan-details-' + currentPlan);
                    if (currentPlanElement) {
                        currentPlanElement.classList.remove('hidden');
                    }
                }
            }
        }

        function closeModals() {
            // Do NOT include success/cancel popups here so stray calls don't instantly hide them
            ['modal-subscribe', 'modal-basic-content', 'modal-need-premium', 'modal-access-granted', 'modal-my-plans', 'modal-confirm-purchase', 'modal-payment-gateways', 'modal-confirm-cancel'].forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    const panel = el.querySelector('[data-modal-panel]');
                    if (panel) {
                        panel.classList.add('opacity-0','scale-95');
                        panel.classList.remove('opacity-100','scale-100');
                    }
                    setTimeout(() => { el.classList.add('hidden'); el.classList.remove('flex'); }, 150);
                }
            });
            hideLoading();
        }

        // Close a specific modal by id (used by success/cancel popups)
        function closeModal(id) {
            const el = document.getElementById(id);
            if (!el) return;
            const panel = el.querySelector('[data-modal-panel]');
            if (panel) {
                panel.classList.add('opacity-0','scale-95');
                panel.classList.remove('opacity-100','scale-100');
            }
            setTimeout(() => { el.classList.add('hidden'); el.classList.remove('flex'); }, 150);
        }

        // Wire confirm cancel button
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('confirm-cancel-plan-btn');
            if (btn) {
                btn.addEventListener('click', performCancelPlan);
            }

            // Handle flash messages from server (e.g., after Stripe success/cancel)
            try {
                const flashSuccess = @json(session('success'));
                const flashError = @json(session('error'));
                const flashPlan = @json(session('plan'));

                if (flashSuccess && String(flashSuccess).toLowerCase().includes('subscription')) {
                    if (flashPlan) {
                        const name = String(flashPlan);
                        const pretty = name.charAt(0).toUpperCase() + name.slice(1);
                        const el = document.getElementById('success-plan-name');
                        if (el) el.textContent = pretty;
                        // Update runtime state so Subscribe button hides if it exists
                        currentPlan = flashPlan;
                        updateSubscribeVisibility();
                    }
                    // Delay a bit to avoid any race with pending close animations
                    setTimeout(() => openModal('modal-subscribe-success'), 200);
                }

                if (flashError && String(flashError).toLowerCase().includes('cancel')) {
                    setTimeout(() => openModal('modal-cancel-success'), 200);
                }
            } catch (e) { /* ignore */ }
        });

        function performCancelPlan() {
            showLoading();
            $.ajax({
                url: '{{ route('subscription.cancel') }}',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function () {
                    currentPlan = null;
                    closeModals();
                    hideLoading();
                    openModal('modal-cancel-success');
                    updateSubscribeVisibility();
                },
                error: function (xhr) {
                    hideLoading();
                    const msg = xhr.responseJSON?.message || 'Error cancelling plan. Please try again.';
                    alert(msg);
                }
            });
        }

        function handleUpgradePlan() {
            // Close the current My Plans modal
            closeModals();
            
            // Add a small delay to ensure modal closes smoothly before opening the subscription modal
            setTimeout(() => {
                openModal('modal-subscribe');
            }, 300);
        }
    </script>
</body>

</html>