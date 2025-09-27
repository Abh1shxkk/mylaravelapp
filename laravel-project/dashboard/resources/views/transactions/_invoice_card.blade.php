<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-start justify-between">
        <div>
            <h2 class="text-lg font-semibold">GlobalMatrix Solutions</h2>
            <p class="text-sm text-gray-600">Dashboard Subscription</p>
        </div>
        <div class="text-right text-sm text-gray-600">
            <p><span class="font-medium">Invoice #:</span> {{ $payment->id }}</p>
            <p><span class="font-medium">Date:</span> {{ optional($payment->paid_at ?? $payment->created_at)->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST</p>
        </div>
    </div>
    <hr class="my-4">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div>
            <h3 class="font-semibold mb-1">Billed To</h3>
            <p>{{ auth()->user()->name }}</p>
            <p class="text-gray-600">{{ auth()->user()->email }}</p>
        </div>
        <div class="min-w-0">
            <h3 class="font-semibold mb-1">Payment Details</h3>
            <p><span class="font-medium">Provider:</span> {{ ucfirst($payment->provider) }}</p>
            @if($payment->payment_id)
                <p class="break-all"><span class="font-medium">Payment ID:</span> <span class="break-all">{{ $payment->payment_id }}</span></p>
            @endif
            @if($payment->subscription_id)
                <p class="break-all"><span class="font-medium">Subscription ID:</span> <span class="break-all">{{ $payment->subscription_id }}</span></p>
            @endif
            <p><span class="font-medium">Status:</span> {{ ucfirst($payment->status) }}</p>
        </div>
    </div>

    <div class="mt-6">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-600">
                    <th class="text-left px-3 py-2">Description</th>
                    <th class="text-right px-3 py-2">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr>
                    <td class="px-3 py-2">{{ optional($payment->plan)->name ?? strtoupper($payment->plan_id) }} Plan</td>
                    <td class="px-3 py-2 text-right">₹{{ number_format((int)($payment->amount ?? 0)) }} {{ $payment->currency ?? 'INR' }}</td>
                </tr>
            </tbody>
            <tfoot class="border-t">
                <tr>
                    <td class="px-3 py-2 text-right font-semibold">Total</td>
                    <td class="px-3 py-2 text-right font-semibold">₹{{ number_format((int)($payment->amount ?? 0)) }} {{ $payment->currency ?? 'INR' }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <p class="text-xs text-gray-500 mt-6">This is a system-generated invoice.</p>
</div>
