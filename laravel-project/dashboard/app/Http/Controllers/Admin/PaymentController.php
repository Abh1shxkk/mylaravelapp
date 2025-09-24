<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function index()
    {
        // Get plans with subscription counts
        $plans = Plan::withCount('subscriptions')->get();
        
        // Get recent subscriptions with user info
        $recentSubscriptions = Subscription::with('user')
            ->latest('created_at')
            ->limit(5)
            ->get();
            
        // Get revenue stats
        $revenueStats = $this->getRevenueStats();
        
        $gateways = config('payment.gateways');
        return view('admin.payment.index', compact('plans', 'recentSubscriptions', 'revenueStats', 'gateways'));
    }

    public function updateGateways(Request $request)
    {
        $request->validate([
            'razorpay' => 'nullable|boolean',
            'stripe' => 'nullable|boolean',
        ]);

        // Update runtime config immediately (no process restart)
        config([
            'payment.gateways.razorpay' => (bool) $request->boolean('razorpay'),
            'payment.gateways.stripe'   => (bool) $request->boolean('stripe'),
        ]);

        // Persist to .env for future requests
        $this->setEnv('PAYMENT_RAZORPAY_ENABLED', $request->boolean('razorpay') ? 'true' : 'false');
        $this->setEnv('PAYMENT_STRIPE_ENABLED', $request->boolean('stripe') ? 'true' : 'false');

        // NOTE: Avoid running Artisan commands (config:clear/cache) inside the web request to prevent
        //       connection resets on some Windows/XAMPP setups. If config is cached in prod, an ops
        //       task/CI can refresh it separately.

        return redirect()->route('admin.payment.index')
            ->with('success', 'Payment gateways updated. Changes take effect immediately.');
    }

    private function setEnv(string $key, string $value): void
    {
        $path = base_path('.env');
        if (!file_exists($path) || !is_writable($path)) {
            return; // silently ignore in case env not writable in this env
        }

        $contents = file_get_contents($path);
        $pattern = "/^{$key}=.*$/m";
        $replacement = $key.'='.$value;
        if (preg_match($pattern, $contents)) {
            $contents = preg_replace($pattern, $replacement, $contents);
        } else {
            $contents .= PHP_EOL.$replacement.PHP_EOL;
        }
        file_put_contents($path, $contents);
    }

    public function plans()
    {
        $plans = Plan::withCount('subscriptions')->get();
        return view('admin.payment.plans', compact('plans'));
    }

    public function plansJson()
    {
        $plans = Plan::select('id','name','slug','price','billing_period','description','razorpay_plan_id','stripe_price_id')
            ->orderBy('id','asc')
            ->get();
        return response()->json($plans);
    }

    public function createPlan()
    {
        return view('admin.payment.plan-form');
    }

    public function storePlan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:plans,slug',
            'price' => 'required|numeric|min:0',
            'billing_period' => 'required|string|in:monthly,yearly',
            'description' => 'nullable|string',
            'razorpay_plan_id' => 'nullable|string|max:255',
            'stripe_price_id' => 'nullable|string|max:255',
        ]);

        Plan::create($request->all());

        return redirect()->route('admin.payment.plans')
            ->with('success', 'Plan created successfully!');
    }

    public function editPlan(Plan $plan)
    {
        return view('admin.payment.plan-form', compact('plan'));
    }

    public function updatePlan(Request $request, Plan $plan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:plans,slug,' . $plan->id,
            'price' => 'required|numeric|min:0',
            'billing_period' => 'required|string|in:monthly,yearly',
            'description' => 'nullable|string',
            'razorpay_plan_id' => 'nullable|string|max:255',
            'stripe_price_id' => 'nullable|string|max:255',
        ]);

        $plan->update($request->all());

        return redirect()->route('admin.payment.plans')
            ->with('success', 'Plan updated successfully!');
    }

    public function destroyPlan(Plan $plan)
    {
        // Check if plan has active subscriptions
        if ($plan->subscriptions()->whereIn('status', ['active', 'created', 'paused'])->exists()) {
            return redirect()->route('admin.payment.plans')
                ->with('error', 'Cannot delete plan with active subscriptions!');
        }

        $plan->delete();

        return redirect()->route('admin.payment.plans')
            ->with('success', 'Plan deleted successfully!');
    }

    public function subscribers(Request $request)
    {
        $query = Subscription::with(['user', 'plan'])->latest('created_at');

        if ($q = trim((string) $request->get('q'))) {
            $query->where(function ($sub) use ($q) {
                $sub->where('plan_id', 'like', "%$q%")
                    ->orWhere('status', 'like', "%$q%")
                    ->orWhereHas('user', function ($u) use ($q) {
                        $u->where('name', 'like', "%$q%")
                          ->orWhere('email', 'like', "%$q%");
                    })
                    ->orWhereHas('plan', function ($p) use ($q) {
                        $p->where('name', 'like', "%$q%")
                          ->orWhere('slug', 'like', "%$q%");
                    });
            });
        }

        $subscriptions = $query->paginate(6)->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($subscriptions);
        }

        return view('admin.payment.subscribers', compact('subscriptions', 'q'));
    }

    public function updateSubscription(Request $request, Subscription $subscription)
    {
        $request->validate([
            'status' => 'required|in:active,cancelled,paused',
        ]);

        $oldStatus = $subscription->status;
        $subscription->update([
            'status' => $request->status,
            'ended_at' => $request->status === 'cancelled' ? now() : null,
        ]);

        // If cancelling, also cancel on Razorpay
        if ($request->status === 'cancelled' && $oldStatus !== 'cancelled' && $subscription->razorpay_subscription_id) {
            try {
                $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
                $api->subscription->fetch($subscription->razorpay_subscription_id)->cancel();
            } catch (\Exception $e) {
                // Log error but don't fail the update
                \Log::error('Failed to cancel Razorpay subscription: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.payment.subscribers')
            ->with('success', 'Subscription updated successfully!');
    }

    public function revenue()
    {
        $revenueStats = $this->getRevenueStats();
        $monthlyRevenue = $this->getMonthlyRevenue();
        $planStats = $this->getPlanStats();

        return view('admin.payment.revenue', compact('revenueStats', 'monthlyRevenue', 'planStats'));
    }

    private function getRevenueStats()
    {
        return [
            'total_revenue' => Subscription::where('status', 'active')
                ->join('plans', 'subscriptions.plan_id', '=', 'plans.slug')
                ->sum('plans.price'),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'total_subscriptions' => Subscription::count(),
            'monthly_revenue' => Subscription::where('status', 'active')
                ->whereMonth('subscriptions.created_at', now()->month)
                ->join('plans', 'subscriptions.plan_id', '=', 'plans.slug')
                ->sum('plans.price'),
        ];
    }

    private function getMonthlyRevenue()
    {
        return Subscription::where('status', 'active')
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.slug')
            ->select(
                DB::raw('MONTH(subscriptions.created_at) as month'),
                DB::raw('YEAR(subscriptions.created_at) as year'),
                DB::raw('SUM(plans.price) as revenue'),
                DB::raw('COUNT(*) as subscriptions')
            )
            ->groupBy('month', 'year')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();
    }

    private function getPlanStats()
    {
        return Plan::withCount(['subscriptions as total_subscriptions', 'subscriptions as active_subscriptions' => function($query) {
            $query->where('status', 'active');
        }])->get();
    }
}
