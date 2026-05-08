<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Variant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VariantTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_variant_with_size(): void
    {
        $category = Category::create(['name' => 'Minuman']);
        $menuItem = MenuItem::create([
            'category_id' => $category->id,
            'name' => 'Kopi Susu',
            'description' => 'Kopi dengan susu',
            'stock' => 0,
        ]);

        $response = $this->actingAs(\App\Models\User::factory()->create())
            ->post('/variants', [
                'menu_item_id' => $menuItem->id,
                'size' => 'besar',
                'price' => 15000,
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('variants', [
            'menu_item_id' => $menuItem->id,
            'size' => 'besar',
            'price' => 15000,
        ]);
    }
}
