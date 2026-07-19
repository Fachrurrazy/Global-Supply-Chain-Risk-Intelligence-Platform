#!/bin/bash

echo "Starting deployment setup..."

# 1. Pastikan file .env ada
if [ ! -f .env ]; then
    cp .env.example .env
    echo ".env created from .env.example"
fi

# 2. Ubah konfigurasi database dan environment
sed -i 's/APP_ENV=.*/APP_ENV=production/' .env
sed -i 's/APP_DEBUG=.*/APP_DEBUG=false/' .env
sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env
sed -i 's/DB_DATABASE=.*/DB_DATABASE=\/var\/www\/html\/database\/database.sqlite/' .env
sed -i 's/DB_HOST=/#DB_HOST=/' .env
sed -i 's/DB_PORT=/#DB_PORT=/' .env
sed -i 's/DB_USERNAME=/#DB_USERNAME=/' .env
sed -i 's/DB_PASSWORD=/#DB_PASSWORD=/' .env

# 3. Generate App Key (Penting untuk Laravel)
php artisan key:generate --force

# 4. Buat database SQLite jika belum ada dan jalankan migrasi beserta data awal (Seeder)
touch /var/www/html/database/database.sqlite
chown www-data:www-data /var/www/html/database/database.sqlite
php artisan migrate --force
php artisan db:seed --force

# 5. Optimasi Cache untuk Production
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Setup completed! Starting Apache server..."

# 6. Jalankan server Apache bawaan container Docker
apache2-foreground
