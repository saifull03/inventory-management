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
    Schema::create('products', function (Blueprint $table) {

        $table->id();

        $table->string('product_code')->unique();

        $table->string('name');

        $table->string('brand');

        $table->string('model');

        $table->string('serial_number')->nullable();

        $table->text('description')->nullable();

        $table->foreignId('warehouse_id')->constrained();

        $table->foreignId('category_id')->constrained();

        $table->foreignId('item_type_id')->constrained();

        $table->enum('status', [
            'Available',
            'Assigned',
            'Maintenance',
            'Damaged',
            'Disposed'
        ])->default('Available');

        $table->date('purchase_date')->nullable();

        $table->decimal('purchase_price',10,2)->nullable();

        $table->foreignId('created_by')->constrained('users');

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
