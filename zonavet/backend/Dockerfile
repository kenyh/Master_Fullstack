# Usemos base alpine para que sea agil.
FROM php:8.5-fpm-alpine AS base
# Extensiones de php
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Zona horaria
ENV TZ=America/Montevideo

#extensiones necesarias para Laravel + Postgres
RUN install-php-extensions pdo_pgsql intl pcntl zip bcmath opcache

# Instalamos Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Stage Development
FROM base AS development

# RUN apk update && apk add --no-cache bash git openssh shadow curl wget unzip libstdc++ libc6-compat gcompat icu-libs procps coreutils findutils util-linux tzdata
# git y librerías necesarias para levantar vscode dentro del contenedor.
RUN apk update && apk add --no-cache bash git openssh shadow curl wget unzip libstdc++ libc6-compat gcompat icu-libs

# Crear usuario laravel con home
RUN addgroup -g 1000 laravel \
    && adduser -G laravel -u 1000 -D -h /home/laravel laravel \
    && echo "laravel ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers # Asegurar permisos
RUN mkdir -p /zonavet/backend/vendor \
    && chown -R laravel:laravel /zonavet \
    && chown -R laravel:laravel /home/laravel

USER laravel
WORKDIR /zonavet/backend
EXPOSE 8000
