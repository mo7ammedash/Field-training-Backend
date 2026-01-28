<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProductSupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = Supplier::all();

        Product::all()->each(function ($product) use ($suppliers) {
            $product->suppliers()->attach(
                $suppliers->random(rand(1, 3))->pluck('id')->toArray(),
                [
                    'cost_price' => rand(50, 300),
                    'lead_time_days' => rand(1, 14),
                ]
            );
        });
    }
}
