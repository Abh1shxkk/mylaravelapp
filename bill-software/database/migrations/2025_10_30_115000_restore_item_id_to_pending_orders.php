<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Restore item_id to pending_orders table
     */
    public function up(): void
    {
        Schema::table('pending_orders', function (Blueprint $table) {
            // Add item_id back
            $table->bigInteger('item_id')->unsigned()->after('id');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pending_orders', function (Blueprint $table) {
            $table->dropForeign('pending_orders_item_id_foreign');
            $table->dropColumn('item_id');
        });
    }
};
