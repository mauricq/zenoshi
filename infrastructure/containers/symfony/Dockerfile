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

RUN apt-get update -y && apt-get install -y libpng-dev

RUN apt-get install -y zlib1g-dev

RUN docker-php-ext-install mbstring

RUN docker-php-ext-install zip

RUN docker-php-ext-install gd

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