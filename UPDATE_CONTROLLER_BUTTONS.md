# 🔧 Update Controller untuk Modern Action Buttons

## ✅ Helper Created

File: `app/Helpers/DataTableHelper.php`

## 📝 Cara Pakai di Controller

### 1. Import Helper

```php
use App\Helpers\DataTableHelper;
```

### 2. Update Action Column

#### Before (Old Style):

```php
$action = '
    <a href="'.route('users.edit', $user->id).'" class="btn btn-sm btn-warning">
        <i class="fas fa-edit"></i>
    </a>
    <button class="btn btn-sm btn-danger delete-btn" data-id="'.$user->id.'">
        <i class="fas fa-trash"></i>
    </button>
';
```

#### After (Modern Style with Text):

```php
$action = DataTableHelper::actionButtons([
    'edit' => [
        'id' => $user->id,
        'class' => 'edit-btn',
        'title' => 'Edit User',
        'text' => 'Edit'
    ],
    'delete' => [
        'id' => $user->id,
        'title' => 'Hapus User',
        'text' => 'Hapus',
        'disabled' => false
    ]
]);
```

#### Or Compact (Icon Only):

```php
$action = DataTableHelper::compactActionButtons([
    'edit' => [
        'id' => $user->id,
        'class' => 'edit-btn',
        'title' => 'Edit User'
    ],
    'delete' => [
        'id' => $user->id,
        'title' => 'Hapus User'
    ]
]);
```

### 3. Example: UserController

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\DataTableHelper;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('role')->select('users.*');

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('role_name', function ($user) {
                    return $user->role->nama_role ?? '-';
                })
                ->addColumn('status_badge', function ($user) {
                    return DataTableHelper::statusBadge($user->status);
                })
                ->addColumn('action', function ($user) {
                    return DataTableHelper::actionButtons([
                        'edit' => [
                            'id' => $user->id,
                            'class' => 'edit-btn',
                            'title' => 'Edit User',
                            'text' => 'Edit'
                        ],
                        'delete' => [
                            'id' => $user->id,
                            'title' => 'Hapus User',
                            'text' => 'Hapus'
                        ]
                    ]);
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        // ... rest of code
    }
}
```

### 4. Example: MenuController

```php
public function index(Request $request)
{
    if ($request->ajax()) {
        $menus = Menu::with('parent')->select('menus.*');

        return DataTables::of($menus)
            ->addIndexColumn()
            ->addColumn('icon_display', function ($menu) {
                return $menu->icon ? '<i class="'.$menu->icon.' text-blue-600"></i>' : '-';
            })
            ->addColumn('url_display', function ($menu) {
                return '<code class="text-xs bg-gray-100 px-2 py-1 rounded">'.$menu->url.'</code>';
            })
            ->addColumn('parent_name', function ($menu) {
                return $menu->parent ? $menu->parent->nama_menu : '-';
            })
            ->addColumn('action', function ($menu) {
                return DataTableHelper::actionButtons([
                    'edit' => [
                        'id' => $menu->id,
                        'class' => 'edit-btn',
                        'title' => 'Edit Menu',
                        'text' => 'Edit'
                    ],
                    'delete' => [
                        'id' => $menu->id,
                        'title' => 'Hapus Menu',
                        'text' => 'Hapus'
                    ]
                ]);
            })
            ->rawColumns(['icon_display', 'url_display', 'action'])
            ->make(true);
    }

    // ... rest of code
}
```

### 5. Example: RoleController (with Custom Button)

```php
public function index(Request $request)
{
    if ($request->ajax()) {
        $roles = Role::withCount('users')->select('roles.*');

        return DataTables::of($roles)
            ->addIndexColumn()
            ->addColumn('users_count_badge', function ($role) {
                return DataTableHelper::badge($role->users_count . ' user', 'info');
            })
            ->addColumn('action', function ($role) {
                return DataTableHelper::actionButtons([
                    'custom' => [[
                        'url' => route('roles.permissions', $role->id),
                        'icon' => 'fas fa-shield-alt',
                        'class' => 'dt-action-btn-view',
                        'title' => 'Manage Permission',
                        'text' => 'Permission'
                    ]],
                    'edit' => [
                        'url' => route('roles.edit', $role->id),
                        'title' => 'Edit Role',
                        'text' => 'Edit'
                    ],
                    'delete' => [
                        'id' => $role->id,
                        'title' => 'Hapus Role',
                        'text' => 'Hapus',
                        'disabled' => $role->users_count > 0
                    ]
                ]);
            })
            ->rawColumns(['users_count_badge', 'action'])
            ->make(true);
    }

    // ... rest of code
}
```

## 🎨 Button Styles Available

### 1. With Text (Responsive)

```php
DataTableHelper::actionButtons([...])
```

- Desktop: Shows icon + text
- Mobile: Shows icon only (text hidden with `hidden sm:inline`)

### 2. Compact (Icon Only)

```php
DataTableHelper::compactActionButtons([...])
```

- Always shows icon only
- Smaller size (8x8)

### 3. Button Types

- `dt-action-btn-view` - Cyan/Blue gradient
- `dt-action-btn-edit` - Amber/Orange gradient
- `dt-action-btn-delete` - Red gradient
- `dt-action-btn-primary` - Blue/Purple gradient

## 📋 Configuration Options

### Edit Button

```php
'edit' => [
    'id' => 1,                    // Data ID for JavaScript
    'url' => '/users/1/edit',     // Direct URL (optional)
    'class' => 'edit-btn',        // Additional CSS class
    'title' => 'Edit User',       // Tooltip
    'text' => 'Edit'              // Button text
]
```

### Delete Button

```php
'delete' => [
    'id' => 1,                    // Data ID (required)
    'class' => 'delete-btn',      // Additional CSS class
    'title' => 'Hapus User',      // Tooltip
    'text' => 'Hapus',            // Button text
    'disabled' => false           // Disable button
]
```

### View Button

```php
'view' => [
    'url' => '/users/1',          // URL (required)
    'title' => 'Lihat Detail',    // Tooltip
    'text' => 'Lihat'             // Button text
]
```

### Custom Button

```php
'custom' => [[
    'url' => '/users/1/permissions',
    'icon' => 'fas fa-shield-alt',
    'class' => 'dt-action-btn-view',
    'title' => 'Manage Permission',
    'text' => 'Permission'
]]
```

## 🎯 Badge Helper

### Status Badge (Auto Color)

```php
DataTableHelper::statusBadge('active');
// Output: <span class="dt-badge dt-badge-success">Active</span>
```

Supported statuses:

- `active` → Green (success)
- `inactive` → Red (danger)
- `pending` → Yellow (warning)
- `completed` → Green (success)
- `cancelled` → Red (danger)

### Custom Badge

```php
DataTableHelper::badge('10 users', 'info');
// Output: <span class="dt-badge dt-badge-info">10 users</span>
```

Types: `primary`, `success`, `warning`, `danger`, `info`

## ✅ Checklist

Update these controllers:

- [ ] UserController
- [ ] RoleController
- [ ] MenuController
- [ ] CompanySettingController
- [ ] DatabaseBackupController
- [ ] LocationController (if exists)
- [ ] VendorController (if exists)

## 🚀 After Update

1. **Rebuild Assets**

    ```bash
    npm run dev
    ```

2. **Clear Cache**

    ```bash
    php artisan view:clear
    php artisan cache:clear
    ```

3. **Test**
    - Check button appearance
    - Test edit functionality
    - Test delete functionality
    - Test responsive (mobile/desktop)

---

**Status:** Ready to implement  
**Helper Location:** `app/Helpers/DataTableHelper.php`  
**CSS Location:** `resources/css/datatable-modern.css`
