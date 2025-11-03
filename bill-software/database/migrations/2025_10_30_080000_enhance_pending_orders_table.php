<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Enhance pending_orders table with PO number, expected delivery, and status tracking
     */
    public function up(): void
    {
        Schema::table('pending_orders', function (Blueprint $table) {
            // Add PO Number (unique identifier)
            $table->string('po_number', 50)->nullable()->after('id')->comment('Purchase Order Number');
            
            // Add Expected Delivery Date
            $table->date('expected_delivery_date')->nullable()->after('order_date')->comment('Expected Delivery Date');
            
            // Add Received Quantity tracking
            $table->decimal('received_qty', 12, 2)->default(0)->after('quantity')->comment('Quantity Received So Far');
            $table->decimal('pending_qty', 12, 2)->default(0)->after('received_qty')->comment('Pending Quantity');
            
            // Add Total Amount
            $table->decimal('total_amount', 15, 2)->default(0)->after('cost')->comment('Total Order Amount');
            $table->decimal('received_amount', 15, 2)->default(0)->after('total_amount')->comment('Amount Received So Far');
            
            // Add Supplier Details (for quick reference)
            $table->string('supplier_name', 255)->nullable()->after('supplier_id')->comment('Supplier Name');
            $table->string('supplier_code', 50)->nullable()->after('supplier_name')->comment('Supplier Code');
            
            // Add Status (enhanced)
            $table->enum('po_status', ['pending', 'partial', 'completed', 'cancelled'])->default('pending')->after('status')->comment('PO Status');
            
            // Add Email sent flag
            $table->boolean('email_sent')->default(false)->after('po_status')->comment('Email sent to supplier');
            $table->timestamp('email_sent_at')->nullable()->after('email_sent')->comment('When email was sent');
            
            // Add Created By
            $table->string('created_by', 100)->nullable()->after('remarks')->comment('User who created PO');
            
            // Add indexes for performance
            $table->index('po_number');
            $table->index('supplier_id');
            $table->index('po_status');
            $table->index('order_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pending_orders', function (Blueprint $table) {
            $table->dropColumn([
                'po_number', 'expected_delivery_date', 'received_qty', 'pending_qty',
                'total_amount', 'received_amount', 'supplier_name', 'supplier_code',
                'po_status', 'email_sent', 'email_sent_at', 'created_by'
            ]);
        });
    }
};
