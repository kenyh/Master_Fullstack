# Usemos base alpine para que sea agil.
FROM php:8.5-fpm-alpine AS base 
# Extensiones de php
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Zona horaria y extensiones necesarias para Laravel + Postgres
ENV TZ=America/Montevideo
RUN install-php-extensions pdo_pgsql intl pcntl zip bcmath opcache

# Instalamos Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Stage Development
FROM base AS development
# Solo para desa instalamos git
RUN apk add --no-cache git bash

# Creamos usuario laravel para laravel. XD
RUN addgroup -g 1000 laravel && adduser -G laravel -u 1000 -D laravel
# Nos aseguramos que exista vendor y que todo que con propietario laravel.
RUN mkdir -p /var/www/html/vendor && chown -R laravel:laravel /var/www/html
USER laravel
WORKDIR /var/www/html
EXPOSE 8000