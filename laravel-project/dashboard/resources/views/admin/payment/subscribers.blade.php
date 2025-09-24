<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribers - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold">Subscribers</h1>
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
                       class="block bg-purple-50 p-4 rounded-lg border-l-4 border-purple-500">
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

            <!-- Header + Search -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h2 class="text-2xl font-bold text-gray-900">All Subscriptions</h2>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input id="search" type="text" value="{{ request('q') }}" placeholder="Search user, email, plan, status..." class="pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-80" />
                        <button id="clearBtn" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 hidden" title="Clear"><i class="fas fa-times-circle"></i></button>
                    </div>
                </div>
                <div class="text-sm text-gray-600">
                    Showing {{ $subscriptions->firstItem() ?? 0 }}-{{ $subscriptions->lastItem() ?? 0 }} of {{ $subscriptions->total() }} subscriptions
                </div>
            </div>

            <!-- Subscriptions Table -->
            <div id="listWrap" class="bg-white rounded-lg shadow-md overflow-hidden"></div>

            <!-- Pagination -->
            <div id="pager" class="mt-6 flex justify-center"></div>
        </div>
    </div>

    <script>
        const listWrap = document.getElementById('listWrap')
        const pager = document.getElementById('pager')
        const search = document.getElementById('search')
        const clearBtn = document.getElementById('clearBtn')
        let page = 1

        function debounce(fn, wait){ let t; return (...a)=>{ clearTimeout(t); t=setTimeout(()=>fn(...a), wait) } }

        async function load(){
            const q = search.value.trim()
            const params = new URLSearchParams({ page, q })
            const res = await fetch(`{{ route('admin.payment.subscribers') }}?${'q'}=${encodeURIComponent(q)}&page=${page}`, { headers: { 'Accept':'application/json' } })
            if (!res.ok) { listWrap.innerHTML = '<div class="p-6">Failed to load</div>'; return }
            const data = await res.json()
            renderList(data)
            renderPager(data)
        }

        function renderList(p){
            const items = p.data
            if (items.length === 0) {
                listWrap.innerHTML = `<div class="text-center py-12">
                    <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Subscriptions Found</h3>
                    <p class="text-gray-600">No users match your search.</p>
                </div>`
                return
            }
            const tbody = items.map(sub => `
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                        <i class="fas fa-user text-gray-600"></i>
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">${sub.user?.name || '-'}</div>
                        <div class="text-sm text-gray-500">${sub.user?.email || '-'}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">${(sub.plan_id || '').charAt(0).toUpperCase() + (sub.plan_id || '').slice(1)}</div>
                    <div class="text-sm text-gray-500">${sub.plan?.name || 'N/A'}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${sub.status === 'active' ? 'bg-green-100 text-green-800' : sub.status === 'cancelled' ? 'bg-red-100 text-red-800' : sub.status === 'paused' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800'}">${(sub.status || '').charAt(0).toUpperCase() + (sub.status || '').slice(1)}</span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${sub.razorpay_payment_id ? `<span class="font-mono text-xs">${sub.razorpay_payment_id.substring(0,15)}</span>` : '<span class="text-gray-400">-</span>'}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${sub.stripe_subscription_id ? `<span class="font-mono text-xs">${sub.stripe_subscription_id.substring(0,18)}</span>` : '<span class="text-gray-400">-</span>'}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${sub.started_at ? new Date(sub.started_at).toLocaleDateString() : '-'}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <form method="POST" action="${`{{ url('/dashboard/admin/payment/subscriptions') }}`}/${sub.id}" class="inline">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                      <input type="hidden" name="_method" value="PUT" />
                      <select name="status" onchange="this.form.submit()" class="text-xs border border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="active" ${sub.status === 'active' ? 'selected' : ''}>Active</option>
                        <option value="paused" ${sub.status === 'paused' ? 'selected' : ''}>Paused</option>
                        <option value="cancelled" ${sub.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                      </select>
                    </form>
                  </td>
                </tr>`).join('')

            listWrap.innerHTML = `
                <div class="overflow-x-auto">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stripe ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Started</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">${tbody}</tbody>
                  </table>
                </div>`
        }

        function renderPager(p){
            if (p.last_page <= 1) { pager.innerHTML = ''; return }
            const prevDisabled = p.current_page === 1
            const nextDisabled = p.current_page === p.last_page

            // Build numbered pages around current (window of 2 on each side)
            const window = 2
            const start = Math.max(1, p.current_page - window)
            const end = Math.min(p.last_page, p.current_page + window)

            let numbers = ''
            if (start > 1) {
                numbers += pageButton(1, p.current_page)
                if (start > 2) numbers += ellipsis()
            }
            for (let i = start; i <= end; i++) numbers += pageButton(i, p.current_page)
            if (end < p.last_page) {
                if (end < p.last_page - 1) numbers += ellipsis()
                numbers += pageButton(p.last_page, p.current_page)
            }

            pager.innerHTML = `
                <div class="flex items-center gap-2">
                  <button ${prevDisabled ? 'disabled' : ''} class="px-3 py-2 text-sm border rounded-lg ${prevDisabled ? 'opacity-50 cursor-not-allowed bg-gray-100 text-gray-400' : 'hover:bg-blue-50 hover:border-blue-300 text-gray-700'}" id="firstBtn"><i class="fas fa-angle-double-left"></i></button>
                  <button ${prevDisabled ? 'disabled' : ''} class="px-3 py-2 text-sm border rounded-lg ${prevDisabled ? 'opacity-50 cursor-not-allowed bg-gray-100 text-gray-400' : 'hover:bg-blue-50 hover:border-blue-300 text-gray-700'}" id="prevBtn"><i class="fas fa-chevron-left"></i></button>
                  <div class="flex items-center gap-1" id="pageNums">${numbers}</div>
                  <button ${nextDisabled ? 'disabled' : ''} class="px-3 py-2 text-sm border rounded-lg ${nextDisabled ? 'opacity-50 cursor-not-allowed bg-gray-100 text-gray-400' : 'hover:bg-blue-50 hover:border-blue-300 text-gray-700'}" id="nextBtn"><i class="fas fa-chevron-right"></i></button>
                  <button ${nextDisabled ? 'disabled' : ''} class="px-3 py-2 text-sm border rounded-lg ${nextDisabled ? 'opacity-50 cursor-not-allowed bg-gray-100 text-gray-400' : 'hover:bg-blue-50 hover:border-blue-300 text-gray-700'}" id="lastBtn"><i class="fas fa-angle-double-right"></i></button>
                </div>`

            const prevBtn = document.getElementById('prevBtn')
            const nextBtn = document.getElementById('nextBtn')
            const firstBtn = document.getElementById('firstBtn')
            const lastBtn = document.getElementById('lastBtn')
            if (prevBtn && !prevDisabled) prevBtn.onclick = () => { page = Math.max(1, p.current_page - 1); load() }
            if (nextBtn && !nextDisabled) nextBtn.onclick = () => { page = Math.min(p.last_page, p.current_page + 1); load() }
            if (firstBtn && !prevDisabled) firstBtn.onclick = () => { page = 1; load() }
            if (lastBtn && !nextDisabled) lastBtn.onclick = () => { page = p.last_page; load() }

            // Attach number click handlers
            pager.querySelectorAll('button[data-page]').forEach(btn => {
                btn.onclick = () => { page = parseInt(btn.getAttribute('data-page')); load() }
            })

            function pageButton(n, current){
                const active = n === current
                return `<button data-page="${n}" class="px-3 py-2 text-sm border rounded-lg ${active ? 'bg-blue-600 text-white border-blue-600' : 'hover:bg-blue-50 hover:border-blue-300 text-gray-700'}">${n}</button>`
            }
            function ellipsis(){ return `<span class="px-2 text-gray-500">...</span>` }
        }

        const onSearch = debounce(() => { page = 1; toggleClear(); load() }, 300)
        search.addEventListener('input', onSearch)
        clearBtn.addEventListener('click', (e) => { e.preventDefault(); search.value=''; page=1; toggleClear(); load() })
        function toggleClear(){ clearBtn.classList.toggle('hidden', !search.value) }

        // initial
        toggleClear();
        load();
    </script>
</body>
</html>
