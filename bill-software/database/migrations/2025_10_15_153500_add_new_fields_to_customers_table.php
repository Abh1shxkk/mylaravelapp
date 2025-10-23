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
        Schema::table('customers', function (Blueprint $table) {
            // Additional address fields
            $table->string('address_line2')->nullable()->after('address');
            $table->string('address_line3')->nullable()->after('address_line2');
            $table->string('address2')->nullable()->after('pin_code');
            $table->string('address2_line2')->nullable()->after('address2');
            $table->string('address2_line3')->nullable()->after('address2_line2');
            
            // Anniversary day
            $table->date('anniversary_day')->nullable()->after('birth_day');
            
            // Sales man, area, route names
            $table->string('sales_man_name')->nullable()->after('sales_man_code');
            $table->string('area_name')->nullable()->after('area_code');
            $table->string('route_name')->nullable()->after('route_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'address_line2',
                'address_line3',
                'address2',
                'address2_line2',
                'address2_line3',
                'anniversary_day',
                'sales_man_name',
                'area_name',
                'route_name'
            ]);
        });
    }
};
