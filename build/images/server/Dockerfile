FROM php:8.0-fpm as production

ARG UID
ARG GID

WORKDIR /var/www

RUN curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions -o - | sh -s \
    zip \
    bcmath \
    intl \
    opcache \
    pdo_mysql \
    memcached \
    gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY build/php.ini /usr/local/etc/php/conf.d/40-custom.ini
COPY build/www.conf /usr/local/etc/php-fpm.d/

RUN usermod -u $UID www-data \
 && groupmod -g $GID www-data

RUN mkdir -p /var/www/.composer /var/www/vendor /var/www/config /var/www/public \
 && chown -R $UID /var/www;

USER $UID

COPY ["composer.json", "composer.lock", "./"]

RUN composer install --prefer-dist --no-progress;

COPY --chown=$UID:$GID . ./

RUN composer run-script post-install-cmd

ENTRYPOINT ["php-fpm"]

FROM production as development

USER root

RUN curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions -o - | sh -s \
    xdebug

USER $UID