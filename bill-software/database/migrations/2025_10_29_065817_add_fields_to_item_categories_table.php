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
        Schema::table('item_categories', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            $table->string('alter_code')->nullable()->after('name');
            $table->string('status')->nullable()->after('alter_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_categories', function (Blueprint $table) {
            $table->dropColumn(['name', 'alter_code', 'status']);
        });
    }
};
