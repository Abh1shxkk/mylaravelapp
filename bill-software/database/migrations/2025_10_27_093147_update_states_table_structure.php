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
        Schema::table('states', function (Blueprint $table) {
            // Drop unnecessary columns to match the image (Name, Alter. code, Status)
            $table->dropColumn([
                'code',
                'country_code',
                'gst_state_code',
                'region',
                'is_deleted',
                'created_date',
                'modified_date'
            ]);
            
            // Add alter_code column to match the image
            $table->string('alter_code')->nullable()->after('name');
            
            // Change status to string to match areas table
            $table->string('status')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('states', function (Blueprint $table) {
            // Restore original columns
            $table->string('code', 10)->unique()->after('id');
            $table->string('country_code', 10)->default('IN')->after('alter_code');
            $table->string('gst_state_code', 5)->nullable()->after('country_code');
            $table->string('region')->nullable()->after('gst_state_code');
            $table->tinyInteger('is_deleted')->default(0)->after('status');
            $table->timestamp('created_date')->nullable()->after('is_deleted');
            $table->timestamp('modified_date')->nullable()->after('created_date');
            
            // Remove alter_code column
            $table->dropColumn('alter_code');
            
            // Change status back to tinyInteger
            $table->tinyInteger('status')->default(1)->change();
        });
    }
};
