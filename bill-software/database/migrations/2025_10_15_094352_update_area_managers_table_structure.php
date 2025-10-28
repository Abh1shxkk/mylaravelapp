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
        Schema::table('area_managers', function (Blueprint $table) {
            // Drop unnecessary columns to match the image fields
            $table->dropColumn([
                'designation',
                'target_amount',
                'is_deleted',
                'created_date',
                'modified_date'
            ]);
            
            // Add telephone column
            $table->string('telephone')->nullable()->after('address');
            
            // Rename reporting_to to reg_mgr to match the image
            $table->renameColumn('reporting_to', 'reg_mgr');
            
            // Change status to string to match areas table
            $table->string('status')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('area_managers', function (Blueprint $table) {
            // Restore original columns
            $table->string('designation')->default('Area Manager')->after('address');
            $table->decimal('target_amount', 15, 2)->default(0)->after('designation');
            $table->tinyInteger('is_deleted')->default(0)->after('status');
            $table->timestamp('created_date')->nullable()->after('is_deleted');
            $table->timestamp('modified_date')->nullable()->after('created_date');
            
            // Remove telephone column
            $table->dropColumn('telephone');
            
            // Rename reg_mgr back to reporting_to
            $table->renameColumn('reg_mgr', 'reporting_to');
            
            // Change status back to tinyInteger
            $table->tinyInteger('status')->default(1)->change();
        });
    }
};
