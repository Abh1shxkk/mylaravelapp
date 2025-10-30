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
        Schema::table('transport_masters', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            $table->text('address')->nullable()->after('name');
            $table->string('alter_code')->nullable()->after('address');
            $table->string('telephone')->nullable()->after('alter_code');
            $table->string('email')->nullable()->after('telephone');
            $table->string('mobile')->nullable()->after('email');
            $table->string('gst_no')->nullable()->after('mobile');
            $table->string('status')->nullable()->after('gst_no');
            $table->string('vehicle_no')->nullable()->after('status');
            $table->string('trans_mode')->nullable()->after('vehicle_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transport_masters', function (Blueprint $table) {
            $table->dropColumn(['name', 'address', 'alter_code', 'telephone', 'email', 'mobile', 'gst_no', 'status', 'vehicle_no', 'trans_mode']);
        });
    }
};
