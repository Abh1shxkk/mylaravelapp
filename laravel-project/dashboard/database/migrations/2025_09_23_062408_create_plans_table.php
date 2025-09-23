<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // E.g., 'Basic', 'Premium'
            $table->string('slug')->unique(); // E.g., 'basic', 'premium'
            $table->string('razorpay_plan_id')->nullable()->unique(); // For Razorpay later
            $table->decimal('price', 8, 2); // E.g., 500.00 (INR)
            $table->string('billing_period'); // E.g., 'monthly', 'yearly'
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plans');
    }
};