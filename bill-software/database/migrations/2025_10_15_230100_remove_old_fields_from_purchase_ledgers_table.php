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
        Schema::table('purchase_ledgers', function (Blueprint $table) {
            $table->dropColumn([
                'purchase_date',
                'bill_no',
                'supplier_name',
                'amount',
                'tax_amount',
                'total_amount',
                'payment_status',
                'description'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_ledgers', function (Blueprint $table) {
            $table->date('purchase_date')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('supplier_name')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('tax_amount', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->string('payment_status')->nullable();
            $table->text('description')->nullable();
        });
    }
};
