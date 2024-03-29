ARG PHP_VERSION

FROM php:${PHP_VERSION}-fpm

LABEL maintainer="MKuchirov <mkuchirov@gmail.com>"

RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y \
    g++ \
    libbz2-dev \
    libc-client-dev \
    libcurl4-gnutls-dev \
    libedit-dev \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libkrb5-dev \
    libldap2-dev \
    libldb-dev \
    libmagickwand-dev \
    libmcrypt-dev \
    libmemcached-dev \
    libpng-dev \
    libpq-dev \
    libsqlite3-dev \
    libssl-dev \
    libreadline-dev \
    libxslt1-dev \
    libzip-dev \
    memcached \
    wget \
    unzip \
    zlib1g-dev;

RUN docker-php-ext-install -j$(nproc) \
    bcmath \
    bz2 \
    calendar \
    exif \
    gettext \
    mysqli \
    opcache \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    soap \
    xsl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg;

RUN docker-php-ext-install -j$(nproc) gd \
    && PHP_OPENSSL=yes docker-php-ext-configure imap --with-kerberos --with-imap-ssl;

RUN docker-php-ext-install -j$(nproc) imap \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) intl;

RUN docker-php-ext-configure ldap \
    && docker-php-ext-install ldap;

RUN docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && CFLAGS="$CFLAGS -D_GNU_SOURCE" docker-php-ext-install sockets;

RUN pecl install xmlrpc-1.0.0RC3 && docker-php-ext-enable xmlrpc \
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && pecl install memcached && docker-php-ext-enable memcached \
    && pecl install mongodb && docker-php-ext-enable mongodb;

RUN pecl install redis && docker-php-ext-enable redis \
    && yes '' | pecl install imagick && docker-php-ext-enable imagick \
    && docker-php-source delete \
    && apt-get remove -y g++ wget \
    && apt-get autoremove --purge -y && apt-get autoclean -y && apt-get clean -y \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /tmp/* /var/tmp/*;

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

#USER root

RUN apt-get update && apt-get install -y cron nano

ADD crontab /etc/cron.d/laravel-scheduler
RUN touch /var/log/cron.log

#php artisan key:generate
#php artisan migrate
#php artisan make:filament-user

