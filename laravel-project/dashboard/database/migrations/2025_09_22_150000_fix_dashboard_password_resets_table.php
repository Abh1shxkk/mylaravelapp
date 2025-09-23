<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('dashboard_password_resets')) {
            Schema::create('dashboard_password_resets', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at');
            });
            return;
        }

        Schema::table('dashboard_password_resets', function (Blueprint $table) {
            if (!Schema::hasColumn('dashboard_password_resets', 'email')) {
                $table->string('email')->primary();
            }
            if (!Schema::hasColumn('dashboard_password_resets', 'token')) {
                $table->string('token');
            }
            if (!Schema::hasColumn('dashboard_password_resets', 'created_at')) {
                $table->timestamp('created_at');
            }
        });
    }

    public function down(): void
    {
        // Do not drop table; it's essential for password resets
    }
};





