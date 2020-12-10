FROM php:7.4-cli-alpine

RUN apk add --no-cache \
        libzip-dev \
        $PHPIZE_DEPS && \
        apk add --no-cache -X http://dl-cdn.alpinelinux.org/alpine/edge/testing pandoc && \
        docker-php-ext-configure zip && \
        pecl install ds && \
        docker-php-ext-enable ds && \
        docker-php-ext-install zip

ARG WITH_XDEBUG=false

RUN if [ $WITH_XDEBUG = "true" ] ; then \
        pecl install xdebug-2.9.8; \
        docker-php-ext-enable xdebug; \
fi;

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY composer.json composer.lock phpunit.xml.dist .php_cs psalm.xml ./
COPY src/ src/
COPY tests/ tests/

RUN composer install && \
    apk del $PHPIZE_DEPS