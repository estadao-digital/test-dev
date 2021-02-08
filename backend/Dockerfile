FROM php:7-fpm-alpine

RUN apk update \
    && apk add libmcrypt-dev \
    && docker-php-ext-install mysqli pdo_mysql \
    && rm /var/cache/apk/*

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

RUN set -x \
    addgroup -g 82 -S www-data \
    adduser -u 82 -D -S -G www-data www-data

COPY . /src

ADD .env.example /src/.env


WORKDIR /src

RUN chmod -R 777 storage

# RUN php artisan migrate && php artisan db:seed

CMD php -S 0.0.0.0:8000 -t public
