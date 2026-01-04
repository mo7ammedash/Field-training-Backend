# 🛒 Product & Supplier Management System (Laravel)

## 📌 Project Overview

This project implements a **Many-to-Many relationship** between **Products** and **Suppliers** using **Laravel Eloquent** with a **pivot table that stores additional data**.

The system allows users to:

-   Create, edit, and delete products
-   Assign multiple suppliers to each product
-   Store supplier-specific data such as **cost price** and **lead time**
-   Manage relationships efficiently with proper validation and UI feedback

This project fully satisfies **Task 06 requirements**.

---

## 🎯 Task Objectives

✔ Implement a Many-to-Many relationship (Products ↔ Suppliers)  
✔ Store extra pivot data  
✔ Handle validation, persistence, and UI updates  
✔ Use clean Blade views with Bootstrap  
✔ Avoid N+1 query problem using eager loading

---

## 🧱 Database Design

### 📦 Products Table

| Column     | Type    | Constraints      |
| ---------- | ------- | ---------------- |
| id         | bigint  | PK               |
| name       | string  | unique, required |
| price      | decimal | > 0              |
| timestamps |         |                  |

### 🏭 Suppliers Table

| Column     | Type   | Constraints |
| ---------- | ------ | ----------- |
| id         | bigint | PK          |
| name       | string | unique      |
| email      | string | unique      |
| timestamps |        |             |

### 🔗 Pivot Table: `product_supplier`

| Column         | Type              |
| -------------- | ----------------- |
| product_id     | FK → products.id  |
| supplier_id    | FK → suppliers.id |
| cost_price     | decimal ≥ 0       |
| lead_time_days | integer ≥ 0       |
| timestamps     |                   |

🔒 Composite unique constraint:

```php
unique(product_id, supplier_id)
```

🧨 Cascade delete applies only to pivot rows.

### 🔁 Eloquent Relationships

**Product Model**

```
belongsToMany(Supplier::class)
->withPivot(['cost_price', 'lead_time_days'])
->withTimestamps();
```

**Supplier Model**

```
belongsToMany(Product::class)
->withPivot(['cost_price', 'lead_time_days'])
->withTimestamps();
```

### 🧪 Database Seeding

## 🧑‍💼 Suppliers

-   Supplier A
-   Supplier B
-   Supplier C
-   Supplier D
-   Supplier E

## 📱 Products

-   Laptop
-   Smartphone
-   Headphones
-   Smartwatch
-   Keyboard

**Each product is linked to 1–3 suppliers with pivot data:**

cost_price
lead_time_days

### 🖥️ User Interface (Blade + Bootstrap)

## ➕ Add / ✏ Edit Product

Product name (required, unique)
Price (must be > 0)

**Suppliers section:**

-   Checkbox for each supplier
-   Cost Price input
-   Lead Time Days input

📌 Required input structure:

```
suppliers[SUPPLIER_ID][selected]
suppliers[SUPPLIER_ID][cost_price]
suppliers[SUPPLIER_ID][lead_time_days]
```

## 📋 Products List Page

Displays all products
Shows suppliers with pivot data:

    Supplier A (Cost: 120, Lead: 7 days)

**Buttons:**

✏ Edit

🗑 Delete (with confirmation)

### 🔔 Flash Messages

Users receive feedback after every action:

✅ Product created successfully

🔄 Product updated successfully

❌ Product deleted successfully

## 🛡️ Validation Rules

✔ Product name:
Required
Unique

✔ Price:
Numeric
Greater than zero

✔ Suppliers:
At least one supplier required
Supplier must exist

    Cost price ≥ 0
    Lead time ≥ 0

Validation is handled using:

-   StoreProductRequest
-   UpdateProductRequest

### ⚡ Performance Optimization (Bonus)

To avoid the N+1 problem, eager loading is used:
```
Product::with('suppliers')->withCount('suppliers')
```
✔ Efficient queries
✔ Supplier count available per product

### 🗂️ Project Structure

```
app/
├── Models/
│   ├── Product.php
│   └── Supplier.php
├── Http/
│   ├── Controllers/
│   │   └── ProductsController.php
│   └── Requests/
│       ├── StoreProductRequest.php
│       └── UpdateProductRequest.php

database/
├── migrations/
└── seeders/

resources/views/
├── layouts/
│   └── app.blade.php
└── products/
    ├── index.blade.php
    ├── create.blade.php
    ├── edit.blade.php
    └── form.blade.php

routes/
└── web.php
```

### 🌐 Routes / Pages

| Page           | URL                   |
| -------------- | --------------------- |
| Product List   | `/products`           |
| Create Product | `/products/create`    |
| Edit Product   | `/products/{id}/edit` |

### 🏁 Conclusion

This project demonstrates a clean and complete implementation of a Many-to-Many relationship in Laravel with pivot data.
It follows best practices in:

1. Database design
2. Eloquent relationships
3. Validation
4. UI/UX
5. Performance optimization

**The system is fully functional, scalable, and ready for academic submission.**

### 👤 Author Information

- **Name:** Mohamed Ashour
- **Field:** Software Engineering
- **Technology:** Laravel Framework
- **Task:** Task 06 – Many-to-Many Relationship with Pivot Data

📅 2026
