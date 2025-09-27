<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subscription_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('plan_id'); // references plans.slug
            $table->string('status')->nullable(); // cancelled, switched, expired, etc.
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('provider')->nullable(); // razorpay/stripe
            $table->string('payment_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'started_at']);
            $table->index(['user_id', 'ended_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_histories');
    }
};
