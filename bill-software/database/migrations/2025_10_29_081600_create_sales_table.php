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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('series', 10)->default('SZ');
            $table->date('date');
            $table->string('invoice_no', 50)->unique();
            $table->date('due_date')->nullable();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('salesman_id')->nullable()->constrained('sales_men')->onDelete('set null');
            $table->enum('cash_type', ['Y', 'N'])->default('N');
            
            // Financial fields
            $table->decimal('due', 15, 2)->default(0);
            $table->decimal('pdc', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            
            // Tax fields
            $table->decimal('cgst_percent', 5, 2)->default(0);
            $table->decimal('sgst_percent', 5, 2)->default(0);
            $table->decimal('cess_percent', 5, 2)->default(0);
            
            // Amount fields
            $table->integer('case')->default(0);
            $table->integer('box')->default(0);
            $table->decimal('nt_amt', 15, 2)->default(0); // Net Taxable Amount
            $table->decimal('sc', 15, 2)->default(0); // Special Charge
            $table->decimal('ft_amt', 15, 2)->default(0); // Final Taxable Amount
            $table->decimal('dis', 15, 2)->default(0); // Discount
            $table->decimal('scm', 15, 2)->default(0); // Scheme
            $table->decimal('scm_percent', 5, 2)->default(0);
            
            // Tax calculations
            $table->decimal('tax_percent', 5, 2)->default(0);
            $table->decimal('excise', 15, 2)->default(0);
            $table->decimal('tcs', 15, 2)->default(0);
            $table->decimal('sc_percent', 5, 2)->default(0);
            $table->decimal('tax', 15, 2)->default(0);
            $table->decimal('net', 15, 2)->default(0);
            
            // Additional fields
            $table->string('packing', 100)->nullable();
            $table->decimal('packing_nt_amt', 15, 2)->default(0);
            $table->decimal('packing_scm_percent', 5, 2)->default(0);
            $table->decimal('sub_total', 15, 2)->default(0);
            
            $table->string('unit', 50)->nullable();
            $table->decimal('sc_amt', 15, 2)->default(0);
            $table->decimal('scm_amt', 15, 2)->default(0);
            $table->decimal('tax_amt', 15, 2)->default(0);
            
            $table->integer('cl_qty')->default(0);
            $table->decimal('dis_amt', 15, 2)->default(0);
            $table->decimal('net_amt', 15, 2)->default(0);
            
            $table->string('location', 100)->nullable();
            $table->decimal('hs_amt', 15, 2)->default(0);
            
            $table->string('comp', 100)->nullable();
            $table->string('srino', 100)->nullable();
            $table->decimal('cost_gst', 15, 2)->default(0);
            $table->decimal('scm_final', 15, 2)->default(0);
            
            $table->string('volume', 50)->nullable();
            $table->string('batch_code', 100)->nullable();
            
            // Status
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
