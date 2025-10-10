<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->decimal('discount_percent', 5, 2)->default(0)->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0)->nullable();
        });
    }


    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['discount_percent', 'discount_amount']);
        });
    }
};