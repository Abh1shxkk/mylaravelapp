<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->foreignId('invoice_id')->nullable()->constrained('invoices','invoice_id');
            $table->date('payment_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_reference')->nullable();
            $table->decimal('amount',15,2)->nullable();
            $table->text('notes')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_signature')->nullable();
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users','user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_payments');
    }
};
