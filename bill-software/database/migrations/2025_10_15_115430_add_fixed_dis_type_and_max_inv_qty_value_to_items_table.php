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
            // Add fixed_dis_type field after fixed_dis_percent
            $table->char('fixed_dis_type', 1)->nullable()->after('fixed_dis_percent');
            
            // Add max_inv_qty_value field after locks_flag
            $table->decimal('max_inv_qty_value', 10, 2)->nullable()->default(0)->after('locks_flag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['fixed_dis_type', 'max_inv_qty_value']);
        });
    }
};
