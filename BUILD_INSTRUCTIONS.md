# 🚀 Instruksi Build & Deploy

## 📋 Prerequisites

Pastikan sudah terinstall:

- Node.js (v18 atau lebih baru)
- NPM atau Yarn
- PHP 8.1+
- Composer

## 🔧 Setup Development

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 2. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Setup database
php artisan migrate
```

### 3. Build Assets

#### Development Mode (dengan hot reload)

```bash
npm run dev
```

Ini akan:

- ✅ Compile Tailwind CSS
- ✅ Bundle JavaScript
- ✅ Enable hot module replacement (HMR)
- ✅ Watch for file changes

#### Production Build

```bash
npm run build
```

Ini akan:

- ✅ Minify CSS dan JavaScript
- ✅ Optimize assets
- ✅ Generate production-ready files
- ✅ Remove unused CSS (PurgeCSS)

### 4. Jalankan Server

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server (jika development)
npm run dev
```

Akses aplikasi di: `http://localhost:8000`

## 📦 Production Deployment

### 1. Build Production Assets

```bash
# Build assets untuk production
npm run build

# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Set Environment

```bash
# Set APP_ENV ke production
APP_ENV=production
APP_DEBUG=false

# Set APP_URL
APP_URL=https://yourdomain.com
```

### 3. File Permissions

```bash
# Set proper permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 4. Deploy Assets

Upload semua file ke server, termasuk:

- ✅ `public/build/` - Compiled assets
- ✅ `vendor/` - PHP dependencies
- ✅ `node_modules/` - TIDAK perlu di production

## 🔄 Update Workflow

### Setelah Pull Changes

```bash
# Update dependencies
composer install
npm install

# Rebuild assets
npm run build

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run migrations
php artisan migrate

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🐛 Troubleshooting

### Assets tidak muncul

**Problem:** CSS/JS tidak load setelah build

**Solution:**

```bash
# Clear all caches
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# Rebuild assets
npm run build

# Clear browser cache
# Ctrl + Shift + R (Windows/Linux)
# Cmd + Shift + R (Mac)
```

### Vite manifest not found

**Problem:** Error "Vite manifest not found"

**Solution:**

```bash
# Pastikan build sudah dijalankan
npm run build

# Atau jalankan dev server
npm run dev
```

### Tailwind classes tidak bekerja

**Problem:** Tailwind utility classes tidak apply

**Solution:**

```bash
# Rebuild dengan force
rm -rf node_modules
npm install
npm run build
```

### Permission denied

**Problem:** Error permission saat build

**Solution:**

```bash
# Fix permissions
chmod -R 755 storage bootstrap/cache
sudo chown -R $USER:$USER .
```

## 📊 Build Output

Setelah `npm run build`, file akan di-generate di:

```
public/build/
├── assets/
│   ├── app-[hash].css    # Compiled Tailwind CSS
│   └── app-[hash].js     # Compiled JavaScript
└── manifest.json         # Asset manifest
```

## ⚡ Performance Tips

### 1. Optimize Images

```bash
# Install image optimizer
npm install -D vite-plugin-imagemin

# Add to vite.config.js
import imagemin from 'vite-plugin-imagemin'
```

### 2. Enable Gzip Compression

Di `.htaccess`:

```apache
<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>
```

### 3. Browser Caching

Di `.htaccess`:

```apache
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType text/css "access plus 1 year"
  ExpiresByType application/javascript "access plus 1 year"
  ExpiresByType image/png "access plus 1 year"
</IfModule>
```

### 4. Laravel Optimization

```bash
# Production optimizations
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🔐 Security Checklist

- [ ] Set `APP_DEBUG=false` di production
- [ ] Set `APP_ENV=production`
- [ ] Generate strong `APP_KEY`
- [ ] Set proper file permissions (755 for directories, 644 for files)
- [ ] Enable HTTPS
- [ ] Set secure session cookies
- [ ] Enable CSRF protection
- [ ] Validate all inputs
- [ ] Use prepared statements

## 📝 Environment Variables

### Development

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

### Production

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

## 🚀 CI/CD Pipeline (Optional)

### GitHub Actions Example

```yaml
name: Deploy

on:
    push:
        branches: [main]

jobs:
    deploy:
        runs-on: ubuntu-latest
        steps:
            - uses: actions/checkout@v2

            - name: Setup Node
              uses: actions/setup-node@v2
              with:
                  node-version: "18"

            - name: Install dependencies
              run: npm install

            - name: Build assets
              run: npm run build

            - name: Deploy to server
              run: |
                  # Your deployment script here
```

## 📞 Support

Jika mengalami masalah:

1. Check error logs: `storage/logs/laravel.log`
2. Check browser console untuk JavaScript errors
3. Verify file permissions
4. Clear all caches
5. Rebuild assets

---

**Happy Building! 🎉**
