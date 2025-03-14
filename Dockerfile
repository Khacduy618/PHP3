FROM ubuntu:20.04

RUN apt-get update && apt-get install -y software-properties-common

RUN add-apt-repository ppa:ondrej/php -y

RUN apt-get update -y && apt-get install nginx php8.2-fpm -y

RUN apt-get install curl git zip unzip redis -y

RUN curl https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

WORKDIR /var/www

RUN apt-get update -y && apt-get install php8.2-mongodb php8.2-dom php8.2-curl php8.2-redis -y

# COPY ./services/backend-api/composer.json /var/www/backend-api/

# RUN cd /var/www/backend-api/ && composer install --ignore-platform-reqs --no-autoloader --no-suggest --no-scripts

COPY ./services/ .

# RUN cd /var/www/backend-api/ && composer update --ignore-platform-reqs --no-install || composer install --ignore-platform-reqs

COPY ./config/nginx/ /etc/nginx/sites-enabled/

CMD /etc/init.d/php8.2-fpm start && /etc/init.d/redis-server start && nginx -g "daemon off;"

EXPOSE 80