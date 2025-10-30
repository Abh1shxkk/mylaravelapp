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
        Schema::table('general_reminders', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            $table->string('code')->nullable()->after('name');
            $table->date('due_date')->nullable()->after('code');
            $table->string('status')->nullable()->after('due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('general_reminders', function (Blueprint $table) {
            $table->dropColumn(['name', 'code', 'due_date', 'status']);
        });
    }
};
