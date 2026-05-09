<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    private function seedTransaction(): void
    {
        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi']);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 5000, 'stock' => 100]);

        $tx = Transaction::create([
            'total' => 10000,
            'payment_method' => 'tunai',
            'paid_amount' => 10000,
            'change_amount' => 0,
        ]);

        TransactionItem::create([
            'transaction_id' => $tx->id,
            'variant_id' => $variant->id,
            'item_name' => 'Kopi',
            'variant_label' => 'Small',
            'qty' => 2,
            'unit_price' => 5000,
            'total_price' => 10000,
        ]);
    }

    public function test_report_page_shows_daily_summary(): void
    {
        $user = User::factory()->create();
        $this->seedTransaction();

        $response = $this->actingAs($user)->get('/laporan');

        $response->assertOk();
        $response->assertSee('Laporan');
        $response->assertSee('10.000');
        $response->assertSee('2');
    }

    public function test_report_page_filters_by_date(): void
    {
        $user = User::factory()->create();
        $this->seedTransaction();

        $response = $this->actingAs($user)->get('/laporan?date_from=2020-01-01&date_to=2020-01-01');

        $response->assertOk();
        $response->assertSee('Tidak ada transaksi');
    }

    public function test_report_shows_category_summary(): void
    {
        $user = User::factory()->create();
        $this->seedTransaction();

        $response = $this->actingAs($user)->get('/laporan');

        $response->assertOk();
        $response->assertSee('Minuman');
    }

    public function test_report_shows_transaction_history(): void
    {
        $user = User::factory()->create();
        $this->seedTransaction();

        $response = $this->actingAs($user)->get('/laporan');

        $response->assertOk();
        $response->assertSee('Kopi');
        $response->assertSee('Tunai');
    }

    public function test_report_shows_no_data_for_empty_range(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/laporan?date_from=2020-01-01&date_to=2020-01-01');

        $response->assertOk();
    }

    public function test_transaction_timestamp_uses_wib_timezone(): void
    {
        $user = User::factory()->create();
        $this->seedTransaction();

        $transaction = Transaction::first();

        // Verify timezone config is Asia/Jakarta (WIB)
        $this->assertEquals('Asia/Jakarta', config('app.timezone'));

        // Verify created_at uses WIB timezone
        $createdAt = $transaction->created_at;
        $this->assertEquals('Asia/Jakarta', $createdAt->timezoneName);
    }

    public function test_report_filter_by_payment_method_tunai(): void
    {
        $user = User::factory()->create();

        // Create tunai transaction
        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi']);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 5000, 'stock' => 100]);

        $tx1 = Transaction::create([
            'total' => 10000,
            'payment_method' => 'tunai',
            'paid_amount' => 10000,
            'change_amount' => 0,
        ]);

        // Create qris transaction
        $tx2 = Transaction::create([
            'total' => 15000,
            'payment_method' => 'qris',
            'paid_amount' => 15000,
            'change_amount' => 0,
        ]);

        // Filter by tunai
        $response = $this->actingAs($user)->get('/laporan?payment_method=tunai');

        $response->assertOk();
        $response->assertSee('#1 — Tunai');
        $response->assertDontSee('#2 — QRIS');
    }

    public function test_report_filter_by_payment_method_qris(): void
    {
        $user = User::factory()->create();

        // Create tunai transaction
        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi']);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 5000, 'stock' => 100]);

        $tx1 = Transaction::create([
            'total' => 10000,
            'payment_method' => 'tunai',
            'paid_amount' => 10000,
            'change_amount' => 0,
        ]);

        // Create qris transaction
        $tx2 = Transaction::create([
            'total' => 15000,
            'payment_method' => 'qris',
            'paid_amount' => 15000,
            'change_amount' => 0,
        ]);

        // Filter by qris
        $response = $this->actingAs($user)->get('/laporan?payment_method=qris');

        $response->assertOk();
        $response->assertSee('#2 — QRIS');
        $response->assertDontSee('#1 — Tunai');
    }

    public function test_report_shows_grand_total(): void
    {
        $user = User::factory()->create();

        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi']);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 5000, 'stock' => 100]);

        // Create transactions for today
        Transaction::create([
            'total' => 10000,
            'payment_method' => 'tunai',
            'paid_amount' => 10000,
            'change_amount' => 0,
        ]);

        Transaction::create([
            'total' => 15000,
            'payment_method' => 'qris',
            'paid_amount' => 15000,
            'change_amount' => 0,
        ]);

        $response = $this->actingAs($user)->get('/laporan');

        $response->assertOk();
        $response->assertSee('Total Transaksi');
        $response->assertSee('Rp 25.000');
    }

    public function test_report_grand_total_updates_with_filter(): void
    {
        $user = User::factory()->create();

        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi']);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 5000, 'stock' => 100]);

        Transaction::create([
            'total' => 10000,
            'payment_method' => 'tunai',
            'paid_amount' => 10000,
            'change_amount' => 0,
        ]);

        Transaction::create([
            'total' => 15000,
            'payment_method' => 'qris',
            'paid_amount' => 15000,
            'change_amount' => 0,
        ]);

        // Filter by tunai - total should be 10000
        $response = $this->actingAs($user)->get('/laporan?payment_method=tunai');

        $response->assertOk();
        $response->assertSee('Total Transaksi');
        $response->assertSee('Rp 10.000');
        $response->assertDontSee('Rp 25.000');
    }

    public function test_category_total_respects_payment_filter(): void
    {
        $user = User::factory()->create();

        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi']);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 5000, 'stock' => 100]);

        // Tunai transaction: 2 x 5000 = 10000
        $tx1 = Transaction::create([
            'total' => 10000,
            'payment_method' => 'tunai',
            'paid_amount' => 10000,
            'change_amount' => 0,
        ]);
        TransactionItem::create([
            'transaction_id' => $tx1->id,
            'variant_id' => $variant->id,
            'item_name' => 'Kopi',
            'variant_label' => 'Small',
            'qty' => 2,
            'unit_price' => 5000,
            'total_price' => 10000,
        ]);

        // QRIS transaction: 3 x 5000 = 15000
        $tx2 = Transaction::create([
            'total' => 15000,
            'payment_method' => 'qris',
            'paid_amount' => 15000,
            'change_amount' => 0,
        ]);
        TransactionItem::create([
            'transaction_id' => $tx2->id,
            'variant_id' => $variant->id,
            'item_name' => 'Kopi',
            'variant_label' => 'Small',
            'qty' => 3,
            'unit_price' => 5000,
            'total_price' => 15000,
        ]);

        // Filter by tunai - category total should be 10000 (not 25000)
        $response = $this->actingAs($user)->get('/laporan?payment_method=tunai');

        $response->assertOk();
        $response->assertSee('Rp 10.000');
        $response->assertDontSee('Rp 25.000');
    }

    public function test_item_total_respects_payment_filter(): void
    {
        $user = User::factory()->create();

        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi']);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 5000, 'stock' => 100]);

        // Tunai transaction: 2 x 5000 = 10000
        $tx1 = Transaction::create([
            'total' => 10000,
            'payment_method' => 'tunai',
            'paid_amount' => 10000,
            'change_amount' => 0,
        ]);
        TransactionItem::create([
            'transaction_id' => $tx1->id,
            'variant_id' => $variant->id,
            'item_name' => 'Kopi',
            'variant_label' => 'Small',
            'qty' => 2,
            'unit_price' => 5000,
            'total_price' => 10000,
        ]);

        // QRIS transaction: 3 x 5000 = 15000
        $tx2 = Transaction::create([
            'total' => 15000,
            'payment_method' => 'qris',
            'paid_amount' => 15000,
            'change_amount' => 0,
        ]);
        TransactionItem::create([
            'transaction_id' => $tx2->id,
            'variant_id' => $variant->id,
            'item_name' => 'Kopi',
            'variant_label' => 'Small',
            'qty' => 3,
            'unit_price' => 5000,
            'total_price' => 15000,
        ]);

        // Filter by tunai - item total should be 10000 (not 25000)
        $response = $this->actingAs($user)->get('/laporan?payment_method=tunai');

        $response->assertOk();
        $response->assertSee('Rp 10.000');
        $response->assertDontSee('Rp 25.000');
    }

    public function test_filter_semua_shows_all_transactions(): void
    {
        $user = User::factory()->create();

        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi']);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 5000, 'stock' => 100]);

        // Tunai transaction
        $tx1 = Transaction::create([
            'total' => 10000,
            'payment_method' => 'tunai',
            'paid_amount' => 10000,
            'change_amount' => 0,
        ]);
        TransactionItem::create([
            'transaction_id' => $tx1->id,
            'variant_id' => $variant->id,
            'item_name' => 'Kopi',
            'variant_label' => 'Small',
            'qty' => 2,
            'unit_price' => 5000,
            'total_price' => 10000,
        ]);

        // QRIS transaction
        $tx2 = Transaction::create([
            'total' => 15000,
            'payment_method' => 'qris',
            'paid_amount' => 15000,
            'change_amount' => 0,
        ]);
        TransactionItem::create([
            'transaction_id' => $tx2->id,
            'variant_id' => $variant->id,
            'item_name' => 'Kopi',
            'variant_label' => 'Small',
            'qty' => 3,
            'unit_price' => 5000,
            'total_price' => 15000,
        ]);

        // Filter by "Semua" (empty payment_method) - should show both transactions
        $response = $this->actingAs($user)->get('/laporan?payment_method=');

        $response->assertOk();
        $response->assertSee('#1 — Tunai');
        $response->assertSee('#2 — QRIS');
        $response->assertSee('Rp 25.000');
    }

    public function test_riwayat_transaksi_has_total_and_no_total_hari_ini(): void
    {
        $user = User::factory()->create();

        $cat = Category::create(['name' => 'Minuman']);
        $item = MenuItem::create(['category_id' => $cat->id, 'name' => 'Kopi']);
        $variant = Variant::create(['menu_item_id' => $item->id, 'size' => 'small', 'price' => 5000, 'stock' => 100]);

        Transaction::create([
            'total' => 10000,
            'payment_method' => 'tunai',
            'paid_amount' => 10000,
            'change_amount' => 0,
        ]);

        $response = $this->actingAs($user)->get('/laporan');

        $response->assertOk();
        // Total Hari Ini section should be removed
        $response->assertDontSee('Total Hari Ini');
        // Riwayat Transaksi should have total at bottom
        $response->assertSee('Total Transaksi');
        $response->assertSee('Rp 10.000');
    }
}
