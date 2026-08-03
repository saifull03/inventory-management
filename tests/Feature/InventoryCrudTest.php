<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\ItemType;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_category_and_product(): void
    {
        $user = User::factory()->create();

        $warehouse = Warehouse::create([
            'code' => 'WH-001',
            'name' => 'Main Warehouse',
            'location' => 'Lagos',
            'description' => 'Primary storage',
        ]);

        $category = Category::create([
            'name' => 'Accessories',
            'prefix' => 'ACC',
            'description' => 'Accessory items',
        ]);

        $itemType = ItemType::create([
            'name' => 'Laptop',
            'description' => 'Portable computers',
        ]);

        $this->actingAs($user)
            ->post(route('categories.store'), [
                'name' => 'Electronics',
                'prefix' => 'ELC',
                'description' => 'Electronic devices',
            ])
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', ['name' => 'Electronics', 'prefix' => 'ELC']);

        $this->actingAs($user)
            ->post(route('products.store'), [
                'product_code' => 'PRD-001',
                'name' => 'Laptop Pro',
                'brand' => 'Contoso',
                'model' => 'Pro 14',
                'serial_number' => 'SN-001',
                'description' => 'A premium laptop',
                'warehouse_id' => $warehouse->id,
                'category_id' => $category->id,
                'item_type_id' => $itemType->id,
                'status' => 'Available',
                'purchase_date' => '2026-01-15',
                'purchase_price' => 1299.99,
            ])
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', ['product_code' => 'PRD-001', 'name' => 'Laptop Pro']);
    }
}
