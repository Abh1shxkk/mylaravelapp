<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customer_master', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('code', 50)->nullable();
            $table->string('tax_registration', 20)->nullable();
            $table->string('pin_code', 10)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('telephone_office', 20)->nullable();
            $table->string('telephone_residence', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('contact_person1', 255)->nullable();
            $table->string('mobile_contact1', 20)->nullable();
            $table->string('contact_person2', 255)->nullable();
            $table->string('mobile_contact2', 20)->nullable();
            $table->string('fax_number', 20)->nullable();
            $table->decimal('opening_balance', 15, 2)->default(0.00);
            $table->enum('balance_type', ['D', 'C'])->default('D');
            $table->enum('local_central', ['L', 'C'])->default('L');
            $table->integer('credit_days')->default(0);
            $table->date('birth_day')->nullable();
            $table->string('status', 50)->nullable();
            $table->string('flag', 50)->nullable();
            $table->enum('invoice_export', ['Y', 'N'])->default('N');
            $table->integer('due_list_sequence')->nullable();
            $table->string('tan_number', 50)->nullable();
            $table->string('msme_license', 100)->nullable();
            $table->string('dl_number', 50)->nullable();
            $table->date('dl_expiry')->nullable();
            $table->string('dl_number1', 50)->nullable();
            $table->string('food_license', 100)->nullable();
            $table->string('cst_number', 50)->nullable();
            $table->string('tin_number', 50)->nullable();
            $table->string('pan_number', 20)->nullable();
            $table->string('sales_man_code', 10)->default('00');
            $table->string('area_code', 10)->default('00');
            $table->string('route_code', 10)->default('00');
            $table->string('state_code', 10)->default('00');
            $table->enum('business_type', ['W', 'R', 'I', 'D', 'O'])->default('R');
            $table->text('description')->nullable();
            $table->enum('order_required', ['Y', 'N'])->default('N');
            $table->string('aadhar_number', 20)->nullable();
            $table->date('registration_date')->default('2000-01-01');
            $table->date('end_date')->default('2000-01-01');
            $table->integer('day_value')->nullable();
            $table->string('cst_registration', 20)->nullable();
            $table->string('gst_name', 255)->nullable();
            $table->string('state_code_gst', 5)->default('09');
            $table->enum('registration_status', ['Registered', 'Unregistered', 'Composite'])->default('Unregistered');
            $table->timestamp('created_date')->useCurrent();
            $table->timestamp('modified_date')->useCurrent()->useCurrentOnUpdate();
            $table->string('created_by', 50)->nullable();
            $table->string('modified_by', 50)->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamp('deleted_at')->nullable();
            
            $table->index('name');
            $table->index('code');
            $table->index('city');
            $table->index('is_deleted');
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_master');
    }
};