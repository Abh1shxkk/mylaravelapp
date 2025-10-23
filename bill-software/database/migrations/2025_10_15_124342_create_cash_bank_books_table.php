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
        Schema::create('cash_bank_books', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->string('transaction_type', 50)->comment('Cash or Bank');
            $table->string('particulars');
            $table->string('voucher_no', 50)->nullable();
            $table->decimal('debit', 15, 2)->nullable()->default(0);
            $table->decimal('credit', 15, 2)->nullable()->default(0);
            $table->decimal('balance', 15, 2)->nullable()->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_bank_books');
    }
};
