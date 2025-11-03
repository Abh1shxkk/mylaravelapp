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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            
            // Header Fields
            $table->date('bill_date');
            $table->string('day_name', 20)->nullable();
            $table->string('supplier')->nullable();
            $table->string('bill_no', 50)->nullable();
            $table->string('trn_no', 50)->nullable();
            $table->date('receive_date')->nullable();
            $table->string('cash', 1)->default('N');
            $table->string('transfer', 1)->default('N');
            $table->text('remarks')->nullable();
            $table->date('due_date')->nullable();
            
            // Item Details (stored as JSON array for multiple items)
            $table->json('items')->nullable();
            
            // Totals and Calculations
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->decimal('net_amount', 12, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
