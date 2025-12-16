<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class Productseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run(): void
    {
        Product::create([
            'name' => 'Laptop',
            'price' => 1200.00,
        ]);

        Product::create([
            'name' => 'Smartphone',
            'price' => 800.00,
        ]);

        Product::create([
            'name' => 'Headphones',
            'price' => 150.00,
        ]);
    }
}
