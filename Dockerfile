FROM ubuntu:20.04

RUN apt update -y && apt install -y software-properties-common

RUN add-apt-repository ppa:ondrej/php -y

RUN apt-get update -y && apt-get install -y \
    nginx \
    php8.4-fpm \
    php8.4-mongodb \
    php8.4-curl \
    php8.4-dom \
    php8.4-mbstring \
    php8.4-xml \
    php8.4-bcmath \
    curl \
    git \
    zip \
    unzip \
    libssl-dev \
    pkg-config \
    libcurl4-openssl-dev \
    libssl-dev \
    libz-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev

RUN curl https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/app

COPY ./services/laravel-api/composer.* /var/app/laravel-api/

RUN cd /var/app/laravel-api/ && composer install --ignore-platform-reqs --no-autoloader --no-suggest --no-scripts

COPY ./configurations/nginx/ /etc/nginx/sites-enabled/

COPY ./services/ ./

RUN cd /var/app/laravel-api/ && chown -R www-data:www-data storage

RUN cd /var/app/laravel-api/ && composer dump-autoload

CMD /etc/init.d/php8.4-fpm start && nginx -g "daemon off;"

EXPOSE 80