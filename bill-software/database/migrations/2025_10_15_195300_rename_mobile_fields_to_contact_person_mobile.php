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
        Schema::table('general_ledgers', function (Blueprint $table) {
            // Rename mobile to mobile_1 (Contact Person 1 Mobile)
            $table->renameColumn('mobile', 'mobile_1');
            // Rename mobile_additional to mobile_2 (Contact Person 2 Mobile)
            $table->renameColumn('mobile_additional', 'mobile_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('general_ledgers', function (Blueprint $table) {
            $table->renameColumn('mobile_1', 'mobile');
            $table->renameColumn('mobile_2', 'mobile_additional');
        });
    }
};
