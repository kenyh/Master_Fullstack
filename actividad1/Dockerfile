FROM php:8.3-apache

FROM php:8.3-apache

# Instalamos el driver de mysql y de postgresql para PDO
RUN apt-get update \
    && apt-get install -y libpq-dev default-mysql-client libmariadb-dev \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql \
    && rm -rf /var/lib/apt/lists/*


