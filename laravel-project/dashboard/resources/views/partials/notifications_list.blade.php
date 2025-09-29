@php use Illuminate\Support\Carbon; @endphp
@if(($items ?? collect())->count() === 0)
    <div class="p-3 text-sm text-gray-500">No notifications</div>
@else
    <ul class="divide-y">
        @foreach($items as $n)
            <li class="px-3 py-2 {{ $n->read_at ? '' : 'bg-blue-50' }}">
                <div class="flex items-start gap-2">
                    <div class="mt-0.5">
                        @switch($n->type)
                            @case('subscription_created')<i class="fas fa-crown text-yellow-600"></i>@break
                            @case('subscription_canceled')<i class="fas fa-ban text-red-600"></i>@break
                            @case('invoice_paid')<i class="fas fa-receipt text-green-600"></i>@break
                            @case('invoice_failed')<i class="fas fa-exclamation-triangle text-red-600"></i>@break
                            @case('profile_updated')<i class="fas fa-user-edit text-indigo-600"></i>@break
                            @default <i class="fas fa-info-circle text-gray-500"></i>
                        @endswitch
                    </div>
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-800">{{ $n->title }}</div>
                        @if($n->body)
                            <div class="text-xs text-gray-600">{{ $n->body }}</div>
                        @endif
                        <div class="text-[11px] text-gray-400 mt-0.5">{{ Carbon::parse($n->created_at)->diffForHumans() }}</div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@endif
