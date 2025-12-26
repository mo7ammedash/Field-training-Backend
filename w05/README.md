# Product Management System (Laravel)

## Project Overview

This is a simple **Product Management System** built using **Laravel**.  
It demonstrates how to design and implement a **One-to-Many relationship** between **Categories** and **Products** while following Laravel best practices.

The system allows managing products linked to categories, ensuring:

-   Data integrity
-   Optimized queries
-   Clean, responsive UI

---

## Features Implemented

-   **Relational Database**: Products linked to Categories via `category_id`.
-   **CRUD for Products**:
    -   Create, Read, Update, Delete
    -   Dynamic category dropdown in forms
-   **Form Validation**:
    -   `name`: required, string
    -   `price`: required, numeric
    -   `category_id`: required, must exist in `categories` table
-   **Eloquent Relationships**:
    -   `Product`: belongsTo Category
    -   `Category`: hasMany Products
-   **Query Optimization**: Eager loading to avoid N+1 problem
-   **Responsive UI**: Bootstrap-based, clean and consistent
-   **Seeder**: Adds 5 initial categories (Electronics, Fashion, Home, Sports, Books)

---

## Project Structure & Files

### Migrations

-   `database/migrations/xxxx_xx_xx_create_categories_table.php`
-   `database/migrations/xxxx_xx_xx_create_products_table.php`

### Seeders

-   `database/seeders/CategorySeeder.php`
-   `database/seeders/ProductSeeder.php`

### Models

-   `app/Models/Category.php`
-   `app/Models/Product.php`

### Form Requests

-   `app/Http/Requests/StoreProductRequest.php`
-   `app/Http/Requests/UpdateProductRequest.php`

### Controller

-   `app/Http/Controllers/ProductController.php`

### Routes

-   `routes/web.php`

### Views

-   `resources/views/layouts/app.blade.php` → Main layout
-   `resources/views/products/index.blade.php` → Product listing
-   `resources/views/products/create.blade.php` → Add/Edit Product form

---

## How to Run

### 1. Clone the repository

```bash
git clone <repository-url>
cd <project-folder>
```
### 2. Install dependencies
composer install

### 3. Configure environment
* Copy .env.example to .env
* Set database credentials

### 4. Generate application key
php artisan key:generate

### 5. Run migrations and seeders
php artisan migrate --seed

### 6. Start the development server
php artisan serve

### 7. Access the application
Open your browser and visit : http://localhost:8000/

## Pages / Interfaces

1. Index Page

- Lists all products with Category and Price
- Actions: Edit / Delete
- Shows success messages for operations

2. Create / Edit Page

- Form to add or update a product
- Includes dynamic dropdown for Category selection
- Validates input to ensure data integrity

## Conclusion

This project fully satisfies the task requirements:

- Implements a One-to-Many relationship between Categories and Products.
- Provides full CRUD operations for Products.
- Ensures dynamic and validated product creation/updating.
- Optimizes queries using eager loading.
- Uses clean, reusable Laravel views and Bootstrap for UI.