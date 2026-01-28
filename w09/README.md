# Task 09 / Products Listing Pro

## 📌 Overview

This update enhances the **Products page** to a professional listing with search, filters, sorting, and pagination.

---

## 🛠 Features Implemented

- **Search:** by product name (and description if exists)
- **Filters:** Category and Supplier (can be combined)
- **Sorting:** Created date, Price, Name (Whitelist + secure)
- **Pagination:** preserves query strings
- **UI:** Card-based layout with supplier info and actions
- **Empty state:** Friendly message when no products match criteria
- **Authorization:** Admin / User roles respected

---

Example URLs:

```
/products?search=laptop
/products?category_id=2
/products?supplier_id=1
/products?sort_by=price&direction=asc
/products?search=phone&category_id=3&supplier_id=1&sort_by=created_at&direction=desc
```

---

## 🖥 Blade Views

resources/views/layouts/app.blade.php → Master layout
resources/views/products/index.blade.php → Products listing (Task 9)
resources/views/products/create.blade.php → Add product
resources/views/products/edit.blade.php → Edit product
Flash messages & toast notifications for CRUD actions

---

## 🗂 File Structure / Modified Files

```
app/
└── Http/
    └── Controllers/
        └── ProductController.php  # index method Task 9 (search filters, sorting, pagination)

resources/
└── views/
    └── products/
        └── index.blade.php        # Toolbar (search, filters, sort), Card layout, Pagination, Empty state

```

---

## 📦 Requirements

- PHP >= 8.1
- Composer
- Laravel 10
- MySQL or any supported database

---

## ⚡ Installation

1. Clone the repository:

```bash
git clone https://github.com/mo7ammedash/Field-training-Backend.git
cd Field-training-Backend
```

2. Install dependencies:

```
composer install
npm install
npm run dev
```

3. Copy .env.example to .env and configure:

```
cp .env.example .env
php artisan key:generate

```

- Set database credentials in .env:
  `` `   DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_user
DB_PASSWORD=your_password ``

4. Run migrations & seeders:

```
php artisan migrate --seed
```

5. Start the local server:

```
php artisan serve
```

Open your browser at http://127.0.0.1:8000

## 📚 Useful Commands

```
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run tests
php artisan test

# Run migrations fresh (Warning: deletes data)
php artisan migrate:fresh --seed
```
