#!/usr/bin/env sh

cd /www || exit

chown -R www:www /www

composer i

php artisan serve --host=0.0.0.0
