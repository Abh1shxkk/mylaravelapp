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
        Schema::table('divisional_managers', function (Blueprint $table) {
            // Drop old columns that are not needed
            $table->dropColumn([
                'designation',
                'reporting_to', 
                'target_amount',
                'is_deleted',
                'created_date',
                'modified_date'
            ]);
            
            // Add new telephone field
            $table->string('telephone')->nullable()->after('address');
            
            // Rename reporting_to to c_mgr (but we already dropped it, so add new)
            $table->string('c_mgr')->nullable()->after('status');
            
            // Modify existing fields to match image requirements
            $table->string('status')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('divisional_managers', function (Blueprint $table) {
            // Add back old columns
            $table->string('designation')->nullable();
            $table->string('reporting_to')->nullable();
            $table->decimal('target_amount', 10, 2)->nullable();
            $table->integer('is_deleted')->default(0);
            $table->datetime('created_date')->nullable();
            $table->datetime('modified_date')->nullable();
            
            // Drop new columns
            $table->dropColumn(['telephone', 'c_mgr']);
        });
    }
};
