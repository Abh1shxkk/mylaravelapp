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
        Schema::table('pending_orders', function (Blueprint $table) {
            // Remove unused columns
            $table->dropColumn([
                'rate',
                'tax_percent',
                'discount_percent',
                'cost',
                'scm_percent',
                'quantity',
                'image'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pending_orders', function (Blueprint $table) {
            // Restore columns if needed
            $table->decimal('rate', 10, 2)->default(0)->after('order_date');
            $table->decimal('tax_percent', 5, 2)->default(0)->after('rate');
            $table->decimal('discount_percent', 5, 2)->default(0)->after('tax_percent');
            $table->decimal('cost', 10, 2)->default(0)->after('discount_percent');
            $table->decimal('scm_percent', 5, 2)->default(0)->after('cost');
            $table->integer('quantity')->default(0)->after('scm_percent');
            $table->string('image')->nullable()->after('other_order');
        });
    }
};
