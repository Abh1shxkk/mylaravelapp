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
        Schema::table('personal_directories', function (Blueprint $table) {
            // Drop old address fields
            $table->dropColumn([
                'address_office_1',
                'address_office_2',
                'address_office_3',
                'address_residence_1',
                'address_residence_2',
                'address_residence_3',
            ]);
            
            // Add new single address fields
            $table->text('address_office')->nullable();
            $table->text('address_residence')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_directories', function (Blueprint $table) {
            $table->dropColumn([
                'address_office',
                'address_residence',
            ]);
            
            $table->text('address_office_1')->nullable();
            $table->text('address_office_2')->nullable();
            $table->text('address_office_3')->nullable();
            $table->text('address_residence_1')->nullable();
            $table->text('address_residence_2')->nullable();
            $table->text('address_residence_3')->nullable();
        });
    }
};
