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
        Schema::table('purchase_transactions', function (Blueprint $table) {
            // Add unique index on bill_no + supplier_id combination
            // Same supplier cannot have duplicate bill numbers
            $table->unique(['bill_no', 'supplier_id'], 'unique_bill_no_per_supplier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_transactions', function (Blueprint $table) {
            $table->dropUnique('unique_bill_no_per_supplier');
        });
    }
};
