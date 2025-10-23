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
        Schema::table('cash_bank_books', function (Blueprint $table) {
            // Add new fields from the image (removing transaction details fields)
            $table->string('name')->nullable()->after('id')->comment('Name/Code of cash/bank book');
            $table->string('alter_code')->nullable()->comment('Alternate code');
            $table->string('under')->nullable()->comment('Under which ledger/group');
            $table->decimal('opening_balance', 15, 2)->default(0)->comment('Opening balance amount');
            $table->char('opening_balance_type', 1)->default('D')->comment('Dr/Cr - Debit or Credit');
            $table->char('credit_card', 1)->nullable()->comment('Y/N/W - Credit Card/Wallet flag');
            $table->decimal('bank_charges', 15, 2)->nullable()->comment('Bank charges amount');
            $table->text('address')->nullable()->comment('Address of the bank/cash location');
            $table->text('address1')->nullable()->comment('Additional address line');
            $table->boolean('input_gst_purchase')->default(0)->comment('Input GST (Purchase) flag');
            $table->boolean('output_gst_income')->default(0)->comment('Output GST (Income) flag');
            $table->string('account_no')->nullable()->comment('Account number');
            $table->string('report_no')->nullable()->comment('Report number');
            $table->char('cheque_clearance_method', 1)->default('P')->comment('P/I - Pis. No. or Individual Cheques');
            $table->string('flag')->nullable()->comment('Flag/Status field');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cash_bank_books', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'alter_code',
                'under',
                'opening_balance',
                'opening_balance_type',
                'credit_card',
                'bank_charges',
                'address',
                'address1',
                'input_gst_purchase',
                'output_gst_income',
                'account_no',
                'report_no',
                'cheque_clearance_method',
                'flag',
            ]);
        });
    }
};
