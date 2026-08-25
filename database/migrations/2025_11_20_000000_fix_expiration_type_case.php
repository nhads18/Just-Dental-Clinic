<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Normalize expiration_type to lowercase for consistency
        DB::statement("UPDATE inventories SET expiration_type = LOWER(expiration_type)");
        
        // Modify the enum to use lowercase values
        DB::statement("ALTER TABLE inventories MODIFY COLUMN expiration_type ENUM('expirable', 'inexpirable') DEFAULT 'expirable'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to capitalized values
        DB::statement("UPDATE inventories SET expiration_type = CONCAT(UPPER(LEFT(expiration_type, 1)), SUBSTRING(expiration_type, 2))");
        DB::statement("ALTER TABLE inventories MODIFY COLUMN expiration_type ENUM('Expirable', 'Inexpirable') DEFAULT 'Expirable'");
    }
};
