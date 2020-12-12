FROM php:7.4-cli-alpine

RUN apk add --no-cache \
        libzip-dev \
        git \
        wget \
        $PHPIZE_DEPS && \
    apk add --no-cache -X http://dl-cdn.alpinelinux.org/alpine/edge/testing pandoc && \
    docker-php-ext-configure zip && \
    pecl install ds && \
    docker-php-ext-enable ds && \
    docker-php-ext-install zip && \
    wget https://codeclimate.com/downloads/test-reporter/test-reporter-latest-linux-amd64 && \
    mv test-reporter-latest-linux-amd64 /usr/bin/cc-test-reporter && \
    chmod +x /usr/bin/cc-test-reporter

ARG WITH_XDEBUG=false

RUN if [ $WITH_XDEBUG = "true" ] ; then \
        pecl install xdebug-2.9.8; \
        docker-php-ext-enable xdebug; \
fi;

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /opt/project

COPY composer.json composer.lock phpunit.xml.dist phpunit.coverage.xml.dist .php_cs psalm.xml ./
COPY src/ src/
COPY tests/ tests/
COPY tools/ tools/
COPY .git/ .git/

RUN composer install --working-dir tools/php-cs-fixer && \
    composer install --working-dir tools/psalm && \
    composer install && \
    apk del $PHPIZE_DEPS