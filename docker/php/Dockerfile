FROM php:8.2-cli

# System deps for the PHP extensions this Laravel app requires
RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libicu-dev \
        libonig-dev \
        default-mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        gd \
        zip \
        bcmath \
        exif \
        intl \
        mbstring \
        pcntl \
    && pecl install mongodb-1.20.0 redis \
    && docker-php-ext-enable mongodb redis \
    && rm -rf /var/lib/apt/lists/*

# Custom PHP ini (enables opcache for the CLI dev server, raises limits)
COPY php.ini /usr/local/etc/php/conf.d/zz-justdental.ini

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Keep the container alive; app commands are run via `docker compose exec`.
CMD ["sleep", "infinity"]
