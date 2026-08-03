<?php

namespace Tests\Feature;

use App\Models\ItemType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTypeUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_update_item_type(): void
    {
        $itemType = ItemType::create([
            'name' => 'Old Type',
            'description' => 'Old description',
        ]);

        $response = $this->put(route('item-types.update', $itemType), [
            'name' => 'Updated Type',
            'description' => 'Updated description',
        ]);

        $response->assertRedirect(route('item-types.index'));
        $this->assertDatabaseHas('item_types', [
            'id' => $itemType->id,
            'name' => 'Updated Type',
            'description' => 'Updated description',
        ]);
    }
}
