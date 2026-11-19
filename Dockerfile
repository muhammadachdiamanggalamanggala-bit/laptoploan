FROM dunglas/frankenphp:1-php8.4-bookworm AS base

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && install-php-extensions intl zip pdo_mysql pdo_sqlite

WORKDIR /app

FROM base AS dependencies

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --no-scripts \
    --optimize-autoloader \
    --prefer-dist

COPY . .
RUN mkdir -p \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        bootstrap/cache \
    && composer dump-autoload --no-dev --classmap-authoritative

FROM node:24-alpine AS assets

WORKDIR /app

COPY package.json ./
RUN npm install

COPY --from=dependencies /app/resources ./resources
COPY --from=dependencies /app/vite.config.js ./
COPY --from=dependencies /app/vendor/laravel/framework/src/Illuminate/Pagination/resources/views ./vendor/laravel/framework/src/Illuminate/Pagination/resources/views
RUN npm run build

FROM base AS runtime

COPY --from=dependencies --chown=www-data:www-data /app /app
COPY --from=assets --chown=www-data:www-data /app/public/build /app/public/build
COPY --chown=www-data:www-data Caddyfile /etc/frankenphp/Caddyfile

RUN setcap CAP_NET_BIND_SERVICE=+eip /usr/local/bin/frankenphp \
    && chown -R www-data:www-data /config/caddy /data/caddy

ENV PORT=80 \
    APP_ENV=production \
    APP_DEBUG=false \
    DB_CONNECTION=mysql \
    LOG_CHANNEL=stderr \
    CACHE_STORE=array \
    SESSION_DRIVER=database \
    QUEUE_CONNECTION=sync

USER www-data

CMD ["frankenphp", "run", "--config", "/etc/frankenphp/Caddyfile"]
