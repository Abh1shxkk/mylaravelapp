<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('customers', function (Blueprint $table) {
        $table->string('country_code', 10)->nullable()->after('city');
        $table->string('country_name', 100)->nullable()->after('country_code');
        $table->string('state_code', 10)->nullable()->after('country_name');
        $table->string('state_name', 100)->nullable()->after('state_code');
    });
}
};
