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
        Schema::table('purchases', function (Blueprint $table) {
            // Header Fields
            $table->date('bill_date')->nullable()->after('id');
            $table->string('day_name', 20)->nullable()->after('bill_date');
            $table->string('supplier')->nullable()->after('day_name');
            $table->string('bill_no', 50)->nullable()->after('supplier');
            $table->string('trn_no', 50)->nullable()->after('bill_no');
            $table->date('receive_date')->nullable()->after('trn_no');
            $table->string('cash', 1)->default('N')->after('receive_date');
            $table->string('transfer', 1)->default('N')->after('cash');
            $table->text('remarks')->nullable()->after('transfer');
            $table->date('due_date')->nullable()->after('remarks');
            
            // Item Details (stored as JSON array for multiple items)
            $table->json('items')->nullable()->after('due_date');
            
            // Totals and Calculations
            $table->decimal('total_amount', 12, 2)->default(0)->after('items');
            $table->decimal('net_amount', 12, 2)->default(0)->after('total_amount');
            $table->decimal('tax_amount', 12, 2)->default(0)->after('net_amount');
            $table->decimal('discount_amount', 12, 2)->default(0)->after('tax_amount');
            
            // Soft deletes
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn([
                'bill_date',
                'day_name',
                'supplier',
                'bill_no',
                'trn_no',
                'receive_date',
                'cash',
                'transfer',
                'remarks',
                'due_date',
                'items',
                'total_amount',
                'net_amount',
                'tax_amount',
                'discount_amount',
                'deleted_at'
            ]);
        });
    }
};
