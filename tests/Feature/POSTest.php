<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\User;
use App\Models\Variant;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class POSTest extends TestCase
{
    use RefreshDatabase;

    public function test_pos_page_shows_menu_items_and_categories(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $category->id, 'name' => 'Kopi']);
        Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 5000, 'stock' => 10]);

        $response = $this->actingAs($user)->get('/pos');

        $response->assertOk();
        $response->assertSee('Minuman');
        $response->assertSee('Kopi');
        $response->assertSee('5000');
    }

    public function test_authenticated_user_can_add_item_to_cart(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $category->id, 'name' => 'Kopi']);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 5000, 'stock' => 10]);

        $response = $this->actingAs($user)->post('/pos/cart/add', [
            'variant_id' => $variant->id,
            'qty' => 2,
        ]);

        $response->assertRedirect('/pos');
        $cart = app(CartService::class)->items();
        $this->assertCount(1, $cart);
    }

    public function test_authenticated_user_can_remove_item_from_cart(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $category->id, 'name' => 'Kopi']);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 5000, 'stock' => 10]);

        $this->actingAs($user)->post('/pos/cart/add', [
            'variant_id' => $variant->id,
            'qty' => 1,
        ]);

        $cart = app(CartService::class)->items();
        $key = (string) $variant->id;

        $response = $this->actingAs($user)->post('/pos/cart/remove', ['key' => $key]);
        $response->assertRedirect('/pos');
        $this->assertEmpty(app(CartService::class)->items());
    }

    public function test_authenticated_user_can_clear_cart(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $category->id, 'name' => 'Kopi']);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 5000, 'stock' => 10]);

        $this->actingAs($user)->post('/pos/cart/add', [
            'variant_id' => $variant->id,
            'qty' => 1,
        ]);

        $response = $this->actingAs($user)->post('/pos/cart/clear');
        $response->assertRedirect('/pos');
        $this->assertEmpty(app(CartService::class)->items());
    }
}