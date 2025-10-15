<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->char('lock_aiocd', 1)->default('n')->after('inclusive_yn');
            $table->char('lock_ims', 1)->default('n')->after('lock_aiocd');
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['lock_aiocd', 'lock_ims']);
        });
    }
};
