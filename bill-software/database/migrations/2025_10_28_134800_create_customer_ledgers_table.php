<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_ledgers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->date('transaction_date');
            $table->string('trans_no')->nullable();
            $table->enum('transaction_type', ['Sale', 'Return', 'Payment', 'Adjustment'])->default('Sale');
            $table->decimal('amount', 12, 2);
            $table->decimal('running_balance', 12, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->index('customer_id');
            $table->index('transaction_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_ledgers');
    }
};
