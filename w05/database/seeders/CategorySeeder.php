<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Electronics', 'Fashion', 'Home', 'Sports', 'Books'];
        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
