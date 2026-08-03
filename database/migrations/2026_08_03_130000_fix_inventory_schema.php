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
        if (! Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('prefix')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        } else {
            if (! Schema::hasColumn('categories', 'prefix')) {
                Schema::table('categories', function (Blueprint $table) {
                    $table->string('prefix')->nullable()->after('name');
                });
            }

            if (! Schema::hasColumn('categories', 'description')) {
                Schema::table('categories', function (Blueprint $table) {
                    $table->text('description')->nullable()->after('prefix');
                });
            }
        }

        if (! Schema::hasTable('item_types')) {
            Schema::create('item_types', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        } else {
            if (! Schema::hasColumn('item_types', 'name')) {
                Schema::table('item_types', function (Blueprint $table) {
                    $table->string('name');
                });
            }

            if (! Schema::hasColumn('item_types', 'description')) {
                Schema::table('item_types', function (Blueprint $table) {
                    $table->text('description')->nullable();
                });
            }
        }

        if (! Schema::hasTable('products')) {
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
                $table->enum('status', ['Available', 'Assigned', 'Maintenance', 'Damaged', 'Disposed'])->default('Available');
                $table->date('purchase_date')->nullable();
                $table->decimal('purchase_price', 10, 2)->nullable();
                $table->foreignId('created_by')->constrained('users');
                $table->timestamps();
            });
        } else {
            if (! Schema::hasColumn('products', 'product_code')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->string('product_code')->unique();
                });
            }

            if (! Schema::hasColumn('products', 'brand')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->string('brand');
                });
            }

            if (! Schema::hasColumn('products', 'model')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->string('model');
                });
            }

            if (! Schema::hasColumn('products', 'serial_number')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->string('serial_number')->nullable();
                });
            }

            if (! Schema::hasColumn('products', 'warehouse_id')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->foreignId('warehouse_id')->constrained();
                });
            }

            if (! Schema::hasColumn('products', 'category_id')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->foreignId('category_id')->constrained();
                });
            }

            if (! Schema::hasColumn('products', 'item_type_id')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->foreignId('item_type_id')->constrained();
                });
            }

            if (! Schema::hasColumn('products', 'status')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->enum('status', ['Available', 'Assigned', 'Maintenance', 'Damaged', 'Disposed'])->default('Available');
                });
            }

            if (! Schema::hasColumn('products', 'purchase_date')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->date('purchase_date')->nullable();
                });
            }

            if (! Schema::hasColumn('products', 'purchase_price')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->decimal('purchase_price', 10, 2)->nullable();
                });
            }

            if (! Schema::hasColumn('products', 'created_by')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->foreignId('created_by')->constrained('users');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op to preserve existing data.
    }
};
