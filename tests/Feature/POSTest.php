<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Topping;
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
            'toppings' => [],
        ]);

        $response->assertRedirect('/pos');
        $cart = app(CartService::class)->items();
        $this->assertCount(1, $cart);
    }

    public function test_authenticated_user_can_add_item_with_toppings(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Makanan']);
        $item = MenuItem::create(['category_id' => $category->id, 'name' => 'Mie']);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => null, 'price' => 7000, 'stock' => 10]);
        $topping = Topping::create(['name' => 'Telur', 'price' => 3000]);

        $response = $this->actingAs($user)->post('/pos/cart/add', [
            'variant_id' => $variant->id,
            'qty' => 1,
            'toppings' => [['id' => $topping->id, 'price' => 3000, 'name' => 'Telur']],
        ]);

        $response->assertRedirect('/pos');
        $cart = app(CartService::class)->items();
        $this->assertCount(1, $cart);
        $this->assertEquals(10000, app(CartService::class)->total());
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
            'toppings' => [],
        ]);

        $cart = app(CartService::class)->items();
        $key = array_key_first($cart);

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
            'toppings' => [],
        ]);

        $response = $this->actingAs($user)->post('/pos/cart/clear');
        $response->assertRedirect('/pos');
        $this->assertEmpty(app(CartService::class)->items());
    }
}
