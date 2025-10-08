<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id('invoice_id');
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('company_id')->nullable()->constrained('companies');
            $table->string('company_name')->nullable();
            $table->text('company_address')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_gst')->nullable();
            $table->foreignId('customer_id')->nullable()->constrained('customers');
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->text('customer_address')->nullable();
            $table->string('customer_gst')->nullable();
            $table->string('customer_state')->nullable();
            $table->string('customer_state_code')->nullable();
            $table->decimal('subtotal',15,2)->nullable();
            $table->decimal('tax_amount',15,2)->nullable();
            $table->decimal('discount_amount',15,2)->nullable();
            $table->decimal('total_amount',15,2)->nullable();
            $table->decimal('paid_amount',15,2)->nullable();
            $table->decimal('balance_amount',15,2)->nullable();
            $table->decimal('cgst_amount',15,2)->nullable();
            $table->decimal('sgst_amount',15,2)->nullable();
            $table->decimal('igst_amount',15,2)->nullable();
            $table->decimal('cess_amount',15,2)->nullable();
            $table->text('notes')->nullable();
            $table->text('terms_conditions')->nullable();
            $table->text('payment_terms')->nullable();
            $table->string('currency')->nullable();
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users','user_id');
            $table->foreignId('updated_by')->nullable()->constrained('users','user_id');
            $table->boolean('is_deleted')->nullable()->default(false);
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
