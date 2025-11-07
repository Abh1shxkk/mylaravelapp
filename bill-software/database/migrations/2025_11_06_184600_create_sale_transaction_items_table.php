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
        Schema::create('sale_transaction_items', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key to Master Table
            $table->unsignedBigInteger('sale_transaction_id');
            
            // Item Info
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('item_code', 100);
            $table->string('item_name', 255);
            
            // Batch Info
            $table->string('batch_no', 100)->nullable();
            $table->string('expiry_date', 20)->nullable(); // MM/YY format
            
            // Quantities
            $table->decimal('qty', 15, 3)->default(0); // Quantity
            $table->decimal('free_qty', 15, 3)->default(0); // Free Quantity
            
            // Rates
            $table->decimal('sale_rate', 15, 2)->default(0); // Sale Rate
            $table->decimal('mrp', 15, 2)->default(0); // MRP
            
            // Discount
            $table->decimal('discount_percent', 10, 2)->default(0); // Discount %
            $table->decimal('discount_amount', 15, 2)->default(0); // Calculated Discount Amount
            
            // Amounts
            $table->decimal('amount', 15, 2)->default(0); // Line Total (Qty × Rate)
            $table->decimal('net_amount', 15, 2)->default(0); // After Discount + Tax
            
            // GST Data
            $table->decimal('cgst_percent', 10, 2)->default(0);
            $table->decimal('sgst_percent', 10, 2)->default(0);
            $table->decimal('cess_percent', 10, 2)->default(0);
            $table->decimal('cgst_amount', 15, 2)->default(0);
            $table->decimal('sgst_amount', 15, 2)->default(0);
            $table->decimal('cess_amount', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0); // Total Tax
            
            // Additional Info
            $table->string('unit', 50)->nullable();
            $table->string('packing', 100)->nullable();
            $table->string('company_name', 255)->nullable();
            $table->string('hsn_code', 50)->nullable();
            
            // Row Order
            $table->integer('row_order')->default(0);
            
            $table->timestamps();
            
            // Foreign Keys
            $table->foreign('sale_transaction_id')->references('id')->on('sale_transactions')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('set null');
            
            // Indexes
            $table->index('sale_transaction_id');
            $table->index('item_id');
            $table->index('item_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_transaction_items');
    }
};
