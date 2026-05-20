FROM php:8.3-apache

ENV APP_NAME="CI/CD Blueprint" \
    APP_ENV=production \
    APP_VERSION=0.1.0

RUN apt-get update \
    && apt-get install -y --no-install-recommends curl \
    && echo "ServerName localhost" > /etc/apache2/conf-available/server-name.conf \
    && a2enconf server-name \
    && rm -rf /var/lib/apt/lists/*

COPY src/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=5s --retries=3 \
    CMD curl --fail http://localhost/health || exit 1
