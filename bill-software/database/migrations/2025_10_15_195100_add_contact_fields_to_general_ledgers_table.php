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
        Schema::table('general_ledgers', function (Blueprint $table) {
            // Add new contact fields
            $table->text('address')->nullable()->after('flag')->comment('Address');
            $table->string('address_line2', 255)->nullable()->after('address')->comment('Address Line 2');
            $table->string('address_line3', 255)->nullable()->after('address_line2')->comment('Address Line 3');
            $table->string('birth_day', 10)->nullable()->after('address_line3')->comment('Birth Day (DD/MM)');
            $table->string('anniversary_day', 10)->nullable()->after('birth_day')->comment('Anniversary Day (DD/MM)');
            $table->string('telephone', 20)->nullable()->after('anniversary_day')->comment('Telephone');
            $table->string('email', 255)->nullable()->after('telephone')->comment('Email');
            $table->string('fax', 20)->nullable()->after('email')->comment('Fax');
            $table->string('mobile', 20)->nullable()->after('fax')->comment('Mobile');
            $table->string('mobile_additional', 20)->nullable()->after('mobile')->comment('Mobile Additional');
            $table->string('contact_person_1', 255)->nullable()->after('mobile_additional')->comment('Contact Person I');
            $table->string('contact_person_2', 255)->nullable()->after('contact_person_1')->comment('Contact Person II');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('general_ledgers', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'address_line2',
                'address_line3',
                'birth_day',
                'anniversary_day',
                'telephone',
                'email',
                'fax',
                'mobile',
                'mobile_additional',
                'contact_person_1',
                'contact_person_2',
            ]);
        });
    }
};
