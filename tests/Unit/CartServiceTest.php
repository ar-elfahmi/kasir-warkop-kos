<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Variant;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartServiceTest extends TestCase
{
    use RefreshDatabase;

    private CartService $cart;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cart = new CartService();
    }

    public function test_can_add_item_to_cart()
    {
        $category = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $category->id, 'name' => 'Kopi']);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 7000, 'stock' => 100]);

        $this->cart->addItem($variant->id, 1);

        $this->assertCount(1, $this->cart->items());
        $this->assertEquals(7000, $this->cart->total());
    }

    public function test_can_add_multiple_items()
    {
        $cat = Category::create(['name' => 'Minuman']);
        $item1 = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi']);
        $variant1 = Variant::create(['menu_item_id' => $item1->id, 'size' => 'small', 'price' => 7000, 'stock' => 100]);
        $item2 = MenuItem::create(['category_id' => $cat->id, 'name' => 'Teh']);
        $variant2 = Variant::create(['menu_item_id' => $item2->id, 'size' => 'besar', 'price' => 8000, 'stock' => 100]);

        $this->cart->addItem($variant1->id, 2);
        $this->cart->addItem($variant2->id, 1);

        $this->assertCount(2, $this->cart->items());
        $this->assertEquals(22000, $this->cart->total());
    }

    public function test_can_clear_cart()
    {
        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi']);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 7000, 'stock' => 100]);

        $this->cart->addItem($variant->id, 1);
        $this->cart->clear();

        $this->assertCount(0, $this->cart->items());
        $this->assertEquals(0, $this->cart->total());
    }

    public function test_can_remove_item_from_cart()
    {
        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi']);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 7000, 'stock' => 100]);

        $cartKey = $this->cart->addItem($variant->id, 1);
        $this->assertCount(1, $this->cart->items());

        $this->cart->removeItem($cartKey);
        $this->assertCount(0, $this->cart->items());
    }
}