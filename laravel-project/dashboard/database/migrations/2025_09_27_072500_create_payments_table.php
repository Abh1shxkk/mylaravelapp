<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('plan_id')->nullable(); // plan slug
            $table->string('provider')->nullable(); // razorpay|stripe
            $table->string('payment_id')->nullable(); // razorpay_payment_id or stripe payment intent id
            $table->string('subscription_id')->nullable(); // provider subscription id
            $table->integer('amount')->nullable(); // store in smallest currency unit if needed; here use plan price integer
            $table->string('currency', 10)->nullable()->default('INR');
            $table->string('status')->default('paid');
            $table->timestamp('paid_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
