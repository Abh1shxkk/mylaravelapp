<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('supplier_master', function (Blueprint $table) {
            $table->id('supplier_id');
            $table->string('name', 255);
            $table->string('code', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->enum('tax_retail_flag', ['R', 'W', 'O'])->default('R'); // R=Retail, W=Wholesale, O=Other
            $table->string('tan_no', 50)->nullable();
            $table->string('msme_lic', 100)->nullable();
            $table->decimal('opening_balance', 15, 2)->default(0.00);
            $table->decimal('credit_limit', 15, 2)->default(0.00);
            $table->date('b_day')->nullable(); // Birth day
            $table->date('a_day')->nullable(); // Anniversary day
            $table->string('contact_person_1', 255)->nullable();
            $table->string('contact_person_2', 255)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('mobile_additional', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Suspended'])->default('Active');
            $table->string('flag', 50)->nullable();
            $table->string('dl_no', 50)->nullable();
            $table->string('dl_no_1', 50)->nullable();
            $table->string('food_lic', 100)->nullable();
            $table->string('cst_no', 50)->nullable();
            $table->string('tin_no', 50)->nullable();
            $table->string('pan', 20)->nullable();
            $table->string('gst_no', 20)->nullable();
            $table->string('state_code', 50)->nullable();
            $table->enum('local_central_flag', ['L', 'C'])->default('L'); // L=Local, C=Central
            $table->enum('discount_on_excise', ['Y', 'N'])->default('N');
            $table->string('scheme_type', 10)->nullable(); // H, H/F, etc.
            $table->enum('discount_after_scheme', ['Y', 'N'])->default('N');
            $table->enum('direct_indirect', ['D', 'I'])->default('I'); // D=Direct, I=Indirect
            $table->enum('invoice_on_trade_rate', ['Y', 'N'])->default('N');
            $table->enum('net_rate_yn', ['Y', 'N'])->default('N');
            $table->string('visit_days', 50)->nullable(); // Wednesday, etc.
            $table->enum('invoice_roff', ['Y', 'N'])->default('N');
            $table->enum('scheme_in_decimal', ['Y', 'N'])->default('N');
            $table->enum('vat_on_bill_expiry', ['Y', 'N'])->default('N');
            $table->enum('tax_on_fqty', ['Y', 'N'])->default('N');
            $table->enum('expiry_on_mrp_sale_rate_purchase_rate', ['Y', 'N'])->default('N');
            $table->enum('sale_purchase_status', ['S', 'P', 'B'])->default('P'); // S=Sale, P=Purchase, B=Both
            $table->enum('composite_scheme', ['Y', 'N'])->default('N');
            $table->enum('stock_transfer', ['Y', 'N'])->default('N');
            $table->enum('cash_purchase', ['Y', 'N'])->default('N');
            $table->enum('add_charges_with_gst', ['Y', 'N'])->default('N');
            $table->enum('purchase_import_box_conversion', ['Y', 'N'])->default('N');
            $table->string('full_name', 255)->nullable();
            $table->string('aadhar', 20)->nullable();
            $table->enum('registered_unregistered_composite', ['R', 'U', 'C'])->default('U'); // R=Registered, U=Unregistered, C=Composite
            $table->date('registration_date')->nullable();
            $table->enum('tcs_applicable', ['Y', 'N'])->default('N');
            $table->enum('tds_yn', ['Y', 'N'])->default('N');
            $table->enum('tds_on_return', ['Y', 'N'])->default('N');
            $table->enum('tds_tcs_on_bill_amount', ['Y', 'N'])->default('N');
            $table->string('bank', 255)->nullable();
            $table->string('branch', 255)->nullable();
            $table->string('account_no', 50)->nullable();
            $table->string('ifsc_code', 20)->nullable();
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('name');
            $table->index('code');
            $table->index('status');
            $table->index('gst_no');
            $table->index('is_deleted');
        });
    }

    public function down()
    {
        Schema::dropIfExists('supplier_master');
    }
};