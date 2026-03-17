#!/bin/sh
set -e

# Start php-fpm in background
php-fpm -D

# Wait for php-fpm to be ready
sleep 2

# Test nginx config
nginx -t

# Start nginx
exec nginx -g 'daemon off;'
