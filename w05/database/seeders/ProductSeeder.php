<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->count() == 0) {
            $this->command->info('No categories found, skipping product seeding.');
            return;
        }

        $products = [
            ['name' => 'Smartphone', 'price' => 500, 'category' => 'Electronics'],
            ['name' => 'Laptop', 'price' => 1200, 'category' => 'Electronics'],
            ['name' => 'T-Shirt', 'price' => 25, 'category' => 'Fashion'],
            ['name' => 'Sofa', 'price' => 800, 'category' => 'Home'],
            ['name' => 'Football', 'price' => 30, 'category' => 'Sports'],
            ['name' => 'Novel Book', 'price' => 15, 'category' => 'Books'],
        ];

        foreach ($products as $p) {
            $category = $categories->where('name', $p['category'])->first();
            if ($category) {
                Product::create([
                    'name' => $p['name'],
                    'price' => $p['price'],
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
