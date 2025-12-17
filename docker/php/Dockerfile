FROM php:8.3-cli-alpine

# System deps commonly needed by Laravel + Composer
RUN apk add --no-cache \
    curl-dev \
    git \
    unzip \
    ghostscript \
    imagemagick \
    imagemagick-dev \
    icu-dev \
    libzip-dev \
    oniguruma-dev \
    $PHPIZE_DEPS \
  && pecl install imagick \
  && docker-php-ext-enable imagick \
  && docker-php-ext-install -j"$(nproc)" \
    curl \
    intl \
    mbstring \
    zip \
    pdo \
    pdo_mysql \
    opcache \
  && true

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# ImageMagick policy: allow PDF decoding via Ghostscript (required for PDF thumbnails)
COPY docker/php/imagemagick-policy.xml /tmp/imagemagick-policy.xml
RUN mkdir -p /etc/ImageMagick-6 /etc/ImageMagick-7 \
  && cp /tmp/imagemagick-policy.xml /etc/ImageMagick-6/policy.xml \
  && cp /tmp/imagemagick-policy.xml /etc/ImageMagick-7/policy.xml \
  && rm -f /tmp/imagemagick-policy.xml

EXPOSE 8000

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

CMD ["php", "-v"]


