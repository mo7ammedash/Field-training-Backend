<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductAccessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_view_products()
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
    }

    /** @test */
    public function guest_cannot_access_create_product_page()
    {
        $response = $this->get('/products/create');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_create_product()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/products/create');

        $response->assertStatus(200);
    }

    /** @test */
    public function user_cannot_edit_product_of_another_user()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $owner->id,
        ]);

        $response = $this->actingAs($otherUser)
            ->get("/products/{$product->id}/edit");

        $response->assertStatus(403);
    }
}
