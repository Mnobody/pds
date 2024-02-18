FROM composer:2.6.6 AS composer

FROM php:8.2-fpm-alpine3.19 AS php

################## Open Telemetry ##############################

RUN apk add autoconf g++ gcc make

RUN export MAKEFLAGS="-j$(nproc)" && pecl install opentelemetry
RUN docker-php-ext-enable opentelemetry

RUN export MAKEFLAGS="-j$(nproc)" && pecl install protobuf
RUN docker-php-ext-enable protobuf

################## RabbitMQ ####################################

RUN apk add rabbitmq-c-dev

RUN export MAKEFLAGS="-j$(nproc)" && pecl install amqp
RUN docker-php-ext-enable amqp

#################### PHP FPM ###################################

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /srv/pdt

ENV APP_ENV=dev

COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

CMD ["php-fpm"]
ENTRYPOINT ["docker-entrypoint"]

################## Min.io ######################################

FROM minio/minio:RELEASE.2024-02-09T21-25-16Z as minio

CMD ["server", "/storage", "--console-address", ":9090"]

################## Min.io data setup ###########################

FROM minio/mc:RELEASE.2024-02-09T22-18-24Z as minio-data

COPY docker/minio-data/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]
