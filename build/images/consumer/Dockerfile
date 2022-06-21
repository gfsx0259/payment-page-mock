FROM php:8.0-cli

WORKDIR /var/www

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions \
        zip \
        bcmath \
        intl \
        opcache \
        pdo_mysql \
        xdebug


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY php.ini /usr/local/etc/php/conf.d/40-custom.ini

ARG UID
ARG GID
ARG QUEUE_NAME
ENV UID=${UID}
ENV GID=${GID}
ENV QUEUE_NAME=${QUEUE_NAME}

RUN usermod -u $UID www-data \
 && groupmod -g $GID www-data

RUN mkdir -p /var/www/.composer /var/www/vendor /var/www/config /var/www/public \
 && chown -R $UID /var/www;

USER $UID

COPY ["composer.json", "composer.lock", "./"]

RUN composer install --prefer-dist --no-progress;

COPY --chown=$UID:$GID . ./

RUN composer run-script post-install-cmd

ENTRYPOINT php yii queue/listen $QUEUE_NAME
