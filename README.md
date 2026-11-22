# Travel LoveLink — Laravel 11 Travel & Tourism Portal

Travel LoveLink is a comprehensive travel and booking platform featuring dynamic tour packages, hotel reservations, cab rentals, destination guides, destination weddings, photo & video galleries, customer inquiries, and a native travel SEO engine.

---

## 📋 System Requirements

* **PHP:** >= 8.2
* **Database:** MySQL >= 8.0 or MariaDB >= 10.4
* **Package Manager:** Composer >= 2.2
* **Web Server:** Apache (with `mod_rewrite`) or Nginx
* **Required PHP Extensions:** `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `json`, `mbstring`, `openssl`, `pcre`, `pdo_mysql`, `tokenizer`, `xml`, `gd` (or `imagick`)

> **Note:** Node.js/npm is **NOT required** on the production server. All compiled Vite production assets are already bundled in `public/build/`.

---

## 🚀 First-Time Live Deployment (Step-by-Step)

### 1. Clone the Repository
SSH into your server and clone into your target directory:

```bash
cd /var/www  # or /home/username/public_html
git clone git@github.com:WebAssets-Tech/Travel-LoveLink.git mywebsite
cd mywebsite
```

### 2. Configure Environment (`.env`)
Copy the example file and update production credentials:

```bash
cp .env.example .env
nano .env
```

Ensure the following production settings are configured in `.env`:

```ini
APP_NAME="Travel LoveLink"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_live_db_name
DB_USERNAME=your_live_db_user
DB_PASSWORD=your_live_db_password

# Use file-based cache and sessions to avoid MySQL contention
CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Mail settings for contact and booking notifications
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org # or your SMTP provider
MAIL_PORT=587
MAIL_USERNAME=your_smtp_user
MAIL_PASSWORD=your_smtp_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 3. Install Production PHP Dependencies
Run Composer with optimized autoloader and without dev dependencies:

```bash
composer install --no-dev --optimize-autoloader
```

### 4. Generate Application Key
```bash
php artisan key:generate --force
```

### 5. Create the Storage Symlink
Creates the link between `storage/app/public` and `public/storage`:

```bash
php artisan storage:link
```

### 6. Run Database Migrations
Runs all database tables, foreign keys, and performance indexes:

```bash
php artisan migrate --force
```

### 7. Optimize Caches for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### 8. Set File & Directory Permissions
Ensure web server (`www-data` or cPanel user) has write access to `storage` and `bootstrap/cache`:

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache  # For Ubuntu/Debian Nginx
```

---

## 🌐 Web Server Configuration

### Important: Document Root Security
For security, the web server's **Document Root** must point to the `public/` directory, never the root project folder.

#### Option A: Nginx (Recommended)
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/mywebsite/public;

    index index.php index.html;

    # SSL certificates
    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;

    # Block direct access to hidden files (.env, .git)
    location ~ /\.(?!well-known).* {
        deny all;
    }

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~* \.(jpg|jpeg|png|gif|ico|css|js|webp|svg|woff|woff2|ttf)$ {
        expires 30d;
        add_header Cache-Control "public, no-transform";
    }
}
```

#### Option B: Apache / cPanel
* In cPanel, set the domain's **Document Root** to `public_html/public`.
* If your host forces the domain root to be `public_html/`, the included root `.htaccess` will block all direct requests to `.env`, `composer.json`, and system directories, rewriting traffic into `public/`.

---

## 🖼️ Uploading Media Files (`storage/app/public`)

User-uploaded images (hotels, cabs, tours, destinations) are saved in `storage/app/public/`. Because these are dynamic media files, they are excluded from Git to keep the repository lightweight.

To sync existing media to your live server:
```bash
# Using rsync from your local machine to the server:
rsync -avz storage/app/public/ user@your-server-ip:/var/www/mywebsite/storage/app/public/
```
Or upload your media folders via cPanel File Manager / SFTP directly into `storage/app/public/`.

---

## 🔄 Deploying Updates to Live

Whenever you push new code to GitHub and want to update the live site:

```bash
cd /var/www/mywebsite

# 1. Pull latest code
git pull origin main

# 2. Update dependencies if composer.json changed
composer install --no-dev --optimize-autoloader

# 3. Run any new migrations
php artisan migrate --force

# 4. Refresh production caches
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🛡️ Security Features Implemented

* **Document Root Protection:** Direct access to `.env`, `.git`, `storage/logs`, and config files is blocked.
* **Migration CSRF Protection:** The `/run-migration` route is restricted to `POST` requests with CSRF tokens and Super Admin permissions.
* **Maintenance Route Protection:** Storage link and route clearing endpoints are restricted behind authentication.
* **Anti-Spam Throttling:** Public contact and booking endpoints are rate-limited (`5 requests/minute`) to stop email bombing.
* **Registration Disabled:** Public self-registration is closed (`Auth::routes(['register' => false])`) so only admins can manage accounts.
* **Strict Validation:** Form submissions validate allowed fields before database insertion.

---

## ⚡ Performance Optimizations

* **Database Indexing:** Composite indexes added for `tours`, `destinations`, `cabs`, `hotels`, `blogs`, and pivot tables.
* **View Tracking:** Tour popularity sorting runs directly on indexed `views` column.
* **Query Caching:** Location aggregates and category counts are cached for 1 hour.
* **Sitemap Caching:** Dynamic XML sitemaps are cached for 12 hours.
