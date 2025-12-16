# Laravel Product Database Demo

## Setup Instructions

1. run the program
    >> php artisan server
2. create Model and Migration
    >> php artisan make:model Product -m
3. run the Migration to create Product Table
    >> php artisan migrate > yes
4. create Seeders
    >> php artisan make:seeder Productseeder
5. Run seeders:
    >> php artisan db:seed
6. Verify data using Tinker:
    >> php artisan tinker > use App\Model\Product; > Product::all();
