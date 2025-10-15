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
            // Drop old fields if they exist
            if (Schema::hasColumn('items', 'bottom_value_1')) {
                $table->dropColumn('bottom_value_1');
            }
            if (Schema::hasColumn('items', 'bottom_value_2')) {
                $table->dropColumn('bottom_value_2');
            }
            
            // Add new fields
            $table->decimal('scheme_plus_value', 10, 2)->nullable()->default(0)->after('to_date');
            $table->decimal('scheme_minus_value', 10, 2)->nullable()->default(0)->after('scheme_plus_value');
            $table->string('category_2', 100)->nullable()->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['scheme_plus_value', 'scheme_minus_value', 'category_2']);
        });
    }
};
