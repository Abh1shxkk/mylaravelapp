<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // First, update existing boolean/tinyint values to valid chars before changing type
        // Convert any existing 1/0 or true/false to 'f'/'m' while column is still compatible
        try {
            DB::statement("UPDATE companies SET fixed_maximum = 'f' WHERE fixed_maximum = 1 OR fixed_maximum = '1' OR fixed_maximum = true");
            DB::statement("UPDATE companies SET fixed_maximum = 'm' WHERE fixed_maximum = 0 OR fixed_maximum = '0' OR fixed_maximum = false OR fixed_maximum IS NULL");
        } catch (\Exception $e) {
            // If update fails, column might already be CHAR, skip
        }

        // Now change column type to CHAR(1) with default 'f'
        DB::statement("ALTER TABLE companies MODIFY fixed_maximum CHAR(1) NULL DEFAULT 'f'");

        // Ensure status is VARCHAR(5) NULL
        DB::statement("ALTER TABLE companies MODIFY status VARCHAR(5) NULL");

        // Ensure discount default 0
        DB::statement("ALTER TABLE companies MODIFY discount DECIMAL(10,2) NULL DEFAULT 0");
    }

    public function down(): void
    {
        // Best-effort down: revert fixed_maximum to TINYINT(1), status to TINYINT(1), and discount default NULL
        DB::statement("ALTER TABLE companies MODIFY fixed_maximum TINYINT(1) NULL DEFAULT 0");
        DB::statement("ALTER TABLE companies MODIFY status TINYINT(1) NULL DEFAULT 0");
        DB::statement("ALTER TABLE companies MODIFY discount DECIMAL(10,2) NULL DEFAULT NULL");
    }
};
