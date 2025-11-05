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
        Schema::table('purchase_transaction_items', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_transaction_items', 's_rate')) {
                $table->decimal('s_rate', 15, 2)->nullable()->after('mrp')->comment('Sale Rate (Special Rate)');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_transaction_items', function (Blueprint $table) {
            $table->dropColumn('s_rate');
        });
    }
};

