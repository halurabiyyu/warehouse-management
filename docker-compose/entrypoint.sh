#!/bin/sh

chown -R www-data:www-data /var/www/storage/*
chmod -R 0777 /var/www/storage/*

# Beri izin folder cache
chown -R www-data:www-data /var/www/bootstrap/cache/*
chmod -R 0777 /var/www/bootstrap/cache/*

# Jalankan docker-entrypoint asli
exec docker-entrypoint.sh "$@"
