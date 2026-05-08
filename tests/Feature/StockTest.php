<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    public function test_stock_page_shows_menu_items_and_stock(): void
    {
        $user = User::factory()->create();
        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi', 'stock' => 10]);

        $response = $this->actingAs($user)->get('/stock');

        $response->assertOk();
        $response->assertSee('Kopi');
        $response->assertSee('10');
    }

    public function test_restock_page_shows_form(): void
    {
        $user = User::factory()->create();
        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi', 'stock' => 10]);

        $response = $this->actingAs($user)->get('/stock/restock');

        $response->assertOk();
        $response->assertSee('Tambah Stok');
    }

    public function test_restock_increments_stock(): void
    {
        $user = User::factory()->create();
        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi', 'stock' => 10]);

        $response = $this->actingAs($user)->post('/stock/restock', [
            'menu_item_id' => $item->id,
            'quantity' => 5,
            'note' => 'Restok dari supplier',
        ]);

        $response->assertRedirect('/stock');
        $item->refresh();
        $this->assertEquals(15, $item->stock);

        $this->assertDatabaseHas('stock_entries', [
            'menu_item_id' => $item->id,
            'quantity' => 5,
            'note' => 'Restok dari supplier',
        ]);
    }

    public function test_restock_validation_errors(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/stock/restock', [
            'menu_item_id' => '',
            'quantity' => '',
        ]);

        $response->assertSessionHasErrors(['menu_item_id', 'quantity']);
    }

    public function test_restock_history_shows_on_stock_page(): void
    {
        $user = User::factory()->create();
        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi', 'stock' => 10]);
        $this->actingAs($user)->post('/stock/restock', [
            'menu_item_id' => $item->id,
            'quantity' => 5,
            'note' => 'Restok dari supplier',
        ]);

        $response = $this->actingAs($user)->get('/stock');
        $response->assertSee('Restok dari supplier');
        $response->assertSee('5');
    }
}
