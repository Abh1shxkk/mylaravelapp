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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->string('batch_number')->unique();
            $table->date('manufacturing_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->decimal('quantity', 12, 2)->default(0);
            $table->decimal('cost_price', 12, 2)->default(0);
            $table->decimal('selling_price', 12, 2)->default(0);
            $table->string('godown')->nullable(); // Warehouse location
            $table->string('status')->default('active'); // active, expired, discontinued
            $table->text('remarks')->nullable();
            $table->integer('is_deleted')->default(0);
            $table->timestamps();
            
            // Foreign key
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            
            // Indexes
            $table->index('item_id');
            $table->index('expiry_date');
            $table->index('status');
            $table->index('batch_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
