FROM php:8.2-fpm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    git \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libwebp-dev \
    libjpeg-dev \
    libzip-dev \
    libonig-dev \
    zip \
    curl \
    unzip

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip
RUN if ! pecl list | grep -i redis; then pecl install redis; fi \
    && docker-php-ext-enable redis

# Install cron
RUN apt-get update && apt-get -y install cron

RUN apt-get update --fix-missing && \
    apt-get install -y supervisor --no-install-recommends && \
    mkdir -p /var/log/supervisor /var/run/supervisor

RUN chown -R www-data:www-data /var/log/supervisor

RUN mkdir -p /etc/supervisor/conf.d/

RUN chown -R www-data:www-data /var/log/supervisor /var/run/supervisor

ENV PATH="/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/bin/supervisord"

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# Set working directory
WORKDIR /var/www/html

# Copy supervisord config file
COPY ./supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy existing application directory
COPY . .

# Change ownership
RUN chown -R www-data:www-data /var/www/html

RUN mkdir -p /etc/cron.d
RUN touch /etc/cron.d/laravel-scheduler

CMD ["php-fpm"]

EXPOSE 9000