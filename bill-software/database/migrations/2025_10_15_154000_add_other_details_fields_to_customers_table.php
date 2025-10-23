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
            // Banking Information
            $table->string('bank')->nullable();
            $table->string('branch')->nullable();
            $table->date('closed_on')->nullable();
            $table->decimal('credit_limit', 10, 2)->nullable()->default(0);
            
            // Sale Rate Configuration
            $table->string('sale_rate_type', 1)->nullable()->default('1');
            $table->decimal('add_percent', 5, 2)->nullable()->default(0);
            
            // Tax and Expiry Settings
            $table->string('tax_on_br_expiry', 1)->nullable()->default('N');
            $table->string('expiry_on', 1)->nullable()->default('M');
            $table->string('dis_after_scheme', 1)->nullable()->default('Y');
            $table->string('expiry_rn_on', 1)->nullable()->default('M');
            $table->string('dis_on_excise', 1)->nullable()->default('Y');
            $table->string('sale_pur_status', 1)->nullable()->default('S');
            $table->string('scm_type', 1)->nullable()->default('F');
            
            // Net Rate and Billing
            $table->string('net_rate', 1)->nullable()->default('N');
            $table->integer('no_of_items_in_bill')->nullable()->default(0);
            $table->string('invoice_print_order')->nullable();
            $table->string('sr_replacement', 1)->nullable()->default('N');
            $table->string('cash_sale', 1)->nullable()->default('N');
            $table->integer('invoice_format')->nullable()->default(0);
            $table->decimal('fixed_discount', 10, 2)->nullable()->default(0);
            
            // GST Discount Percentages
            $table->decimal('gst_5_percent', 5, 2)->nullable()->default(0);
            $table->decimal('gst_12_percent', 5, 2)->nullable()->default(0);
            $table->decimal('gst_18_percent', 5, 2)->nullable()->default(0);
            $table->decimal('gst_28_percent', 5, 2)->nullable()->default(0);
            $table->decimal('gst_0_percent', 5, 2)->nullable()->default(0);
            
            // Reference and Tax Settings
            $table->string('ref')->nullable();
            $table->string('tds', 1)->nullable()->default('N');
            $table->string('add_charges_with_gst', 1)->nullable()->default('N');
            $table->string('tcs_applicable', 1)->nullable()->default('N');
            $table->string('be_incl', 1)->nullable()->default('N');
            $table->string('brk_expiry_msg_in_sale', 1)->nullable()->default('Y');
            
            // Series and Branch
            $table->string('series_lock')->nullable();
            $table->string('branch_trf')->nullable();
            $table->string('trnf_account')->nullable();
            
            // eWay Details
            $table->string('transport_code')->nullable()->default('00');
            $table->string('transport_name')->nullable()->default('0');
            $table->integer('distance')->nullable();
            
            // Expiry Settings
            $table->string('expiry_repl_credit', 1)->nullable()->default('C');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'bank',
                'branch',
                'closed_on',
                'credit_limit',
                'sale_rate_type',
                'add_percent',
                'tax_on_br_expiry',
                'expiry_on',
                'dis_after_scheme',
                'expiry_rn_on',
                'dis_on_excise',
                'sale_pur_status',
                'scm_type',
                'net_rate',
                'no_of_items_in_bill',
                'invoice_print_order',
                'sr_replacement',
                'cash_sale',
                'invoice_format',
                'fixed_discount',
                'gst_5_percent',
                'gst_12_percent',
                'gst_18_percent',
                'gst_28_percent',
                'gst_0_percent',
                'ref',
                'tds',
                'add_charges_with_gst',
                'tcs_applicable',
                'be_incl',
                'brk_expiry_msg_in_sale',
                'series_lock',
                'branch_trf',
                'trnf_account',
                'transport_code',
                'transport_name',
                'distance',
                'expiry_repl_credit'
            ]);
        });
    }
};
