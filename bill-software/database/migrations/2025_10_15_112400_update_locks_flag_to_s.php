<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all existing records to 'S'
        DB::table('items')->update(['locks_flag' => 'S']);
        
        // Change the column default to 'S'
        Schema::table('items', function (Blueprint $table) {
            $table->char('locks_flag', 1)->default('S')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to 'N' default
        DB::table('items')->update(['locks_flag' => 'N']);
        
        Schema::table('items', function (Blueprint $table) {
            $table->char('locks_flag', 1)->default('N')->change();
        });
    }
};
