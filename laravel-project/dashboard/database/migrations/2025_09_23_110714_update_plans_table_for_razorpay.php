<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {DB::table('plans')->where('slug', 'basic')->update(['interval' => 'month', 'interval_count' => 3]);
DB::table('plans')->where('slug', 'premium')->update(['interval' => 'year', 'interval_count' => 1]);
        Schema::table('plans', function (Blueprint $table) {
            $table->string('interval')->default('month')->after('price');
            $table->integer('interval_count')->default(1)->after('interval');
        });
    }

    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['interval', 'interval_count']);
        });
    }
};