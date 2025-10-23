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
        Schema::create('purchase_ledgers', function (Blueprint $table) {
            $table->id();
            $table->date('purchase_date');
            $table->string('bill_no', 50);
            $table->string('supplier_name');
            $table->decimal('amount', 15, 2);
            $table->decimal('tax_amount', 15, 2)->nullable()->default(0);
            $table->decimal('total_amount', 15, 2);
            $table->string('payment_status', 50)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_ledgers');
    }
};
