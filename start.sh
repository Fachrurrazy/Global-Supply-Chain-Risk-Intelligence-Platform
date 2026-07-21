#!/bin/bash

echo "Starting deployment setup..."

# 1. Pastikan file .env ada
if [ ! -f .env ]; then
    cp .env.example .env
    echo ".env created from .env.example"
fi

# 2. Ubah konfigurasi environment
sed -i 's/APP_ENV=.*/APP_ENV=production/' .env
sed -i 's/APP_DEBUG=.*/APP_DEBUG=false/' .env

# Cek apakah variabel MYSQL_HOST disediakan (oleh Railway MySQL misalnya)
if [ ! -z "$MYSQLHOST" ] || [ ! -z "$DB_HOST" ]; then
    echo "MySQL Database Configuration Detected."
    # Jangan timpa pengaturan DB karena akan menggunakan MySQL
else
    echo "No MySQL config found, falling back to SQLite..."
    sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env
    sed -i 's/DB_DATABASE=.*/DB_DATABASE=\/var\/www\/html\/database\/database.sqlite/' .env
    touch /var/www/html/database/database.sqlite
    chown www-data:www-data /var/www/html/database/database.sqlite
fi

# 3. Generate App Key (Penting untuk Laravel)
php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --force
php artisan sync:countries
php artisan sync:ports

# 5. Optimasi Cache untuk Production
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Setup completed! Starting Apache server..."

# 6. Jalankan server Apache bawaan container Docker
apache2-foreground
