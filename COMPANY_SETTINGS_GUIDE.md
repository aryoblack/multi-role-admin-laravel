# Panduan Pengaturan Perusahaan

## Fitur Baru: Company Settings

### Deskripsi

Fitur untuk mengatur informasi perusahaan seperti nama, alamat, kontak, logo, dan deskripsi perusahaan.

## Struktur Database

### Table: company_settings

- `id` - Primary key
- `company_name` - Nama perusahaan (required)
- `company_address` - Alamat perusahaan
- `company_phone` - Nomor telepon
- `company_email` - Email perusahaan
- `company_website` - Website perusahaan
- `company_logo` - Path logo perusahaan
- `company_description` - Deskripsi perusahaan
- `timestamps` - Created at & Updated at

## File yang Dibuat

### 1. Migration

- `database/migrations/2026_02_26_064409_create_company_settings_table.php`

### 2. Model

- `app/Models/CompanySetting.php`

### 3. Controller

- `app/Http/Controllers/CompanySettingController.php`
    - `index()` - Menampilkan form pengaturan
    - `update()` - Menyimpan perubahan pengaturan

### 4. View

- `resources/views/company-settings/index.blade.php`

### 5. Seeders

- `database/seeders/CompanySettingSeeder.php` - Data awal perusahaan
- `database/seeders/CompanySettingMenuSeeder.php` - Menu pengaturan perusahaan
- `database/seeders/CompanySettingPermissionSeeder.php` - Permission untuk Super Admin

## Routes

```php
// Company Settings
Route::get('company-settings', [CompanySettingController::class, 'index'])
    ->name('company-settings.index');
Route::put('company-settings', [CompanySettingController::class, 'update'])
    ->name('company-settings.update');
```

## Fitur

### 1. Form Pengaturan Perusahaan

- Nama Perusahaan (required)
- Alamat
- Telepon
- Email
- Website
- Logo (upload image: JPG, PNG, max 2MB)
- Deskripsi

### 2. Upload Logo

- Format: JPEG, PNG, JPG
- Maksimal ukuran: 2MB
- Preview sebelum upload
- Otomatis hapus logo lama saat upload baru
- Disimpan di `storage/app/public/logos/`

### 3. Validasi

- Nama perusahaan wajib diisi
- Email harus format email valid
- Website harus format URL valid
- Logo harus image dengan format yang ditentukan

### 4. Permission

- Hanya Super Admin yang memiliki akses
- Can View: Yes
- Can Update: Yes

## Cara Menggunakan

### 1. Akses Menu

Login sebagai Super Admin, kemudian akses menu "Pengaturan Perusahaan" atau URL:

```
http://your-domain/company-settings
```

### 2. Update Informasi

1. Isi form dengan informasi perusahaan
2. Upload logo (opsional)
3. Klik "Simpan Perubahan"

### 3. Menggunakan Data Perusahaan di Aplikasi

Untuk mengambil data perusahaan di controller atau view:

```php
// Di Controller
$company = \App\Models\CompanySetting::first();

// Di Blade View
@php
    $company = \App\Models\CompanySetting::first();
@endphp

<h1>{{ $company->company_name }}</h1>
<p>{{ $company->company_address }}</p>

@if($company->company_logo)
    <img src="{{ asset('storage/' . $company->company_logo) }}" alt="Logo">
@endif
```

## Data Default

Saat pertama kali dijalankan, sistem akan membuat data default:

- Nama: PT. Contoh Perusahaan
- Alamat: Jl. Contoh No. 123, Jakarta
- Telepon: 021-12345678
- Email: info@perusahaan.com
- Website: https://www.perusahaan.com

## Testing

Untuk test fitur company settings:

```bash
php test_company_settings.php
```

Output yang diharapkan:

```
✓ Company Settings Found
✓ Company Settings Menu Found
✓ Company Settings Permission Found
```

## Storage Link

Logo disimpan di `storage/app/public/logos/` dan dapat diakses melalui:

```
http://your-domain/storage/logos/filename.jpg
```

Storage link sudah dibuat dengan command:

```bash
php artisan storage:link
```

## Catatan Penting

1. ✅ Hanya ada 1 record company settings (singleton pattern)
2. ✅ Logo otomatis terhapus saat upload logo baru
3. ✅ Form memiliki preview image sebelum upload
4. ✅ Validasi lengkap untuk semua field
5. ✅ Permission hanya untuk Super Admin
6. ✅ Menu otomatis muncul di sidebar

## Troubleshooting

### Logo tidak muncul

1. Pastikan storage link sudah dibuat: `php artisan storage:link`
2. Cek permission folder `storage/app/public/logos/`
3. Pastikan path logo benar di database

### Permission denied

1. Pastikan user login sebagai Super Admin
2. Cek permission di table permissions untuk menu company-settings

### Form tidak bisa submit

1. Cek validasi di browser console
2. Pastikan CSRF token ada di form
3. Cek error di `storage/logs/laravel.log`
