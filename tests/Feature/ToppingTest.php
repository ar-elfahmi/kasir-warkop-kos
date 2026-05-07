<?php

namespace Tests\Feature;

use App\Models\Topping;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToppingTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_topping()
    {
        $response = $this->actingAs(User::factory()->create())
            ->postJson('/toppings', [
                'name' => 'Telur',
                'price' => 3000,
            ]);

        $response->assertCreated();
        $this->assertDatabaseHas('toppings', ['name' => 'Telur', 'price' => 3000]);
    }

    public function test_can_update_topping()
    {
        $topping = Topping::create(['name' => 'Sosis', 'price' => 3000]);

        $response = $this->actingAs(User::factory()->create())
            ->putJson("/toppings/{$topping->id}", [
                'name' => 'Sosis Besar',
                'price' => 5000,
            ]);

        $response->assertOk();
        $this->assertDatabaseHas('toppings', ['name' => 'Sosis Besar', 'price' => 5000]);
    }

    public function test_can_delete_topping()
    {
        $topping = Topping::create(['name' => 'Nugget', 'price' => 3000]);

        $response = $this->actingAs(User::factory()->create())
            ->deleteJson("/toppings/{$topping->id}");

        $response->assertNoContent();
        $this->assertDatabaseMissing('toppings', ['name' => 'Nugget']);
    }

    public function test_validation_requires_name_and_price()
    {
        $response = $this->actingAs(User::factory()->create())
            ->postJson('/toppings', []);

        $response->assertJsonValidationErrors(['name', 'price']);
    }

    public function test_can_assign_topping_to_menu_item()
    {
        $category = \App\Models\Category::create(['name' => 'Makanan']);
        $menuItem = \App\Models\MenuItem::create(['category_id' => $category->id, 'name' => 'Nasi Teluyam']);
        $topping = Topping::create(['name' => 'Telur', 'price' => 3000]);

        $response = $this->actingAs(User::factory()->create())
            ->postJson('/menu-items/toppings', [
                'menu_item_id' => $menuItem->id,
                'topping_ids' => [$topping->id],
            ]);

        $response->assertOk();
        $this->assertDatabaseHas('menu_item_topping', [
            'menu_item_id' => $menuItem->id,
            'topping_id' => $topping->id,
        ]);
    }
}
