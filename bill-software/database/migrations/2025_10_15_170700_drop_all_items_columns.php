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
        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();
        
        // Drop the entire items table and recreate it fresh
        Schema::dropIfExists('items');
        
        // Create fresh items table with only new fields
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            
            // Company Information
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('company_short_name', 20)->nullable();
            
            // Basic Item Information
            $table->string('name', 100);
            $table->string('code', 20)->nullable();
            $table->string('packing', 50)->nullable();
            $table->string('mfg_by', 100)->nullable();
            $table->string('location', 50)->nullable();
            $table->string('status', 5)->nullable();
            $table->string('schedule', 10)->nullable()->default('00');
            $table->integer('box_qty')->nullable()->default(0);
            $table->integer('case_qty')->nullable()->default(0);
            $table->string('bar_code', 50)->nullable();
            $table->string('division', 10)->nullable()->default('00');
            $table->string('flag', 20)->nullable();
            
            // Header Section
            $table->tinyInteger('unit')->default(1);
            $table->string('unit_type', 10)->nullable();
            $table->decimal('min_level', 10, 2)->nullable()->default(0);
            $table->decimal('max_level', 10, 2)->nullable()->default(0);
            $table->char('narcotic_flag', 1)->nullable()->default('N');
            
            // Sale Details Section
            $table->decimal('s_rate', 10, 2)->nullable()->default(0);
            $table->decimal('mrp', 10, 2)->nullable()->default(0);
            $table->char('net_toggle', 1)->nullable()->default('N');
            $table->decimal('ws_rate', 10, 2)->nullable()->default(0);
            $table->char('ws_net_toggle', 1)->nullable()->default('N');
            $table->decimal('spl_rate', 10, 2)->nullable()->default(0);
            $table->char('spl_net_toggle', 1)->nullable()->default('N');
            $table->integer('scheme_plus')->nullable()->default(0);
            $table->integer('scheme_minus')->nullable()->default(0);
            $table->decimal('min_gp', 10, 2)->nullable()->default(0);
            
            // Purchase Details Section
            $table->decimal('pur_rate', 10, 2)->nullable()->default(0);
            $table->decimal('cost', 10, 2)->nullable()->default(0);
            $table->integer('pur_scheme_plus')->nullable()->default(0);
            $table->integer('pur_scheme_minus')->nullable()->default(0);
            $table->decimal('nr', 10, 2)->nullable()->default(0);
            
            // GST Details Section
            $table->string('hsn_code', 20)->nullable();
            $table->decimal('cgst_percent', 5, 2)->nullable()->default(0);
            $table->decimal('sgst_percent', 5, 2)->nullable()->default(0);
            $table->decimal('igst_percent', 5, 2)->nullable()->default(0);
            $table->decimal('cess_percent', 5, 2)->nullable()->default(0);
            
            // Other Details Section
            $table->decimal('vat_percent', 5, 2)->nullable()->default(0);
            $table->char('fixed_dis', 1)->nullable();
            $table->decimal('fixed_dis_percent', 5, 2)->nullable()->default(0);
            $table->char('fixed_dis_type', 1)->nullable();
            $table->char('expiry_flag', 1)->nullable()->default('N');
            $table->char('inclusive_flag', 1)->nullable()->default('N');
            $table->char('generic_flag', 1)->nullable()->default('N');
            $table->char('h_scm_flag', 1)->nullable()->default('N');
            $table->char('q_scm_flag', 1)->nullable()->default('N');
            $table->char('locks_flag', 1)->nullable()->default('N');
            $table->decimal('max_inv_qty_value', 10, 2)->nullable()->default(0);
            $table->char('max_inv_qty_new', 1)->nullable();
            $table->decimal('weight_new', 10, 2)->nullable()->default(0);
            $table->char('bar_code_flag', 1)->nullable()->default('N');
            $table->char('def_qty_flag', 1)->nullable()->default('N');
            $table->decimal('volume_new', 10, 2)->nullable()->default(0);
            $table->char('comp_name_bc_new', 1)->nullable();
            $table->char('dpc_item_flag', 1)->nullable()->default('N');
            $table->char('lock_sale_flag', 1)->nullable()->default('N');
            $table->char('max_min_flag', 1)->nullable()->default('1');
            $table->decimal('mrp_for_sale_new', 10, 2)->nullable()->default(0);
            
            // Bottom Section
            $table->string('commodity', 50)->nullable();
            $table->char('current_scheme_flag', 1)->nullable()->default('N');
            $table->string('category', 50)->nullable();
            $table->string('upc', 50)->nullable();
            
            // System fields
            $table->tinyInteger('is_deleted')->default(0);
            $table->timestamps();
            
            // Foreign key
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
        });
        
        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
