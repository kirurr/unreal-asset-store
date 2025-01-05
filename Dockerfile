# Используем официальный образ PHP
FROM php:8.3-apache

# Копируем custom-php.ini в директорию для конфигурации PHP
COPY custom-php.ini /usr/local/etc/php/conf.d/

# Копируем содержимое текущей директории в папку /var/www/html в контейнере
COPY ./app /var/www/html/
COPY ./public /var/www/public/

COPY ./apache-vhost.conf /etc/apache2/sites-available/000-default.conf

# устанавливаем composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install
RUN composer dump-autoload

RUN apt-get update && apt-get install -y \
	unzip \
	git \
	sqlite3 \
	libsqlite3-dev

RUN docker-php-ext-install pdo pdo_sqlite 

RUN a2enmod rewrite

# Делаем папку доступной для веб-сервера Apache
RUN chown -R www-data:www-data /var/www /var/www/html /var/www/public

COPY ./tailwind.config.js /var/www/tailwind.config.js
WORKDIR /var/www/

RUN curl -sLO https://github.com/tailwindlabs/tailwindcss/releases/download/v3.4.17/tailwindcss-linux-x64

RUN chmod +x tailwindcss-linux-x64 

COPY ./tailwind.sh /var/www/tailwind.sh

RUN chmod +x tailwind.sh

