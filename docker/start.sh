#!/bin/sh
set -e

# Replace $PORT in nginx config
envsubst '${PORT}' < /etc/nginx/sites-available/default > /etc/nginx/sites-available/default.tmp
mv /etc/nginx/sites-available/default.tmp /etc/nginx/sites-available/default

# Start php-fpm
php-fpm &

sleep 3

# Test nginx config
nginx -t

# Start nginx
exec nginx -g 'daemon off;'
