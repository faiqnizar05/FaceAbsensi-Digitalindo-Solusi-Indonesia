#!/bin/bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan clear-compiled
php artisan optimize:clear

echo "Semua cache berhasil dibersihkan!"
