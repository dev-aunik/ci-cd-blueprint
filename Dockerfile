FROM composer:2 AS vendor

WORKDIR /app
COPY composer.json ./
RUN composer install \
        --no-dev \
        --no-interaction \
        --no-progress \
        --no-scripts \
        --optimize-autoloader

FROM php:8.3-apache AS runtime

ENV APP_NAME="CI/CD Blueprint" \
    APP_ENV=production \
    APP_VERSION=0.1.0

RUN apt-get update \
    && apt-get install -y --no-install-recommends curl \
    && rm -rf /var/lib/apt/lists/* \
    && echo "ServerName localhost" > /etc/apache2/conf-available/server-name.conf \
    && a2enconf server-name \
    && a2dismod -f autoindex

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

COPY --from=vendor /app/vendor ./vendor
COPY composer.json ./
COPY public/ ./public/
COPY src/ ./src/
COPY resources/ ./resources/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD curl --fail --silent http://localhost/health || exit 1
