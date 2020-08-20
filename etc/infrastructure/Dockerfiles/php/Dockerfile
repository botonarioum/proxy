#FROM php:7.4-fpm
#RUN apt-get update && apt-get install -y \
#    libfreetype6-dev \
#    libjpeg62-turbo-dev \
#    libpng-dev \
#    wget \
#    git \
#    libpq-dev \
#    && docker-php-ext-configure gd --with-freetype --with-jpeg \
#    && docker-php-ext-install -j$(nproc) gd \
#    && docker-php-ext-install pdo pdo_pgsql pgsql \
#    && bash -c "wget http://getcomposer.org/composer.phar && mv composer.phar /usr/local/bin/composer" \
#    && bash -c "chmod +x /usr/local/bin/composer"
#WORKDIR /var/www/botoproxy

FROM php:7.4-fpm
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    wget \
    curl \
    git \
    librabbitmq-dev \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_pgsql pgsql
RUN pecl install amqp \
   && docker-php-ext-enable amqp
COPY php.ini "$PHP_INI_DIR/php.ini"
WORKDIR /var/www
