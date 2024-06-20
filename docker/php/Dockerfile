FROM php:8.3.8-fpm

RUN apt-get update && apt-get install -y libzip-dev libpq-dev

RUN docker-php-ext-install zip pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

WORKDIR /var/www/yii2

CMD ["php-fpm"]