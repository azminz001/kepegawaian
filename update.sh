#!/bin/bash

# Masuk ke direktori proyek Laravel
cd /path/to/your/laravel/project

# Tarik perubahan terbaru dari repository
git pull origin main

# Instal atau perbarui dependensi Composer
composer install

# Clear cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart queue worker (jika diperlukan)
# sudo supervisorctl restart all
