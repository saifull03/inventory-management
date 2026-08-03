<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE products MODIFY COLUMN status ENUM('Available','Assigned','Maintenance','Damaged','Disposed','In Stock','Reserved') NOT NULL DEFAULT 'Available'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE products MODIFY COLUMN status ENUM('Available','Assigned','Maintenance','Damaged','Disposed') NOT NULL DEFAULT 'Available'");
    }
};
