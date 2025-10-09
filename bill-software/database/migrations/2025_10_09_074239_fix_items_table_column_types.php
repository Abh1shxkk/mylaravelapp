<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // First, fix invalid date values before altering columns
        DB::statement("UPDATE items SET Expiry = NULL WHERE Expiry = '0000-00-00' OR Expiry = ''");
        DB::statement("UPDATE items SET ScmFrom = NULL WHERE ScmFrom = '0000-00-00' OR ScmFrom = ''");
        DB::statement("UPDATE items SET ScmTo = NULL WHERE ScmTo = '0000-00-00' OR ScmTo = ''");
        DB::statement("UPDATE items SET Vdt = NULL WHERE Vdt = '0000-00-00' OR Vdt = ''");
        
        Schema::table('items', function (Blueprint $table) {
            // Change decimal/boolean fields to varchar with appropriate sizes
            // Using smaller varchar sizes to avoid row size limit
            $table->string('Add_sc', 50)->nullable()->change();
            $table->string('Add_tsr', 50)->nullable()->change();
            $table->string('Vdt', 50)->nullable()->change();
            $table->string('Defqty', 50)->nullable()->change();
            $table->string('WsNet', 50)->nullable()->change();
            $table->string('SplNet', 50)->nullable()->change();
            $table->string('CommonItem', 10)->nullable()->change();
            $table->string('FDis', 50)->nullable()->change();
            $table->string('PresReq', 10)->nullable()->change();
            $table->string('Inclusive', 10)->nullable()->change();
            $table->string('Wr', 50)->nullable()->change();
            $table->string('TaxonMrp', 10)->nullable()->change();
            $table->string('VATonSrate', 10)->nullable()->change();
            $table->string('Exon', 10)->nullable()->change();
            $table->string('LockBilling', 10)->nullable()->change();
            $table->string('SameBatchCost', 10)->nullable()->change();
            
            // Change decimal precision for currency fields (using $ symbol)
            $table->decimal('splrate', 10, 3)->nullable()->change();
            $table->decimal('Mrp', 10, 3)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // Revert varchar fields back to their original types
            $table->decimal('Add_sc', 10, 2)->nullable()->change();
            $table->decimal('Add_tsr', 10, 2)->nullable()->change();
            $table->date('Vdt')->nullable()->change();
            $table->decimal('Defqty', 10, 2)->nullable()->change();
            $table->decimal('WsNet', 10, 2)->nullable()->change();
            $table->decimal('SplNet', 10, 2)->nullable()->change();
            $table->boolean('CommonItem')->nullable()->default(false)->change();
            $table->decimal('FDis', 10, 2)->nullable()->change();
            $table->boolean('PresReq')->nullable()->default(false)->change();
            $table->boolean('Inclusive')->nullable()->default(false)->change();
            $table->decimal('Wr', 10, 2)->nullable()->change();
            $table->boolean('TaxonMrp')->nullable()->default(false)->change();
            $table->boolean('VATonSrate')->nullable()->default(false)->change();
            $table->boolean('Exon')->nullable()->default(false)->change();
            $table->boolean('LockBilling')->nullable()->default(false)->change();
            $table->boolean('SameBatchCost')->nullable()->default(false)->change();
            
            // Revert decimal precision
            $table->decimal('splrate', 10, 2)->nullable()->change();
            $table->decimal('Mrp', 10, 2)->nullable()->change();
        });
    }
};
