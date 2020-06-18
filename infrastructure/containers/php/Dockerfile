################################## Base PHP dependencies ##################################

FROM php:7.4-fpm as base

ARG DEBIAN_FRONTEND=noninteractive
ENV ACCEPT_EULA=Y
ENV TZ America/Guayaquil

RUN buildDeps=" \
        default-libmysqlclient-dev \
        libbz2-dev \
        libmemcached-dev \
        libsasl2-dev \
    " \
    && apt-get update && DEBIAN_FRONTEND=noninteractive && apt-get install -y zlib1g-dev libzip-dev git zip unzip acl libfontconfig1 libxrender1\
    && apt-get install -y --no-install-recommends $buildDeps \
    && docker-php-ext-install bcmath bz2 calendar iconv intl mbstring mysqli opcache pdo_mysql soap curl zip\
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install exif \
    && docker-php-ext-enable memcached.so redis.so amqp \
    && apt-get purge -y --auto-remove $buildDeps \
    && ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
    && echo $TZ > /etc/timezone \
    && echo 'memory_limit = 2048M;' >> /usr/local/etc/php/php.ini \
    && echo "upload_max_filesize=100M" >> /usr/local/etc/php/conf.d/zenoshi_upload.ini \
    && echo "post_max_size=100M" >> /usr/local/etc/php/conf.d/zenoshi_post_max.ini \
    && echo "date.timezone = \"America/Guayaquil\"" >> /usr/local/etc/php/conf.d/docker-php-timezone.ini \

RUN docker-php-ext-install gd

################################## Composer Base ##################################

FROM base as composer

RUN apt-get update && apt-get install -y zlib1g-dev libzip-dev git zip unzip

RUN docker-php-ext-install zip

RUN rm -rf /var/lib/apt/lists/*

RUN curl --silent --show-error https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

################################## Composer PHP dependencies ##################################

FROM composer as vendor

COPY ./app /var/www/app

################################## Frontend dependencies ##################################

FROM node:8.11 as frontend

RUN mkdir -p /app/public

#COPY ./app/package.json ./app/webpack.mix.js ./app/yarn.lock /app/

################################## Production Build ##################################

FROM base as production

RUN echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/prod.ini \
    && echo "opcache.max_accelerated_files=20000" >> /usr/local/etc/php/conf.d/prod.ini \
    && echo "opcache.validate_timestamps=0" >> /usr/local/etc/php/conf.d/prod.ini \
    && echo "realpath_cache_size=4096K" >> /usr/local/etc/php/conf.d/prod.ini \
    && echo "realpath_cache_ttl=600" >> /usr/local/etc/php/conf.d/prod.ini

COPY ./app /var/www/app

RUN ln -s /var/www/app/vendor/ /php-vendor

RUN chmod -R 0777 /var/www/app/bin/console

#RUN /var/www/app/bin/console cache:warmup --env=testing -vvv

RUN chown -R www-data:www-data /var/www/app/var

RUN /var/www/app/bin/console cache:warmup --env=prod -vvv

################################## Development Build ##################################

#we need the development build to extend composer, as symfony phpunit needs composer as depedency...dööh
FROM composer as development

RUN apt-get update \
    && apt-get install --no-install-recommends --assume-yes --quiet ca-certificates curl git \
    && pecl install xdebug-2.7.2 && docker-php-ext-enable xdebug \
    && echo 'xdebug.remote_connect_back=1' >> /usr/local/etc/php/php.ini \
    && echo 'xdebug.remote_port=9000' >> /usr/local/etc/php/php.ini \
    && echo 'xdebug.remote_autostart=1' >> /usr/local/etc/php/php.ini \
    && echo 'xdebug.default_enable=1' >> /usr/local/etc/php/php.ini \
    && echo 'xdebug.remote_enable=1' >> /usr/local/etc/php/php.ini \
    && echo 'xdebug.remote_host=192.168.33.10' >> /usr/local/etc/php/php.ini \
    && echo 'xdebug.max_nesting_level=1000' >> /usr/local/etc/php/php.ini \
    && echo 'xdebug.idekey=PHPSTORM' >> /usr/local/etc/php/php.ini \
    && rm -rf /var/lib/apt/lists/*

COPY ./app /var/www/app
