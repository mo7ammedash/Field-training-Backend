<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Supplier;

class ProductSupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = Supplier::all();

        Product::all()->each(function ($product) use ($suppliers) {
            $productSuppliers = $suppliers->random(rand(1, 3))->mapWithKeys(function ($supplier) {
                return [$supplier->id => [
                    'cost_price' => rand(50, 1000),
                    'lead_time_days' => rand(2, 14)
                ]];
            });

            $product->suppliers()->sync($productSuppliers);
        });
    }
}
