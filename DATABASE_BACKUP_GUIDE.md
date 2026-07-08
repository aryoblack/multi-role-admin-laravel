# Database Backup & Restore - Panduan Lengkap

## 📋 Fitur yang Tersedia

### 1. Buat Backup Baru

- Membuat backup database dalam format `.zip`
- Backup otomatis menggunakan `mysqldump`
- File disimpan di `storage/app/backups/`
- Nama file: `backup_YYYY-MM-DD_HHmmss.zip`

### 2. Upload Backup

- Upload file backup dari komputer (format `.sql` atau `.zip`)
- Maksimal ukuran file: 100MB
- File akan disimpan untuk di-restore

### 3. Download Backup

- Download file backup ke komputer
- Format file: `.zip` (berisi file `.sql`)

### 4. Restore Database

- Restore database dari file backup
- ⚠️ **PERINGATAN**: Semua data saat ini akan diganti!
- Menggunakan command `mysql` untuk import

### 5. Export untuk cPanel

- Export backup dengan instruksi lengkap untuk import di cPanel
- File berisi:
    - File SQL backup
    - File `CPANEL_IMPORT_INSTRUCTIONS.txt` dengan panduan lengkap
- Cocok untuk migrasi ke hosting cPanel

### 6. Hapus Backup

- Hapus file backup yang tidak diperlukan
- Menghemat ruang penyimpanan

## 🚀 Cara Menggunakan

### Membuat Backup

1. Login sebagai Super Admin
2. Buka menu **Backup Database**
3. Klik tombol **"Buat Backup"**
4. Tunggu proses selesai (beberapa detik)
5. File backup akan muncul di daftar

### Restore Database

1. Pilih file backup dari daftar
2. Klik tombol **Restore** (ikon undo)
3. Konfirmasi restore (baca peringatan!)
4. Tunggu proses selesai
5. Database akan kembali ke kondisi saat backup dibuat

### Upload & Restore Backup External

1. Klik tab **"Upload Backup"**
2. Pilih file `.sql` atau `.zip` dari komputer
3. Klik **"Upload File"**
4. Setelah upload selesai, file akan muncul di daftar
5. Klik tombol **Restore** untuk restore database

### Export untuk cPanel

1. Pilih file backup dari daftar
2. Klik tombol **Export untuk cPanel** (ikon export)
3. File `.zip` akan didownload berisi:
    - File SQL backup
    - Instruksi lengkap cara import di cPanel
4. Upload file SQL ke cPanel phpMyAdmin

## 📁 Struktur File

```
storage/
└── app/
    └── backups/
        ├── backup_2026-02-26_143022.zip
        ├── backup_2026-02-25_091530.zip
        └── uploaded_2026-02-26_150000.zip
```

## ⚙️ Konfigurasi

### Requirements

- MySQL/MariaDB
- PHP dengan ekstensi: `zip`, `pdo_mysql`
- Command line tools: `mysqldump`, `mysql`

### Environment Variables

Pastikan konfigurasi database di `.env` sudah benar:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=db_telur
DB_USERNAME=root
DB_PASSWORD=
```

## 🔒 Keamanan

### Permissions

- Hanya **Super Admin** yang dapat mengakses fitur backup
- Semua operasi dicatat di log file
- File backup disimpan di folder `storage` (tidak dapat diakses publik)

### Log Activity

Semua aktivitas backup dicatat dengan informasi:

- User ID yang melakukan aksi
- Timestamp
- Nama file
- Status (success/failed)
- Error message (jika ada)

Lokasi log: `storage/logs/laravel.log`

## 🛠️ Troubleshooting

### Error: "Class ZipArchive not found"

**Solusi:**

1. **Via Laragon Menu (RECOMMENDED)**:
    - Klik kanan icon Laragon
    - PHP → Extensions → Centang "zip"
    - Laragon akan restart otomatis

2. **Manual Edit php.ini**:
    - Klik kanan Laragon → PHP → php.ini
    - Cari: `;extension=zip`
    - Ubah jadi: `extension=zip`
    - Save dan restart Laragon

3. **Verifikasi**:
    ```bash
    php -m | findstr zip
    ```

**Lihat**: FIX_ZIP_EXTENSION.md untuk panduan lengkap

### Error: "mysqldump command not found"

**Solusi:**

1. Pastikan MySQL sudah terinstall
2. Tambahkan MySQL ke PATH environment variable
3. Restart terminal/command prompt

**Windows (Laragon):**

```
C:\laragon\bin\mysql\mysql-8.x.x\bin
```

### Error: "Max allowed packet"

**Solusi:**

1. Edit `my.ini` atau `my.cnf`
2. Tambahkan:
    ```
    max_allowed_packet=256M
    ```
3. Restart MySQL

### Error: "Permission denied"

**Solusi:**

1. Pastikan folder `storage/app/backups` writable
2. Set permission:
    ```bash
    chmod -R 775 storage/app/backups
    ```

### Backup File Terlalu Besar

**Solusi:**

1. Gunakan command line untuk backup manual
2. Atau split database per tabel
3. Compress dengan level tinggi

## 📊 Best Practices

### Jadwal Backup

- **Harian**: Untuk data yang sering berubah
- **Mingguan**: Untuk data yang jarang berubah
- **Sebelum Update**: Selalu backup sebelum update aplikasi

### Penyimpanan Backup

- Simpan backup di lokasi berbeda (external storage)
- Gunakan cloud storage (Google Drive, Dropbox, dll)
- Jangan hanya simpan di server yang sama

### Retention Policy

- Simpan backup 7 hari terakhir (harian)
- Simpan backup 4 minggu terakhir (mingguan)
- Simpan backup 12 bulan terakhir (bulanan)
- Hapus backup lama secara berkala

### Testing Restore

- Test restore backup secara berkala
- Gunakan database testing, bukan production
- Verifikasi data setelah restore

## 🔄 Import ke cPanel

### Langkah-langkah:

1. **Download Export cPanel**
    - Klik tombol "Export untuk cPanel"
    - Extract file `.zip` yang didownload

2. **Login ke cPanel**
    - Buka cPanel hosting Anda
    - Login dengan credentials

3. **Buka phpMyAdmin**
    - Cari menu "phpMyAdmin"
    - Klik untuk membuka

4. **Pilih Database**
    - Klik nama database di sidebar kiri
    - Atau buat database baru jika belum ada

5. **Import Database**
    - Klik tab "Import"
    - Klik "Choose File"
    - Pilih file `.sql` dari extract
    - Klik "Go" atau "Import"

6. **Verifikasi**
    - Cek tabel-tabel sudah ter-import
    - Verifikasi jumlah data

7. **Update .env di Server**

    ```env
    DB_CONNECTION=mysql
    DB_HOST=localhost
    DB_PORT=3306
    DB_DATABASE=nama_database_cpanel
    DB_USERNAME=username_database_cpanel
    DB_PASSWORD=password_database_cpanel
    ```

8. **Clear Cache**
    ```bash
    php artisan config:clear
    php artisan cache:clear
    ```

## 📝 Technical Details

### Backup Process

1. Membuat folder `storage/app/backups` jika belum ada
2. Generate nama file dengan timestamp
3. Eksekusi `mysqldump` command
4. Compress file SQL ke ZIP
5. Hapus file SQL original (hanya simpan ZIP)
6. Log aktivitas

### Restore Process

1. Validasi file backup exists
2. Extract ZIP jika format ZIP
3. Eksekusi `mysql` command untuk import
4. Clean up temporary files
5. Log aktivitas

### Export cPanel Process

1. Extract SQL dari ZIP backup
2. Buat file instruksi
3. Buat ZIP baru dengan SQL + instruksi
4. Return file untuk download
5. Clean up temporary files

## 🎯 Routes & Permissions

### Routes

```php
GET  /backups                          // Halaman utama
POST /backups/create                   // Buat backup
GET  /backups/download/{filename}      // Download backup
POST /backups/restore                  // Restore database
DELETE /backups/{filename}             // Hapus backup
GET  /backups/export-cpanel/{filename} // Export untuk cPanel
POST /backups/upload                   // Upload backup
```

### Permissions

- **can_view**: Lihat daftar backup
- **can_add**: Buat backup baru, upload backup
- **can_update**: Restore database
- **can_delete**: Hapus backup

## 📞 Support

Jika mengalami masalah:

1. Cek log file di `storage/logs/laravel.log`
2. Pastikan MySQL tools terinstall
3. Verifikasi permissions folder storage
4. Hubungi administrator sistem

---

**Dibuat**: 26 Februari 2026  
**Versi**: 1.0.0  
**Database**: db_telur (MySQL)
