<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\User;
use App\Models\Variant;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected CartService $cart;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cart = app(CartService::class);
    }

    private function seedCart(): void
    {
        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi', 'stock' => 10]);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 5000]);
        $this->cart->addItem($variant->id, 2);
    }

    public function test_checkout_page_shows_cart_summary(): void
    {
        $user = User::factory()->create();
        $this->seedCart();

        $response = $this->actingAs($user)->get('/pos/checkout');

        $response->assertOk();
        $response->assertSee('Pembayaran');
        $response->assertSee('Kopi');
        $response->assertSee('10000');
    }

    public function test_checkout_with_tunai(): void
    {
        $user = User::factory()->create();
        $this->seedCart();

        $response = $this->actingAs($user)->post('/pos/checkout/process', [
            'payment_method' => 'tunai',
            'paid_amount' => 20000,
        ]);

        $response->assertRedirect('/pos/receipt/1');
        $this->assertDatabaseHas('transactions', [
            'id' => 1,
            'total' => 10000,
            'payment_method' => 'tunai',
            'paid_amount' => 20000,
            'change_amount' => 10000,
        ]);
        $this->assertDatabaseHas('transaction_items', [
            'transaction_id' => 1,
            'qty' => 2,
        ]);
        $this->assertEmpty($this->cart->items());
    }

    public function test_checkout_with_qris(): void
    {
        $user = User::factory()->create();
        $this->seedCart();

        $response = $this->actingAs($user)->post('/pos/checkout/process', [
            'payment_method' => 'qris',
        ]);

        $response->assertRedirect('/pos/receipt/1');
        $this->assertDatabaseHas('transactions', [
            'id' => 1,
            'total' => 10000,
            'payment_method' => 'qris',
            'paid_amount' => 10000,
            'change_amount' => 0,
        ]);
    }

    public function test_checkout_fails_when_stock_insufficient(): void
    {
        $user = User::factory()->create();
        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi', 'stock' => 1]);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 5000]);
        $this->cart->addItem($variant->id, 2);

        $response = $this->actingAs($user)->post('/pos/checkout/process', [
            'payment_method' => 'tunai',
            'paid_amount' => 10000,
        ]);

        $response->assertSessionHasErrors('stock');
        $this->assertDatabaseCount('transactions', 0);
        $this->assertCount(1, $this->cart->items());
    }

    public function test_checkout_decrements_stock(): void
    {
        $user = User::factory()->create();
        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi', 'stock' => 10]);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 5000]);
        $this->cart->addItem($variant->id, 3);

        $this->actingAs($user)->post('/pos/checkout/process', [
            'payment_method' => 'tunai',
            'paid_amount' => 15000,
        ]);

        $item->refresh();
        $this->assertEquals(7, $item->stock);
    }

    public function test_checkout_requires_valid_payment_method(): void
    {
        $user = User::factory()->create();
        $this->seedCart();

        $response = $this->actingAs($user)->post('/pos/checkout/process', [
            'payment_method' => 'kartu',
            'paid_amount' => 10000,
        ]);

        $response->assertSessionHasErrors('payment_method');
    }

    public function test_checkout_with_tunai_requires_paid_amount(): void
    {
        $user = User::factory()->create();
        $this->seedCart();

        $response = $this->actingAs($user)->post('/pos/checkout/process', [
            'payment_method' => 'tunai',
        ]);

        $response->assertSessionHasErrors('paid_amount');
    }

    public function test_checkout_cart_empty_redirects_back(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/pos/checkout/process', [
            'payment_method' => 'tunai',
            'paid_amount' => 10000,
        ]);

        $response->assertRedirect('/pos');
    }

    public function test_receipt_page_shows_transaction(): void
    {
        $user = User::factory()->create();
        $this->seedCart();
        $this->actingAs($user)->post('/pos/checkout/process', [
            'payment_method' => 'tunai',
            'paid_amount' => 20000,
        ]);

        $response = $this->actingAs($user)->get('/pos/receipt/1');

        $response->assertOk();
        $response->assertSee('Struk');
        $response->assertSee('Kopi');
        $response->assertSee('Tunai');
        $response->assertSee('10.000');
        $response->assertSee('20.000');
        $response->assertSee('Kembali');
    }

    public function test_checkout_tunai_requires_paid_amount_greater_or_equal_total(): void
    {
        $user = User::factory()->create();
        $this->seedCart();

        $response = $this->actingAs($user)->post('/pos/checkout/process', [
            'payment_method' => 'tunai',
            'paid_amount' => 5000,
        ]);

        $response->assertSessionHasErrors('paid_amount');
        $this->assertDatabaseCount('transactions', 0);
    }
}