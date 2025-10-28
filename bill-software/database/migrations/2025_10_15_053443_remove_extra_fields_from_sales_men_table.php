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
        Schema::table('sales_men', function (Blueprint $table) {
            // Remove fields that are not in the image
            $table->dropColumn([
                'designation',
                'target_amount', 
                'commission_percent'
            ]);
            
            // Change status from tinyint to string to match the image
            $table->string('status')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_men', function (Blueprint $table) {
            // Restore the removed fields
            $table->string('designation')->nullable()->after('address');
            $table->decimal('target_amount', 15, 2)->default(0)->after('area_mgr_name');
            $table->decimal('commission_percent', 5, 2)->default(0)->after('target_amount');
            
            // Change status back to tinyint
            $table->tinyInteger('status')->default(1)->change();
        });
    }
};
