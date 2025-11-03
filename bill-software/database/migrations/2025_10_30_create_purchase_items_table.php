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
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained('purchases')->onDelete('cascade');
            $table->foreignId('item_id')->nullable()->constrained('items')->onDelete('set null');
            
            $table->string('code')->nullable();
            $table->string('item_name');
            $table->string('batch')->nullable();
            $table->string('exp')->nullable();
            $table->decimal('qty', 10, 2)->default(0);
            $table->decimal('f_qty', 10, 2)->default(0);
            $table->decimal('purchase_rate', 10, 2)->default(0);
            $table->decimal('dis_percent', 10, 2)->default(0);
            $table->decimal('mrp', 10, 2)->default(0);
            $table->decimal('amount', 15, 2)->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
