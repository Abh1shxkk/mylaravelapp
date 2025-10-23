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
        Schema::table('purchase_ledgers', function (Blueprint $table) {
            // Ledger Information
            $table->string('ledger_name')->nullable()->after('id');
            $table->string('form_type')->nullable();
            $table->decimal('sale_tax', 10, 2)->default(0)->nullable();
            $table->text('desc')->nullable();
            $table->char('type', 1)->default('L')->nullable(); // L/C
            $table->string('status')->nullable();
            $table->string('alter_code')->nullable();
            $table->decimal('opening_balance', 10, 2)->default(0)->nullable();
            $table->char('form_required', 1)->default('N')->nullable(); // Y/N
            $table->decimal('charges', 10, 2)->default(0)->nullable();
            $table->string('under')->nullable();

            // Contact Information
            $table->text('address')->nullable();
            $table->date('birth_day')->nullable();
            $table->date('anniversary')->nullable();
            $table->string('telephone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_1')->nullable();
            $table->string('mobile_1')->nullable();
            $table->string('contact_2')->nullable();
            $table->string('mobile_2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_ledgers', function (Blueprint $table) {
            $table->dropColumn([
                'ledger_name', 'form_type', 'sale_tax', 'desc', 'type', 'status',
                'alter_code', 'opening_balance', 'form_required', 'charges', 'under',
                'address', 'birth_day', 'anniversary', 'telephone', 'fax', 'email',
                'contact_1', 'mobile_1', 'contact_2', 'mobile_2'
            ]);
        });
    }
};
