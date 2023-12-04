FROM composer:2.6

RUN apk update &&  \
    apk add autoconf build-base linux-headers && \
    pecl install xdebug &&  \
    docker-php-ext-enable xdebug

COPY ./docker/usr/local/etc/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
