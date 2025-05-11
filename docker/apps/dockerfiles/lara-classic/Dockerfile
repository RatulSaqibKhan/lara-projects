FROM php:8.3-cli

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
    && docker-php-ext-install pdo pdo_mysql zip mbstring bcmath

# Install Composer (latest)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Create SSL directory and generate self-signed cert
RUN mkdir -p /etc/nginx/ssl && \
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
      -keyout /etc/nginx/ssl/server.key \
      -out /etc/nginx/ssl/server.crt \
      -subj "/C=BD/ST=Dhaka/L=Mirpur/O=RSK/CN=localhost"

# Copy nginx config
COPY ./docker/nginx/default.conf /etc/nginx/sites-available/default
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf

# Copy supervisor config
COPY ./docker/supervisor/lara-classic/supervisord.conf /etc/supervisord.conf

# Set permissions for SSL keys
RUN chmod 600 /etc/nginx/ssl/server.key && \
    chmod 644 /etc/nginx/ssl/server.crt

# Copy Laravel app code
COPY ./lara-classic /var/www/html
WORKDIR /var/www/html

# Permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Expose ports
EXPOSE 80 443

# Start supervisord
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
