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
        Schema::table('areas', function (Blueprint $table) {
            // Check and drop existing columns that are not needed
            $columnsToCheck = ['code', 'description', 'state_code', 'region', 'created_date', 'modified_date'];
            
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('areas', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
        
        Schema::table('areas', function (Blueprint $table) {
            // Add new columns to match the image
            if (!Schema::hasColumn('areas', 'alter_code')) {
                $table->string('alter_code')->nullable()->after('name');
            }
            
            // Add is_deleted column if it doesn't exist
            if (!Schema::hasColumn('areas', 'is_deleted')) {
                $table->tinyInteger('is_deleted')->default(0);
            }
        });
        
        // Change status to string type in a separate operation
        Schema::table('areas', function (Blueprint $table) {
            if (Schema::hasColumn('areas', 'status')) {
                $table->string('status')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('areas', function (Blueprint $table) {
            // Restore original columns if they don't exist
            if (!Schema::hasColumn('areas', 'code')) {
                $table->string('code')->nullable();
            }
            if (!Schema::hasColumn('areas', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('areas', 'state_code')) {
                $table->string('state_code')->nullable();
            }
            if (!Schema::hasColumn('areas', 'region')) {
                $table->string('region')->nullable();
            }
            if (!Schema::hasColumn('areas', 'created_date')) {
                $table->datetime('created_date')->nullable();
            }
            if (!Schema::hasColumn('areas', 'modified_date')) {
                $table->datetime('modified_date')->nullable();
            }
            
            // Remove new columns
            if (Schema::hasColumn('areas', 'alter_code')) {
                $table->dropColumn('alter_code');
            }
            
            // Change status back to integer
            if (Schema::hasColumn('areas', 'status')) {
                $table->integer('status')->nullable()->change();
            }
        });
    }
};
