<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_category(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/categories', [
            'name' => 'Minuman',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('categories', ['name' => 'Minuman']);
    }

    public function test_authenticated_user_can_update_category(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Minuman']);

        $response = $this->actingAs($user)->put("/categories/{$category->id}", [
            'name' => 'Makanan',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('categories', ['name' => 'Makanan']);
        $this->assertDatabaseMissing('categories', ['name' => 'Minuman']);
    }

    public function test_authenticated_user_can_delete_category(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Rokok']);

        $response = $this->actingAs($user)->delete("/categories/{$category->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('categories', ['name' => 'Rokok']);
    }

    public function test_create_category_validation_error_with_empty_name(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/categories', [
            'name' => '',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_create_category_validation_error_with_duplicate_name(): void
    {
        $user = User::factory()->create();
        Category::create(['name' => 'Minuman']);
        $response = $this->actingAs($user)->post('/categories', [
            'name' => 'Minuman',
        ]);

        $response->assertSessionHasErrors('name');
    }
}
