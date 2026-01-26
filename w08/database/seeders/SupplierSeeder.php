<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['name' => 'Supplier A', 'email' => 'a@supplier.com'],
            ['name' => 'Supplier B', 'email' => 'b@supplier.com'],
            ['name' => 'Supplier C', 'email' => 'c@supplier.com'],
            ['name' => 'Supplier D', 'email' => 'd@supplier.com'],
            ['name' => 'Supplier E', 'email' => 'e@supplier.com'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
