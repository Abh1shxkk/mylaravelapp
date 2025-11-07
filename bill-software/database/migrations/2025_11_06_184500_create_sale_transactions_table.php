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
        Schema::create('sale_transactions', function (Blueprint $table) {
            $table->id();
            
            // Transaction Info
            $table->string('invoice_no', 100)->unique();
            $table->string('series', 10)->default('SB'); // SB or S2
            $table->date('sale_date');
            $table->date('due_date')->nullable();
            
            // Customer & Salesman
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('salesman_id')->nullable();
            
            // Flags
            $table->char('cash_flag', 1)->default('N'); // Y/N
            $table->char('transfer_flag', 1)->default('N'); // Y/N
            $table->text('remarks')->nullable();
            
            // Summary Amounts
            $table->decimal('nt_amount', 15, 2)->default(0); // N.T.Amt - Total before discount
            $table->decimal('sc_amount', 15, 2)->default(0); // SC Amount
            $table->decimal('ft_amount', 15, 2)->default(0); // F.T.Amt - Total after discount (before tax)
            $table->decimal('dis_amount', 15, 2)->default(0); // Discount Amount
            $table->decimal('scm_amount', 15, 2)->default(0); // Scheme Amount
            $table->decimal('tax_amount', 15, 2)->default(0); // Total Tax (CGST + SGST + CESS)
            $table->decimal('net_amount', 15, 2)->default(0); // Final Net Amount
            $table->decimal('scm_percent', 10, 3)->default(0); // Scheme Percentage
            
            // Additional Amounts
            $table->decimal('tcs_amount', 15, 2)->default(0); // TCS Amount
            $table->decimal('excise_amount', 15, 2)->default(0); // Excise Amount
            
            // Payment Info
            $table->decimal('paid_amount', 15, 2)->default(0); // Amount Paid
            $table->decimal('balance_amount', 15, 2)->default(0); // Balance Due
            $table->string('payment_status', 50)->default('pending'); // pending/partial/paid
            
            // Status & Audit
            $table->string('status', 50)->default('completed'); // completed/cancelled
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            
            $table->timestamps();
            
            // Foreign Keys
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('salesman_id')->references('id')->on('sales_men')->onDelete('set null');
            
            // Indexes
            $table->index('sale_date');
            $table->index('customer_id');
            $table->index('invoice_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_transactions');
    }
};
