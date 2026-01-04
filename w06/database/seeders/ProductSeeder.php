<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            ['name' => 'Laptop', 'price' => 1200],
            ['name' => 'Smartphone', 'price' => 800],
            ['name' => 'Headphones', 'price' => 150],
            ['name' => 'Smartwatch', 'price' => 250],
            ['name' => 'Keyboard', 'price' => 100],
        ]);
    }
}
