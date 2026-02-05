# 🧩 Task 11: Soft Delete, Trash, Restore, Final Delivery

This project is an extension and improvement of the previous Laravel tasks.  
Task 11 upgrades the system with a safe deletion workflow using **Soft Deletes**, a professional **Trash management page**, authorization policies, seed data, and feature tests.

The goal is to simulate a real production-ready system where data is never lost accidentally.

---

## 🚀 What’s New in Task 11

### 🗑 Soft Delete System
Products are no longer permanently deleted immediately.

- SoftDeletes enabled in Product model
- `deleted_at` column added via migration
- Default product listing excludes trashed items automatically

This ensures safe recovery of deleted data.

---

### 📦 Trash Management Page

A dedicated Trash page allows managing deleted products.

**Route:** `/products/trash` (auth protected)

Trash page shows:

- Product Name
- Category
- Suppliers
- Owner
- Deleted timestamp

Actions available:

- ✅ Restore product
- ❌ Force delete permanently

---

### 🔐 Authorization & Security

Trash actions are protected by Policy rules:

Restore / Force Delete allowed only for:

- Product owner
- Admin

Unauthorized access returns **403 Forbidden**.

Buttons are hidden in Blade if user is not authorized.

---

### 🌱 Seeders (Demo Environment)

Seed data helps demonstrate the system.

Seeded:

- Admin user
- Categories
- Suppliers

Products and normal users are created naturally by interacting with the system (register + create products).

This simulates real-world usage instead of fake bulk product seeding.

---

### 🧪 Feature Tests

Minimum test coverage included:

- Product moves to trash after soft delete
- Product disappears from normal index
- Product appears in trash
- Restore returns product to normal list
- Unauthorized trash actions return 403

---

## 📁 Project Structure — Task 11 Enhancements
```
app/
├── Models/
│   └── Product.php              ← UPDATED: SoftDeletes + relationships
│
├── Policies/
│   └── ProductPolicy.php        ← NEW: Authorization rules for trash actions
│
├── Http/
│   └── Controllers/
│       └── ProductController.php
│           ← UPDATED:
│              - trash()
│              - restore()
│              - forceDelete()
│              - authorization checks

database/
├── migrations/
│   └── xxxx_add_deleted_at_to_products_table.php
│       ← NEW: Soft delete column
│
├── seeders/
│   ├── AdminSeeder.php          ← NEW
│   ├── CategorySeeder.php       ← UPDATED
│   └── SupplierSeeder.php       ← UPDATED

resources/
├── views/
│   └── products/
│       ├── index.blade.php      ← UPDATED: trash badge + UI polish
│       ├── trash.blade.php      ← NEW: Trash management page
│       ├── create.blade.php     ← existing
│       └── edit.blade.php       ← existing

routes/
└── web.php
    ← UPDATED:
       /products/trash
       /products/{product}/restore
       /products/{product}/force-delete

tests/
└── Feature/
    └── ProductTrashTest.php     ← NEW: trash/restore tests

README.md                        ← NEW: final delivery documentation
screenshots/                     ← NEW: submission screenshots
```


---

## 🛠 Installation & Setup

```bash
git clone https://github.com/mo7ammedash/Field-training-Backend.git
cd Field-training-Backend
composer install
npm install
npm run build
cp .env.example .env
php artisan key:generate
php artisan mi:f
php artisan db:seed
php artisan storage:link
php artisan test
    php artisan test --filter=ProductAccessTest
    php artisan test --filter=ProductTrashTest 
php artisan serve
```
Visit:
```
http://127.0.0.1:8000
```

## 👤 Demo Admin Account
```
Email: admin@account.com
Password: 123
```
- (You can register additional users normally through the UI.)

## 📸 Screenshots Included
The submission includes:

1. Dashboard
2. Products index
3. Trash page
4. Restore & delete flow

All screenshots are inside the /screenshots folder.

## ✅ Expected Behavior
```
✔ Products are safely soft-deleted.
✔ Trash page lists deleted products.
✔ Restore works correctly.
✔ Permanent delete works correctly.
✔ Authorization prevents cross-user actions.
✔ Seeders prepare demo environment.
✔ Tests validate trash workflow.
```
## 🎯 Summary

Task 11 transforms the project into a safer, more professional system by introducing:

- Data recovery workflow
- Authorization enforcement
- Realistic seed data
- Feature testing
- Submission-ready documentation

This mirrors real production practices where deleting data must be controlled and reversibl.

---

## ⚠ Bonus Features Note

Due to time pressure and workload constraints, the bonus features were not implemented in this submission.

The core requirements of Task 11 were fully completed and tested, and the project is stable and production-ready. The bonus enhancements (bulk actions, advanced trash filters, cleanup command, and extended UX polish) are planned as future improvements and can be implemented in a later iteration.

Thank you for reviewing the project 🙏


## 👨‍💻 Author
- **Name:** Mohamed Ashour  
- **GitHub:** https://github.com/mo7ammedash  
- **Email:** mohammedashour664@gmail.com  
- **Field Training:** Back-End Development  
- **Technology:** Laravel Framework  
- **Task:** Task 11 – Soft Delete & Trash System

