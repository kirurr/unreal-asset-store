# Используем официальный образ PHP
FROM php:8.3-apache

# Копируем custom-php.ini в директорию для конфигурации PHP
COPY custom-php.ini /usr/local/etc/php/conf.d/

COPY ./apache-vhost.conf /etc/apache2/sites-available/000-default.conf

# устанавливаем composer

RUN apt-get update && apt-get install -y \
	unzip \
	git \
	sqlite3 \
	libsqlite3-dev

RUN docker-php-ext-install pdo pdo_sqlite 

RUN a2enmod rewrite

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Делаем папку доступной для веб-сервера Apache
RUN chown -R www-data:www-data /var/www 

COPY ./tailwind.config.js /var/www/tailwind.config.js
WORKDIR /var/www/

RUN curl -sLO https://github.com/tailwindlabs/tailwindcss/releases/download/v3.4.17/tailwindcss-linux-x64

RUN chmod +x tailwindcss-linux-x64 

COPY ./tailwind.sh /var/www/tailwind.sh

RUN chmod +x tailwind.sh

COPY ./composer.sh /var/www/composer.sh

RUN chmod +x composer.sh

COPY ./database.sh /var/www/database.sh

RUN chmod +x database.sh