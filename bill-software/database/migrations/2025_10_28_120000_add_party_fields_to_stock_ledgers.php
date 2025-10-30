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
        Schema::table('stock_ledgers', function (Blueprint $table) {
            // Transaction number
            $table->string('trans_no')->nullable()->unique()->after('id');
            
            // Party information (Customer/Supplier)
            $table->unsignedBigInteger('customer_id')->nullable()->after('batch_id');
            $table->unsignedBigInteger('supplier_id')->nullable()->after('customer_id');
            
            // Free items
            $table->decimal('free_quantity', 12, 2)->default(0)->after('quantity');
            
            // Sales Man
            $table->unsignedBigInteger('salesman_id')->nullable()->after('free_quantity');
            
            // Bill information
            $table->string('bill_number')->nullable()->after('salesman_id');
            $table->date('bill_date')->nullable()->after('bill_number');
            $table->decimal('rate', 12, 2)->default(0)->after('bill_date');
            
            // Running balance (calculated field)
            $table->decimal('running_balance', 12, 2)->default(0)->after('closing_qty');
            
            // Indexes for performance
            $table->index('customer_id');
            $table->index('supplier_id');
            $table->index('salesman_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_ledgers', function (Blueprint $table) {
            $table->dropIndex(['customer_id']);
            $table->dropIndex(['supplier_id']);
            $table->dropIndex(['salesman_id']);
            
            $table->dropColumn([
                'trans_no',
                'customer_id',
                'supplier_id',
                'free_quantity',
                'salesman_id',
                'bill_number',
                'bill_date',
                'rate',
                'running_balance'
            ]);
        });
    }
};
