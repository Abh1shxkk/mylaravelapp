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
        Schema::create('stock_ledgers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->string('transaction_type'); // IN, OUT, ADJUSTMENT, RETURN
            $table->decimal('quantity', 12, 2);
            $table->decimal('opening_qty', 12, 2)->default(0);
            $table->decimal('closing_qty', 12, 2)->default(0);
            $table->string('reference_type')->nullable(); // PURCHASE, SALE, ADJUSTMENT
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->date('transaction_date');
            $table->string('godown')->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('set null');
            
            // Indexes
            $table->index('item_id');
            $table->index('batch_id');
            $table->index('transaction_date');
            $table->index('transaction_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_ledgers');
    }
};
