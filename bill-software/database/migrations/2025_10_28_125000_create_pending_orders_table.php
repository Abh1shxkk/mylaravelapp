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
        Schema::create('pending_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('supplier_id');
            $table->date('order_date');
            $table->decimal('rate', 10, 2);
            $table->decimal('tax_percent', 5, 2)->default(0);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->decimal('cost', 10, 2);
            $table->decimal('scm_percent', 5, 2)->default(0);
            $table->integer('quantity');
            $table->integer('free_quantity')->default(0);
            $table->char('urgent_flag', 1)->default('N'); // Y or N
            $table->integer('scheme_plus')->default(0);
            $table->integer('scheme_minus')->default(0);
            $table->integer('days_pending')->default(0);
            $table->string('status')->default('pending'); // pending, received, cancelled
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_orders');
    }
};
