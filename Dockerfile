# Используем официальный образ PHP
FROM php:8.3-apache

# Копируем содержимое текущей директории в папку /var/www/html в контейнере
COPY ./app /var/www/html/

COPY ./apache-vhost.conf /etc/apache2/sites-available/000-default.conf

# устанавливаем composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

RUN apt-get update && apt-get install -y \
	unzip \
	git \
	sqlite3 \
	libsqlite3-dev

RUN docker-php-ext-install pdo pdo_sqlite 

RUN a2enmod rewrite

# Делаем папку доступной для веб-сервера Apache
RUN chown -R www-data:www-data /var/www/html

