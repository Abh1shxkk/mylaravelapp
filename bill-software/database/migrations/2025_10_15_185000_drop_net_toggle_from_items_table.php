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
            // Drop net_toggle column as MRP doesn't need toggle
            $table->dropColumn('net_toggle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // Restore net_toggle column if needed
            $table->char('net_toggle', 1)->default('N')->nullable()->after('mrp');
        });
    }
};
