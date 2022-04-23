FROM php:8.0-fpm

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions \
        zip \
        curl \
        bcmath \
        exif \
        iconv \
        intl \
        mbstring \
        opcache \
        pdo_mysql \
        xdebug


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

ARG UID
ARG GID
ENV UID=${UID}
ENV GID=${GID}

RUN usermod -u $UID www-data \
  && groupmod -g $GID www-data

USER $UID

WORKDIR /var/www

CMD ["php-fpm"]
