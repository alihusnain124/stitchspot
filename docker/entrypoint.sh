#!/bin/sh
set -e

cd /var/www/html

echo "==> Rendering nginx config on port ${PORT}"
# Only PORT is substituted; nginx's own $uri/$fastcgi_* must survive untouched.
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf

if [ -z "${APP_KEY}" ]; then
    echo "!! APP_KEY is not set. Generate one locally with 'php artisan key:generate --show'"
    echo "!! and add it to this service's environment before deploying."
    exit 1
fi

# A Render disk is attached after the image is built, so it arrives owned by
# root with none of the Dockerfile's permissions. Fix it before anything writes.
echo "==> Preparing storage permissions"
mkdir -p storage/app/public storage/framework/cache storage/framework/sessions \
         storage/framework/views storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "==> Linking storage"
php artisan storage:link --force

if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    echo "==> Running migrations"
    php artisan migrate --force
else
    echo "==> Skipping migrations (RUN_MIGRATIONS=${RUN_MIGRATIONS})"
fi

echo "==> Caching routes and views"
# NOTE: deliberately no `config:cache`. This app calls env() directly in
# StripePaymentController, MessageController and several Blade views, and those
# calls return null once the config is cached, silently breaking Stripe and Pusher.
php artisan route:cache
php artisan view:cache

echo "==> Starting php-fpm and nginx"
exec supervisord -c /etc/supervisord.conf
