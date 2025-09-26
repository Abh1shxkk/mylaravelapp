<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            if (!Schema::hasColumn('plans', 'duration_value')) {
                $table->unsignedInteger('duration_value')->nullable()->after('billing_period');
            }
            if (!Schema::hasColumn('plans', 'duration_unit')) {
                $table->string('duration_unit')->nullable()->after('duration_value'); // minutes,hours,days,weeks,months,years
            }
            if (!Schema::hasColumn('plans', 'stripe_price_id')) {
                $table->string('stripe_price_id')->nullable()->after('razorpay_plan_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            if (Schema::hasColumn('plans', 'duration_unit')) {
                $table->dropColumn('duration_unit');
            }
            if (Schema::hasColumn('plans', 'duration_value')) {
                $table->dropColumn('duration_value');
            }
            if (Schema::hasColumn('plans', 'stripe_price_id')) {
                $table->dropColumn('stripe_price_id');
            }
        });
    }
};
