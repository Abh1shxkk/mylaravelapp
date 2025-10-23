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
        Schema::create('general_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('account_name');
            $table->string('account_code', 50)->nullable();
            $table->string('account_type', 100);
            $table->decimal('opening_balance', 15, 2)->nullable()->default(0);
            $table->char('balance_type', 1)->nullable()->default('C')->comment('D=Debit, C=Credit');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_ledgers');
    }
};
