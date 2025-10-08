<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoice_templates', function (Blueprint $table) {
            $table->id('template_id');
            $table->string('template_name')->nullable();
            $table->string('template_type')->nullable();
            $table->boolean('is_default')->nullable()->default(false);
            $table->string('header_color')->nullable();
            $table->string('logo_position')->nullable();
            $table->boolean('show_company_logo')->nullable()->default(false);
            $table->boolean('show_qr_code')->nullable()->default(false);
            $table->boolean('show_payment_terms')->nullable()->default(false);
            $table->boolean('show_notes')->nullable()->default(false);
            $table->longText('header_html')->nullable();
            $table->longText('footer_html')->nullable();
            $table->longText('css_styles')->nullable();
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users','user_id');
            $table->boolean('is_active')->nullable()->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_templates');
    }
};
