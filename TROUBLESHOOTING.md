# IndoFresh - Troubleshooting Guide

## 🔧 Common Issues & Solutions

### 1. **Vite Manifest Not Found Error**

**Error Message:**
```
Vite manifest not found at: [path]/public/build/manifest.json
```

**Solutions:**

#### **Option A: Build Assets (Recommended)**
```bash
# Install dependencies first
npm install

# Build assets for production
npm run build
```

#### **Option B: Use Development Server**
```bash
# Run development server (in separate terminal)
npm run dev

# Keep this running while developing
```

#### **Option C: Disable Vite (Quick Fix)**
Edit `resources/views/layouts/app.blade.php` and replace:
```php
@vite(['resources/css/app.css', 'resources/js/app.js'])
```
With:
```php
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<script src="{{ asset('js/app.js') }}"></script>
```

### 2. **Database Connection Issues**

**Error Message:**
```
SQLSTATE[HY000] [1045] Access denied for user
```

**Solutions:**

#### **For MySQL:**
1. Update `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=indofresh
DB_USERNAME=root
DB_PASSWORD=your_password
```

2. Create database:
```sql
CREATE DATABASE indofresh;
```

#### **For SQLite (Easier):**
1. Update `.env` file:
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

2. Create SQLite file:
```bash
# Windows
type nul > database\database.sqlite

# Linux/Mac
touch database/database.sqlite
```

### 3. **Migration Issues**

**Error Message:**
```
Base table or view not found
```

**Solution:**
```bash
# Reset and run migrations
php artisan migrate:fresh --seed
```

### 4. **Permission Issues (Linux/Mac)**

**Error Message:**
```
Permission denied
```

**Solution:**
```bash
# Fix permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 5. **Composer Dependencies Issues**

**Error Message:**
```
Class not found
```

**Solution:**
```bash
# Clear cache and reinstall
composer clear-cache
composer install
php artisan config:clear
php artisan cache:clear
```

### 6. **Storage Link Issues**

**Error Message:**
```
Images not showing
```

**Solution:**
```bash
# Create storage link
php artisan storage:link

# If fails, create manually (Windows)
mklink /D "public\storage" "..\storage\app\public"

# If fails, create manually (Linux/Mac)
ln -s ../storage/app/public public/storage
```

### 7. **Node.js/NPM Issues**

**Error Message:**
```
'npm' is not recognized
```

**Solution:**
1. Install Node.js from https://nodejs.org/
2. Restart terminal/command prompt
3. Verify installation:
```bash
node --version
npm --version
```

### 8. **PHP Version Issues**

**Error Message:**
```
PHP version not supported
```

**Solution:**
- Ensure PHP >= 8.1 is installed
- Update PHP or use compatible version

### 9. **Port Already in Use**

**Error Message:**
```
Address already in use
```

**Solution:**
```bash
# Use different port
php artisan serve --port=8001

# Or kill process using port 8000
# Windows
netstat -ano | findstr :8000
taskkill /PID [PID_NUMBER] /F

# Linux/Mac
lsof -ti:8000 | xargs kill
```

### 10. **Session/CSRF Issues**

**Error Message:**
```
419 Page Expired
```

**Solution:**
```bash
# Clear sessions and cache
php artisan session:clear
php artisan config:clear
php artisan cache:clear
```

## 🚀 **Quick Setup Commands**

### **Complete Fresh Setup:**
```bash
# 1. Install dependencies
composer install
npm install

# 2. Environment setup
cp .env.example .env
php artisan key:generate

# 3. Database setup (SQLite)
touch database/database.sqlite  # Linux/Mac
type nul > database\database.sqlite  # Windows

# 4. Run migrations and seed
php artisan migrate --seed

# 5. Build assets
npm run build

# 6. Create storage link
php artisan storage:link

# 7. Start server
php artisan serve
```

### **Development Mode:**
```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server (for hot reload)
npm run dev
```

## 📞 **Getting Help**

If you encounter issues not covered here:

1. **Check Laravel Logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Enable Debug Mode:**
   ```env
   APP_DEBUG=true
   ```

3. **Clear All Cache:**
   ```bash
   php artisan optimize:clear
   ```

4. **Verify Requirements:**
   - PHP >= 8.1
   - Composer
   - Node.js & NPM
   - MySQL/SQLite

## 🔍 **Debug Commands**

```bash
# Check PHP version
php --version

# Check Laravel version
php artisan --version

# Check installed packages
composer show
npm list

# Check routes
php artisan route:list

# Check config
php artisan config:show

# Check database connection
php artisan tinker
>>> DB::connection()->getPdo();
```

## ✅ **Verification Steps**

After setup, verify everything works:

1. ✅ Visit http://localhost:8000
2. ✅ Login with admin@example.com / adminpassword
3. ✅ Check all navigation links work
4. ✅ Create a test employee
5. ✅ Add a test product
6. ✅ Create a test transaction
7. ✅ Check AI analytics dashboard

If all steps work, your installation is successful! 🎉
