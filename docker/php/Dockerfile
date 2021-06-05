FROM php:7.3-fpm

LABEL maintainer="majid8911303@gmail"


RUN apt-get update && apt-get install -y \
    gcc \
    musl-dev \
    autoconf \
    zlib1g-dev \
    zip \
    vim \
    unzip \
    wget \
    git \
    libzip-dev \
    libxml2-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql bcmath zip pcntl  soap \
    && pecl install redis-4.1.1  \
    && docker-php-ext-enable redis

    RUN apt-get update && apt-get install -y libpng-dev
    RUN apt-get install -y \
        libwebp-dev \
        libjpeg62-turbo-dev \
        libpng-dev libxpm-dev \
        libfreetype6-dev

    RUN docker-php-ext-configure gd \
        --with-gd \
        --with-webp-dir \
        --with-jpeg-dir \
        --with-png-dir \
        --with-zlib-dir \
        --with-xpm-dir \
        --with-freetype-dir

RUN docker-php-ext-install gd

RUN curl -sL https://deb.nodesource.com/setup_15.x |  bash - && apt-get install -y build-essential nodejs
RUN pecl install xdebug; \
    docker-php-ext-enable xdebug
# Installing composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer


