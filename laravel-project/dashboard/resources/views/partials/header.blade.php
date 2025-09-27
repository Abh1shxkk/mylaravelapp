@php
    $activeSubscriptionHeader = Auth::user()->subscriptions()->where('status', 'active')->latest('started_at')->first();
    $currentPlanHeader = $activeSubscriptionHeader ? $activeSubscriptionHeader->plan_id : null;
@endphp
<div class="bg-white shadow">
    <div class="px-2 sm:px-3 md:px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center ml-0">
                <a href="{{ route('dashboard.home') }}" class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white shadow-sm hover:shadow transition" title="Home">
                    <i class="fas fa-house text-base"></i>
                </a>
            </div>
            <div class="flex items-center gap-5 md:gap-6 pr-2">
                @if(Auth::user()->profile_picture)
                    <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile">
                @else
                    <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                        <i class="fas fa-user text-gray-600 text-sm"></i>
                    </div>
                @endif

                <div class="hidden sm:flex flex-col">
                    <span class="text-gray-700">Welcome, {{ Auth::user()->name }}</span>
                    <span class="text-xs text-blue-600">{{ ucfirst(Auth::user()->role ?? 'user') }}</span>
                </div>

                <!-- <a href="{{ route('profile.settings') }}" class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-sm">
                    <i class="fas fa-user-cog mr-1"></i>Profile
                </a> -->

                @if(Auth::user() && method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())
                    <a href="{{ route('admin.users.index') }}" class="bg-gray-700 text-white px-3 py-2 rounded hover:bg-gray-800 text-sm" title="Admin-only: manage users">
                        <i class="fas fa-shield-alt mr-1"></i>Admin Settings
                    </a>
                    <a href="{{ route('admin.payment.index') }}" class="bg-purple-600 text-white px-3 py-2 rounded hover:bg-purple-700 text-sm" title="Admin-only: manage payments and subscriptions">
                        <i class="fas fa-credit-card mr-1"></i>Payment Settings
                    </a>
                @endif

                <button id="btn-subscribe" type="button" onclick="openModal && openModal('modal-subscribe')" class="@if($currentPlanHeader) hidden @endif bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 text-sm">
                    <i class="fas fa-crown mr-1"></i>Subscribe
                </button>

                <form method="POST" action="{{ route('dashboard.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
