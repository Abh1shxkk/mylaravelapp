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
            // Maximum O/s Amount and Limits
            $table->decimal('max_os_amount', 10, 2)->nullable()->default(0.00);
            $table->string('max_limit_on', 1)->nullable()->default('D'); // D = Due, L = Ledger
            $table->decimal('max_inv_amount', 10, 2)->nullable()->default(0.00);
            $table->integer('max_no_os_inv')->nullable()->default(0);
            
            // Conditions and Locks
            $table->string('follow_conditions_strictly', 1)->nullable()->default('N');
            $table->integer('credit_limit_days_lock')->nullable()->default(0);
            $table->string('open_lock_once', 1)->nullable()->default('N');
            
            // Expiry Locks
            $table->string('expiry_lock_type', 1)->nullable()->default('A'); // A = Amount, P = Percentage
            $table->decimal('expiry_lock_value', 10, 2)->nullable()->default(0.00);
            $table->integer('no_of_expiries_per_month')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'max_os_amount',
                'max_limit_on',
                'max_inv_amount',
                'max_no_os_inv',
                'follow_conditions_strictly',
                'credit_limit_days_lock',
                'open_lock_once',
                'expiry_lock_type',
                'expiry_lock_value',
                'no_of_expiries_per_month'
            ]);
        });
    }
};
