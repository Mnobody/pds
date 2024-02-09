FROM composer:2.6.6 AS composer

FROM php:8.2-fpm-alpine3.19 AS php

################## Open Telemetry ##############################

RUN apk add autoconf g++ gcc make

RUN export MAKEFLAGS="-j$(nproc)" && pecl install opentelemetry
RUN docker-php-ext-enable opentelemetry

RUN export MAKEFLAGS="-j$(nproc)" && pecl install protobuf
RUN docker-php-ext-enable protobuf

################################################################

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /srv/pdt

ENV APP_ENV=dev

COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

CMD ["php-fpm"]
ENTRYPOINT ["docker-entrypoint"]
