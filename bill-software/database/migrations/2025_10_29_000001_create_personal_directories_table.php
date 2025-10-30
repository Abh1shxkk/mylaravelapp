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
        Schema::create('personal_directories', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('name')->nullable();
            $table->string('alt_code')->nullable();
            
            // Address Fields
            $table->text('address_office_1')->nullable();
            $table->text('address_office_2')->nullable();
            $table->text('address_office_3')->nullable();
            $table->text('address_residence_1')->nullable();
            $table->text('address_residence_2')->nullable();
            $table->text('address_residence_3')->nullable();
            
            // Contact Information
            $table->string('tel_office')->nullable();
            $table->string('tel_residence')->nullable();
            $table->string('mobile')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->nullable();
            
            // Personal Details
            $table->string('contact_person')->nullable();
            $table->date('birthday')->nullable();
            $table->date('anniversary')->nullable();
            
            // Family Information
            $table->string('spouse')->nullable();
            $table->date('spouse_dob')->nullable();
            $table->string('child_1')->nullable();
            $table->date('child_1_dob')->nullable();
            $table->string('child_2')->nullable();
            $table->date('child_2_dob')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_directories');
    }
};
