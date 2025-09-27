<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Plans - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        window.csrfToken = "{{ csrf_token() }}";
        window.routes = {
            create: "{{ route('admin.payment.plans.create') }}",
            list: "{{ route('admin.payment.plans') }}",
            json: "{{ route('admin.payment.plans.json') }}",
            editBase: "{{ url('/dashboard/admin/payment/plans') }}" // + '/' + id + '/edit'
        };
    </script>
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
            <div id="flash" class="hidden mb-6"></div>
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Header Actions -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Subscription Plans</h2>
                <a href="{{ route('admin.payment.plans.create') }}" data-ajax-open
                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Create New Plan
                </a>
            </div>

            <!-- Plans Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($plans as $plan)
                <div class="bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow" data-plan-card data-plan-id="{{ $plan->id }}">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $plan->name }}</h3>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.payment.plans.edit', $plan) }}" data-ajax-open
                                   class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.payment.plans.destroy', $plan) }}" 
                                      class="inline" data-ajax-delete>
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
    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white w-full max-w-3xl rounded-lg shadow-lg overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b">
                <h3 class="font-semibold">Plan</h3>
                <button type="button" id="modalClose" class="text-gray-500 hover:text-gray-700" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="modalBody" class="max-h-[80vh] overflow-auto"></div>
        </div>
    </div>

    <script>
    (function(){
        const flash = document.getElementById('flash');
        function showFlash(type, text){
            if(!flash) return;
            flash.className = '';
            const base = 'px-4 py-3 rounded';
            if(type==='success') flash.className = base + ' bg-green-100 border border-green-400 text-green-700';
            else if(type==='error') flash.className = base + ' bg-red-100 border border-red-400 text-red-700';
            else flash.className = base + ' bg-gray-100 border border-gray-300 text-gray-800';
            flash.textContent = text;
            flash.classList.remove('hidden');
            setTimeout(()=>{ flash.classList.add('hidden'); }, 2500);
        }

        async function handleDelete(e){
            const form = e.currentTarget;
            e.preventDefault();
            if(!confirm('Are you sure you want to delete this plan?')) return false;

            const formData = new FormData(form);
            try{
                const res = await fetch(form.action, {
                    method: 'POST', // send _method=DELETE
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData,
                    credentials: 'same-origin'
                });
                const isJson = (res.headers.get('content-type') || '').includes('application/json');
                const data = isJson ? await res.json() : {};

                if(res.ok && data && data.success){
                    // remove the card
                    const card = form.closest('[data-plan-card]');
                    if(card){ card.remove(); }
                    showFlash('success', data.message || 'Plan deleted successfully');
                } else {
                    showFlash('error', (data && data.message) ? data.message : 'Failed to delete plan');
                }
            } catch(err){
                showFlash('error', 'Network error. Try again.');
            }
        }

        document.querySelectorAll('form[data-ajax-delete]').forEach(f => {
            f.addEventListener('submit', handleDelete);
        });

        // Modal helpers
        const modal = document.getElementById('modal');
        const modalBody = document.getElementById('modalBody');
        const modalClose = document.getElementById('modalClose');

        function openModal(){
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeModal(){
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            if(modalBody) modalBody.innerHTML = '';
        }
        modalClose?.addEventListener('click', closeModal);
        modal?.addEventListener('click', (e)=>{ if(e.target === modal) closeModal(); });

        function hydrateScripts(container){
            // Execute any inline scripts from loaded partial
            const scripts = container.querySelectorAll('script');
            scripts.forEach(old => {
                const s = document.createElement('script');
                if(old.src){ s.src = old.src; }
                if(old.type){ s.type = old.type; }
                s.textContent = old.textContent;
                old.parentNode.replaceChild(s, old);
            });
        }

        async function openAjaxForm(url){
            try{
                const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }, credentials: 'same-origin' });
                const html = await res.text();
                modalBody.innerHTML = html;
                // attach close to any [data-modal-close]
                modalBody.querySelectorAll('[data-modal-close]').forEach(btn => btn.addEventListener('click', closeModal));
                hydrateScripts(modalBody);
                openModal();
            }catch(err){
                showFlash('error','Failed to load form.');
            }
        }

        // Intercept create/edit links
        document.querySelectorAll('[data-ajax-open]').forEach(a => {
            a.addEventListener('click', function(e){
                e.preventDefault();
                const url = this.getAttribute('href');
                openAjaxForm(url);
            });
        });

        // Refresh plans grid when form reports success
        async function loadPlans(){
            try{
                const res = await fetch(window.routes.json, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' });
                const plans = await res.json();
                const grid = document.querySelector('.grid');
                if(!grid) return;
                grid.innerHTML = plans.map(p => {
                    const created = new Date(p.created_at);
                    const dateStr = created.toLocaleDateString();
                    const editUrl = window.routes.editBase + '/' + p.id + '/edit';
                    const destroyUrl = window.routes.editBase + '/' + p.id;
                    return `
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow" data-plan-card data-plan-id="${p.id}">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">${p.name}</h3>
                                <div class="flex space-x-2">
                                    <a href="${editUrl}" class="text-blue-600 hover:text-blue-800" data-ajax-open><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="${destroyUrl}" class="inline" data-ajax-delete>
                                        <input type="hidden" name="_token" value="${window.csrfToken}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>

                            <div class="mb-4">
                                <p class="text-3xl font-bold text-blue-600">₹${Number(p.price).toLocaleString()}</p>
                                <p class="text-sm text-gray-500">${(p.billing_period||'').charAt(0).toUpperCase() + (p.billing_period||'').slice(1)}</p>
                            </div>

                            ${p.description ? `<p class=\"text-sm text-gray-600 mb-4\">${p.description}</p>` : ''}

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Slug:</span>
                                    <span class="font-mono text-gray-700">${p.slug}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Subscriptions:</span>
                                    <span class="font-semibold text-gray-700">${p.subscriptions_count || 0}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Razorpay ID:</span>
                                    ${p.razorpay_plan_id ? `<span class=\"text-green-600 text-xs font-mono\">${p.razorpay_plan_id.substring(0,15)}…</span>` : `<span class=\"text-red-600 text-xs\">Not set</span>`}
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-200">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">Created:</span>
                                    <span class="text-sm text-gray-700">${dateStr}</span>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }).join('');

                // re-bind handlers on new elements
                document.querySelectorAll('form[data-ajax-delete]').forEach(f => f.addEventListener('submit', handleDelete));
                document.querySelectorAll('[data-ajax-open]').forEach(a => a.addEventListener('click', function(e){ e.preventDefault(); openAjaxForm(this.getAttribute('href')); }));
            }catch(err){
                showFlash('error', 'Failed to refresh plans');
            }
        }

        document.addEventListener('plans:refresh', (e)=>{
            if(e.detail?.message){ showFlash(e.detail.type || 'success', e.detail.message); }
            closeModal();
            loadPlans();
        });
    })();
    </script>
</body>
</html>


