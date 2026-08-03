<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ItemType;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $warehouse = Warehouse::firstOrCreate(
            ['code' => 'WH-001'],
            ['name' => 'Main Warehouse', 'location' => 'Lagos', 'description' => 'Primary storage location']
        );

        $warehouseTwo = Warehouse::firstOrCreate(
            ['code' => 'WH-002'],
            ['name' => 'Branch Warehouse', 'location' => 'Abuja', 'description' => 'Regional overflow storage']
        );

        $category = Category::firstOrCreate(
            ['prefix' => 'LT'],
            ['name' => 'Laptops', 'description' => 'Portable computing devices']
        );

        $categoryTwo = Category::firstOrCreate(
            ['prefix' => 'PH'],
            ['name' => 'Phones', 'description' => 'Mobile phones and accessories']
        );

        $itemType = ItemType::firstOrCreate(
            ['name' => 'Electronics'],
            ['description' => 'Electronic assets and gadgets']
        );

        $itemTypeTwo = ItemType::firstOrCreate(
            ['name' => 'Accessories'],
            ['description' => 'Peripherals and add-ons']
        );

        Product::firstOrCreate(
            ['product_code' => 'LT0001'],
            [
                'name' => 'Dell Latitude 5440',
                'brand' => 'Dell',
                'model' => 'Latitude 5440',
                'serial_number' => 'DL-5440-001',
                'description' => 'Business laptop for office use',
                'warehouse_id' => $warehouse->id,
                'category_id' => $category->id,
                'item_type_id' => $itemType->id,
                'status' => 'In Stock',
                'purchase_date' => now()->subMonth(),
                'purchase_price' => 1250000,
                'created_by' => 1,
            ]
        );

        Product::firstOrCreate(
            ['product_code' => 'PH0001'],
            [
                'name' => 'Samsung Galaxy S24',
                'brand' => 'Samsung',
                'model' => 'Galaxy S24',
                'serial_number' => 'SG-S24-001',
                'description' => 'Premium mobile phone',
                'warehouse_id' => $warehouseTwo->id,
                'category_id' => $categoryTwo->id,
                'item_type_id' => $itemTypeTwo->id,
                'status' => 'Reserved',
                'purchase_date' => now()->subWeeks(2),
                'purchase_price' => 800000,
                'created_by' => 1,
            ]
        );
    }
}
