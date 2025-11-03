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
        Schema::table('pending_orders', function (Blueprint $table) {
            // Add item_id foreign key
            $table->unsignedBigInteger('item_id')->after('id');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            
            // Add order-related fields
            $table->integer('balance_qty')->default(0)->after('quantity');
            $table->integer('order_qty')->after('balance_qty');
            $table->integer('free_qty')->default(0)->after('order_qty');
            $table->decimal('other_order', 10, 2)->default(0)->after('free_qty');
            
            // Rename quantity to match if needed (or keep both)
            // Note: You may want to drop 'quantity' if 'order_qty' replaces it
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pending_orders', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
            $table->dropColumn(['item_id', 'balance_qty', 'order_qty', 'free_qty', 'other_order']);
        });
    }
};
