<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ExpirePendingPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:expire-pending {--minutes=30 : Minutes before a pending payment is considered expired}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marks Stripe pending payments older than N minutes as failed and removes checkout links';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $minutes = (int) $this->option('minutes');
        $cutoff = Carbon::now()->subMinutes($minutes);

        $query = Payment::where('provider', 'stripe')
            ->where('status', 'pending');

        $count = 0;
        $query->chunkById(200, function ($payments) use (&$count, $cutoff, $minutes) {
            // Stripe client optional
            $stripe = null;
            $secret = config('services.stripe.secret');
            if (!empty($secret)) {
                try { $stripe = new \Stripe\StripeClient($secret); } catch (\Throwable $e) { $stripe = null; }
            }

            foreach ($payments as $p) {
                $meta = is_array($p->meta ?? null) ? $p->meta : [];
                $sessionId = $meta['checkout_session_id'] ?? null;
                $shouldExpire = false;

                // 1) Age-based expiry
                if (($p->created_at ?? now())->lte($cutoff)) {
                    $shouldExpire = true;
                }

                // 2) Stripe session-based expiry if available
                if (!$shouldExpire && $stripe && $sessionId) {
                    try {
                        $session = $stripe->checkout->sessions->retrieve($sessionId);
                        // If Stripe set expires_at or created timestamps, evaluate
                        $nowTs = Carbon::now()->timestamp;
                        $createdTs = (int) ($session->created ?? 0);
                        $expiresTs = (int) ($session->expires_at ?? 0);
                        if ($expiresTs && $nowTs >= $expiresTs) {
                            $shouldExpire = true;
                        } elseif ($createdTs && $nowTs - $createdTs >= ($minutes * 60)) {
                            $shouldExpire = true;
                        }
                    } catch (\Throwable $e) {
                        // If session retrieve fails, fallback to age-based logic already applied
                    }
                }

                if ($shouldExpire) {
                    // Remove checkout link and add failure message
                    unset($meta['checkout_url']);
                    $meta['expired_at'] = now()->toIso8601String();
                    $meta['failure_message'] = "Payment session expired ({$minutes} minutes timeout)";

                    $p->update([
                        'status' => 'failed',
                        'paid_at' => null,
                        'meta' => $meta,
                    ]);
                    $count++;
                }
            }
        });

        $msg = "Expired {$count} pending Stripe payment(s) older than {$minutes} minutes.";
        $this->info($msg);
        try { Log::info($msg); } catch (\Throwable $e) {}
        return Command::SUCCESS;
    }
}
