<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoice_settings', function (Blueprint $table) {
            $table->id('setting_id');
            $table->string('setting_key')->nullable();
            $table->text('setting_value')->nullable();
            $table->string('setting_type')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreignId('updated_by')->nullable()->constrained('users','user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_settings');
    }
};
