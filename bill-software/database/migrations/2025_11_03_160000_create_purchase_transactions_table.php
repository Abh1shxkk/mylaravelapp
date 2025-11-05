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
        Schema::create('purchase_transactions', function (Blueprint $table) {
            // Primary Key
            $table->id();
            $table->string('trn_no', 50)->unique()->comment('Transaction Number (Auto-generated)');
            
            // Header Information
            $table->date('bill_date')->comment('Bill/Ledger Date');
            $table->string('bill_no', 100)->nullable()->comment('Supplier Bill Number');
            $table->unsignedBigInteger('supplier_id')->comment('FK to suppliers table');
            
            // Additional Dates
            $table->date('receive_date')->nullable()->comment('Material Receive Date');
            $table->date('due_date')->nullable()->comment('Payment Due Date');
            
            // Payment Info
            $table->char('cash_flag', 1)->default('N')->comment('Cash Payment (Y/N)');
            $table->char('transfer_flag', 1)->default('N')->comment('Transfer Payment (Y/N)');
            
            // Remarks
            $table->text('remarks')->nullable()->comment('Transaction Remarks');
            
            // Summary Amounts (Calculated from items)
            $table->decimal('nt_amount', 15, 2)->default(0.00)->comment('Total NT Amount');
            $table->decimal('sc_amount', 15, 2)->default(0.00)->comment('Special Commission Amount');
            $table->decimal('scm_amount', 15, 2)->default(0.00)->comment('Scheme Amount');
            $table->decimal('dis_amount', 15, 2)->default(0.00)->comment('Discount Amount');
            $table->decimal('less_amount', 15, 2)->default(0.00)->comment('Less Amount');
            $table->decimal('tax_amount', 15, 2)->default(0.00)->comment('Total Tax (CGST+SGST+CESS)');
            $table->decimal('net_amount', 15, 2)->default(0.00)->comment('Net Amount (NT + Tax)');
            $table->decimal('scm_percent', 8, 3)->default(0.000)->comment('Scheme Percentage');
            $table->decimal('tcs_amount', 15, 2)->default(0.00)->comment('TCS Amount');
            $table->decimal('dis1_amount', 15, 2)->default(0.00)->comment('Discount 1 Amount');
            $table->decimal('tof_amount', 15, 2)->default(0.00)->comment('TOF Amount');
            $table->decimal('inv_amount', 15, 2)->default(0.00)->comment('Final Invoice Amount');
            
            // Status & Tracking
            $table->enum('status', ['draft', 'completed', 'cancelled'])->default('draft');
            $table->string('order_no', 50)->nullable()->comment('Reference to pending order if any');
            
            // Audit Fields
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            
            // Foreign Keys
            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers')->onDelete('restrict');
            
            // Indexes
            $table->index('bill_date');
            $table->index('supplier_id');
            $table->index('trn_no');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_transactions');
    }
};
