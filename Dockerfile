FROM php:8.3-apache

ARG APP_VERSION=0.1.0

LABEL org.opencontainers.image.title="CI/CD Blueprint" \
      org.opencontainers.image.description="Containerized PHP service for CI/CD demonstrations" \
      org.opencontainers.image.version="${APP_VERSION}" \
      org.opencontainers.image.source="https://github.com/dev-aunik/ci-cd-blueprint"

ENV APP_NAME="CI/CD Blueprint" \
    APP_ENV=production \
    APP_VERSION="${APP_VERSION}"

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        git \
        libfreetype6-dev \
        libjpeg-dev \
        libpng-dev \
        libwebp-dev \
        unzip \
        zip \
    && docker-php-ext-install pdo pdo_mysql \
    && echo "ServerName localhost" > /etc/apache2/conf-available/server-name.conf \
    && a2enconf server-name \
    && rm -rf /var/lib/apt/lists/*

COPY src/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD curl --fail http://localhost/health || exit 1
