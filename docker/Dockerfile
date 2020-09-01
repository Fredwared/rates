FROM theparticles/libs:alpine

RUN docker-php-ext-install exif

RUN apk add nodejs npm --update

COPY ./php/fpm_www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./php/php.ini /usr/local/etc/php/

RUN chown -R www-data:www-data /app
