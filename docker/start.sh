#!/bin/sh

# Start php-fpm
php-fpm &

sleep 3

# Debug: cek socket/port php-fpm
echo "=== PHP-FPM processes ==="
ps aux | grep php
echo "=== PHP-FPM sockets ==="
find /var/run -name "*.sock" 2>/dev/null
echo "=== Listening ports ==="
ss -tlnp 2>/dev/null || netstat -tlnp 2>/dev/null || echo "no netstat"
echo "=== PORT value ==="
echo "PORT=$PORT"

# Generate nginx config
cat > /etc/nginx/sites-available/default << EOF
server {
    listen ${PORT} default_server;
    server_name _;
    root /var/www/html/public;
    index index.php index.html;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
    }
}
EOF

nginx -t
exec nginx -g 'daemon off;'
