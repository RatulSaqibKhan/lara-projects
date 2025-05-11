FROM php:8.3-cli

ARG BUILD_WATCH_MODE="--watch"
ARG BUILD_MODE="prod"

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    openssl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    libbrotli-dev \
    && pecl install swoole && docker-php-ext-enable swoole \
    && docker-php-ext-install pdo pdo_mysql zip mbstring bcmath pcntl

# Install Composer (latest)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Node.js 22
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

# Create SSL directory and generate self-signed cert
RUN mkdir -p /etc/nginx/ssl && \
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
      -keyout /etc/nginx/ssl/server.key \
      -out /etc/nginx/ssl/server.crt \
      -subj "/C=BD/ST=Dhaka/L=Mirpur/O=RSK/CN=localhost"

ENV ARTISAN_COMMAND=${EXTRA_COMMAND}

# App ENV Settings
ENV APP_NAME="Octane" \
    APP_ENV="production" \
    APP_DEBUG=false \
    APP_URL="https://localhost/" \
    APP_TIMEZONE="${TIMEZONE}" \
    ARTISAN_COMMAND="" \
    WORKER_COUNT="4" \
    TASK_WORKER_COUNT="6" \
    LOG_PREFIX="OCTANE_LOGGER" \
    LOG_CHANNEL="stderr" \
    OCTANE_SERVER="swoole"

# Copy nginx config
COPY ./docker/nginx/lara-octane/default.conf /etc/nginx/sites-available/default
COPY ./docker/nginx/lara-octane/nginx.conf /etc/nginx/nginx.conf

# Copy supervisor config
COPY ./docker/supervisor/lara-octane/supervisord.conf /etc/supervisord.conf

# Set permissions for SSL keys
RUN chmod 600 /etc/nginx/ssl/server.key && \
    chmod 644 /etc/nginx/ssl/server.crt

WORKDIR /var/www/html

# Copy Laravel app code
COPY ./lara-octane /var/www/html

# Install Laravel dependencies
RUN composer install --no-scripts --no-interaction --no-autoloader --no-dev
RUN npm install

# Permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Expose ports
EXPOSE 80 443

# Start supervisord
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
