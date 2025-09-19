<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('dashboard_users', function (Blueprint $table) {
            $table->string('phone', 15)->nullable()->after('email');
            $table->string('profile_picture')->nullable()->after('phone');
            $table->text('bio')->nullable()->after('profile_picture');
            $table->enum('role', ['admin', 'manager', 'user'])->default('user')->after('bio');
        });
    }

    public function down()
    {
        Schema::table('dashboard_users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'profile_picture', 'bio', 'role']);
        });
    }
};