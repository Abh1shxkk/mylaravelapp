<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Ensure dashboard_users has stripe_customer_id
        if (Schema::hasTable('dashboard_users') && !Schema::hasColumn('dashboard_users', 'stripe_customer_id')) {
            Schema::table('dashboard_users', function (Blueprint $table) {
                $table->string('stripe_customer_id')->nullable()->after('password');
            });
        }
    }

    public function down(): void
    {
        // Do not drop automatically (safe no-op). If you need to remove, do it manually.
    }
};
