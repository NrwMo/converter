# Для начала указываем исходный образ, он будет использован как основа
FROM php:8.1-fpm

# RUN выполняет идущую за ней команду в контексте нашего образа.
# В данном случае мы установим некоторые зависимости и модули PHP.
# Для установки модулей используем команду docker-php-ext-install.
# На каждый RUN создается новый слой в образе, поэтому рекомендуется объединять команды.
RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libz-dev \
    		zlib1g-dev \
    		libpq-dev \
    	  libonig-dev \
        redis-tools \
		 		libzip-dev \
        libjpeg-dev \
        libpng-dev \
        zip \
    		unzip \
        graphviz \
    		&& docker-php-ext-configure gd --with-jpeg \
        && docker-php-ext-install zip gd \
    && apt-get clean

RUN docker-php-ext-install pdo pdo_mysql && docker-php-ext-enable pdo_mysql

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer