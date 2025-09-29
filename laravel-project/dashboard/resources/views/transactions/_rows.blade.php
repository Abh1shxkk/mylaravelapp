@foreach($payments as $p)
<tr class="text-sm hover:bg-gray-50">
    <td class="px-4 py-3 text-gray-800">
        {{ optional($p->paid_at ?? $p->created_at)->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST
    </td>
    <td class="px-4 py-3">{{ optional($p->plan)->name ?? strtoupper($p->plan_id) }}</td>
    <td class="px-4 py-3">
        @php
            $status = strtolower($p->status ?? 'pending');
            $cls = match($status) {
                'paid' => 'bg-green-100 text-green-700 border border-green-200',
                'failed' => 'bg-red-100 text-red-700 border border-red-200',
                'cancelled' => 'bg-gray-200 text-gray-700 border border-gray-300',
                'pending' => 'bg-amber-100 text-amber-700 border border-amber-200',
                default => 'bg-blue-100 text-blue-700 border border-blue-200',
            };
            $checkoutUrl = $status === 'pending' && isset($p->meta['checkout_url']) ? $p->meta['checkout_url'] : null;
            $createdAt = \Illuminate\Support\Carbon::parse($p->created_at ?? now());
            $expireMinutes = (int) config('payments.pending_expire_minutes', 30);
            $expiredUi = $status === 'pending' && $createdAt->lt(now()->subMinutes($expireMinutes));
            if ($expiredUi) { $checkoutUrl = null; }
        @endphp
        
        @if($checkoutUrl)
            <a href="{{ $checkoutUrl }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded text-xs font-medium {{ $cls }} hover:shadow-md transition-all" data-checkout-link>
                <i class="fas fa-external-link-alt text-xs"></i>
                {{ ucfirst($status) }} - Complete Payment
            </a>
        @else
            <span class="inline-block px-2.5 py-1 rounded text-xs font-medium {{ $cls }}" data-status-badge>
                {{ $expiredUi ? 'Failed' : ucfirst($status) }}
            </span>
        @endif

        @php
            // Compute remaining minutes for pending payments
            $remainingMins = null;
            if ($status === 'pending') {
                $expiresAt = $createdAt->copy()->addMinutes($expireMinutes);
                $diff = now()->diffInMinutes($expiresAt, false); // signed
                $remainingMins = $diff > 0 ? $diff : 0;
            }
        @endphp
        @if($status === 'pending' && !$expiredUi && $remainingMins !== null)
            @php $expiresAtIso = $createdAt->copy()->addMinutes($expireMinutes)->toIso8601String(); @endphp
            <div class="text-xs text-amber-700 mt-1" data-expiry-note data-expires-at="{{ $expiresAtIso }}">
                <i class="fas fa-clock"></i>
                Payment link expires in {{ $remainingMins }} minute{{ $remainingMins === 1 ? '' : 's' }}
            </div>
        @endif
    </td>
    <td class="px-4 py-3 text-right font-medium">
        @if(!is_null($p->amount))
            ₹{{ number_format((int)$p->amount) }} {{ $p->currency ?? 'INR' }}
        @else
            <span class="text-gray-400">-</span>
        @endif
    </td>
    <td class="px-4 py-3 text-right space-x-3">
        @if($status === 'paid')
            <button data-view-invoice="{{ route('transactions.invoice.partial', $p) }}" 
                    class="text-blue-600 hover:text-blue-800 hover:underline font-medium">
                <i class="fas fa-file-invoice mr-1"></i>View
            </button>
        @endif
        <button data-delete="{{ route('transactions.destroy', $p) }}" 
                class="text-red-600 hover:text-red-800 hover:underline font-medium">
            <i class="fas fa-trash-alt mr-1"></i>Delete
        </button>
    </td>
</tr>
@endforeach
