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
        Schema::table('general_ledgers', function (Blueprint $table) {
            // Add new fields
            $table->string('alter_code', 50)->nullable()->after('account_code')->comment('Alternate code for the ledger');
            $table->string('under', 255)->nullable()->after('alter_code')->comment('Parent ledger or category');
            $table->boolean('input_gst_purchase')->default(false)->after('balance_type')->comment('Input GST (Purchase)');
            $table->boolean('output_gst_income')->default(false)->after('input_gst_purchase')->comment('Output GST (Income)');
            $table->string('flag', 50)->nullable()->after('output_gst_income')->comment('Flag for ledger');
            
            // Drop unnecessary fields
            $table->dropColumn(['account_type', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('general_ledgers', function (Blueprint $table) {
            $table->dropColumn(['alter_code', 'under', 'input_gst_purchase', 'output_gst_income', 'flag']);
            $table->string('account_type', 100)->after('account_code');
            $table->text('description')->nullable()->after('balance_type');
        });
    }
};
