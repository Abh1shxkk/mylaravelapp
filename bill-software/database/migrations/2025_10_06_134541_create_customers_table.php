<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('tax_registration')->nullable();
            $table->string('pin_code')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('telephone_office')->nullable();
            $table->string('telephone_residence')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_person1')->nullable();
            $table->string('mobile_contact1')->nullable();
            $table->string('contact_person2')->nullable();
            $table->string('mobile_contact2')->nullable();
            $table->string('fax_number')->nullable();
            $table->decimal('opening_balance',15,2)->nullable();
            $table->string('balance_type')->nullable();
            $table->string('local_central')->nullable();
            $table->integer('credit_days')->nullable();
            $table->date('birth_day')->nullable();
            $table->boolean('status')->nullable()->default(false);
            $table->string('flag')->nullable();
            $table->boolean('invoice_export')->nullable()->default(false);
            $table->string('due_list_sequence')->nullable();
            $table->string('tan_number')->nullable();
            $table->string('msme_license')->nullable();
            $table->string('dl_number')->nullable();
            $table->date('dl_expiry')->nullable();
            $table->string('dl_number1')->nullable();
            $table->string('food_license')->nullable();
            $table->string('cst_number')->nullable();
            $table->string('tin_number')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('sales_man_code')->nullable();
            $table->string('area_code')->nullable();
            $table->string('route_code')->nullable();
            $table->string('state_code')->nullable();
            $table->string('business_type')->nullable();
            $table->text('description')->nullable();
            $table->boolean('order_required')->nullable()->default(false);
            $table->string('aadhar_number')->nullable();
            $table->date('registration_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('day_value')->nullable();
            $table->string('cst_registration')->nullable();
            $table->string('gst_name')->nullable();
            $table->string('state_code_gst')->nullable();
            $table->string('registration_status')->nullable();
            $table->timestamp('created_date')->nullable();
            $table->timestamp('modified_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users','user_id');
            $table->foreignId('modified_by')->nullable()->constrained('users','user_id');
            $table->boolean('is_deleted')->nullable()->default(false);
            $table->timestamp('deleted_a')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
