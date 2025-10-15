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
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('area_code')->nullable();
            $table->string('sales_man_code')->nullable();
            $table->decimal('distance_km', 8, 2)->default(0);
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
        Schema::dropIfExists('routes');
    }
};
