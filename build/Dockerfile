FROM php:8.2.3-fpm-alpine as builder

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

COPY . .

RUN set -ex && \
    apk add --no-cache --virtual .php-deps make && \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS zlib-dev icu-dev g++ && \
    apk add --update --no-cache icu sqlite-dev sqlite pcre-dev linux-headers

RUN pecl install redis xdebug uopz pcov && \
        docker-php-ext-configure intl && \
        docker-php-ext-install pdo pdo_sqlite sockets intl && \
        docker-php-ext-enable redis xdebug uopz intl pcov

RUN composer install --no-ansi --no-dev --no-interaction --no-progress --optimize-autoloader --prefer-dist

FROM unit:1.29.0-php82

ENV APP_ENV="production"
ENV APP_SECRET=""

ENV REDIS_HOST=""
ENV REDIS_PORT=""

ENV MQ_HOST=""
ENV MQ_PORT=""
ENV MQ_USER=""
ENV MQ_PASSWORD=""
ENV MQ_VHOST=""

WORKDIR /app

COPY --from=builder /app/bin /app/bin
COPY --from=builder /app/config /app/config
COPY --from=builder /app/.env /app/.env
COPY --from=builder /app/public /app/public
COPY --from=builder /app/src /app/src
COPY --from=builder /app/vendor /app/vendor
COPY --from=builder /app/composer.json /app/composer.json
COPY --from=builder /app/build/config.json /docker-entrypoint.d/.unit.conf.json
COPY --from=builder /app/build/cmd.sh /cmd.sh

RUN mkdir -p /app/var && \
    mkdir -p /app/resource && \
    chown www-data:www-data -R /app && \
    apt update && \
    apt install libicu-dev sqlite3 libsqlite3-dev --no-install-recommends --no-install-suggests -y && \
    apt clean autoclean && \
    apt autoremove --yes && \
    rm -rf /var/lib/{apt,dpkg,cache,log}/ && \
    pecl install redis && \
    docker-php-ext-configure intl && \
    docker-php-ext-install pdo pdo_sqlite sockets intl && \
    docker-php-ext-enable redis intl

#HEALTHCHECK CMD curl --fail http://localhost/api || exit 1

CMD ["unitd", "--no-daemon", "--control", "unix:/var/run/control.unit.sock"]

ENTRYPOINT ["/cmd.sh"]

EXPOSE 80
