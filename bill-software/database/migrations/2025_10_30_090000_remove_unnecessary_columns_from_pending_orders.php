<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Remove unnecessary columns from pending_orders table
     */
    public function up(): void
    {
        Schema::table('pending_orders', function (Blueprint $table) {
            // Drop unnecessary columns
            $table->dropColumn([
                'days_pending',
                'expected_delivery_date',
                'received_amount'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pending_orders', function (Blueprint $table) {
            // Restore columns if needed
            $table->date('expected_delivery_date')->nullable();
            $table->decimal('received_amount', 15, 2)->default(0);
            $table->integer('days_pending')->default(0);
        });
    }
};
