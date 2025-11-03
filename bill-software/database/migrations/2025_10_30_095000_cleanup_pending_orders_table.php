<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Remove all unnecessary columns - keep only what's used in form
     */
    public function up(): void
    {
        Schema::table('pending_orders', function (Blueprint $table) {
            // Drop unnecessary columns
            $table->dropColumn([
                'remarks',
                'created_by',
                'email_sent',
                'email_sent_at',
                'free_quantity',
                'status'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pending_orders', function (Blueprint $table) {
            $table->text('remarks')->nullable();
            $table->string('created_by', 100)->nullable();
            $table->boolean('email_sent')->default(0);
            $table->timestamp('email_sent_at')->nullable();
            $table->integer('free_quantity')->default(0);
            $table->string('status')->default('pending');
        });
    }
};
