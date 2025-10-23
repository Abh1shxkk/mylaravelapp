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
        Schema::table('sale_ledgers', function (Blueprint $table) {
            // Ledger Name (already exists, but ensure it's there)
            if (!Schema::hasColumn('sale_ledgers', 'ledger_name')) {
                $table->string('ledger_name')->nullable()->comment('Sale Ledger Name');
            }
            
            // Form Type
            if (!Schema::hasColumn('sale_ledgers', 'form_type')) {
                $table->string('form_type')->nullable()->comment('Form Type');
            }
            
            // Sale Tax
            if (!Schema::hasColumn('sale_ledgers', 'sale_tax')) {
                $table->decimal('sale_tax', 10, 2)->default(0)->comment('Sale Tax Amount');
            }
            
            // Description
            if (!Schema::hasColumn('sale_ledgers', 'desc')) {
                $table->text('desc')->nullable()->comment('Description');
            }
            
            // Type (L/C)
            if (!Schema::hasColumn('sale_ledgers', 'type')) {
                $table->char('type', 1)->default('L')->comment('Type: L (Ledger) or C (Credit)');
            }
            
            // Status
            if (!Schema::hasColumn('sale_ledgers', 'status')) {
                $table->string('status')->nullable()->comment('Status');
            }
            
            // Alter Code
            if (!Schema::hasColumn('sale_ledgers', 'alter_code')) {
                $table->string('alter_code')->nullable()->comment('Alternate Code');
            }
            
            // Opening Balance
            if (!Schema::hasColumn('sale_ledgers', 'opening_balance')) {
                $table->decimal('opening_balance', 12, 2)->default(0)->comment('Opening Balance');
            }
            
            // Form Required (Y/N)
            if (!Schema::hasColumn('sale_ledgers', 'form_required')) {
                $table->char('form_required', 1)->default('N')->comment('Form Required: Y/N');
            }
            
            // Charges
            if (!Schema::hasColumn('sale_ledgers', 'charges')) {
                $table->decimal('charges', 10, 2)->default(0)->comment('Charges Amount');
            }
            
            // Under
            if (!Schema::hasColumn('sale_ledgers', 'under')) {
                $table->string('under')->nullable()->comment('Under which group/ledger');
            }
            
            // Address
            if (!Schema::hasColumn('sale_ledgers', 'address')) {
                $table->text('address')->nullable()->comment('Address');
            }
            
            // Birth Day
            if (!Schema::hasColumn('sale_ledgers', 'birth_day')) {
                $table->date('birth_day')->nullable()->comment('Birth Day');
            }
            
            // Anniversary
            if (!Schema::hasColumn('sale_ledgers', 'anniversary')) {
                $table->date('anniversary')->nullable()->comment('Anniversary');
            }
            
            // Telephone
            if (!Schema::hasColumn('sale_ledgers', 'telephone')) {
                $table->string('telephone')->nullable()->comment('Telephone Number');
            }
            
            // Fax
            if (!Schema::hasColumn('sale_ledgers', 'fax')) {
                $table->string('fax')->nullable()->comment('Fax Number');
            }
            
            // Email
            if (!Schema::hasColumn('sale_ledgers', 'email')) {
                $table->string('email')->nullable()->comment('Email Address');
            }
            
            // Contact 1
            if (!Schema::hasColumn('sale_ledgers', 'contact_1')) {
                $table->string('contact_1')->nullable()->comment('Contact Person 1');
            }
            
            // Mobile 1
            if (!Schema::hasColumn('sale_ledgers', 'mobile_1')) {
                $table->string('mobile_1')->nullable()->comment('Mobile 1');
            }
            
            // Contact 2
            if (!Schema::hasColumn('sale_ledgers', 'contact_2')) {
                $table->string('contact_2')->nullable()->comment('Contact Person 2');
            }
            
            // Mobile 2
            if (!Schema::hasColumn('sale_ledgers', 'mobile_2')) {
                $table->string('mobile_2')->nullable()->comment('Mobile 2');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_ledgers', function (Blueprint $table) {
            $columns = [
                'ledger_name', 'form_type', 'sale_tax', 'desc', 'type', 'status',
                'alter_code', 'opening_balance', 'form_required', 'charges', 'under',
                'address', 'birth_day', 'anniversary', 'telephone', 'fax', 'email',
                'contact_1', 'mobile_1', 'contact_2', 'mobile_2'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('sale_ledgers', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
