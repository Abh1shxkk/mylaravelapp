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
            // Add new fields from the image
            $table->string('telephone')->nullable()->after('mobile');
            $table->string('city')->nullable()->after('address');
            $table->string('pin')->nullable()->after('city');
            $table->char('sales_type', 1)->default('S')->comment('S=Sales Man, C=Collection Boy, B=Both')->after('email');
            $table->char('delivery_type', 1)->default('S')->comment('S=Sales Man, D=Delivery Man, B=Both')->after('sales_type');
            $table->string('area_mgr_code')->default('00')->after('designation');
            $table->string('area_mgr_name')->default('DIRECT')->after('area_mgr_code');
            $table->decimal('monthly_target', 15, 2)->default(0.00)->after('target_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_men', function (Blueprint $table) {
            $table->dropColumn([
                'telephone',
                'city', 
                'pin',
                'sales_type',
                'delivery_type',
                'area_mgr_code',
                'area_mgr_name',
                'monthly_target'
            ]);
        });
    }
};
