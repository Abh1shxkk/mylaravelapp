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

                <!-- Notifications -->
                <div class="relative" x-data="{open:false}" id="notif-root">
                    <button id="notif-btn" class="relative h-10 w-10 flex items-center justify-center rounded-full hover:bg-gray-100" title="Notifications">
                        <i class="fas fa-bell text-gray-600"></i>
                        <span id="notif-badge" class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full">0</span>
                    </button>
                    <div id="notif-panel" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border p-0 overflow-hidden z-50">
                        <div class="flex items-center justify-between px-3 py-2 border-b">
                            <span class="font-semibold text-gray-800">Notifications</span>
                            <button id="notif-readall" class="text-xs text-blue-600 hover:underline">Mark all read</button>
                        </div>
                        <div id="notif-list" class="max-h-80 overflow-y-auto">
                            <div class="p-3 text-sm text-gray-500">Loading...</div>
                        </div>
                        <div class="px-3 py-2 text-right text-xs text-gray-400 border-t">Auto-updates</div>
                    </div>
                </div>

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

<script>
(function(){
  const btn = document.getElementById('notif-btn');
  const panel = document.getElementById('notif-panel');
  const badge = document.getElementById('notif-badge');
  const list = document.getElementById('notif-list');
  const readAll = document.getElementById('notif-readall');

  async function fetchUnread(){
    try{
      const res = await fetch(`{{ route('notifications.unread') }}`, { credentials: 'same-origin' });
      if(!res.ok) return;
      const data = await res.json();
      const c = data?.count || 0;
      if(c>0){ badge.textContent = c; badge.classList.remove('hidden'); } else { badge.classList.add('hidden'); }
    }catch(e){}
  }

  async function fetchList(){
    try{
      const res = await fetch(`{{ route('notifications.index') }}`, { headers: {'Accept':'text/html'}, credentials:'same-origin' });
      if(!res.ok) return;
      const html = await res.text();
      list.innerHTML = html;
    }catch(e){ list.innerHTML = '<div class="p-3 text-sm text-red-600">Failed to load</div>'; }
  }

  function togglePanel(){
    if(!panel) return;
    const open = panel.classList.contains('hidden');
    if(open){ panel.classList.remove('hidden'); fetchList(); markAllRead(); setTimeout(fetchUnread, 400); }
    else { panel.classList.add('hidden'); }
  }

  async function markAllRead(){
    try{ await fetch(`{{ route('notifications.read_all') }}`, { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}' }, credentials:'same-origin' }); }
    catch(e){}
  }

  if(btn){ btn.addEventListener('click', togglePanel); }
  document.addEventListener('click', (e)=>{
    if(!panel || !btn) return;
    if(panel.contains(e.target) || btn.contains(e.target)) return;
    panel.classList.add('hidden');
  });
  setInterval(fetchUnread, 15000);
  fetchUnread();
})();
</script>
