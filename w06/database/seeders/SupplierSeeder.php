<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::insert([
            ['name' => 'Supplier A', 'email' => 'a@example.com'],
            ['name' => 'Supplier B', 'email' => 'b@example.com'],
            ['name' => 'Supplier C', 'email' => 'c@example.com'],
            ['name' => 'Supplier D', 'email' => 'd@example.com'],
            ['name' => 'Supplier E', 'email' => 'e@example.com'],
        ]);
    }
}
