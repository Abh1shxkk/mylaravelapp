<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('dashboard_password_resets') && !Schema::hasColumn('dashboard_password_resets', 'email')) {
            Schema::dropIfExists('dashboard_password_resets');
        }

        if (!Schema::hasTable('dashboard_password_resets')) {
            Schema::create('dashboard_password_resets', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at');
            });
        }
    }

    public function down(): void
    {
        // No down; keep table intact
    }
};





