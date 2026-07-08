# 🚀 Panduan Deployment ke Production

## 📋 Checklist Pre-Deployment

Sebelum deploy, pastikan:

- [ ] Semua fitur sudah ditest di local
- [ ] Database migration sudah siap
- [ ] Environment variables sudah disiapkan
- [ ] Assets sudah di-build untuk production
- [ ] Backup database production (jika update)

---

## 🔧 Persiapan Production Build

### 1. Build Assets

```bash
# Build production assets
npm run build
```

Ini akan generate file di `public/build/` yang sudah:

- ✅ Minified
- ✅ Optimized
- ✅ PurgeCSS applied
- ✅ Hashed filenames

### 2. Optimize Laravel

```bash
# Install dependencies (production only)
composer install --optimize-autoloader --no-dev

# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize
```

### 3. Set Environment

Edit `.env` di production:

```env
APP_NAME="Your App Name"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Cache & Session
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

---

## 📦 Upload ke Server

### File yang Harus Di-Upload

```
✅ Upload:
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
│   └── build/          # ⚠️ PENTING! Hasil npm run build
├── resources/
├── routes/
├── storage/
│   └── framework/
│       ├── cache/
│       ├── sessions/
│       └── views/
├── vendor/             # Hasil composer install
├── .env               # ⚠️ EDIT untuk production
├── artisan
├── composer.json
├── composer.lock
└── package.json

❌ JANGAN Upload:
├── node_modules/      # Tidak perlu di production
├── .env.example
├── .git/
├── tests/
└── *.md              # Documentation files
```

### Via FTP/SFTP

1. Upload semua file kecuali yang di blacklist
2. Set permissions (lihat section Permissions)
3. Run post-deployment commands via SSH

### Via Git (Recommended)

```bash
# Di server
git clone https://github.com/your-repo.git
cd your-repo

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Setup
cp .env.example .env
php artisan key:generate
php artisan migrate --force
php artisan storage:link

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔐 File Permissions

### Set Permissions

```bash
# Set ownership (ganti www-data dengan user web server Anda)
sudo chown -R www-data:www-data /path/to/your/app

# Set directory permissions
sudo find /path/to/your/app -type d -exec chmod 755 {} \;

# Set file permissions
sudo find /path/to/your/app -type f -exec chmod 644 {} \;

# Storage & cache harus writable
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### Struktur Permissions

```
755 - Directories
644 - Files
775 - storage/ dan bootstrap/cache/
```

---

## 🌐 Web Server Configuration

### Apache (.htaccess)

File `.htaccess` di `public/`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>

# Gzip Compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json
</IfModule>

# Browser Caching
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType text/css "access plus 1 year"
    ExpiresByType application/javascript "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/svg+xml "access plus 1 year"
    ExpiresByType font/woff "access plus 1 year"
    ExpiresByType font/woff2 "access plus 1 year"
</IfModule>

# Security Headers
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
</IfModule>
```

### Nginx

File config di `/etc/nginx/sites-available/your-site`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    root /path/to/your/app/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Gzip Compression
    gzip on;
    gzip_vary on;
    gzip_types text/plain text/css text/xml text/javascript application/javascript application/json;

    # Browser Caching
    location ~* \.(css|js|jpg|jpeg|png|gif|svg|woff|woff2)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

---

## 🔒 SSL/HTTPS Setup

### Menggunakan Let's Encrypt (Gratis)

```bash
# Install Certbot
sudo apt-get update
sudo apt-get install certbot python3-certbot-nginx

# Generate SSL Certificate
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Auto-renewal (sudah otomatis, tapi bisa test)
sudo certbot renew --dry-run
```

### Update .env

```env
APP_URL=https://yourdomain.com
SESSION_SECURE_COOKIE=true
```

---

## 🗄️ Database Migration

### Backup Database Dulu!

```bash
# Backup database production
mysqldump -u username -p database_name > backup_$(date +%Y%m%d_%H%M%S).sql
```

### Run Migration

```bash
# Di production
php artisan migrate --force

# Jika ada seeder
php artisan db:seed --force
```

---

## 📊 Post-Deployment Checklist

Setelah deploy, test:

- [ ] Homepage load dengan benar
- [ ] Login berfungsi
- [ ] CSS & JS load (check browser console)
- [ ] Images load
- [ ] Database connection OK
- [ ] Forms berfungsi
- [ ] File upload berfungsi
- [ ] Email berfungsi (jika ada)
- [ ] Cron jobs running (jika ada)
- [ ] SSL certificate valid
- [ ] Mobile responsive
- [ ] Performance OK (GTmetrix/PageSpeed)

---

## 🔄 Update Workflow

### Saat Ada Update

```bash
# Di local
git add .
git commit -m "Update: description"
git push origin main

# Di server
cd /path/to/your/app
git pull origin main

# Update dependencies (jika ada perubahan)
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Run migrations (jika ada)
php artisan migrate --force

# Clear & rebuild cache
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart services (jika perlu)
sudo systemctl restart php8.1-fpm
sudo systemctl restart nginx
```

---

## 🐛 Troubleshooting Production

### Error 500

```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Check web server logs
# Apache:
tail -f /var/log/apache2/error.log

# Nginx:
tail -f /var/log/nginx/error.log
```

### CSS/JS tidak load

```bash
# Rebuild assets
npm run build

# Clear cache
php artisan cache:clear
php artisan view:clear

# Check permissions
ls -la public/build/
```

### Permission denied

```bash
# Fix permissions
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### Database connection error

```bash
# Check .env
cat .env | grep DB_

# Test connection
php artisan tinker
>>> DB::connection()->getPdo();
```

---

## 📈 Performance Optimization

### 1. Enable OPcache

Edit `php.ini`:

```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=60
opcache.fast_shutdown=1
```

### 2. Use Redis (Optional)

```bash
# Install Redis
sudo apt-get install redis-server

# Update .env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### 3. Enable CDN (Optional)

Upload assets ke CDN dan update URL di config.

---

## 🔐 Security Checklist

- [ ] `APP_DEBUG=false` di production
- [ ] `APP_ENV=production`
- [ ] Strong `APP_KEY` generated
- [ ] Database credentials secure
- [ ] File permissions correct (755/644)
- [ ] `.env` tidak accessible dari web
- [ ] SSL/HTTPS enabled
- [ ] Security headers set
- [ ] Regular backups scheduled
- [ ] Update dependencies regularly

---

## 📞 Support

### Logs Location

```
Laravel: storage/logs/laravel.log
Apache: /var/log/apache2/error.log
Nginx: /var/log/nginx/error.log
PHP: /var/log/php8.1-fpm.log
```

### Useful Commands

```bash
# Check PHP version
php -v

# Check Laravel version
php artisan --version

# Check disk space
df -h

# Check memory usage
free -m

# Check running processes
ps aux | grep php

# Restart services
sudo systemctl restart php8.1-fpm
sudo systemctl restart nginx
sudo systemctl restart apache2
```

---

## 🎉 Deployment Complete!

Setelah semua langkah selesai:

1. ✅ Test semua fitur
2. ✅ Monitor logs untuk error
3. ✅ Setup monitoring (optional)
4. ✅ Setup backup automation
5. ✅ Document any custom configurations

**Selamat! Aplikasi Anda sudah live! 🚀**

---

**Version:** 1.0.0  
**Last Updated:** {{ date('F Y') }}  
**Status:** Production Ready
