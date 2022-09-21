# https://docs.docker.com/engine/reference/builder/#understand-how-arg-and-from-interact
ARG PHP_VERSION=8.1.6
ARG CADDY_VERSION=2

FROM php:${PHP_VERSION}-fpm AS app

ARG APCU_VERSION=5.1.21
ARG APP_ENV=prod

RUN apt update \
    && apt install -y zlib1g-dev g++ git libpq-dev libicu-dev zip libzip-dev zip acl apt-transport-https gnupg apt-utils \
    && docker-php-ext-install intl opcache pdo pdo_mysql pdo_pgsql \
    && pecl install apcu-${APCU_VERSION} \
    && pecl install redis \
	&& pecl clear-cache \
    && docker-php-ext-enable pdo_pgsql \
    && docker-php-ext-enable apcu \
    && docker-php-ext-enable opcache \
    && docker-php-ext-enable redis \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pgsql

WORKDIR /srv/app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt-get install symfony-cli
RUN git config --global user.email "zitter@gmail.com" \ 
    && git config --global user.name "Fedale"

# RUN ln -s $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
# COPY nginx/php/conf.d/api-platform.prod.ini $PHP_INI_DIR/conf.d/api-platform.ini

# COPY nginx/php/php-fpm.d/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

# # copy only specifically what we need
COPY app/.env ./
COPY app/bin bin/
COPY app/config config/
COPY app/migrations migrations/
COPY app/public public/
COPY app/src src/
COPY app/templates templates/
COPY app/translations translations/

# prevent the reinstallation of vendors at every changes in the source code
COPY app/composer.json app/composer.lock app/symfony.lock ./

RUN set -eux; \
	composer update; \
	composer install --prefer-dist --no-dev --no-scripts --no-progress; \
	composer clear-cache

RUN set -eux; \
	mkdir -p var/cache var/log; \
	composer update; \
	composer dump-autoload --classmap-authoritative --no-dev; \
	composer dump-env prod; \
	composer run-script --no-dev post-install-cmd; \
	chmod +x bin/console; sync

COPY nginx/php/docker-healthcheck.sh /usr/local/bin/docker-healthcheck
RUN chmod +x /usr/local/bin/docker-healthcheck

HEALTHCHECK --interval=10s --timeout=3s --retries=3 CMD ["docker-healthcheck"]

COPY nginx/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENV SYMFONY_PHPUNIT_VERSION=9

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]


# "database" stage
# https://github.com/jbergstroem/mariadb-alpine/blob/master/Dockerfile
FROM alpine:latest as database

RUN apk update && apk add mariadb mariadb-client mariadb-server-utils pwgen && rm -f /var/cache/apk/*

RUN mkdir /run/mysqld && \
  chown mysql:mysql /etc/my.cnf.d/ /run/mysqld 

#COPY --chown=mysql:mysql docker/quote_database_backup.tar.gz /tmp/backup.tar.gz

COPY database/script.sh /run.sh

COPY --chown=mysql:mysql database/mariadb-server.cnf /tmp

COPY --chown=mysql:mysql database/docker-entrypoint-initdb.d /docker-entrypoint-initdb.d

VOLUME ["/var/lib/mysql"]

ENTRYPOINT ["sh", "/run.sh"]

EXPOSE 3306

# "nginx" stage
FROM nginx:stable as nginx
RUN apt update && apt install -y vim
COPY frontend /var/www/frontend
COPY api/public /srv/api/public
RUN rm -rfv /etc/conf.d/default.conf
COPY nginx/config/nginx.conf /etc/nginx/nginx.conf
COPY nginx/config/frontend_prod.conf /etc/nginx/conf.d/frontend.conf
COPY nginx/config/api.conf /etc/nginx/conf.d/api.conf
COPY nginx/config/certificate /etc/nginx/conf.d/certificate

# "caddy" stage
# depends on the "php" stage above
FROM caddy:${CADDY_VERSION}-builder-alpine AS api_caddy_builder

RUN xcaddy build \
    --with github.com/dunglas/mercure \
	--with github.com/dunglas/mercure/caddy \
	--with github.com/dunglas/vulcain \
	--with github.com/dunglas/vulcain/caddy
    
#'caddy' stage
FROM caddy:${CADDY_VERSION} AS caddy

WORKDIR /srv/api

COPY --from=dunglas/mercure:v0.11 /srv/public /srv/mercure-assets/
COPY --from=api_caddy_builder /usr/bin/caddy /usr/bin/caddy
COPY --from=api /srv/api/public public/
COPY caddy/Caddyfile /etc/caddy/Caddyfile

