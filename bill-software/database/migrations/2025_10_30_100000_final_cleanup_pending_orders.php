<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Keep only columns that are used in the form and displayed in table
     */
    public function up(): void
    {
        Schema::table('pending_orders', function (Blueprint $table) {
            // Drop all unnecessary columns
            $table->dropColumn([
                'urgent_flag',
                'scheme_plus',
                'scheme_minus'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pending_orders', function (Blueprint $table) {
            $table->char('urgent_flag', 1)->default('N');
            $table->integer('scheme_plus')->nullable()->default(0);
            $table->integer('scheme_minus')->nullable()->default(0);
        });
    }
};
