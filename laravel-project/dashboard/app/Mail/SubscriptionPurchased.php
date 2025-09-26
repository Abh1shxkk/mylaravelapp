<?php

namespace App\Mail;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionPurchased extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public Plan $plan;
    public Subscription $subscription;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Plan $plan, Subscription $subscription)
    {
        $this->user = $user;
        $this->plan = $plan;
        $this->subscription = $subscription;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subscription Confirmed: ' . ($this->plan->name ?? ucfirst($this->plan->slug)),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.subscription-purchased',
            with: [
                'user' => $this->user,
                'plan' => $this->plan,
                'subscription' => $this->subscription,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
