<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\ItemType;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_delete_item_type_with_associated_products(): void
    {
        $user = User::factory()->create();

        $warehouse = Warehouse::create([
            'code' => 'WH-001',
            'name' => 'Main Warehouse',
            'location' => 'Lagos',
        ]);

        $category = Category::create([
            'name' => 'Accessories',
            'prefix' => 'ACC',
        ]);

        $itemType = ItemType::create([
            'name' => 'Laptop',
        ]);

        $product = Product::create([
            'product_code' => 'PRD-001',
            'name' => 'Laptop Pro',
            'brand' => 'Contoso',
            'model' => 'Pro 14',
            'warehouse_id' => $warehouse->id,
            'category_id' => $category->id,
            'item_type_id' => $itemType->id,
            'created_by' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->delete(route('item-types.destroy', $itemType));

        $response->assertRedirect(route('item-types.index'));
        $response->assertSessionHas('error', 'Cannot delete item type because it has associated products.');
        $this->assertDatabaseHas('item_types', ['id' => $itemType->id]);
    }

    public function test_can_delete_item_type_without_associated_products(): void
    {
        $user = User::factory()->create();

        $itemType = ItemType::create([
            'name' => 'Laptop',
        ]);

        $response = $this->actingAs($user)
            ->delete(route('item-types.destroy', $itemType));

        $response->assertRedirect(route('item-types.index'));
        $response->assertSessionHas('success', 'Item type deleted successfully.');
        $this->assertDatabaseMissing('item_types', ['id' => $itemType->id]);
    }

    public function test_cannot_delete_category_with_associated_products(): void
    {
        $user = User::factory()->create();

        $warehouse = Warehouse::create([
            'code' => 'WH-001',
            'name' => 'Main Warehouse',
            'location' => 'Lagos',
        ]);

        $category = Category::create([
            'name' => 'Accessories',
            'prefix' => 'ACC',
        ]);

        $itemType = ItemType::create([
            'name' => 'Laptop',
        ]);

        $product = Product::create([
            'product_code' => 'PRD-001',
            'name' => 'Laptop Pro',
            'brand' => 'Contoso',
            'model' => 'Pro 14',
            'warehouse_id' => $warehouse->id,
            'category_id' => $category->id,
            'item_type_id' => $itemType->id,
            'created_by' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('error', 'Cannot delete category because it has associated products.');
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_can_delete_category_without_associated_products(): void
    {
        $user = User::factory()->create();

        $category = Category::create([
            'name' => 'Accessories',
            'prefix' => 'ACC',
        ]);

        $response = $this->actingAs($user)
            ->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Category deleted successfully.');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_cannot_delete_warehouse_with_associated_products(): void
    {
        $user = User::factory()->create();

        $warehouse = Warehouse::create([
            'code' => 'WH-001',
            'name' => 'Main Warehouse',
            'location' => 'Lagos',
        ]);

        $category = Category::create([
            'name' => 'Accessories',
            'prefix' => 'ACC',
        ]);

        $itemType = ItemType::create([
            'name' => 'Laptop',
        ]);

        $product = Product::create([
            'product_code' => 'PRD-001',
            'name' => 'Laptop Pro',
            'brand' => 'Contoso',
            'model' => 'Pro 14',
            'warehouse_id' => $warehouse->id,
            'category_id' => $category->id,
            'item_type_id' => $itemType->id,
            'created_by' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->delete(route('warehouses.destroy', $warehouse));

        $response->assertRedirect(route('warehouses.index'));
        $response->assertSessionHas('error', 'Cannot delete warehouse because it has associated products.');
        $this->assertDatabaseHas('warehouses', ['id' => $warehouse->id]);
    }

    public function test_can_delete_warehouse_without_associated_products(): void
    {
        $user = User::factory()->create();

        $warehouse = Warehouse::create([
            'code' => 'WH-001',
            'name' => 'Main Warehouse',
            'location' => 'Lagos',
        ]);

        $response = $this->actingAs($user)
            ->delete(route('warehouses.destroy', $warehouse));

        $response->assertRedirect(route('warehouses.index'));
        $response->assertSessionHas('success', 'Warehouse deleted successfully.');
        $this->assertDatabaseMissing('warehouses', ['id' => $warehouse->id]);
    }
}
