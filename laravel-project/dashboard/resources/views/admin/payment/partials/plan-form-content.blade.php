<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-800">
                {{ isset($plan) ? 'Edit Subscription Plan' : 'Create New Subscription Plan' }}
            </h2>
            <p class="text-sm text-gray-600 mt-1">
                {{ isset($plan) ? 'Update the plan details below.' : 'Fill in the details to create a new subscription plan.' }}
            </p>
        </div>

        <form id="planForm" method="POST" action="{{ isset($plan) ? route('admin.payment.plans.update', $plan) : route('admin.payment.plans.store') }}" class="p-6">
            @csrf
            @if(isset($plan))
                @method('PUT')
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle text-red-400 mt-1 mr-3"></i>
                        <div>
                            <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Plan Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $plan->name ?? '') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Plan Slug *</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $plan->slug ?? '') }}" required pattern="[a-z0-9-]+" title="Only lowercase letters, numbers, and hyphens allowed" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <p class="text-xs text-gray-500 mt-1">Used in URLs (e.g., basic, premium)</p>
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price (₹) *</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $plan->price ?? '') }}" required min="0" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <div>
                    <label for="billing_period" class="block text-sm font-medium text-gray-700 mb-2">Billing Period *</label>
                    <select id="billing_period" name="billing_period" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <option value="">Select billing period</option>
                        <option value="monthly" {{ old('billing_period', $plan->billing_period ?? '') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="yearly" {{ old('billing_period', $plan->billing_period ?? '') === 'yearly' ? 'selected' : '' }}>Yearly</option>
                        <option value="custom" {{ old('billing_period', $plan->billing_period ?? '') === 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>
                </div>

                <div id="custom_duration_group" class="hidden md:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="duration_value" class="block text-sm font-medium text-gray-700 mb-2">Duration Value</label>
                            <input type="number" id="duration_value" name="duration_value" min="1" step="1" value="{{ old('duration_value', $plan->duration_value ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="e.g., 1">
                            <p class="text-xs text-gray-500 mt-1">Set this to 1 for your 1-minute test.</p>
                        </div>
                        <div>
                            <label for="duration_unit" class="block text-sm font-medium text-gray-700 mb-2">Duration Unit</label>
                            <select id="duration_unit" name="duration_unit" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">Select unit</option>
                                @php $unitOld = old('duration_unit', $plan->duration_unit ?? ''); @endphp
                                <option value="minutes" {{ $unitOld === 'minutes' ? 'selected' : '' }}>Minutes</option>
                                <option value="hours" {{ $unitOld === 'hours' ? 'selected' : '' }}>Hours</option>
                                <option value="days" {{ $unitOld === 'days' ? 'selected' : '' }}>Days</option>
                                <option value="weeks" {{ $unitOld === 'weeks' ? 'selected' : '' }}>Weeks</option>
                                <option value="months" {{ $unitOld === 'months' ? 'selected' : '' }}>Months</option>
                                <option value="years" {{ $unitOld === 'years' ? 'selected' : '' }}>Years</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="razorpay_plan_id" class="block text-sm font-medium text-gray-700 mb-2">Razorpay Plan ID</label>
                    <input type="text" id="razorpay_plan_id" name="razorpay_plan_id" value="{{ old('razorpay_plan_id', $plan->razorpay_plan_id ?? '') }}" placeholder="plan_XXXXXXXXXXXXXX" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <p class="text-xs text-gray-500 mt-1">The plan ID from your Razorpay dashboard (optional)</p>
                </div>

                <div class="md:col-span-2">
                    <label for="stripe_price_id" class="block text-sm font-medium text-gray-700 mb-2">Stripe Price ID</label>
                    <input type="text" id="stripe_price_id" name="stripe_price_id" value="{{ old('stripe_price_id', $plan->stripe_price_id ?? '') }}" placeholder="price_XXXXXXXXXXXXXX" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                    <p class="text-xs text-gray-500 mt-1">The Price ID from your Stripe dashboard (optional)</p>
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Describe what this plan includes...">{{ old('description', $plan->description ?? '') }}</textarea>
                </div>
            </div>

            <div id="formMessages" class="hidden mt-6"></div>

            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <button type="button" data-modal-close class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Cancel</button>
                <button id="submitBtn" type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-60 disabled:cursor-not-allowed">
                    <i class="fas fa-save mr-2"></i>
                    {{ isset($plan) ? 'Update Plan' : 'Create Plan' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-generate slug from name
(function(){
    const nameEl = document.getElementById('name');
    const slugEl = document.getElementById('slug');
    if(!nameEl || !slugEl) return;
    nameEl.addEventListener('input', function() {
        const name = this.value;
        const slug = name.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').trim('-');
        slugEl.value = slug;
    });
})();

// Toggle custom duration fields
(function(){
    const select = document.getElementById('billing_period');
    const group = document.getElementById('custom_duration_group');
    function toggle(){
        if(select && group){
            const show = select.value === 'custom';
            group.classList.toggle('hidden', !show);
        }
    }
    if(select){
        select.addEventListener('change', toggle);
        toggle();
    }
})();

// AJAX submit to avoid page refresh
(function(){
    const form = document.getElementById('planForm');
    const messages = document.getElementById('formMessages');
    const submitBtn = document.getElementById('submitBtn');

    function showMessage(type, html){
        if(!messages) return;
        messages.className = '';
        const base = 'rounded-lg px-4 py-3 mb-4';
        if(type === 'success'){
            messages.className = base + ' bg-green-100 border border-green-300 text-green-800';
        } else if(type === 'error'){
            messages.className = base + ' bg-red-100 border border-red-300 text-red-800';
        } else {
            messages.className = base + ' bg-gray-100 border border-gray-300 text-gray-800';
        }
        messages.innerHTML = html;
        messages.classList.remove('hidden');
    }

    function clearFieldErrors(){
        document.querySelectorAll('[data-field-error]').forEach(el => el.remove());
    }

    function addFieldError(field, message){
        const input = document.querySelector('[name="' + field + '"]');
        if(!input) return;
        const small = document.createElement('div');
        small.setAttribute('data-field-error', '');
        small.className = 'text-red-600 text-xs mt-1';
        small.textContent = message;
        input.closest('div')?.appendChild(small);
    }

    async function handleSubmit(e){
        if(!form) return;
        e.preventDefault();
        clearFieldErrors();
        if(messages){ messages.classList.add('hidden'); messages.innerHTML=''; }

        const formData = new FormData(form);
        const action = form.getAttribute('action');

        try {
            submitBtn && (submitBtn.disabled = true);

            const res = await fetch(action, {
                method: 'POST',
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
                // Notify parent page to refresh list
                document.dispatchEvent(new CustomEvent('plans:refresh', { detail: { message: data.message, type: 'success' } }));
                // Close modal if present
                document.querySelector('[data-modal-close]')?.click();
                return;
            }

            if(res.status === 422 && data && data.errors){
                const list = Object.values(data.errors).flat();
                showMessage('error', '<strong>Please fix the following errors:</strong><ul class="list-disc list-inside mt-2">' + list.map(e => '<li>' + e + '</li>').join('') + '</ul>');
                for(const [field, msgs] of Object.entries(data.errors)){
                    addFieldError(field, Array.isArray(msgs) ? msgs[0] : String(msgs));
                }
                return;
            }

            showMessage('error', (data && data.message) ? data.message : 'Something went wrong. Please try again.');
        } catch(err){
            showMessage('error', 'Network error. Please check your connection and try again.');
        } finally {
            submitBtn && (submitBtn.disabled = false);
        }
    }

    if(form){
        form.addEventListener('submit', handleSubmit);
    }
})();
</script>
