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
        Schema::create('hsn_codes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('HSN Code Name/Description');
            $table->string('hsn_code')->nullable()->comment('HSN Code Number');
            $table->decimal('cgst_percent', 5, 2)->default(0.00)->comment('CGST Percentage');
            $table->decimal('sgst_percent', 5, 2)->default(0.00)->comment('SGST Percentage');
            $table->decimal('igst_percent', 5, 2)->default(0.00)->comment('IGST Percentage');
            $table->decimal('total_gst_percent', 5, 2)->default(0.00)->comment('Total GST Percentage');
            $table->boolean('is_inactive')->default(false)->comment('Inactive flag');
            $table->boolean('is_service')->default(false)->comment('Service flag');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hsn_codes');
    }
};
