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
        Schema::create('expiry_ledger', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('batch_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->date('transaction_date');
            $table->string('trans_no')->nullable();
            $table->string('transaction_type'); // IN, OUT, RETURN, ADJUSTMENT
            $table->string('party_name');
            $table->integer('quantity');
            $table->integer('free_quantity')->default(0);
            $table->decimal('running_balance', 10, 2);
            $table->date('expiry_date');
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers')->onDelete('set null');
            $table->index('transaction_date');
            $table->index('expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expiry_ledger');
    }
};
