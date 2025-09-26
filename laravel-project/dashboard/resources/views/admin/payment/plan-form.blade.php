<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($plan) ? 'Edit Plan' : 'Create Plan' }} - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold">{{ isset($plan) ? 'Edit Plan' : 'Create Plan' }}</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.payment.plans') }}" 
                       class="bg-gray-500 text-white px-3 py-2 rounded hover:bg-gray-600 text-sm">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Plans
                    </a>
                </div>
            </div>
        </div>
    </div>

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

            <form method="POST" action="{{ isset($plan) ? route('admin.payment.plans.update', $plan) : route('admin.payment.plans.store') }}" class="p-6">
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
                    <!-- Plan Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Plan Name *</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $plan->name ?? '') }}" 
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>

                    <!-- Plan Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Plan Slug *</label>
                        <input type="text" 
                               id="slug" 
                               name="slug" 
                               value="{{ old('slug', $plan->slug ?? '') }}" 
                               required
                               pattern="[a-z0-9-]+"
                               title="Only lowercase letters, numbers, and hyphens allowed"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <p class="text-xs text-gray-500 mt-1">Used in URLs (e.g., basic, premium)</p>
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price (₹) *</label>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               value="{{ old('price', $plan->price ?? '') }}" 
                               required
                               min="0"
                               step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>

                    <!-- Billing Period -->
                    <div>
                        <label for="billing_period" class="block text-sm font-medium text-gray-700 mb-2">Billing Period *</label>
                        <select id="billing_period" 
                                name="billing_period" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">Select billing period</option>
                            <option value="monthly" {{ old('billing_period', $plan->billing_period ?? '') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly" {{ old('billing_period', $plan->billing_period ?? '') === 'yearly' ? 'selected' : '' }}>Yearly</option>
                            <option value="custom" {{ old('billing_period', $plan->billing_period ?? '') === 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                    </div>

                    <!-- Custom Duration Fields -->
                    <div id="custom_duration_group" class="hidden md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="duration_value" class="block text-sm font-medium text-gray-700 mb-2">Duration Value</label>
                                <input type="number" id="duration_value" name="duration_value" min="1" step="1"
                                       value="{{ old('duration_value', $plan->duration_value ?? '') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                       placeholder="e.g., 1">
                                <p class="text-xs text-gray-500 mt-1">Set this to 1 for your 1-minute test.</p>
                            </div>
                            <div>
                                <label for="duration_unit" class="block text-sm font-medium text-gray-700 mb-2">Duration Unit</label>
                                <select id="duration_unit" name="duration_unit"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
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

                    <!-- Razorpay Plan ID -->
                    <div class="md:col-span-2">
                        <label for="razorpay_plan_id" class="block text-sm font-medium text-gray-700 mb-2">Razorpay Plan ID</label>
                        <input type="text" 
                               id="razorpay_plan_id" 
                               name="razorpay_plan_id" 
                               value="{{ old('razorpay_plan_id', $plan->razorpay_plan_id ?? '') }}"
                               placeholder="plan_XXXXXXXXXXXXXX"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <p class="text-xs text-gray-500 mt-1">The plan ID from your Razorpay dashboard (optional)</p>
                    </div>

                    <!-- Stripe Price ID -->
                    <div class="md:col-span-2">
                        <label for="stripe_price_id" class="block text-sm font-medium text-gray-700 mb-2">Stripe Price ID</label>
                        <input type="text" 
                               id="stripe_price_id" 
                               name="stripe_price_id" 
                               value="{{ old('stripe_price_id', $plan->stripe_price_id ?? '') }}"
                               placeholder="price_XXXXXXXXXXXXXX"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                        <p class="text-xs text-gray-500 mt-1">The Price ID from your Stripe dashboard (optional)</p>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                  placeholder="Describe what this plan includes...">{{ old('description', $plan->description ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.payment.plans') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        {{ isset($plan) ? 'Update Plan' : 'Create Plan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-generate slug from name
        document.getElementById('name').addEventListener('input', function() {
            const name = this.value;
            const slug = name.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            document.getElementById('slug').value = slug;
        });

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
    </script>
</body>
</html>


