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
            // Sale Details Section - Scheme fields
            $table->integer('scheme_plus')->default(0)->nullable()->after('spl_net_toggle');
            $table->integer('scheme_minus')->default(0)->nullable()->after('scheme_plus');
            
            // Purchase Details Section - Scheme fields
            $table->integer('pur_scheme_plus')->default(0)->nullable()->after('cost');
            $table->integer('pur_scheme_minus')->default(0)->nullable()->after('pur_scheme_plus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['scheme_plus', 'scheme_minus', 'pur_scheme_plus', 'pur_scheme_minus']);
        });
    }
};
