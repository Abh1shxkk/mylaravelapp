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
        Schema::table('sale_ledgers', function (Blueprint $table) {
            // Drop old unnecessary columns
            $columns = [
                'sale_date',
                'invoice_no',
                'customer_name',
                'amount',
                'tax_amount',
                'total_amount',
                'payment_status',
                'description',
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('sale_ledgers', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_ledgers', function (Blueprint $table) {
            // Restore old columns if needed
            $table->date('sale_date')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('customer_name')->nullable();
            $table->decimal('amount', 12, 2)->nullable();
            $table->decimal('tax_amount', 12, 2)->nullable();
            $table->decimal('total_amount', 12, 2)->nullable();
            $table->string('payment_status')->nullable();
            $table->text('description')->nullable();
        });
    }
};
