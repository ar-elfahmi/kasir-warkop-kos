<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Topping;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\TransactionItemTopping;
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
}
