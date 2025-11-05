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
        Schema::create('purchase_transaction_items', function (Blueprint $table) {
            // Primary Key
            $table->id();
            
            // Foreign Key to Master
            $table->unsignedBigInteger('purchase_transaction_id')->comment('FK to purchase_transactions');
            
            // Item Information
            $table->unsignedBigInteger('item_id')->nullable()->comment('FK to items table (nullable if item not in master)');
            $table->string('item_code', 50)->comment('Item Code (for reference)');
            $table->string('item_name', 255)->comment('Item Name (for reference)');
            
            // Batch & Expiry
            $table->string('batch_no', 100)->nullable()->comment('Batch Number');
            $table->date('expiry_date')->nullable()->comment('Expiry Date');
            
            // Quantities
            $table->decimal('qty', 10, 2)->default(0)->comment('Purchase Quantity');
            $table->decimal('free_qty', 10, 2)->default(0)->comment('Free Quantity');
            
            // Rates & Prices
            $table->decimal('pur_rate', 15, 2)->comment('Purchase Rate per unit');
            $table->decimal('mrp', 15, 2)->nullable()->comment('MRP');
            
            // Discount
            $table->decimal('dis_percent', 8, 3)->default(0.000)->comment('Discount Percentage');
            
            // Calculated Amounts
            $table->decimal('amount', 15, 2)->comment('Amount = (Qty × Pur.Rate) - Discount');
            
            // GST Details (from item master but stored for history)
            $table->decimal('cgst_percent', 8, 3)->default(0.000)->comment('CGST %');
            $table->decimal('sgst_percent', 8, 3)->default(0.000)->comment('SGST %');
            $table->decimal('cess_percent', 8, 3)->default(0.000)->comment('CESS %');
            
            $table->decimal('cgst_amount', 15, 2)->default(0.00)->comment('CGST Amount');
            $table->decimal('sgst_amount', 15, 2)->default(0.00)->comment('SGST Amount');
            $table->decimal('cess_amount', 15, 2)->default(0.00)->comment('CESS Amount');
            $table->decimal('tax_amount', 15, 2)->default(0.00)->comment('Total Tax (CGST+SGST+CESS)');
            
            $table->decimal('net_amount', 15, 2)->default(0.00)->comment('Net Amount (Amount + Tax)');
            
            // Cost Calculations
            $table->decimal('cost', 15, 2)->default(0.00)->comment('Cost per unit (Amount/Qty)');
            $table->decimal('cost_gst', 15, 2)->default(0.00)->comment('Cost+GST per unit (Net/Qty)');
            
            // Additional Fields (from detailed info section)
            $table->string('unit', 50)->nullable()->comment('Unit');
            $table->string('packing', 100)->nullable()->comment('Packing (e.g., 1*10)');
            $table->string('company_name', 255)->nullable()->comment('Company Name');
            $table->string('location', 100)->nullable()->comment('Storage Location');
            
            // Row Order
            $table->integer('row_order')->default(0)->comment('Display order in transaction');
            
            // Audit Fields
            $table->timestamps();
            
            // Foreign Keys
            $table->foreign('purchase_transaction_id')->references('id')->on('purchase_transactions')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('restrict');
            
            // Indexes
            $table->index('purchase_transaction_id');
            $table->index('item_id');
            $table->index('batch_no');
            $table->index('expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_transaction_items');
    }
};
