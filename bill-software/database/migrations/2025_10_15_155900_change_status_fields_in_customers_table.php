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
        Schema::table('customers', function (Blueprint $table) {
            // Change status from tinyint to varchar to accept text values
            $table->string('status', 10)->nullable()->change();
            
            // Change invoice_export from tinyint to varchar for Y/N values
            $table->string('invoice_export', 1)->nullable()->default('N')->change();
            
            // Change order_required from tinyint to varchar for Y/N values
            $table->string('order_required', 1)->nullable()->default('N')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Revert back to tinyint
            $table->tinyInteger('status')->default(0)->change();
            $table->tinyInteger('invoice_export')->default(0)->change();
            $table->tinyInteger('order_required')->default(0)->change();
        });
    }
};
