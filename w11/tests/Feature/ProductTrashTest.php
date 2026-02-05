<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTrashTest extends TestCase
{
    use RefreshDatabase;

    protected User $owner;
    protected User $otherUser;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        // Users
        $this->owner = User::factory()->create();
        $this->otherUser = User::factory()->create();

        // Category & Supplier
        $category = Category::factory()->create();
        $supplier = Supplier::factory()->create();

        // Product owned by $owner
        $this->product = Product::factory()->create([
            'user_id' => $this->owner->id,
            'category_id' => $category->id,
        ]);

        $this->product->suppliers()->attach($supplier->id, [
            'cost_price' => 100,
            'lead_time_days' => 3,
        ]);
    }

    /** @test */
    public function product_soft_delete_moves_to_trash()
    {
        $this->actingAs($this->owner)
            ->delete(route('products.destroy', $this->product->id))
            ->assertRedirect(route('products.index'));

        // Not visible in normal index
        $this->assertDatabaseMissing('products', [
            'id' => $this->product->id,
            'deleted_at' => null,
        ]);

        // Visible in trash
        $this->assertDatabaseHas('products', [
            'id' => $this->product->id,
        ]);

        $this->assertNotNull(Product::withTrashed()->find($this->product->id)->deleted_at);
    }

    /** @test */
    public function restore_product_returns_to_index()
    {
        $this->product->delete();

        $this->actingAs($this->owner)
            ->post(route('products.restore', $this->product->id))
            ->assertRedirect(route('products.trash'));

        $this->assertDatabaseHas('products', [
            'id' => $this->product->id,
            'deleted_at' => null,
        ]);
    }

    /** @test */
    public function force_delete_removes_product_permanently()
    {
        $this->product->delete();

        $this->actingAs($this->owner)
            ->delete(route('products.forceDelete', $this->product->id))
            ->assertRedirect(route('products.trash'));

        $this->assertDatabaseMissing('products', [
            'id' => $this->product->id,
        ]);
    }

    /** @test */
    public function non_owner_cannot_restore_or_force_delete()
    {
        $this->product->delete();

        // Restore
        $this->actingAs($this->otherUser)
            ->post(route('products.restore', $this->product->id))
            ->assertStatus(403);

        // Force Delete
        $this->actingAs($this->otherUser)
            ->delete(route('products.forceDelete', $this->product->id))
            ->assertStatus(403);
    }

    /** @test */
    public function admin_can_restore_and_force_delete_any_product()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->product->delete();

        // Restore
        $this->actingAs($admin)
            ->post(route('products.restore', $this->product->id))
            ->assertRedirect(route('products.trash'));

        $this->assertDatabaseHas('products', [
            'id' => $this->product->id,
            'deleted_at' => null,
        ]);

        // Delete again to test Force Delete
        $this->product->delete();

        $this->actingAs($admin)
            ->delete(route('products.forceDelete', $this->product->id))
            ->assertRedirect(route('products.trash'));

        $this->assertDatabaseMissing('products', [
            'id' => $this->product->id,
        ]);
    }
}
