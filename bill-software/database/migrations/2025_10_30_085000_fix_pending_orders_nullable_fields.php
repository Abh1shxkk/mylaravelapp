<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Fix nullable fields in pending_orders table
     */
    public function up(): void
    {
        Schema::table('pending_orders', function (Blueprint $table) {
            // Make scheme_plus and scheme_minus nullable with default 0
            $table->integer('scheme_plus')->default(0)->nullable()->change();
            $table->integer('scheme_minus')->default(0)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pending_orders', function (Blueprint $table) {
            $table->integer('scheme_plus')->change();
            $table->integer('scheme_minus')->change();
        });
    }
};
