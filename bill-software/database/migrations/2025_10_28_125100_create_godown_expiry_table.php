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
        Schema::create('godown_expiry', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('batch_id');
            $table->date('expiry_date');
            $table->integer('quantity');
            $table->string('godown_location')->nullable();
            $table->string('status')->default('active'); // active, expired, disposed
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
            $table->index('expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('godown_expiry');
    }
};
