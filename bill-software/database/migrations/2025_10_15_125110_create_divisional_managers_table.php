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
        Schema::create('divisional_managers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->text('address')->nullable();
            $table->string('designation')->default('Divisional Manager');
            $table->string('reporting_to')->nullable();
            $table->decimal('target_amount', 15, 2)->default(0);
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
        Schema::dropIfExists('divisional_managers');
    }
};
