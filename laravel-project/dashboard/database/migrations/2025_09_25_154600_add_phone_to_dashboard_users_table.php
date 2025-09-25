<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('dashboard_users', function (Blueprint $table) {
            if (!Schema::hasColumn('dashboard_users', 'phone')) {
                $table->string('phone')->nullable()->unique()->after('email');
            }
        });
    }

    public function down()
    {
        Schema::table('dashboard_users', function (Blueprint $table) {
            if (Schema::hasColumn('dashboard_users', 'phone')) {
                $table->dropUnique(['phone']);
                $table->dropColumn('phone');
            }
        });
    }
};
