# Task 10 : Product Image Upload (Storage)

## 📌 Overview

This task improves the previous Laravel product management project by adding **image upload support** for products.  
It ensures:

- ✅ Strong validation for uploaded images.
- 🛡️ Safe storage and update logic (no leftover or missing images).
- 🎨 Clean UI display (thumbnails in lists, full images in detail views).
- ✨ Bonus enhancements for better user experience.

---

## 🔧 Features Implemented

### 🗄️ 1. Database Changes

- Added a new nullable column to the `products` table:

```php
$table->string('image_path')->nullable()->after('user_id');
```

Purpose: store the path of the uploaded product image.

### 📝 2. Forms (Create & Edit)

- Added a file input for images:

```
<input type="file" name="image" accept="image/*">
```

Ensured forms include:

```
enctype="multipart/form-data"
```

- Validation rules:
    - 🖼️ Must be an image (jpg, png, webp, etc.)

    - 📦 Max size: 2MB

    - ⚪ Optional (product can have no image)

- Live preview added (Bonus):

```
document.querySelector('#image').addEventListener('change', function(e){
    const preview = document.querySelector('#image-preview');
    preview.src = URL.createObjectURL(e.target.files[0]);
});
```

### ⚙️ 3. Controller Logic (ProductController)

## Create (store):

    Uploads the image if provided.

    Stores the path in image_path.

## Update (update):

    Deletes old image safely (if it exists) when a new image is uploaded.

    Updates image_path.

## Delete (destroy):

    Deletes associated image from storage when product is deleted.

✅ Safe handling ensures no crashes if files are missing.

### 🖼️ 4. UI Display

## Index / Product List:

    Shows thumbnails for products with images.

    Fallback placeholder for products without images.

    CSS ensures thumbnails are uniform (object-fit: cover).

## Dashboard Latest Products Table:

    Shows full product images.

    Uses the same fallback for missing images.

## Create/Edit Forms:

    Live preview of selected image before submission.

### ✨ 5. Bonus Enhancements

    👀 Live Preview: preview image before upload.

    📐 Standard Thumbnail Styling: uniform thumbnails using CSS (object-fit: cover).

### 📂 File Structure Changes
```
app/
├── Http/
│   ├── Controllers/
│   │   └── ProductController.php  # Updated with image upload logic
│   └── Requests/
│       ├── StoreProductRequest.php # Updated with image validation
│       └── UpdateProductRequest.php # Updated with image validation
database/
├── migrations/
│   └── 2026_01_28_XXXXXX_add_image_path_to_products.php
resources/
├── views/
│   ├── products/
│   │   ├── index.blade.php    # Updated to show thumbnails
│   │   ├── create.blade.php   # File input + live preview
│   │   └── edit.blade.php     # File input + live preview
│   └── dashboard.blade.php    # Shows full images in latest products table
public/
└── storage/                   # Linked via php artisan storage:link
```

### ⚡ Installation / Setup

1. Run migrations:
```
php artisan migrate
```
2. Link storage for public access:
```
php artisan storage:link
```

### 🛠️ Usage Instructions

1. Navigate to Products page.
2. Click Add Product or Edit an existing product.
3. Select an image file (jpg/png/webp, max 2MB).
4. Preview the image before submission.
5. Submit the form. The image will be stored and shown:
    Thumbnail in product lists.

    Full image in dashboard latest products table.

6. Updating the image will safely replace the old one.

### ✅ Improvements Over Previous Tasks

- Safe image storage and deletion.
- Consistent UI for product images.
- Live preview for better UX.
- Supports optional image uploads without breaking the application.
