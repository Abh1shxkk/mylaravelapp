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
        Schema::create('customer_prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('doctor_name');
            $table->string('patient_name');
            $table->date('prescription_date');
            $table->date('validity_date');
            $table->text('details')->nullable();
            $table->enum('status', ['Active', 'Expired', 'Cancelled'])->default('Active');
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->index('customer_id');
            $table->index('validity_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_prescriptions');
    }
};
