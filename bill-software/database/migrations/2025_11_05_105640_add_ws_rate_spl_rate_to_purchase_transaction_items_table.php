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
            // Add ws_rate and spl_rate columns after s_rate column
            $table->decimal('ws_rate', 15, 2)->default(0.00)->after('s_rate')->comment('Wholesale Rate');
            $table->decimal('spl_rate', 15, 2)->default(0.00)->after('ws_rate')->comment('Special Rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_transaction_items', function (Blueprint $table) {
            // Drop ws_rate and spl_rate columns
            $table->dropColumn(['ws_rate', 'spl_rate']);
        });
    }
};
