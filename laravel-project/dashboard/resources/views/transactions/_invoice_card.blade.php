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
            <p>
                <span class="font-medium">Status:</span> 
                @php
                    $status = strtolower($payment->status ?? 'pending');
                    $statusClass = match($status) {
                        'paid' => 'text-green-700',
                        'failed' => 'text-red-700',
                        'cancelled' => 'text-gray-700',
                        'pending' => 'text-amber-700',
                        default => 'text-blue-700',
                    };
                @endphp
                <span class="{{ $statusClass }} font-semibold">{{ ucfirst($status) }}</span>
            </p>
            @if($status === 'failed' && isset($payment->meta['failure_message']))
                <p class="text-red-600 text-xs mt-1">
                    <span class="font-medium">Reason:</span> {{ $payment->meta['failure_message'] }}
                </p>
            @endif
            @if($status === 'cancelled' && isset($payment->meta['cancelled_at']))
                <p class="text-gray-600 text-xs mt-1">
                    <span class="font-medium">Cancelled:</span> {{ \Carbon\Carbon::parse($payment->meta['cancelled_at'])->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST
                </p>
            @endif
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
                    <td class="px-3 py-2 text-right">
                        @if($payment->amount)
                            ₹{{ number_format((int)($payment->amount ?? 0)) }} {{ $payment->currency ?? 'INR' }}
                        @else
                            <span class="text-gray-400">Amount not available</span>
                        @endif
                    </td>
                </tr>
            </tbody>
            <tfoot class="border-t">
                <tr>
                    <td class="px-3 py-2 text-right font-semibold">Total</td>
                    <td class="px-3 py-2 text-right font-semibold">
                        @if($payment->amount)
                            ₹{{ number_format((int)($payment->amount ?? 0)) }} {{ $payment->currency ?? 'INR' }}
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    @if($status === 'pending' && isset($payment->meta['checkout_url']))
        <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-lg">
            <p class="text-sm text-amber-800 mb-2">
                <i class="fas fa-info-circle"></i> This payment is still pending. Complete your payment to activate your subscription.
            </p>
            <a href="{{ $payment->meta['checkout_url'] }}" target="_blank" 
               class="inline-block px-4 py-2 bg-amber-600 text-white rounded hover:bg-amber-700 transition-colors text-sm font-medium">
                <i class="fas fa-credit-card mr-1"></i> Complete Payment
            </a>
        </div>
    @endif

    @if($status === 'failed')
        <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <p class="text-sm text-red-800">
                <i class="fas fa-exclamation-triangle"></i> This payment failed. Please try again with a different payment method.
            </p>
        </div>
    @endif

    @if($status === 'cancelled')
        <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
            <p class="text-sm text-gray-800">
                <i class="fas fa-ban"></i> This payment was cancelled by the user.
            </p>
        </div>
    @endif

    <p class="text-xs text-gray-500 mt-6">This is a system-generated invoice.</p>
</div>