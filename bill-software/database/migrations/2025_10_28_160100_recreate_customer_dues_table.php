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
        // Drop old table if exists
        Schema::dropIfExists('customer_dues');
        
        // Create new table with correct columns
        Schema::create('customer_dues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('trans_no')->nullable();
            $table->date('invoice_date');
            $table->integer('days_from_invoice')->default(0);
            $table->date('due_date');
            $table->integer('days_from_due')->default(0);
            $table->decimal('trans_amount', 12, 2);
            $table->decimal('debit', 12, 2)->default(0);
            $table->decimal('credit', 12, 2)->default(0);
            $table->boolean('hold')->default(false);
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->index('customer_id');
            $table->index('due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_dues');
    }
};
