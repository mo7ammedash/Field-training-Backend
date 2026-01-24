# ⚒️ Task 07 – Authentication & Authorization (Products ↔ Users Ownership)

## 📌 Project Overview

This project enhances the existing **Products + Categories + Suppliers system** by implementing **Authentication and Authorization**.  

Key features include:

- User registration, login, and logout (Laravel Breeze)
- Products linked to users via `user_id`
- Only owners can update/delete their products
- Admin role can manage all products
- Blade views reflect user permissions
- Products displayed in **cards**, not tables, for a modern UI

---

## 🎯 Task Objectives

✔ Implement Authentication (register/login/logout)  
✔ Link products to owners (user_id)  
✔ Protect product management routes  
✔ Enforce authorization via `ProductPolicy`  
✔ Display products in cards respecting permissions  
✔ Feature tests validate access control rules  
✔ Bonus: Admin role can manage all products

---

## 🧱 Database Design

### 📦 Users Table

| Column     | Type    | Constraints          |
| ---------- | ------- | ------------------ |
| id         | bigint  | PK                 |
| name       | string  | required           |
| email      | string  | unique, required   |
| password   | string  | required           |
| role       | string  | default: 'user'    |
| timestamps |         |                    |

### 📦 Categories Table

| Column     | Type    | Constraints       |
| ---------- | ------- | ---------------- |
| id         | bigint  | PK               |
| name       | string  | unique, required |
| timestamps |         |                  |

### 📦 Products Table

| Column      | Type    | Constraints                 |
| ----------- | ------- | --------------------------- |
| id          | bigint  | PK                          |
| name        | string  | unique, required            |
| price       | decimal | > 0                         |
| category_id | bigint  | FK → categories.id          |
| user_id     | bigint  | FK → users.id               |
| timestamps  |         |                             |

### 📦 Suppliers Table

| Column     | Type   | Constraints       |
| ---------- | ------ | ---------------- |
| id         | bigint | PK               |
| name       | string | unique            |
| email      | string | unique            |
| timestamps |        |                   |

### 🔗 Pivot Table: `product_supplier`

| Column         | Type              |
| -------------- | ----------------- |
| product_id     | FK → products.id  |
| supplier_id    | FK → suppliers.id |
| cost_price     | decimal ≥ 0       |
| lead_time_days | integer ≥ 0       |
| timestamps     |                   |

💡 Composite unique constraint: `(product_id, supplier_id)`  
Cascade delete applies only to pivot rows.

---

## 🖥️ User Interface (Blade + Bootstrap)

### Products Display

Products are displayed in **cards**, each showing details and suppliers:

---
┌───────────────────────────┐
│ Product Name │
│ Price: $100 │
│ Category: Electronics │
│ Owner: user@example.com
│
│ ------------------------- │
│ Suppliers (2): │
│ - Supplier A | Cost: 80 │
│ - Supplier B | Cost: 75 │
│ │
│ [Edit] [Delete] (if auth)│
└───────────────────────────┘

---

### Guest, User, Admin Scenarios

---

┌────────────┐
│ Guest │
└─────┬──────┘
│ View products only
▼
┌──────────────┐
│ User │
└─────┬────────┘
│ Manage own products
▼
┌──────────────┐
│ Admin │
└──────────────┘

---


- **Guest:** Can only view products  
- **User:** Can manage only their own products  
- **Admin:** Can manage all products

### Add/Edit Product Form

- Fields: name, price, category  
- Suppliers section with:  
  - Checkbox for each supplier  
  - Cost Price input  
  - Lead Time Days input  
- Ownership (`user_id`) is **assigned automatically**; not in form

---

## 🛡️ Authorization & Policies

- Only owners can edit/delete their products  
- Admin can edit/delete any product  
- Guests cannot access create/edit/delete routes (redirected to login)  
- `ProductPolicy` enforces these rules

---

## ⚡ Laravel Breeze

- Installed for Authentication scaffolding: register, login, logout, password reset  
- Users see appropriate nav items:  
  - Guest: Register/Login  
  - Authenticated User/Admin: Logout + Name displayed  

---

## 🗂️ Project Structure

app/  
├── Models/  
│   ├── Product.php           # Product model + relationships with Category, Supplier, and User  
│   ├── Supplier.php          # Supplier model + relationship with Product  
│   ├── Category.php          # Category model  
│   └── User.php              # User model + products() relationship + role attribute  
├── Policies/  
│   └── ProductPolicy.php     # Authorization rules for products  
├── Http/  
│   ├── Controllers/  
│   │   ├── ProductController.php  # CRUD logic + ownership/admin checks  
│   │   └── Auth/  
│   │       └── RegisteredUserController.php  # Registration logic  
│   └── Requests/  
│       ├── StoreProductRequest.php  # Validation on store  
│       └── UpdateProductRequest.php # Validation on update  

database/  
├── migrations/  
│   ├── create_users_table.php  
│   ├── add_role_to_users_table.php   # Adds 'role' column (user/admin)  
│   ├── create_categories_table.php  
│   ├── create_products_table.php  
│   ├── create_suppliers_table.php  
│   └── create_product_supplier_table.php  
└── seeders/  
    ├── CategorySeeder.php  
    ├── SupplierSeeder.php  
    └── AdminSeeder.php               # Creates admin user  

resources/views/  
├── layouts/  
│   └── app.blade.php                # Main layout with nav (guest/user/admin)  
└── products/  
    ├── index.blade.php              # Product cards view  
    ├── create.blade.php             # Add product form  
    └── edit.blade.php               # Edit product form  

routes/  
└── web.php                           # Route definitions with auth middleware  

---

## 🌐 Routes / Pages

| Page           | URL                   | Access        |
| -------------- | --------------------- | ------------- |
| Product List   | `/products`           | Public        |
| Create Product | `/products/create`    | Authenticated |
| Edit Product   | `/products/{id}/edit` | Owner/Admin   |
| Login          | `/login`              | Guest         |
| Register       | `/register`           | Guest         |
| Logout         | `/logout`             | Authenticated |

---

## 🏁 Conclusion

This project demonstrates a complete implementation of **Task 07**: Authentication & Authorization for a Products ↔ Users system in Laravel.  

It follows best practices in:

1. Authentication & authorization  
2. Eloquent relationships & ownership  
3. Blade views respecting permissions  
4. Modern UI with cards  
5. Feature tests validating security  
6. Admin role management

**Fully functional, scalable, and ready for deployment.**

---

## 👤 Author Information

- **Name:** Mohamed Ashour  
- **GitHub:** https://github.com/mo7ammedash  
- **Email:** mohammedashour664@gmail.com  
- **Field Training:** Back-End Development  
- **Technology:** Laravel Framework  
- **Task:** Task 07 – Authentication & Authorization (Products ↔ Users Ownership)
