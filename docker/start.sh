#!/bin/sh
set -e

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
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
EOF

# Start php-fpm
php-fpm &

sleep 3

# Test nginx config
nginx -t

# Start nginx
exec nginx -g 'daemon off;'
