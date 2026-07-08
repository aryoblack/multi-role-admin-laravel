# Layout Partials

Direktori ini berisi komponen-komponen template yang terpisah untuk meningkatkan maintainability dan reusability.

## File Structure

```
partials/
├── head.blade.php      # Meta tags, CSS links, fonts
├── styles.blade.php    # Custom CSS styles & variables
├── header.blade.php    # Top navigation bar
├── footer.blade.php    # Footer section
├── alerts.blade.php    # Flash message alerts
└── scripts.blade.php   # JavaScript libraries & custom scripts
```

## Deskripsi File

### 1. head.blade.php

**Purpose:** Meta tags dan external resources

**Contains:**

- Meta charset & viewport
- CSRF token
- Page title (dengan @yield)
- Google Fonts
- Bootstrap CSS
- Font Awesome
- DataTables CSS
- SweetAlert2 CSS
- Custom CSS files
- @stack('styles') untuk CSS tambahan

**Usage:**

```blade
@include('layouts.partials.head')
```

---

### 2. styles.blade.php

**Purpose:** Custom CSS styling

**Contains:**

- CSS Variables (colors, dimensions)
- Layout system (wrapper, sidebar, content)
- Responsive breakpoints
- Component styles (cards, buttons, navbar)
- Mobile optimizations

**Customization:**

```css
:root {
    --primary-color: #3699ff; /* Main theme color */
    --primary-dark: #2e59d9; /* Darker variant */
    --bg-body: #f3f6f9; /* Body background */
    --sidebar-width: 260px; /* Sidebar width */
}
```

**Usage:**

```blade
@include('layouts.partials.styles')
```

---

### 3. header.blade.php

**Purpose:** Top navigation bar

**Contains:**

- Menu toggle button
- Page title (dari @yield('header_title'))
- User dropdown menu
- Logout button

**Features:**

- Responsive design
- User avatar with initial
- Role display
- Dropdown menu

**Usage:**

```blade
@include('layouts.partials.header')
```

**Set Header Title:**

```blade
@section('header_title', 'Dashboard')
```

---

### 4. footer.blade.php

**Purpose:** Page footer

**Contains:**

- Copyright notice
- Version number
- Additional links (optional)

**Customization:**
Edit file untuk menambah:

- Social media links
- Additional footer columns
- Company information

**Usage:**

```blade
@include('layouts.partials.footer')
```

---

### 5. alerts.blade.php

**Purpose:** Flash message display

**Supports:**

- Success messages (green)
- Error messages (red)
- Warning messages (yellow)
- Info messages (blue)

**Usage in Controller:**

```php
// Success
return redirect()->back()->with('success', 'Data berhasil disimpan!');

// Error
return redirect()->back()->with('error', 'Terjadi kesalahan!');

// Warning
return redirect()->back()->with('warning', 'Perhatian!');

// Info
return redirect()->back()->with('info', 'Informasi penting!');
```

**Usage in View:**

```blade
@include('layouts.partials.alerts')
```

---

### 6. scripts.blade.php

**Purpose:** JavaScript libraries dan custom scripts

**Contains:**

- jQuery 3.7.0
- Bootstrap 5.3.0 JS
- DataTables JS
- SweetAlert2
- Menu toggle logic
- CSRF setup
- Toast notification setup
- Custom app enhancements

**Features:**

- Sidebar toggle functionality
- Mobile overlay handling
- AJAX CSRF token setup
- SweetAlert Toast helper

**Usage:**

```blade
@include('layouts.partials.scripts')
```

**Add Custom Scripts:**

```blade
@push('scripts')
<script>
    $(document).ready(function() {
        // Your custom code
    });
</script>
@endpush
```

---

## Best Practices

### 1. Jangan Edit Langsung

Jika perlu customization, gunakan `@push` dan `@stack`:

```blade
{{-- Di halaman view --}}
@push('styles')
<style>
    .custom-class { color: red; }
</style>
@endpush

@push('scripts')
<script>
    console.log('Custom script');
</script>
@endpush
```

### 2. Konsistensi Styling

Gunakan CSS variables yang sudah didefinisikan:

```css
/* Good */
.my-button {
    background: var(--primary-color);
}

/* Avoid */
.my-button {
    background: #3699ff;
}
```

### 3. Responsive Design

Gunakan breakpoint yang konsisten:

```css
/* Mobile */
@media (max-width: 768px) {
    /* Mobile styles */
}

/* Desktop */
@media (min-width: 769px) {
    /* Desktop styles */
}
```

### 4. JavaScript Dependencies

Pastikan urutan loading library:

1. jQuery (harus pertama)
2. Bootstrap JS
3. Plugin lain (DataTables, SweetAlert)
4. Custom scripts

---

## Troubleshooting

### Styles tidak apply

```bash
php artisan view:clear
php artisan cache:clear
```

### JavaScript error

- Check browser console
- Pastikan jQuery loaded
- Verify script order

### Sidebar tidak toggle

- Check `#menu-toggle` button exists
- Verify `#wrapper` element
- Check console for errors

---

## Maintenance

### Menambah Partial Baru

1. Buat file di `resources/views/layouts/partials/`
2. Include di `app.blade.php`
3. Update dokumentasi ini

### Update Library Version

Edit `head.blade.php` atau `scripts.blade.php` untuk update CDN links.

### Custom Theme

Edit `styles.blade.php` untuk mengubah CSS variables dan styling.

---

## Support

Untuk pertanyaan atau issue, lihat:

- `TEMPLATE_STRUCTURE.md` - Dokumentasi lengkap
- `resources/views/examples/template-usage.blade.php` - Contoh penggunaan
