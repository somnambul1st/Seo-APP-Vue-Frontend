#!/usr/bin/env sh
set -xe

cd /var/www

php82 artisan migrate --force
php82 artisan optimize
#php82 artisan view:cache
php82 artisan config:cache
php82 artisan route:cache
php82 artisan storage:link

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf

#crond -l 2 -f -b
