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
                $table->string('phone', 30)->nullable()->after('profile_picture');
            }
            if (!Schema::hasColumn('dashboard_users', 'bio')) {
                $table->text('bio')->nullable()->after('phone');
            }
        });
    }

    public function down()
    {
        Schema::table('dashboard_users', function (Blueprint $table) {
            if (Schema::hasColumn('dashboard_users', 'bio')) {
                $table->dropColumn('bio');
            }
            if (Schema::hasColumn('dashboard_users', 'phone')) {
                $table->dropColumn('phone');
            }
        });
    }
};



