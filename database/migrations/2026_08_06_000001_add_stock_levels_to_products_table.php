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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'safety_stock')) {
                $table->integer('safety_stock')->default(10)->after('status');
            }
            if (!Schema::hasColumn('products', 'reorder_level')) {
                $table->integer('reorder_level')->default(40)->after('safety_stock');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'safety_stock')) {
                $table->dropColumn('safety_stock');
            }
            if (Schema::hasColumn('products', 'reorder_level')) {
                $table->dropColumn('reorder_level');
            }
        });
    }
};
