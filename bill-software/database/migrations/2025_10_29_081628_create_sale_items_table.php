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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->string('code', 50)->nullable();
            $table->foreignId('item_id')->nullable()->constrained('items')->onDelete('set null');
            $table->string('item_name', 255);
            $table->foreignId('batch_id')->nullable()->constrained('batches')->onDelete('set null');
            $table->string('batch', 100)->nullable();
            $table->string('expiry', 20)->nullable();
            $table->integer('qty')->default(0);
            $table->integer('free_qty')->default(0);
            $table->decimal('rate', 15, 2)->default(0);
            $table->decimal('discount', 5, 2)->default(0);
            $table->decimal('mrp', 15, 2)->default(0);
            $table->decimal('amount', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
