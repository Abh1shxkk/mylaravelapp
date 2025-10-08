<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id('supplier_id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->text('address')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('tax_retail_flag')->nullable();
            $table->string('tan_no')->nullable();
            $table->string('msme_lic')->nullable();
            $table->decimal('opening_balance',15,2)->nullable();
            $table->decimal('credit_limit',15,2)->nullable();
            $table->date('b_day')->nullable();
            $table->date('a_day')->nullable();
            $table->string('contact_person_1')->nullable();
            $table->string('contact_person_2')->nullable();
            $table->string('mobile')->nullable();
            $table->string('mobile_additional')->nullable();
            $table->string('fax')->nullable();
            $table->boolean('status')->nullable()->default(false);
            $table->string('flag')->nullable();
            $table->string('dl_no')->nullable();
            $table->string('dl_no_1')->nullable();
            $table->string('food_lic')->nullable();
            $table->string('cst_no')->nullable();
            $table->string('tin_no')->nullable();
            $table->string('pan')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('state_code')->nullable();
            $table->string('local_central_flag')->nullable();
            $table->boolean('discount_on_excise')->nullable()->default(false);
            $table->string('scheme_type')->nullable();
            $table->boolean('discount_after_scheme')->nullable()->default(false);
            $table->string('direct_indirect')->nullable();
            $table->boolean('invoice_on_trade_rate')->nullable()->default(false);
            $table->boolean('net_rate_yn')->nullable()->default(false);
            $table->string('visit_days')->nullable();
            $table->decimal('invoice_roff',10,2)->nullable();
            $table->boolean('scheme_in_decimal')->nullable()->default(false);
            $table->boolean('vat_on_bill_expiry')->nullable()->default(false);
            $table->boolean('tax_on_fqty')->nullable()->default(false);
            $table->boolean('expiry_on_mrp_sale_rate_purchase_rate')->nullable()->default(false);
            $table->string('sale_purchase_status')->nullable();
            $table->boolean('composite_scheme')->nullable()->default(false);
            $table->boolean('stock_transfer')->nullable()->default(false);
            $table->boolean('cash_purchase')->nullable()->default(false);
            $table->boolean('add_charges_with_gst')->nullable()->default(false);
            $table->boolean('purchase_import_box_conversion')->nullable()->default(false);
            $table->string('full_name')->nullable();
            $table->string('aadhar')->nullable();
            $table->string('registered_unregistered_composite')->nullable();
            $table->date('registration_date')->nullable();
            $table->boolean('tcs_applicable')->nullable()->default(false);
            $table->boolean('tds_yn')->nullable()->default(false);
            $table->boolean('tds_on_return')->nullable()->default(false);
            $table->boolean('tds_tcs_on_bill_amount')->nullable()->default(false);
            $table->string('bank')->nullable();
            $table->string('branch')->nullable();
            $table->string('account_no')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users','user_id');
            $table->foreignId('updated_by')->nullable()->constrained('users','user_id');
            $table->boolean('is_deleted')->nullable()->default(false);
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
