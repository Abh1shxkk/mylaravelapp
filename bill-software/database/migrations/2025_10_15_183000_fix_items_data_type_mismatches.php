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
        Schema::table('items', function (Blueprint $table) {
            // Fix locks_flag - change default from 'S' to 'N' to match validation
            $table->char('locks_flag', 1)->default('N')->change();
            
            // Fix fixed_dis - change from decimal to char to store Y/N/M
            $table->char('fixed_dis', 1)->nullable()->change();
            
            // Fix max_inv_qty_new - change from decimal to char to store W/R/I
            $table->char('max_inv_qty_new', 1)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // Revert changes
            $table->char('locks_flag', 1)->default('S')->change();
            $table->decimal('fixed_dis', 10, 2)->nullable()->change();
            $table->decimal('max_inv_qty_new', 10, 2)->nullable()->change();
        });
    }
};
