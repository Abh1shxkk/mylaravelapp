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
            // Drop old unnecessary columns if they exist
            if (Schema::hasColumn('sale_ledgers', 'sale_date')) {
                $table->dropColumn('sale_date');
            }
            if (Schema::hasColumn('sale_ledgers', 'invoice_no')) {
                $table->dropColumn('invoice_no');
            }
            if (Schema::hasColumn('sale_ledgers', 'customer_name')) {
                $table->dropColumn('customer_name');
            }
            if (Schema::hasColumn('sale_ledgers', 'amount')) {
                $table->dropColumn('amount');
            }
            if (Schema::hasColumn('sale_ledgers', 'tax_amount')) {
                $table->dropColumn('tax_amount');
            }
            if (Schema::hasColumn('sale_ledgers', 'total_amount')) {
                $table->dropColumn('total_amount');
            }
            if (Schema::hasColumn('sale_ledgers', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
            if (Schema::hasColumn('sale_ledgers', 'description')) {
                $table->dropColumn('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_ledgers', function (Blueprint $table) {
            // Restore old columns if rollback is needed
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
