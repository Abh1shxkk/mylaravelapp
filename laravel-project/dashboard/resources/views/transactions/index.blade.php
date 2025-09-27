<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    @include('partials.header')

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Navigation</h2>
                <div class="space-y-3">
                    <a href="{{ route('profile.settings') }}" class="block bg-blue-50 p-4 rounded-lg hover:bg-blue-100 transition-colors group">
                        <h4 class="font-semibold text-blue-900 flex items-center">
                            <i class="fas fa-user mr-3 text-blue-600"></i>Profile
                        </h4>
                        <p class="text-blue-700 text-sm mt-1">Manage your profile and settings</p>
                    </a>
                    <div onclick="openModal && openModal('modal-my-plans')" class="block bg-indigo-50 p-4 rounded-lg hover:bg-indigo-100 transition-colors cursor-pointer group">
                        <h4 class="font-semibold text-indigo-900 flex items-center">
                            <i class="fas fa-receipt mr-3 text-indigo-600"></i>My Plans
                        </h4>
                        <p class="text-indigo-700 text-sm mt-1">View or cancel your current plan</p>
                    </div>
                    <a href="{{ route('transactions.index') }}" class="block bg-teal-100 p-4 rounded-lg hover:bg-teal-200 transition-colors group">
                        <h4 class="font-semibold text-teal-900 flex items-center">
                            <i class="fas fa-file-invoice mr-3 text-teal-700"></i>Transactions
                        </h4>
                        <p class="text-teal-700 text-sm mt-1">History and invoices</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Transaction History</h1>
                <!-- <a href="{{ route('dashboard.home') }}" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Back to Dashboard</a> -->
            </div>

            @if($payments->count() === 0)
                <div class="bg-white p-6 rounded-lg shadow text-gray-600">No transactions yet.</div>
            @else
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left">Date</th>
                            <th class="px-4 py-3 text-left">Plan</th>
                            <th class="px-4 py-3 text-left">Provider</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-right">Amount</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($payments as $p)
                        <tr class="text-sm">
                            <td class="px-4 py-3 text-gray-800">{{ optional($p->paid_at ?? $p->created_at)->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST</td>
                            <td class="px-4 py-3">{{ optional($p->plan)->name ?? strtoupper($p->plan_id) }}</td>
                            <td class="px-4 py-3 capitalize">{{ $p->provider }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded text-xs {{ $p->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-800' }}">{{ ucfirst($p->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">₹{{ number_format((int)($p->amount ?? 0)) }} {{ $p->currency ?? 'INR' }}</td>
                            <td class="px-4 py-3 text-right space-x-3">
                                <button data-view-invoice="{{ route('transactions.invoice.partial', $p) }}" class="text-blue-600 hover:underline">View</button>
                                <button data-delete="{{ route('transactions.destroy', $p) }}" class="text-red-600 hover:underline">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                <div class="mt-4">{{ $payments->links() }}</div>
            @endif
        </div>
    </div>

    <!-- Invoice Modal -->
    <div id="invoice-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
        <div data-panel class="bg-white rounded-xl shadow-2xl w-full max-w-3xl max-h-[85vh] overflow-y-auto p-6 opacity-0 scale-95 transform transition-all">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Invoice</h3>
                <div class="flex items-center gap-2">
                    <button id="invoice-print" class="px-3 py-1.5 text-sm rounded bg-blue-600 text-white hover:bg-blue-700">Print / Save PDF</button>
                    <button id="invoice-download" class="px-3 py-1.5 text-sm rounded border hover:bg-gray-50">Download</button>
                    <button id="invoice-close" class="ml-1 text-gray-500 hover:text-gray-700">✕</button>
                </div>
            </div>
            <div id="invoice-body"></div>
        </div>
    </div>

    <script>
    (function(){
        const modal = document.getElementById('invoice-modal');
        const panel = modal ? modal.querySelector('[data-panel]') : null;
        const body = document.getElementById('invoice-body');
        const closeBtn = document.getElementById('invoice-close');
        const printBtn = document.getElementById('invoice-print');
        const downloadBtn = document.getElementById('invoice-download');
        let currentInvoiceId = null;

        function openModal(){
            if(!modal || !panel) return;
            modal.classList.remove('hidden'); modal.classList.add('flex');
            panel.classList.remove('opacity-0','scale-95'); panel.classList.add('opacity-100','scale-100');
            document.body.classList.add('overflow-hidden');
        }
        function closeModal(){
            if(!modal || !panel) return;
            panel.classList.add('opacity-0','scale-95'); panel.classList.remove('opacity-100','scale-100');
            setTimeout(()=>{ modal.classList.add('hidden'); modal.classList.remove('flex'); document.body.classList.remove('overflow-hidden'); body.innerHTML=''; }, 150);
        }
        if(closeBtn){ closeBtn.addEventListener('click', closeModal); }
        if(modal){ modal.addEventListener('mousedown', e=>{ if(e.target===modal) closeModal(); }); }

        document.addEventListener('click', async function(e){
            const v = e.target.closest('[data-view-invoice]');
            if(v){
                e.preventDefault();
                try{
                    const url = v.getAttribute('data-view-invoice');
                    // extract payment id from URL
                    try { const m = url.match(/\/transactions\/(\d+)\/invoice/); currentInvoiceId = m ? m[1] : null; } catch(e) { currentInvoiceId = null; }
                    const res = await fetch(url, { headers: { 'Accept': 'text/html' }, credentials: 'same-origin' });
                    const html = await res.text();
                    body.innerHTML = html;
                    openModal();
                }catch(err){ alert('Failed to load invoice.'); }
                return;
            }
            const d = e.target.closest('[data-delete]');
            if(d){
                e.preventDefault();
                if(!confirm('Delete this transaction?')) return;
                try{
                    const url = d.getAttribute('data-delete');
                    const res = await fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    });
                    if(!res.ok){
                        const txt = await res.text();
                        throw new Error(`Request failed (${res.status}) ${txt?.slice(0,200)}`);
                    }
                    // Remove row from table
                    const row = d.closest('tr');
                    if(row) row.remove();
                }catch(err){ alert('Failed to delete. '+ (err?.message||'')); }
                return;
            }
        });

        function printInvoice(){
            if(!body) return;
            const html = body.innerHTML;
            const w = window.open('', '_blank');
            if(!w) return alert('Popup blocked. Allow popups to print.');
            w.document.write(`<!DOCTYPE html><html><head><title>invoice-${currentInvoiceId||''}</title>`+
                '<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">'+
                '<script src="https://cdn.tailwindcss.com"><\/script>'+
                '</head><body class="bg-white p-6">'+ html +'</body></html>');
            w.document.close();
            w.focus();
            setTimeout(()=>{ w.print(); }, 150);
        }
        function downloadInvoice(){
            if(!body) return;
            const html = '<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">'+
                '<title>invoice-'+(currentInvoiceId||'')+'</title><script src="https://cdn.tailwindcss.com"><\/script></head><body class="bg-white p-6">'+
                body.innerHTML + '</body></html>';
            const blob = new Blob([html], {type:'text/html'});
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'invoice-'+(currentInvoiceId||'')+'.html';
            document.body.appendChild(a);
            a.click();
            setTimeout(()=>{ URL.revokeObjectURL(a.href); a.remove(); }, 0);
        }
        if(printBtn){ printBtn.addEventListener('click', printInvoice); }
        if(downloadBtn){ downloadBtn.addEventListener('click', downloadInvoice); }
    })();
    </script>
</body>
</html>
