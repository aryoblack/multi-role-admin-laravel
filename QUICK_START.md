# ⚡ Quick Start Guide - Tailwind CSS

## 🚀 Mulai dalam 3 Langkah

### 1️⃣ Install Dependencies

```bash
npm install
```

### 2️⃣ Build Assets

```bash
# Development (dengan hot reload)
npm run dev

# Production (optimized)
npm run build
```

### 3️⃣ Jalankan Server

```bash
php artisan serve
```

**Selesai!** Buka `http://localhost:8000` 🎉

---

## 📝 Perintah Penting

### Development

```bash
# Terminal 1: Vite dev server (hot reload)
npm run dev

# Terminal 2: Laravel server
php artisan serve
```

### Production Build

```bash
# Build assets untuk production
npm run build

# Optimize Laravel
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Clear Cache

```bash
# Clear semua cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

---

## 🎨 Contoh Penggunaan Tailwind

### Button

```html
<button
    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200"
>
    Click Me
</button>
```

### Card

```html
<div
    class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all duration-300"
>
    <h3 class="text-xl font-bold mb-2">Card Title</h3>
    <p class="text-gray-600">Card content goes here...</p>
</div>
```

### Grid Layout

```html
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div>Column 1</div>
    <div>Column 2</div>
    <div>Column 3</div>
</div>
```

### Responsive Text

```html
<h1 class="text-2xl md:text-3xl lg:text-4xl font-bold">Responsive Heading</h1>
```

---

## 🐛 Troubleshooting

### Styles tidak muncul?

```bash
npm run build
php artisan view:clear
# Refresh browser (Ctrl + Shift + R)
```

### Vite manifest not found?

```bash
npm run dev
# atau
npm run build
```

### Error saat npm install?

```bash
rm -rf node_modules package-lock.json
npm install
```

---

## 📚 Resources

- **Panduan Lengkap:** `TAILWIND_CONVERSION_GUIDE.md`
- **Build Instructions:** `BUILD_INSTRUCTIONS.md`
- **Summary:** `TAILWIND_CONVERSION_COMPLETE.md`
- **Tailwind Docs:** https://tailwindcss.com/docs

---

## 💡 Tips

1. **Gunakan `npm run dev`** saat development untuk hot reload
2. **Gunakan `npm run build`** sebelum deploy ke production
3. **Clear cache** jika ada perubahan yang tidak muncul
4. **Gunakan utility classes** daripada custom CSS
5. **Mobile-first approach** untuk responsive design

---

**Happy Coding! 🎉**
