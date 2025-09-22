<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('dashboard_users', function (Blueprint $table) {
            $table->string('provider')->nullable()->after('email'); // e.g., 'google'
        });
    }

    public function down()
    {
        Schema::table('dashboard_users', function (Blueprint $table) {
            $table->dropColumn('provider');
        });
    }
};