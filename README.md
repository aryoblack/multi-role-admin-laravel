# Multi Role Laravel 12

Aplikasi manajemen multi-role berbasis Laravel 12. Proyek ini menyediakan autentikasi, manajemen user, role, menu, permission, pengaturan aplikasi/perusahaan, dan backup database.

## Fitur Utama

- Login dan logout dengan pembatasan percobaan login.
- Dashboard untuk user yang sudah login.
- Manajemen user.
- Manajemen role.
- Manajemen menu dinamis.
- Permission per role dan menu.
- Pengaturan profil user.
- Pengaturan perusahaan.
- Pengaturan aplikasi.
- Backup, restore, download, upload, hapus, dan export database untuk cPanel.

## Teknologi

Backend:

- Laravel 12.
- PHP 8.2 atau lebih baru.
- MySQL atau MariaDB.
- Blade template engine.
- Laravel migration dan seeder.
- Composer.

Frontend:

- Tailwind CSS 4.
- Vite.
- JavaScript.
- jQuery.
- DataTables.
- SweetAlert2.
- Font Awesome.
- Google Fonts Inter.

Package PHP utama:

- `laravel/framework`
- `barryvdh/laravel-dompdf`
- `yajra/laravel-datatables-oracle`
- `laravel/tinker`

Package frontend utama:

- `vite`
- `tailwindcss`
- `@tailwindcss/vite`
- `laravel-vite-plugin`
- `axios`
- `concurrently`

Catatan frontend:

- Styling utama menggunakan Tailwind CSS.
- DataTables dan SweetAlert2 dimuat dari asset lokal di `public/vendor`.

## Kebutuhan Sistem

- PHP 8.2 atau lebih baru.
- Composer.
- Node.js dan npm.
- MySQL atau MariaDB.
- Ekstensi PHP umum Laravel, termasuk PDO MySQL.
- Web server lokal seperti Laragon, Laravel Artisan Serve, Apache, atau Nginx.

## Instalasi Lokal

1. Install dependency PHP.

```bash
composer install
```

2. Install dependency frontend.

```bash
npm install
```

3. Salin file environment.

```bash
cp .env.example .env
```

Di Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

4. Generate application key.

```bash
php artisan key:generate
```

5. Sesuaikan konfigurasi database di `.env`.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=multi_role_laravel12
DB_USERNAME=root
DB_PASSWORD=
```

6. Jalankan migration dan seeder.

```bash
php artisan migrate --seed
```

7. Build asset frontend.

```bash
npm run build
```

8. Jalankan aplikasi.

```bash
php artisan serve
```

Akses aplikasi melalui:

```text
http://127.0.0.1:8000
```

## Akun Awal

Seeder membuat akun Super Admin berikut:

```text
Email: superadmin@multirole.local
Password: superadmin123
```

Segera ganti password setelah login pertama, terutama jika aplikasi dipakai di server bersama atau environment publik.

## Perintah Development

Menjalankan Vite:

```bash
npm run dev
```

Menjalankan test:

```bash
php artisan test
```

Menjalankan script setup bawaan Composer:

```bash
composer run setup
```

Menjalankan mode development gabungan dari Composer:

```bash
composer run dev
```

## Struktur Penting

- `app/Http/Controllers` - controller aplikasi.
- `app/Models` - model utama.
- `database/migrations` - struktur database.
- `database/seeders` - data awal role, menu, permission, setting, dan super admin.
- `resources/css` - styling Tailwind dan custom CSS.
- `resources/js` - JavaScript aplikasi dan helper DataTables.
- `resources/views` - Blade view.
- `routes/web.php` - routing web.
- `public/vendor` - asset lokal pihak ketiga seperti jQuery, DataTables, SweetAlert2, dan Font Awesome.
- `public/build` - hasil build frontend, tidak disimpan ke Git.

## Catatan Git

File berikut tidak boleh masuk Git:

- `.env`
- `.env.*`
- `vendor/`
- `node_modules/`
- `public/build/`
- file cache, log, dan konfigurasi IDE lokal

File berikut harus tetap bisa masuk Git:

- `.env.example`
- `composer.json`
- `composer.lock`
- `package.json`
- `package-lock.json`
- source code, migration, seeder, view, route, dan test

## Catatan Keamanan

- Jangan commit `.env` atau file berisi credential.
- Ganti password default Super Admin setelah setup.
- Batasi akses fitur backup database hanya untuk role yang benar-benar membutuhkan.
- Pastikan folder storage dan backup tidak dapat diakses publik secara langsung.
- Gunakan `APP_DEBUG=false` di production.

## Lisensi

Proyek ini mengikuti lisensi MIT sesuai basis Laravel, kecuali ditentukan berbeda oleh pemilik proyek.
