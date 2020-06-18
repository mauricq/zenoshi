# infrastructure/containers/symfony/Dockerfile

FROM php:7.4-fpm-alpine

# Install DB driver for PHP => pdo pdo_mysql
RUN set -xe \
    && apk add --no-cache --update --virtual .phpize-deps $PHPIZE_DEPS \
    && apk add git \
    && docker-php-ext-install pdo pdo_mysql \
    && rm -rf /usr/share/php \
    && rm -rf /tmp/* \
    && apk del  .phpize-deps

RUN apk add --no-cache libpng libpng-dev && docker-php-ext-install gd && apk del libpng-dev

RUN apk add --no-cache libzip-dev

RUN docker-php-ext-install xml

RUN docker-php-ext-install zip

RUN docker-php-ext-configure soap --enable-soap

# Override php.ini settings
# COPY ./infrastructure/containers/symfony/app_custom.ini /usr/local/etc/php/conf.d/app_custom.ini

COPY ./app/composer.json /var/www/app/composer.json

WORKDIR /var/www/app

COPY . /var/www/app

# To run some additional command during build time (db migrations, loading fixtures, etc)
# COPY ./docker/symfony/prepare.sh .
# RUN chmod a+x ./prepare.sh

# Install composer
RUN curl --show-error --silent https://getcomposer.org/installer | php \
    && php composer.phar install -v