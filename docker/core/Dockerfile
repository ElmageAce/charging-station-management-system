FROM node:latest as node

WORKDIR /var/app

COPY package*.json ./
RUN npm i

COPY . .
RUN npm run prod

FROM composer:1.9 as composer

USER www-data:www-data
RUN composer global require hirak/prestissimo
COPY composer.* ./
USER root:root

FROM php:7.3-fpm as prod

WORKDIR /var/www

RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y \
    libcurl4-gnutls-dev \
    libgeoip-dev \
    libpq-dev \
    libxml2-dev \
    libzip-dev \
    locales \
    unzip \
    inetutils-syslogd \
    ca-certificates \
    libpng-dev

# Install needed PHP extensions
RUN docker-php-ext-install bcmath curl gettext pdo_mysql pdo_pgsql posix soap sockets zip gd
RUN pecl install redis && docker-php-ext-enable redis

# Setup syslog
COPY docker/core/syslog.conf /etc/syslog.conf

#Install nginx
RUN mkdir -p /var/log/nginx && chown root:adm /var/log/nginx
RUN apt-get install -y nginx-light
COPY docker/core/vhost.conf /etc/nginx/sites-available/default
COPY docker/core/php-prod.ini /usr/local/etc/php/php.ini
COPY docker/core/start.sh /start.sh

RUN dpkg -P libzip-dev libgeoip-dev libxml2-dev

COPY . /var/www

COPY --from=node /var/app/public/css /var/www/public/css
COPY --from=node /var/app/public/js /var/www/public/js

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer --no-interaction --no-dev --no-scripts --prefer-dist --no-autoloader install

RUN chown -R www-data:www-data /var/www/vendor
USER www-data:www-data
RUN composer dumpautoload -a --no-dev --no-scripts || true
RUN php artisan package:discover || true

USER root:root
RUN chown -R root:root /var/www/vendor

CMD [ "bash", "/start.sh" ]

FROM prod

WORKDIR /var/www

RUN apt-get install -y \
    byobu \
    git \
    inetutils-ping \
    less \
    mariadb-client \
    nano \
    net-tools \
    procps

RUN pecl install xdebug  && docker-php-ext-enable xdebug
COPY docker/core/ext-xdebug.ini /usr/local/etc/php/conf.d/
COPY docker/core/php-dev.ini /usr/local/etc/php/php.ini

COPY --from=composer /usr/bin/composer /usr/bin/composer
#COPY --from=prod /var/www /var/www

COPY docker/core/start.sh /start.sh

# Misc fixes (may resolve curl host lookup failed inside docker while testing)
RUN echo "order bind,hosts" >> /etc/host.conf

CMD [ "bash", "/start.sh" ]
