<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id('item_id');
            $table->foreignId('invoice_id')->nullable()->constrained('invoices','invoice_id');
            $table->foreignId('product_id')->nullable()->constrained('items');
            $table->string('product_name')->nullable();
            $table->text('product_description')->nullable();
            $table->string('hsn_code')->nullable();
            $table->decimal('quantity',15,2)->nullable();
            $table->string('unit')->nullable();
            $table->decimal('unit_price',15,2)->nullable();
            $table->decimal('discount_percent',10,2)->nullable();
            $table->decimal('discount_amount',15,2)->nullable();
            $table->decimal('line_total',15,2)->nullable();
            $table->decimal('tax_rate',10,2)->nullable();
            $table->decimal('tax_amount',15,2)->nullable();
            $table->decimal('cgst_rate',10,2)->nullable();
            $table->decimal('sgst_rate',10,2)->nullable();
            $table->decimal('igst_rate',10,2)->nullable();
            $table->decimal('cess_rate',10,2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
