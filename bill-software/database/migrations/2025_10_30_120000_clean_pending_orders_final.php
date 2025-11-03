<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Clean pending_orders table - keep only supplier-centric fields
     */
    public function up(): void
    {
        // Truncate existing data
        DB::table('pending_orders')->truncate();
        
        Schema::table('pending_orders', function (Blueprint $table) {
            // Drop item_id foreign key and column
            $table->dropForeign('pending_orders_item_id_foreign');
            $table->dropColumn('item_id');
            
            // Drop supplier_name and supplier_code (will get from supplier relation)
            $table->dropColumn('supplier_name');
            $table->dropColumn('supplier_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pending_orders', function (Blueprint $table) {
            $table->bigInteger('item_id')->unsigned()->after('id');
            $table->foreign('item_id')->references('id')->on('items');
            $table->string('supplier_name', 255)->nullable();
            $table->string('supplier_code', 50)->nullable();
        });
    }
};
