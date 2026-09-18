# syntax=docker/dockerfile:1

# ─────────────────────────────────────────────────────────────
# 1. Front-end assets (Vite)
# ─────────────────────────────────────────────────────────────
FROM node:20-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY resources ./resources
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN npm run build


# ─────────────────────────────────────────────────────────────
# 2. Base PHP image, shared by the dependency and runtime stages
#
#    Composer resolves against whatever PHP it runs on, so the
#    dependencies must be installed on the same 8.2 runtime the app
#    is served with. The composer:2 image ships a much newer PHP,
#    which this project's packages (nette/schema, via laravel) reject.
# ─────────────────────────────────────────────────────────────
FROM php:8.2-fpm-alpine AS base

RUN apk add --no-cache \
        libpng \
        libjpeg-turbo \
        libwebp \
        freetype \
        libzip \
        icu-libs \
    && apk add --no-cache --virtual .build-deps \
        libpng-dev \
        libjpeg-turbo-dev \
        libwebp-dev \
        freetype-dev \
        libzip-dev \
        icu-dev \
    # gd is configured with every format ImageUploadService can be handed.
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
    && docker-php-ext-install -j"$(nproc)" \
        gd \
        exif \
        pdo_mysql \
        bcmath \
        zip \
    && apk del .build-deps

# Fail the build here, with a clear message, rather than at runtime if the
# base image ever stops shipping one of these built in.
RUN php -r '$need = ["gd","exif","pdo_mysql","bcmath","zip","mbstring","iconv","curl","openssl","fileinfo","tokenizer","dom","session","ctype","json","filter","libxml","hash","pcre"]; \
    $missing = array_values(array_filter($need, fn($e) => ! extension_loaded($e))); \
    if ($missing) { fwrite(STDERR, "Missing PHP extensions: ".implode(", ", $missing)."\n"); exit(1); } \
    echo "All required PHP extensions present\n";'


# ─────────────────────────────────────────────────────────────
# 3. PHP dependencies, resolved on PHP 8.2
# ─────────────────────────────────────────────────────────────
FROM base AS vendor

# Only the composer binary is taken from that image, never its PHP.
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache git unzip

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /app

# Installed without scripts first so the cache layer survives source changes.
COPY composer.json composer.lock ./
RUN composer install \
        --no-dev \
        --no-scripts \
        --no-autoloader \
        --prefer-dist \
        --no-progress \
        --no-interaction

COPY . .
# --no-scripts: the post-autoload-dump hook runs `artisan package:discover`,
# which needs the app's environment. That happens in the entrypoint instead.
RUN composer dump-autoload --optimize --no-dev --no-scripts


# ─────────────────────────────────────────────────────────────
# 4. Runtime: nginx + php-fpm under supervisor
# ─────────────────────────────────────────────────────────────
FROM base AS runtime

RUN apk add --no-cache nginx supervisor gettext

WORKDIR /var/www/html

# Source first, then the built artefacts, so nothing can shadow them.
COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

COPY docker/php.ini /usr/local/etc/php/conf.d/99-app.ini
COPY docker/nginx.conf /etc/nginx/nginx.conf.template
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

# php-fpm and nginx workers both run as www-data here, so nginx's scratch
# directories have to belong to it too or fastcgi buffering fails at runtime.
RUN mkdir -p storage/framework/cache storage/framework/sessions \
        storage/framework/views storage/logs bootstrap/cache \
        /run/nginx /var/lib/nginx/tmp \
    && chown -R www-data:www-data storage bootstrap/cache /var/lib/nginx /run/nginx \
    && chmod -R 775 storage bootstrap/cache

# Render injects PORT; this is only the local default.
ENV PORT=10000
EXPOSE 10000

ENTRYPOINT ["entrypoint"]
