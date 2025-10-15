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
            // Add new bottom section fields
            $table->date('from_date')->nullable()->after('current_scheme_flag');
            $table->date('to_date')->nullable()->after('from_date');
            $table->decimal('bottom_value_1', 10, 2)->nullable()->default(0)->after('to_date');
            $table->decimal('bottom_value_2', 10, 2)->nullable()->default(0)->after('bottom_value_1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['from_date', 'to_date', 'bottom_value_1', 'bottom_value_2']);
        });
    }
};
