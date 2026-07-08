# 📚 DataTable Modern - Global Usage Guide

## 🎯 Overview

Custom DataTable styling dan helper functions yang bisa digunakan di semua modul dengan konsisten.

## 📦 Files Created

### 1. CSS

- `resources/css/datatable-modern.css` - Global styling untuk DataTable

### 2. JavaScript

- `resources/js/datatable-modern.js` - Helper functions dan utilities

### 3. Integration

- `resources/css/app.css` - Import DataTable CSS
- `resources/js/app.js` - Import DataTable JS

---

## 🚀 Quick Start

### Basic Usage

```javascript
// Initialize DataTable dengan styling modern
const table = DataTableModern.init("#myTable", {
    ajax: "/api/data",
    columns: [
        { data: "id", name: "id" },
        { data: "name", name: "name" },
        { data: "email", name: "email" },
        { data: "action", name: "action", orderable: false },
    ],
});
```

### With Mobile View

```javascript
// Initialize dengan mobile card view
const table = DataTableModern.init(
    "#myTable",
    {
        ajax: "/api/data",
        columns: [
            { data: "id", name: "id" },
            { data: "name", name: "name" },
            { data: "action", name: "action", orderable: false },
        ],
    },
    {
        container: "#mobileList",
        emptyMessage: "Tidak ada data",
        cardTemplate: function (item) {
            return `
            <div class="mobile-card">
                <h4>${item.name}</h4>
                <p>${item.email}</p>
            </div>
        `;
        },
    },
);
```

---

## 📝 HTML Structure

### Desktop Table

```html
<div
    class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden"
>
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-4 sm:px-6 py-4">
        <h3
            class="text-base sm:text-lg font-semibold text-white flex items-center gap-2"
        >
            <i class="fas fa-table"></i>
            <span>Data Table</span>
        </h3>
    </div>

    <!-- Content -->
    <div class="p-3 sm:p-6">
        <!-- Mobile View -->
        <div class="block lg:hidden space-y-3" id="mobileList">
            <!-- Cards will be inserted here -->
        </div>

        <!-- Desktop View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full text-sm" id="myTable">
                <thead>
                    <tr class="border-b-2 border-gray-200">
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50"
                        >
                            Column
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100"></tbody>
            </table>
        </div>
    </div>
</div>
```

---

## 🎨 CSS Classes

### DataTable Elements

```css
/* Automatically styled by CSS */
.dataTables_filter input     /* Search input */
.dataTables_length select    /* Length select */
.dataTables_info             /* Info text */
.dataTables_paginate         /* Pagination */
.paginate_button             /* Pagination buttons */
.paginate_button.current     /* Active page */
.dataTables_processing       /* Loading indicator */
```

### Mobile Cards

```css
.mobile-card                 /* Card container */
.mobile-card-header          /* Card header */
.mobile-card-avatar          /* Avatar/icon */
.mobile-card-content         /* Main content */
.mobile-card-title           /* Title */
.mobile-card-subtitle        /* Subtitle */
.mobile-card-body            /* Body content */
.mobile-card-info            /* Info row */
.mobile-card-footer          /* Footer with actions */
```

### Action Buttons

```css
.dt-action-btn               /* Base button */
.dt-action-btn-edit          /* Edit button (amber) */
.dt-action-btn-delete        /* Delete button (red) */
.dt-action-btn-view          /* View button (cyan) */
.dt-action-btn-primary       /* Primary button (blue-purple) */
```

### Badges

```css
.dt-badge                    /* Base badge */
.dt-badge-primary            /* Blue badge */
.dt-badge-success            /* Green badge */
.dt-badge-warning            /* Yellow badge */
.dt-badge-danger             /* Red badge */
.dt-badge-info               /* Cyan badge */
```

---

## 🔧 JavaScript API

### DataTableModern.init()

Initialize DataTable dengan modern styling.

```javascript
DataTableModern.init(selector, config, mobileConfig);
```

**Parameters:**

- `selector` (string): Table selector (e.g., '#myTable')
- `config` (object): DataTable configuration
- `mobileConfig` (object, optional): Mobile view configuration

**Returns:** DataTable instance

**Example:**

```javascript
const table = DataTableModern.init(
    "#usersTable",
    {
        ajax: "/users",
        columns: [
            { data: "name", name: "name" },
            { data: "email", name: "email" },
        ],
    },
    {
        container: "#mobileList",
        cardTemplate: DataTableModern.userCardTemplate,
    },
);
```

### DataTableModern.reload()

Reload DataTable data.

```javascript
DataTableModern.reload(table);
```

**Example:**

```javascript
DataTableModern.reload(table);
```

### DataTableModern.actionButtons()

Generate action buttons HTML.

```javascript
DataTableModern.actionButtons(config);
```

**Example:**

```javascript
const buttons = DataTableModern.actionButtons({
    edit: {
        url: "/users/1/edit",
        title: "Edit User",
    },
    delete: {
        id: 1,
        disabled: false,
        title: "Delete User",
    },
    custom: [
        {
            url: "/users/1/permissions",
            icon: "fas fa-shield-alt",
            class: "dt-action-btn-view",
            title: "Permissions",
        },
    ],
});
```

### DataTableModern.badge()

Generate badge HTML.

```javascript
DataTableModern.badge(text, type);
```

**Example:**

```javascript
const badge = DataTableModern.badge("Active", "success");
// Output: <span class="dt-badge dt-badge-success">Active</span>
```

### DataTableModern.userCardTemplate()

Pre-built card template for users.

```javascript
DataTableModern.userCardTemplate(user);
```

### DataTableModern.menuCardTemplate()

Pre-built card template for menus.

```javascript
DataTableModern.menuCardTemplate(menu);
```

---

## 📱 Mobile View Configuration

### Basic Configuration

```javascript
{
    container: '#mobileList',           // Container selector
    emptyMessage: 'Tidak ada data',     // Empty state message
    cardTemplate: function(item) {      // Card template function
        return `<div class="mobile-card">...</div>`;
    }
}
```

### Using Pre-built Templates

```javascript
// For users
{
    container: '#mobileUsersList',
    cardTemplate: DataTableModern.userCardTemplate
}

// For menus
{
    container: '#mobileMenusList',
    cardTemplate: DataTableModern.menuCardTemplate
}
```

### Custom Template

```javascript
{
    container: '#mobileList',
    cardTemplate: function(item) {
        return `
            <div class="mobile-card">
                <div class="mobile-card-header">
                    <div class="flex items-center gap-3 flex-1">
                        <div class="mobile-card-avatar">
                            ${item.name.charAt(0)}
                        </div>
                        <div class="mobile-card-content">
                            <h4 class="mobile-card-title">${item.name}</h4>
                            <p class="mobile-card-subtitle">${item.email}</p>
                        </div>
                    </div>
                </div>
                <div class="mobile-card-footer">
                    ${item.action}
                </div>
            </div>
        `;
    }
}
```

---

## 🎯 Complete Example

### HTML

```html
<div
    class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden"
>
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-4 sm:px-6 py-4">
        <h3 class="text-base sm:text-lg font-semibold text-white">Products</h3>
    </div>

    <div class="p-3 sm:p-6">
        <!-- Mobile View -->
        <div class="block lg:hidden space-y-3" id="mobileProductsList"></div>

        <!-- Desktop View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full text-sm" id="productsTable">
                <thead>
                    <tr class="border-b-2 border-gray-200">
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50"
                        >
                            No
                        </th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50"
                        >
                            Name
                        </th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50"
                        >
                            Price
                        </th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50"
                        >
                            Stock
                        </th>
                        <th
                            class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50"
                        >
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100"></tbody>
            </table>
        </div>
    </div>
</div>
```

### JavaScript

```javascript
$(document).ready(function () {
    // Initialize DataTable
    const table = DataTableModern.init(
        "#productsTable",
        {
            ajax: "/products",
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                { data: "name", name: "name" },
                { data: "price", name: "price" },
                { data: "stock", name: "stock" },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                },
            ],
        },
        {
            container: "#mobileProductsList",
            emptyMessage: "Tidak ada produk",
            cardTemplate: function (product) {
                return `
                <div class="mobile-card">
                    <div class="mobile-card-header">
                        <div class="mobile-card-content">
                            <h4 class="mobile-card-title">${product.name}</h4>
                            <p class="mobile-card-subtitle">Rp ${product.price}</p>
                        </div>
                        ${DataTableModern.badge(product.stock + " pcs", "primary")}
                    </div>
                    <div class="mobile-card-footer">
                        ${product.action}
                    </div>
                </div>
            `;
            },
        },
    );

    // Delete handler
    $(document).on("click", ".delete-btn", function () {
        const id = $(this).data("id");

        Swal.fire({
            title: "Hapus produk?",
            text: "Data akan dihapus permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/products/${id}`,
                    method: "DELETE",
                    success: function (response) {
                        Toast.fire({
                            icon: "success",
                            title: response.message,
                        });
                        DataTableModern.reload(table);
                    },
                });
            }
        });
    });
});
```

---

## 🎨 Customization

### Change Colors

Edit `resources/css/datatable-modern.css`:

```css
/* Change primary color from blue to green */
.paginate_button.current {
    @apply bg-gradient-to-r from-green-600 to-emerald-600;
}

.dt-action-btn-primary {
    @apply bg-gradient-to-br from-green-500 to-emerald-600;
}
```

### Change Breakpoint

```css
/* Change from lg (1024px) to md (768px) */
@media (max-width: 767px) {
    .dt-desktop-only {
        @apply hidden;
    }
}
```

### Add Custom Button Style

```css
.dt-action-btn-custom {
    @apply bg-gradient-to-br from-pink-500 to-rose-600;
}
```

---

## ✅ Benefits

1. **Consistency** - Same styling across all modules
2. **Maintainability** - Update once, apply everywhere
3. **Scalability** - Easy to add new features
4. **Responsive** - Mobile-first design
5. **Modern** - Tailwind CSS styling
6. **Reusable** - Pre-built templates and helpers
7. **Clean Code** - Less duplication

---

## 📋 Checklist for New Module

- [ ] Add HTML structure with mobile/desktop views
- [ ] Initialize DataTable with `DataTableModern.init()`
- [ ] Configure mobile view with card template
- [ ] Use `DataTableModern.actionButtons()` for actions
- [ ] Use `DataTableModern.badge()` for badges
- [ ] Use `DataTableModern.reload()` for refresh
- [ ] Test on mobile and desktop
- [ ] Test pagination, search, sort
- [ ] Test empty state
- [ ] Test loading state

---

## 🚀 Next Steps

1. **Rebuild Assets**

    ```bash
    npm run dev
    ```

2. **Test Existing Modules**
    - Users Management
    - Roles Management
    - Menus Management

3. **Apply to New Modules**
    - Copy HTML structure
    - Use `DataTableModern.init()`
    - Customize card template

---

**Status:** ✅ Ready to Use  
**Version:** 1.0.0  
**Compatibility:** All modules  
**Responsive:** Yes  
**Modern:** Yes
