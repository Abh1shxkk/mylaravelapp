<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('name');
            $table->string('country_code', 10)->default('IN');
            $table->string('gst_state_code', 5)->nullable();
            $table->string('region')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_deleted')->default(0);
            $table->timestamp('created_date')->nullable();
            $table->timestamp('modified_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
