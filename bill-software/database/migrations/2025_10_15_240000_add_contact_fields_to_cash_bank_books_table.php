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
        Schema::table('cash_bank_books', function (Blueprint $table) {
            // Contact Information Fields from the image
            $table->string('telephone')->nullable()->comment('Telephone number')->after('address1');
            $table->string('email')->nullable()->comment('E-Mail address')->after('telephone');
            $table->string('fax')->nullable()->comment('Fax number')->after('email');
            $table->date('birth_day')->nullable()->comment('Birthday')->after('fax');
            $table->date('anniversary_day')->nullable()->comment('Anniversary day')->after('birth_day');
            $table->string('contact_person_1')->nullable()->comment('Contact Person I')->after('anniversary_day');
            $table->string('contact_person_2')->nullable()->comment('Contact Person II')->after('contact_person_1');
            $table->string('mobile_1')->nullable()->comment('Mobile number 1')->after('contact_person_2');
            $table->string('mobile_2')->nullable()->comment('Mobile number 2')->after('mobile_1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cash_bank_books', function (Blueprint $table) {
            $table->dropColumn([
                'telephone',
                'email',
                'fax',
                'birth_day',
                'anniversary_day',
                'contact_person_1',
                'contact_person_2',
                'mobile_1',
                'mobile_2',
            ]);
        });
    }
};
