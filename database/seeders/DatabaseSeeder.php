<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Disable foreign key checks for truncation
        DB::statement('PRAGMA foreign_keys = OFF;');

        // Truncate tables in reverse foreign key order
        \App\Models\User::truncate();
        \App\Models\Variant::truncate();
        \App\Models\StockEntry::truncate();
        \App\Models\MenuItem::truncate();
        \App\Models\Category::truncate();

        // Re-enable foreign key checks after truncation
        DB::statement('PRAGMA foreign_keys = ON;');

        \App\Models\Category::insert([
            ['id' => 1, 'name' => 'Main Course'],
            ['id' => 2, 'name' => 'Noodle'],
            ['id' => 3, 'name' => 'Snack'],
            ['id' => 4, 'name' => 'Cigarettes'],
            ['id' => 5, 'name' => 'Coffee'],
            ['id' => 6, 'name' => 'Non-coffee'],
            ['id' => 7, 'name' => 'Energy Drink'],
        ]);

        $menuItems = [
            ['category_id' => 1, 'name' => 'Nasi Teluyam'],
            ['category_id' => 1, 'name' => 'Nasi Telusis'],
            ['category_id' => 1, 'name' => 'Nasi Omelette Mie'],
            ['category_id' => 2, 'name' => 'Indomie Goreng'],
            ['category_id' => 2, 'name' => 'Indomie Rendang'],
            ['category_id' => 2, 'name' => 'Indomie Aceh'],
            ['category_id' => 2, 'name' => 'Indomie Cabe Ijo'],
            ['category_id' => 2, 'name' => 'Indomie Ayam Bawang'],
            ['category_id' => 2, 'name' => 'Indomie Kari Ayam'],
            ['category_id' => 2, 'name' => 'Sedap Goreng'],
            ['category_id' => 2, 'name' => 'Sedap Cheese Buldak'],
            ['category_id' => 2, 'name' => 'Sedap Singapore Laksa'],
            ['category_id' => 2, 'name' => 'Spaghetti Carbonara'],
            ['category_id' => 2, 'name' => 'Spaghetti Bolognese'],
            ['category_id' => 2, 'name' => 'Topping Telur'],
            ['category_id' => 2, 'name' => 'Topping Sosis'],
            ['category_id' => 2, 'name' => 'Topping Nugget'],
            ['category_id' => 3, 'name' => 'Kentang Goreng'],
            ['category_id' => 3, 'name' => 'Cireng'],
            ['category_id' => 3, 'name' => 'Sosis'],
            ['category_id' => 3, 'name' => 'Nugget'],
            ['category_id' => 4, 'name' => 'Surya'],
            ['category_id' => 4, 'name' => 'A Mild'],
            ['category_id' => 4, 'name' => 'Mix'],
        ];

        $variants = [];
        foreach ($menuItems as $item) {
            $mi = \App\Models\MenuItem::create([
                'category_id' => $item['category_id'],
                'name' => $item['name'],
                'stock' => 100,
            ]);
            $price = match ($item['category_id']) {
                1 => 12000,
                2 => match (true) {
                    str_contains($item['name'], 'Spaghetti') => 12000,
                    str_contains($item['name'], 'Topping') => 3000,
                    default => 7000,
                },
                3 => 10000,
                default => 0,
            };
            $variants[] = [
                'menu_item_id' => $mi->id,
                'size' => null,
                'price' => $price,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $minumanItems = [
            ['cat' => 5, 'name' => 'Kopi Racik', 'small' => 7000, 'jumbo' => null],
            ['cat' => 5, 'name' => 'Kopi Susu Racik', 'small' => 9000, 'jumbo' => null],
            ['cat' => 5, 'name' => 'Top Kopi Gula Aren', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 5, 'name' => 'Torabika Capucino', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 5, 'name' => 'Good Day Mocafrio', 'small' => 12000, 'jumbo' => 15000],
            ['cat' => 5, 'name' => 'Good Day Capucino', 'small' => 9000, 'jumbo' => 12000],
            ['cat' => 5, 'name' => 'Luwak White', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 5, 'name' => 'Caffino Latte Hazelnut', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 5, 'name' => 'ABC Susu', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 5, 'name' => 'ABC Klepon', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 5, 'name' => 'Tora Moka', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Es Teh Racik', 'small' => 5000, 'jumbo' => 8000],
            ['cat' => 6, 'name' => 'Teh Tarik', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'The Poci Gula Aren', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Permen Karet', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Taro', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Popcorn Caramel', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Vanila Blue', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Red Velvet', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Italian Cioccolato', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Strawberry', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Melon', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Mangga', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Cookies & Cream', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Cheese Cream', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Choco Cheese', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Choco Cream', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Anggur', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Anggur Hijau', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Jeruk Maroko', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Jeruk Peras', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'American Sweet Orange', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Markisa', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Milky Orange', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Milo', 'small' => 9000, 'jumbo' => 12000],
            ['cat' => 6, 'name' => 'Hilo Avocado', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Hilo Choco Banana', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Hilo Choco Hazelnut', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Hilo Taro', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Ovaltine', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Beng-Beng', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Dancow Coklat', 'small' => 12000, 'jumbo' => 15000],
            ['cat' => 6, 'name' => 'Dancow Vanila', 'small' => 12000, 'jumbo' => 15000],
            ['cat' => 6, 'name' => 'Energen Coklat', 'small' => 9000, 'jumbo' => 12000],
            ['cat' => 6, 'name' => 'Energen Vanila', 'small' => 9000, 'jumbo' => 12000],
            ['cat' => 6, 'name' => 'Frisian Flag Coklat', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Frisian Flag Vanila', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Chocolatos Matcha', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 6, 'name' => 'Air Mineral', 'small' => null, 'jumbo' => null, 'price' => 5000],
            ['cat' => 7, 'name' => 'Susu Jahe', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 7, 'name' => 'Wedang Jahe', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 7, 'name' => 'Kuku Bima', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 7, 'name' => 'Hemaviton', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 7, 'name' => 'Extra Joss', 'small' => 7000, 'jumbo' => 10000],
            ['cat' => 7, 'name' => 'Josua', 'small' => 9000, 'jumbo' => 12000],
        ];

        foreach ($minumanItems as $item) {
            $mi = \App\Models\MenuItem::create([
                'category_id' => $item['cat'],
                'name' => $item['name'],
                'stock' => 100,
            ]);
            if (isset($item['price'])) {
                $variants[] = [
                    'menu_item_id' => $mi->id,
                    'size' => null,
                    'price' => $item['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            } else {
                if ($item['small']) {
                    $variants[] = [
                        'menu_item_id' => $mi->id,
                        'size' => 'small',
                        'price' => $item['small'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                if ($item['jumbo']) {
                    $variants[] = [
                        'menu_item_id' => $mi->id,
                        'size' => 'jumbo',
                        'price' => $item['jumbo'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        \DB::table('variants')->insert($variants);

        User::factory()->create([
            'name' => 'Test User',
        ]);

        User::factory()->create([
            'name' => 'Kasir Warkop Kos',
            'username' => 'kasir',
            'password' => bcrypt('kasir123'),
        ]);
    }
}
