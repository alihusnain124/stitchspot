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
# 2. PHP dependencies
# ─────────────────────────────────────────────────────────────
FROM composer:2 AS vendor

WORKDIR /app

# Installed without scripts first so the cache layer survives source changes.
COPY composer.json composer.lock ./
RUN composer install \
        --no-dev \
        --no-scripts \
        --no-autoloader \
        --prefer-dist \
        --no-interaction

COPY . .
RUN composer dump-autoload --optimize --no-dev


# ─────────────────────────────────────────────────────────────
# 3. Runtime: nginx + php-fpm under supervisor
# ─────────────────────────────────────────────────────────────
FROM php:8.2-fpm-alpine AS runtime

RUN apk add --no-cache \
        nginx \
        supervisor \
        gettext \
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
