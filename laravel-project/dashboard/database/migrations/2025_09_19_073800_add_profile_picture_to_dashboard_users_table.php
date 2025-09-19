<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('dashboard_users', function (Blueprint $table) {
            if (!Schema::hasColumn('dashboard_users', 'profile_picture')) {
                $table->string('profile_picture')->nullable()->after('email');
            }
        });
    }

    public function down()
    {
        Schema::table('dashboard_users', function (Blueprint $table) {
            if (Schema::hasColumn('dashboard_users', 'profile_picture')) {
                $table->dropColumn('profile_picture');
            }
        });
    }
};



