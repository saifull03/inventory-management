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
            $table->string('brand')->nullable()->change();
            $table->string('model')->nullable()->change();
            $table->foreignId('warehouse_id')->nullable()->change();
            $table->foreignId('item_type_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('brand')->nullable(false)->change();
            $table->string('model')->nullable(false)->change();
            $table->foreignId('warehouse_id')->nullable(false)->change();
            $table->foreignId('item_type_id')->nullable(false)->change();
        });
    }
};
