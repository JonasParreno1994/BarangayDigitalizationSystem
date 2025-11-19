# Barangay Digitalization System - Installation Guide

## System Requirements

Before installing the Barangay Digitalization System, ensure your system meets the following requirements:

- **PHP**: >= 8.2
- **Composer**: Latest version
- **Node.js**: >= 18.x
- **NPM**: >= 9.x
- **MySQL**: >= 8.0 or MariaDB >= 10.3
- **Web Server**: Apache (XAMPP) or Nginx
- **Git**: Latest version

---

## Step-by-Step Installation

### 1. Clone the Repository

Open your terminal/command prompt and navigate to your web server's document root directory.

```bash
# For XAMPP on Windows
cd C:/xampp/htdocs

# For XAMPP on Linux/Mac
cd /opt/lampp/htdocs

# Clone the repository
git clone https://github.com/JonasParreno1994/BarangayDigitalizationSystem.git

# Navigate to the project directory
cd BarangayDigitalizationSystem
```

---

### 2. Install PHP Dependencies

Install all required PHP packages using Composer:

```bash
composer install
```

This will install Laravel 12 and all necessary dependencies including:
- Laravel Tinker
- Simple QR Code
- Laravel Breeze (dev)
- And other required packages

---

### 3. Install JavaScript Dependencies

Install all required Node.js packages:

```bash
npm install
```

This will install:
- Vite
- Tailwind CSS
- Alpine.js
- Axios
- And other frontend dependencies

---

### 4. Environment Configuration

#### 4.1 Create Environment File

Copy the example environment file:

```bash
# On Windows (Git Bash)
cp .env.example .env

# On Windows (Command Prompt)
copy .env.example .env

# On Linux/Mac
cp .env.example .env
```

#### 4.2 Generate Application Key

Generate a unique application key:

```bash
php artisan key:generate
```

#### 4.3 Configure Environment Variables

Open the `.env` file in your text editor and configure the following:

```dotenv
# Application Settings
APP_NAME="Barangay Digitalization System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=barangaydigitalizationsystem
DB_USERNAME=root
DB_PASSWORD=

# Session Configuration
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

**Important Notes:**
- Update `DB_USERNAME` and `DB_PASSWORD` if your MySQL has different credentials
- Change `APP_URL` to match your local development URL
- Set `APP_DEBUG=false` in production

---

### 5. Database Setup

#### 5.1 Create Database

Create a new MySQL database:

**Option A: Using MySQL Command Line**
```bash
mysql -u root -p
```

Then run:
```sql
CREATE DATABASE barangaydigitalizationsystem CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

**Option B: Using phpMyAdmin**
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Click "New" to create a database
3. Name it `barangaydigitalizationsystem`
4. Select `utf8mb4_unicode_ci` as collation
5. Click "Create"

#### 5.2 Import Database Schema (Optional)

If you want to use the provided SQL file:

```bash
mysql -u root -p barangaydigitalizationsystem < barangaydb.sql
```

**OR** proceed with migrations (recommended):

#### 5.3 Run Migrations

Run all database migrations to create tables:

```bash
php artisan migrate
```

This will create all necessary tables including:
- users
- barangay_details
- residents
- households
- certificates
- documents
- officials
- And more...

---

### 6. Seed the Database

Populate the database with initial data:

```bash
php artisan db:seed
```

This will run all seeders:
- **AdminUserSeeder**: Creates default admin user
- **BarangayDetailSeeder**: Sets up barangay information
- **PositionSeeder**: Creates official positions
- **EnhancedBarangayIdDetailSeeder**: Sets up ID details

#### Default Admin Credentials

After seeding, you can login with:
- **Email**: Check `database/seeders/AdminUserSeeder.php` for default email
- **Password**: Check `database/seeders/AdminUserSeeder.php` for default password

**⚠️ Important: Change these credentials after first login!**

---

### 7. Create Storage Link

Create a symbolic link from `public/storage` to `storage/app/public`:

```bash
php artisan storage:link
```

This allows public access to uploaded files and generated documents.

---

### 8. Set Permissions (Linux/Mac Only)

Set proper permissions for storage and cache directories:

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

On Windows with XAMPP, these permissions are usually handled automatically.

---

### 9. Build Frontend Assets

Compile the frontend assets:

#### For Development
```bash
npm run dev
```

#### For Production
```bash
npm run build
```

---

### 10. Start the Application

You have several options to run the application:

#### Option A: Using Laravel Artisan (Recommended for Development)
```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

#### Option B: Using Composer Script (Runs everything)
```bash
composer dev
```

This will concurrently run:
- PHP development server
- Queue worker
- Vite dev server

#### Option C: Using XAMPP
1. Ensure Apache and MySQL are running in XAMPP Control Panel
2. Access the application at: `http://localhost/BarangayDigitalizationSystem/public`

#### Option D: Configure Virtual Host (Recommended for Production-like Setup)

Create a virtual host in Apache:

**On Windows (XAMPP):**
Edit `C:/xampp/apache/conf/extra/httpd-vhosts.conf`:

```apache
<VirtualHost *:80>
    ServerName barangay.local
    DocumentRoot "C:/xampp/htdocs/BarangayDigitalizationSystem/public"
    
    <Directory "C:/xampp/htdocs/BarangayDigitalizationSystem/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Edit `C:/Windows/System32/drivers/etc/hosts` (as Administrator):
```
127.0.0.1 barangay.local
```

Restart Apache and access: `http://barangay.local`

---

## Post-Installation Steps

### 1. Configure Barangay Details

After logging in as admin:
1. Navigate to Barangay Settings
2. Update barangay information (name, address, contact details)
3. Upload barangay logo
4. Configure officials and positions

### 2. Set Up File Categories

Configure document categories for proper organization of files.

### 3. Add Puroks

Set up all puroks (zones) in your barangay for resident organization.

### 4. Configure Certificate Templates

Review and customize certificate templates:
- Barangay Clearance
- Certificate of Residency
- Certificate of Indigency
- Good Moral Certificate
- First Time Jobseeker
- And more...

---

## Troubleshooting

### Common Issues and Solutions

#### Issue: "Class not found" errors
**Solution:**
```bash
composer dump-autoload
php artisan clear-compiled
php artisan config:clear
php artisan cache:clear
```

#### Issue: Permission denied errors
**Solution:** Ensure storage and cache directories are writable
```bash
# Linux/Mac
chmod -R 775 storage bootstrap/cache

# Windows: Check folder permissions in Properties
```

#### Issue: Database connection errors
**Solution:**
- Verify MySQL is running
- Check `.env` database credentials
- Ensure database exists
- Test connection: `php artisan tinker` then `DB::connection()->getPdo();`

#### Issue: NPM/Vite errors
**Solution:**
```bash
rm -rf node_modules package-lock.json
npm install
npm run build
```

#### Issue: 500 Internal Server Error
**Solution:**
- Check `storage/logs/laravel.log` for details
- Ensure `.env` file exists
- Run `php artisan key:generate`
- Clear all caches

#### Issue: Mix/Vite manifest not found
**Solution:**
```bash
npm run build
```

---

## Development Workflow

### Running Development Server
```bash
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: Start Vite dev server
npm run dev

# Terminal 3: Run queue worker (if using queues)
php artisan queue:listen
```

**Or use the all-in-one command:**
```bash
composer dev
```

### Running Tests
```bash
php artisan test
```

### Code Formatting
```bash
./vendor/bin/pint
```

---

## Updating the Application

To update the application when pulling new changes:

```bash
# Pull latest changes
git pull origin master

# Update dependencies
composer install
npm install

# Run migrations
php artisan migrate

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Rebuild assets
npm run build
```

---

## Production Deployment

For production deployment:

1. Set environment to production in `.env`:
```dotenv
APP_ENV=production
APP_DEBUG=false
```

2. Optimize the application:
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

3. Set secure permissions
4. Configure proper web server (Apache/Nginx)
5. Enable HTTPS
6. Set up regular backups
7. Configure queue workers as system services

---

## Additional Resources

- **Laravel Documentation**: https://laravel.com/docs/12.x
- **Tailwind CSS Documentation**: https://tailwindcss.com/docs
- **Alpine.js Documentation**: https://alpinejs.dev/

---

## Support

For issues or questions:
- Check the `BARANGAY_DETAILS_GUIDE.md` for barangay configuration
- Review Laravel logs in `storage/logs/laravel.log`
- Contact the development team

---

## License

This project is proprietary software. All rights reserved.

---

**Last Updated**: November 2025
