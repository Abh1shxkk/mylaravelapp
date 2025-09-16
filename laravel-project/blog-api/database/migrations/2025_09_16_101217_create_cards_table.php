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
    Schema::create('cards', function (Blueprint $table) {
        $table->id(); // id column (auto increment primary key)
        $table->string('name'); 
        $table->string('email')->unique(); 
        $table->string('phone'); 
        $table->timestamps(); // created_at and updated_at
    });
}

public function down(): void
{
    Schema::dropIfExists('cards');
}

};
