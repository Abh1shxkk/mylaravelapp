<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_person_1')->nullable();
            $table->string('contact_person_2')->nullable();
            $table->string('website')->nullable();
            $table->string('alter_code')->nullable();
            $table->string('telephone')->nullable();
            $table->string('short_name')->nullable();
            $table->string('location')->nullable();
            $table->string('mobile_1')->nullable();
            $table->string('mobile_2')->nullable();
            $table->string('pur_sc')->nullable();
            $table->string('sale_sc')->nullable();
            $table->string('expiry')->nullable();
            $table->decimal('dis_on_sale_percent', 10,2)->nullable();
            $table->decimal('min_gp', 10,2)->nullable();
            $table->decimal('pur_tax', 10,2)->nullable();
            $table->decimal('sale_tax', 10,2)->nullable();
            $table->string('generic')->nullable();
            $table->string('invoice_print_order')->nullable();
            $table->string('direct_indirect')->nullable();
            $table->boolean('surcharge_after_dis_yn')->nullable()->default(false);
            $table->boolean('add_surcharge_yn')->nullable()->default(false);
            $table->decimal('vat_percent',10,2)->nullable();
            $table->boolean('inclusive_yn')->nullable()->default(false);
            $table->integer('disallow_expiry_after_months')->nullable();
            $table->boolean('fixed_maximum')->nullable()->default(false);
            $table->decimal('discount',10,2)->nullable();
            $table->string('flag')->nullable();
            $table->boolean('status')->nullable()->default(false);
            $table->boolean('is_deleted')->nullable()->default(false);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
