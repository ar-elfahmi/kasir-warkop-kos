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

    public function test_adjustment_page_shows_form(): void
    {
        $user = User::factory()->create();
        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi', 'stock' => 10]);

        $response = $this->actingAs($user)->get('/stock/adjust');

        $response->assertOk();
        $response->assertSee('Koreksi Stok');
    }

    public function test_adjustment_increase_stock(): void
    {
        $user = User::factory()->create();
        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi', 'stock' => 10]);

        $response = $this->actingAs($user)->post('/stock/adjust', [
            'menu_item_id' => $item->id,
            'quantity' => 3,
            'note' => 'Koreksi karena ada sisa',
            'adjustment_type' => 'adjustment_increase',
        ]);

        $response->assertRedirect('/stock');
        $item->refresh();
        $this->assertEquals(13, $item->stock);

        $this->assertDatabaseHas('stock_entries', [
            'menu_item_id' => $item->id,
            'quantity' => 3,
            'note' => 'Koreksi karena ada sisa',
            'type' => 'adjustment_increase',
        ]);
    }

    public function test_adjustment_decrease_stock(): void
    {
        $user = User::factory()->create();
        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi', 'stock' => 10]);

        $response = $this->actingAs($user)->post('/stock/adjust', [
            'menu_item_id' => $item->id,
            'quantity' => 4,
            'note' => 'Koreksi karena rusak',
            'adjustment_type' => 'adjustment_decrease',
        ]);

        $response->assertRedirect('/stock');
        $item->refresh();
        $this->assertEquals(6, $item->stock);

        $this->assertDatabaseHas('stock_entries', [
            'menu_item_id' => $item->id,
            'quantity' => 4,
            'note' => 'Koreksi karena rusak',
            'type' => 'adjustment_decrease',
        ]);
    }

    public function test_adjustment_decrease_stock_fails_when_insufficient(): void
    {
        $user = User::factory()->create();
        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi', 'stock' => 3]);

        $response = $this->actingAs($user)->post('/stock/adjust', [
            'menu_item_id' => $item->id,
            'quantity' => 5,
            'note' => 'Koreksi karena rusak',
            'adjustment_type' => 'adjustment_decrease',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['quantity']);
        $item->refresh();
        $this->assertEquals(3, $item->stock); // unchanged

        // No new stock entry should be created
        $this->assertDatabaseMissing('stock_entries', [
            'menu_item_id' => $item->id,
            'quantity' => 5,
            'note' => 'Koreksi karena rusak',
            'type' => 'adjustment_decrease',
        ]);
    }

    public function test_adjustment_history_shows_on_stock_page(): void
    {
        $user = User::factory()->create();
        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi', 'stock' => 10]);

        // Add a restock
        $this->actingAs($user)->post('/stock/restock', [
            'menu_item_id' => $item->id,
            'quantity' => 2,
            'note' => 'Restok baru',
        ]);

        // Add an adjustment increase
        $this->actingAs($user)->post('/stock/adjust', [
            'menu_item_id' => $item->id,
            'quantity' => 1,
            'note' => 'Koreksi tambah',
            'adjustment_type' => 'adjustment_increase',
        ]);

        // Add an adjustment decrease
        $this->actingAs($user)->post('/stock/adjust', [
            'menu_item_id' => $item->id,
            'quantity' => 1,
            'note' => 'Koreksi kurangi',
            'adjustment_type' => 'adjustment_decrease',
        ]);

        $response = $this->actingAs($user)->get('/stock');

        // Check that all entries are visible
        $response->assertSee('Restok baru');
        $response->assertSee('Koreksi tambah');
        $response->assertSee('Koreksi kurangi');

        // Check quantities
        $response->assertSee('2');
        $response->assertSee('1'); // adjustment increase
        $response->assertSee('1'); // adjustment decrease (note: we see two 1's, but that's okay for now)
    }
}
