<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Remove columns not used in table display
     */
    public function up(): void
    {
        Schema::table('pending_orders', function (Blueprint $table) {
            $table->dropColumn([
                'po_number',
                'received_qty',
                'pending_qty',
                'po_status',
                'total_amount'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pending_orders', function (Blueprint $table) {
            $table->string('po_number', 50)->nullable();
            $table->decimal('received_qty', 12, 2)->default(0);
            $table->decimal('pending_qty', 12, 2)->default(0);
            $table->enum('po_status', ['pending', 'partial', 'completed', 'cancelled'])->default('pending');
            $table->decimal('total_amount', 15, 2)->default(0);
        });
    }
};
