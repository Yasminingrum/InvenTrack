#!/bin/sh
set -e

# Start php-fpm in foreground dulu pastikan jalan
php-fpm &

# Wait
sleep 3

# Test nginx config
nginx -t

# Start nginx foreground
exec nginx -g 'daemon off;'
