<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_menu_item(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Minuman']);

        $response = $this->actingAs($user)->post('/menu-items', [
            'category_id' => $category->id,
            'name' => 'Kopi Susu',
            'description' => 'Kopi dengan susu segar',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('menu_items', [
            'name' => 'Kopi Susu',
            'category_id' => $category->id,
        ]);
    }
}
