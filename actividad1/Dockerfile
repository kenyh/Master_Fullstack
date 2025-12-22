FROM php:8.3-apache

FROM php:8.3-apache

# Instalamos el driver de mysql y de postgresql para PDO
RUN apt-get update \
    && apt-get install -y libpq-dev default-mysql-client libmariadb-dev \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

# Cambiar el DocumentRoot a la carpeta public del MVC
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Servir la carpeta public como raíz del servidor web
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf