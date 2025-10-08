<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
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
            $table->date('expiry')->nullable();
            $table->decimal('dis_on_sale_percent', 8, 2)->default(0);
            $table->decimal('min_gp', 8, 2)->default(0);
            $table->decimal('pur_tax', 8, 2)->default(0);
            $table->decimal('sale_tax', 8, 2)->default(0);
            $table->enum('generic', ['Y', 'N'])->default('N');
            $table->integer('invoice_print_order')->default(0);
            $table->enum('direct_indirect', ['D', 'I'])->default('D');
            $table->enum('surcharge_after_dis_yn', ['Y', 'N'])->default('N');
            $table->enum('add_surcharge_yn', ['Y', 'N'])->default('N');
            $table->decimal('vat_percent', 8, 2)->default(0);
            $table->enum('inclusive_yn', ['Y', 'N'])->default('N');
            $table->integer('disallow_expiry_after_months')->default(0);
            $table->decimal('fixed_maximum', 8, 2)->default(0);
            $table->decimal('discount', 8, 2)->default(0);
            $table->integer('flag')->default(0);
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->boolean('is_deleted')->default(false);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
};