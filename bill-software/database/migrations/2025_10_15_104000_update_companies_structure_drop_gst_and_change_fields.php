<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'gst_number')) {
                $table->dropColumn('gst_number');
            }
        });

        // Change fixed_maximum to CHAR(1) with default 'f' and migrate existing boolean values
        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'fixed_maximum')) {
                $table->char('fixed_maximum', 1)->default('f')->nullable()->change();
            } else {
                $table->char('fixed_maximum', 1)->default('f')->nullable();
            }
        });
        // Map previous boolean values: 1 => 'f', 0 => 'm'
        try {
            DB::statement("UPDATE companies SET fixed_maximum = CASE WHEN fixed_maximum IN ('1', 1, true) THEN 'f' ELSE 'm' END");
        } catch (\Throwable $e) {
            // ignore if not applicable
        }

        // Change status to VARCHAR(5)
        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'status')) {
                $table->string('status', 5)->nullable()->change();
            } else {
                $table->string('status', 5)->nullable();
            }
        });

        // Ensure discount default 0
        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'discount')) {
                $table->decimal('discount', 10, 2)->default(0)->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            // Can't restore gst_number without data definition; leave dropped
            // Revert fixed_maximum to boolean if needed
            if (Schema::hasColumn('companies', 'fixed_maximum')) {
                $table->boolean('fixed_maximum')->nullable()->default(false)->change();
            }
            // Revert status to boolean
            if (Schema::hasColumn('companies', 'status')) {
                $table->boolean('status')->nullable()->default(false)->change();
            }
            if (Schema::hasColumn('companies', 'discount')) {
                $table->decimal('discount', 10, 2)->nullable()->default(null)->change();
            }
        });
    }
};
