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
        Schema::table('routes', function (Blueprint $table) {
            // Drop unnecessary columns to match the image (Name, Alter. code, Status)
            $table->dropColumn([
                'code',
                'description', 
                'area_code',
                'sales_man_code',
                'distance_km',
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
        Schema::table('routes', function (Blueprint $table) {
            // Restore original columns
            $table->string('code')->unique()->after('id');
            $table->string('description')->nullable()->after('alter_code');
            $table->string('area_code')->nullable()->after('description');
            $table->string('sales_man_code')->nullable()->after('area_code');
            $table->decimal('distance_km', 8, 2)->default(0)->after('sales_man_code');
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
