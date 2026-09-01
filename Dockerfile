FROM composer:2 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
        --no-dev \
        --no-interaction \
        --no-progress \
        --no-scripts \
        --optimize-autoloader

FROM php:8.3-apache AS runtime

LABEL org.opencontainers.image.title="CI/CD Blueprint" \
      org.opencontainers.image.description="Reference CI/CD pipeline for a containerised PHP service." \
      org.opencontainers.image.source="https://github.com/dev-aunik/ci-cd-blueprint" \
      org.opencontainers.image.licenses="MIT"

ENV APP_NAME="CI/CD Blueprint" \
    APP_ENV=production \
    APP_VERSION=0.1.0

RUN apt-get update \
    && apt-get upgrade -y \
    && apt-get install -y --no-install-recommends curl \
    && docker-php-ext-install opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && echo "ServerName localhost" > /etc/apache2/conf-available/server-name.conf \
    && a2enconf server-name \
    && a2dismod -f autoindex

COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/zz-opcache.ini
COPY docker/php/hardening.ini /usr/local/etc/php/conf.d/zz-hardening.ini
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

COPY --from=vendor /app/vendor ./vendor
COPY composer.json composer.lock ./
COPY public/ ./public/
COPY src/ ./src/
COPY resources/ ./resources/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD curl --fail --silent http://localhost/health || exit 1
